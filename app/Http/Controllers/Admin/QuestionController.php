<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class QuestionController extends Controller
{
    public function index()
    {
        // Load all questions with options, no pagination as requested
        $questions = Question::with('options')->latest()->get();

        return view('admin.quiz.questions.index', compact('questions'));
    }

    public function create()
    {
        return view('admin.quiz.questions.create');
    }

    public function generateFromAI(Request $request)
    {
        $types = (array) $request->input('type'); // Will be array with single element
        $topic = $request->input('topic');
        $count = (int) $request->input('count');

        if (empty($types) || !$topic || $count <= 0) {
            return response()->json(['error' => 'Missing or invalid required fields'], 422);
        }

        $allQuestions = [];

        foreach ($types as $type) {
            $readableType = match ($type) {
                'multiple_choice' => 'multiple choice',
                'true_false' => 'true/false',
                'fill_in_blanks' => 'fill in the blanks',
                default => $type
            };

            $prompt = "You are a JSON-only question generation API. Generate $count $readableType questions on the topic '$topic'. Respond in pure JSON array format.";

            // Customize prompt structure for different question types
            if ($type === 'multiple_choice') {
                $prompt .= <<<PROMPT

Return questions like:
[
  {
    "type": "multiple_choice",
    "text": "What is Laravel?",
    "options": [
      {"text": "Framework", "correct": true},
      {"text": "Browser", "correct": false},
      {"text": "OS", "correct": false},
      {"text": "App", "correct": false}
    ],
    "explanation": "Laravel is a PHP framework."
  }
]
PROMPT;
            } elseif ($type === 'true_false') {
                $prompt .= <<<PROMPT

Return questions like:
[
  {
    "type": "true_false",
    "text": "Laravel uses Composer for dependency management.",
    "correct": true,
    "explanation": "Composer is the default dependency manager in Laravel."
  }
]
PROMPT;
            } elseif ($type === 'fill_in_blanks') {
                $prompt .= <<<PROMPT

Return questions like:
[
  {
    "type": "fill_in_blanks",
    "text": "The ___ file in Laravel is used to define routes.",
    "options": [
      {"text": "web.php", "correct": true},
      {"text": "routes.php", "correct": false},
      {"text": "index.php", "correct": false},
      {"text": "app.php", "correct": false}
    ],
    "explanation": "web.php defines web routes."
  }
]
PROMPT;
            }

            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . env('HUGGINGFACE_API_TOKEN'),
                    'Content-Type' => 'application/json',
                ])
                    ->timeout(120)  // increased timeout for longer responses
                    ->post('https://router.huggingface.co/v1/chat/completions', [
                        'messages' => [
                            ['role' => 'user', 'content' => $prompt]
                        ],
                        'model' => 'Qwen/Qwen3-Coder-480B-A35B-Instruct:novita',
                        'stream' => false
                    ]);

                if ($response->failed()) {
                    return response()->json(['error' => 'AI API request failed'], 500);
                }

                $text = $response->json('choices.0.message.content');

                if (!$text) {
                    continue;
                }

                // Extract JSON array from response
                $start = strpos($text, '[');
                $end = strrpos($text, ']');
                if ($start === false || $end === false) {
                    continue;
                }

                $json = substr($text, $start, $end - $start + 1);

                // Decode HTML entities in case AI encodes special chars as entities
                $json = html_entity_decode($json, ENT_QUOTES | ENT_HTML5, 'UTF-8');

                // Decode JSON without stripping special chars!
                $questions = json_decode($json, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    // Log error and continue
                    Log::error('JSON decode error in AI response', [
                        'error' => json_last_error_msg(),
                        'json' => $json,
                        'raw_response' => $text,
                    ]);
                    continue;
                }

                if (is_array($questions)) {
                    $allQuestions = array_merge($allQuestions, $questions);
                }
            } catch (\Exception $e) {
                Log::error('AI generation failed', ['message' => $e->getMessage()]);
                return response()->json(['error' => 'Internal error'], 500);
            }
        }

        if (empty($allQuestions)) {
            return response()->json(['error' => 'Failed to parse AI response into questions'], 500);
        }

        return response()->json(['questions' => $allQuestions]);
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.type' => 'required|string',
            'questions.*.answer_explanation' => 'nullable|string',
            'questions.*.options' => 'nullable|array',
            'questions.*.options.*.text' => 'required_with:questions.*.options|string',
            'questions.*.options.*.correct' => 'required_with:questions.*.options|boolean',
            // For true_false and fill_in_blanks
            'questions.*.true_false_correct' => 'sometimes|boolean',
            'questions.*.fill_answer' => 'sometimes|string',
        ]);

        foreach ($validated['questions'] as $q) {
            $question = Question::create([
                'type' => $q['type'],
                'text' => $q['text'],
                'answer_explanation' => $q['answer_explanation'] ?? null,
                'code_snippet' => $q['code_snippet'] ?? null,
                'more_info_link' => $q['more_info_link'] ?? null,
            ]);

            // Save options depending on type
            if ($q['type'] === 'multiple_choice' && !empty($q['options'])) {
                foreach ($q['options'] as $opt) {
                    $question->options()->create([
                        'text' => $opt['text'],
                        'correct' => $opt['correct'] ?? false,
                    ]);
                }
            } elseif ($q['type'] === 'true_false') {
                $question->options()->create([
                    'text' => 'True',
                    'correct' => isset($q['true_false_correct']) ? (bool)$q['true_false_correct'] : false,
                ]);
                $question->options()->create([
                    'text' => 'False',
                    'correct' => isset($q['true_false_correct']) ? !(bool)$q['true_false_correct'] : true,
                ]);
            } elseif ($q['type'] === 'fill_in_blanks' && !empty($q['options'])) {
                foreach ($q['options'] as $opt) {
                    $question->options()->create([
                        'text' => $opt['text'],
                        'correct' => $opt['correct'] ?? false,
                    ]);
                }
            }
        }

        return redirect()->route('quiz.questions.index')->with('success', 'Questions saved successfully.');
    }


    public function data(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'] ?? null;

        $query = Question::with('options');

        if (!empty($searchValue)) {
            $query->where('text', 'like', '%' . $searchValue . '%');
        }

        $query->orderBy('id', 'desc');


        $totalRecords = Question::count();
        $totalFiltered = $query->count();

        $questions = $query->offset($start)->limit($length)->get();

        $data = [];
        $i = $start + 1;

        foreach ($questions as $question) {
            $optionLines = [];
            $correctAnswer = '';

            foreach ($question->options as $opt) {
                $optionLines[] = $opt->text . '.';

                if ($opt->correct) {
                    $correctAnswer = $opt->text;
                }
            }

            // Join options with newline for vertical stacking
            $optionText = implode('<br>', $optionLines);

            $data[] = [
                'DT_RowIndex' => $i++,
                'id' => $question->id,
                'question' => Str::limit($question->text, 80),
                'type' => ucwords(str_replace('_', ' ', $question->type)),
                'options' => $optionText,
                'correct' => $correctAnswer ?: '-',
                'explanation' => $question->answer_explanation ?: '-',
                'action' => '
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item editQuestionBtn" data-id="' . $question->id . '">
                            <i class="fas fa-edit text-warning me-1"></i> Edit
                        </a>
                    </li>
                    <li>
                        <form action="' . route('quiz.questions.destroy', $question->id) . '" method="POST" class="delete-question-form" style="margin:0;">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="button" class="dropdown-item text-danger sweet-delete-btn">
                                <i class="fas fa-trash me-1"></i> Delete
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        ',
            ];
        }

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data,
        ]);
    }

    // Example update method for editing question (you need to implement validation and saving logic)
    public function update(Request $request, $id)
    {
        // Fetch question
        $question = Question::findOrFail($id);

        // Update logic here, e.g.
        // $question->text = $request->input('text');
        // $question->save();

        return response()->json(['success' => true, 'message' => 'Question updated successfully']);
    }

    // Delete question
    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return redirect()->back()->with('success', 'Question deleted successfully');
    }
}
