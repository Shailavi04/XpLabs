@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Quiz Result</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Quiz</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Result</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 ">
                <div class="card custom-card">
                    <div class="card-body">
                        <h4 class="mb-3">{{ $result->quiz->title }}</h4>

                        <ul class="list-group mb-4">
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Student Name:</strong>
                                <span>{{ $result->user?->name ?? '-' }}</span>
                            </li>
                            {{-- <li class="list-group-item d-flex justify-content-between">
                                <strong>Course(s):</strong>
                                <span>
                                    {{ $result->quiz->courses->pluck('name')->join(', ') ?: '-' }}
                                </span>
                            </li> --}}
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Quiz Name:</strong>
                                <span>{{ $result->quiz->title }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Score:</strong>
                                <span>{{ $result->score }} / {{ $result->quiz->questions->count() }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Time Spent:</strong>
                                <span>{{ gmdate('i:s', $result->time_spent) }} mins</span>
                            </li>
                        </ul>

                        <hr>
                        <h5 class="mb-3">Summary:</h5>
                        @foreach ($result->quiz->questions as $index => $question)
                            @php
                                // Get the user's answer for this question
$userAnswer = $result->answers->firstWhere('question_id', $question->id);
                            @endphp

                            <div class="mb-4 p-3 border rounded">
                                <p><strong>Q{{ $index + 1 }}:</strong> {!! $question->text !!}</p>

                                @if ($question->options && $question->options->count())
                                    <ul class="list-group">
                                        @foreach ($question->options as $option)
                                            @php
                                                $isUserSelected = $userAnswer && $userAnswer->option_id == $option->id;
                                                $isCorrect = $option->correct == 1;
                                            @endphp
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center
                        @if ($isCorrect) list-group-item-success
                        @elseif ($isUserSelected) list-group-item-danger @endif">
                                                <span>{!! $option->text !!}</span>
                                                <span>
                                                    @if ($isCorrect)
                                                        ✅
                                                    @endif
                                                    @if ($isUserSelected)
                                                        <strong>{{ $isCorrect ? '(Correct)' : '(Your Answer)' }}</strong>
                                                    @endif
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted">No options available for this question.</p>
                                @endif

                                @if ($question->answer_explanation)
                                    <div class="mt-2">
                                        <strong class="mb-3">Explanation:</strong><br>
                                        <div>{!! $question->answer_explanation !!}</div>
                                    </div>
                                @endif
                            </div>
                        @endforeach






                        <div class="mt-4 text-end">
                            <a href="{{ route('quiz.index') }}" class="btn btn-secondary">Back to Quiz List</a>
                            <a href="{{ route('quiz.download.certificate', $result->id) }}" class="btn btn-primary ms-2">
                                Download Certificate
                            </a>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
@endpush
