<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizResult;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class QuizController extends Controller
{
    public function index()
    {

        $courses = Course::get();
        $questions = Question::get();

        return view('admin.quiz.index', compact('courses', 'questions'));
    }

    public function quiz_data(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'] ?? null;

        $query = Quiz::withCount(['courses', 'questions']);

        if (!empty($searchValue)) {
            $query->where('title', 'like', '%' . $searchValue . '%');
        }

        $totalRecords = Quiz::count();
        $totalFiltered = $query->count();

        $quizzes = $query->orderBy('id', 'desc')
            ->offset($start)
            ->limit($length)
            ->get();


        $data = [];
        $i = 1;

        foreach ($quizzes as $quiz) {
            $deleteUrl = route('quiz.quiz_destroy', $quiz->id);
            $hasQuestions = $quiz->questions->count() > 0;
            $user = auth()->user();

            $items = '';

            // Roles 1 & 2: Edit + Delete
            if ($user->role_id == 1 || $user->role_id == 2) {
                $items .= '
        <li>
            <a href="javascript:void(0);" class="dropdown-item btnEditQuiz" data-id="' . $quiz->id . '">
                <i class="fas fa-edit text-warning me-1"></i> Edit
            </a>
        </li>
        <li>
            <form action="' . $deleteUrl . '" method="POST" class="delete-quiz-form" style="margin:0;">
                ' . csrf_field() . '
                <button type="submit" class="dropdown-item text-danger">
                    <i class="fas fa-trash me-1"></i> Delete
                </button>
            </form>
        </li>';
            }

            // All roles: Play Quiz (role 4 will see only this)
            $items .= '
    <li>
        <a href="' . ($hasQuestions ? route('quiz.play', $quiz->id) : 'javascript:void(0);') . '" class="dropdown-item ' . (!$hasQuestions ? 'disabled' : '') . '" ' . (!$hasQuestions ? 'aria-disabled="true" tabindex="-1"' : '') . '>
            <i class="fas fa-play-circle text-primary me-1"></i> Play Quiz
        </a>
    </li>';

            $actionHtml = '
    <div class="btn-group">
        <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-ellipsis-v"></i>
        </button>
        <ul class="dropdown-menu">
            ' . $items . '
        </ul>
    </div>';

            $data[] = [
                'DT_RowIndex' => $i++,
                'id' => $quiz->id,
                'title' => $quiz->title,
                'slug' => $quiz->slug,
                'published' => $quiz->published ? 'Yes' : 'No',
                'public' => $quiz->public ? 'Yes' : 'No',
                'courses' => $quiz->courses_count,
                'questions' => $quiz->questions_count,
                'action' => $actionHtml,
            ];
        }

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data,
        ]);
    }
    public function edit($id)
    {
        $quiz = Quiz::with(['courses:id', 'questions:id', 'courses:id,name', 'questions:id,text'])->findOrFail($id);
        return response()->json($quiz);
    }




    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:quizzes,slug',
            'published' => 'required|in:0,1',
            'public' => 'required|in:0,1',
            'courses' => 'required|array',
            'questions' => 'required|array',
            'description' => 'nullable|string',
        ]);

        $quiz = Quiz::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'published' => $request->published,
            'public' => $request->public,
            'description' => $request->description,
        ]);
        // \Illuminate\Support\Facades\DB::enableQueryLog();


        $quiz->courses()->sync($request->courses);
        $quiz->questions()->sync($request->questions);

        // dd(\Illuminate\Support\Facades\DB::getQueryLog());


        return redirect()->back()->with('success', 'Quiz created successfully.');
    }


    public function update(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:quizzes,slug,' . $quiz->id,
            'published' => 'required|in:0,1',
            'public' => 'required|in:0,1',
            'courses' => 'required|array',
            'questions' => 'required|array',
            'description' => 'nullable|string',
        ]);

        $quiz->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'published' => $request->published,
            'public' => $request->public,
            'description' => $request->description,
        ]);

        $quiz->courses()->sync($request->courses);
        $quiz->questions()->sync($request->questions);

        return redirect()->back()->with('success', 'Quiz updated successfully.');
    }

    public function play($id)
    {
        $quiz = Quiz::with(['questions.options'])->findOrFail($id);

        // Shuffle questions and their options
        $questions = $quiz->questions->shuffle()->map(function ($q) {
            return [
                'id' => $q->id,
                'text' => $q->text,
                'type' => $q->type,
                'options' => $q->options->shuffle()->map(function ($opt) {
                    return [
                        'id' => $opt->id,
                        'text' => $opt->text,
                    ];
                })->toArray(),
            ];
        })->toArray();

        $isStudent = auth()->check() && auth()->user()->role_id == 3;

        return view('admin.quiz.play.index', compact('quiz'))
            ->with('questionsJson', json_encode($questions))
            ->with('isStudent', $isStudent);
    }




    public function destroy(Request $request, $id)
    {

        $quiz = Quiz::findOrFail($id);
        $quiz->delete();


        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'quiz deleted successfully.']);
        }

        return redirect()->route('quiz.index')->with('success', 'quiz deleted successfully.');
    }
    public function submitQuiz(Request $request)
    {
        // dd($request->all());
        $quiz = Quiz::with('questions.options')->findOrFail($request->quiz_id);
        $answers = $request->input('answers', []);
        $user = auth()->user();

        $correct = 0;
        $quizQuestions = $quiz->questions;

        // Create result record
        $result = QuizResult::create([
            'quiz_id'    => $quiz->id,
            'user_id'    => $user?->id,
            'score'      => 0, // Temp
            'time_spent' => $request->time_spent ?? 0,
            'ip_address' => $request->ip(),
            'status'
        ]);

        foreach ($quizQuestions as $question) {
            $selectedOptionId = $answers[$question->id] ?? null;
            $selectedOption = $question->options->firstWhere('id', $selectedOptionId);
            $isCorrect = $selectedOption?->correct == 1;

            if ($isCorrect) {
                $correct++;
            }

            QuizAnswer::create([
                'quiz_result_id' => $result->id,
                'question_id'    => $question->id,
                'option_id'      => $selectedOption?->id,
                'correct'        => $isCorrect ? 1 : 0,
            ]);
        }

        $result->update(['score' => $correct]);

        return response()->json([
            'success' => true,
            'redirect_url' => route('quiz.result', $result->id),
        ]);
    }



    public function quizResult(Request $request, $id)
    {
        $result = QuizResult::with([
            'quiz.courses',
            'quiz.questions.options',
            'user',
            'answers.option'
        ])->findOrFail($id);

        return view('admin.quiz.result.index', compact('result'));
    }

    public function downloadCertificate($id)
    {
        // $result = QuizResult::with(['quiz', 'user'])->findOrFail($id);



        // $pdf = Pdf::loadView('admin.quiz.certificate.index', compact('result'));
        // return $pdf->download('certificate.pdf');
        $result = QuizResult::with('user', 'user')->findOrFail($id);

        $pdf = PDF::loadView('admin.quiz.certificate.index', ['result' => $result])
            ->setPaper('a4', 'landscape');

        return $pdf->download('certificate.pdf');

        // return $pdf->download('certificate.pdf');
        // return view('admin.quiz.certificate.index',compact('result'));
    }
}
