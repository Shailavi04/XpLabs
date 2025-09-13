@extends('frontend.web_layout.master')

@section('content')

<!-- Breadcrumb -->
<div class="breadcrumb-bar text-center" style="padding: 100px 0; margin-top: 80px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="breadcrumb-title mb-2">My Quiz Attempts</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('frontend.layout.index') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Quiz Attempts</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->

<div class="content">
    <div class="container">
        <!-- Profile Box -->
        @include('frontend.dashboards.profileBox')

        <div class="row">
            <!-- Sidebar -->
            @include('frontend.dashboards.sidebar')

            <!-- Main Content -->
            <div class="col-xl-9 col-lg-8 col-md-12">
                <div class="my-4 page-header-breadcrumb text-center">
                    <h1 class="page-title fw-bold fs-3 mb-4 text-dark dark:text-light">Quiz Result</h1>
                </div>

                <div class="card shadow-sm custom-card bg-white dark:bg-dark text-dark dark:text-light">
                    <div class="card-body">

                        <h4 class="mb-4 text-primary dark:text-info">{{ $quiz->title ?? 'Quiz Name' }}</h4>

                        <!-- Student Info -->
                        <div class="card mb-4 p-3 border-0 shadow-sm bg-white dark:bg-gray-800 text-dark dark:text-white">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between bg-white dark:bg-gray-800 text-dark dark:text-white">
                                    <strong>Student Name:</strong>
                                    <span>{{ auth()->user()->name }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between bg-white dark:bg-gray-800 text-dark dark:text-white">
                                    <strong>Score:</strong>
                                    <span>{{ $score ?? 0 }} / {{ $totalQuestions ?? 0 }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between bg-white dark:bg-gray-800 text-dark dark:text-white">
                                    <strong>Time Spent:</strong>
                                    <span>{{ $timeSpent ?? '00:00 mins' }}</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Loop through questions -->
                        @foreach($questions as $q)
                        <div class="mb-4 p-3 border rounded shadow-sm bg-white dark:bg-gray-800 text-dark dark:text-white">
                            <p class="fw-semibold"><strong>Q{{ $loop->iteration }}:</strong> {{ $q->text }}</p>

                            @php
                            // Get the user's selected answer for this question
                            $userAnswer = $result->answers->firstWhere('question_id', $q->id);
                            @endphp

                            <ul class="list-none p-0">
                                @foreach($q->options as $opt)
                                @php
                                $isCorrect = $opt->correct == 1;
                                $isYourAnswer = $userAnswer && $userAnswer->option_id == $opt->id;

                                // Set background based on correctness
                                $bgClass = 'bg-white dark:bg-gray-700 text-dark dark:text-white'; // default
                                if ($isCorrect) {
                                $bgClass = 'bg-green-100 dark:bg-green-700 text-dark dark:text-white';
                                } elseif ($isYourAnswer && !$isCorrect) {
                                $bgClass = 'bg-red-100 dark:bg-red-700 text-dark dark:text-white';
                                }
                                @endphp
                                <li class="flex justify-between p-2 mb-1 rounded {{ $bgClass }}">
                                    <span>{{ $opt->text }}</span>
                                    <span>
                                        @if($isCorrect) ✅ @endif
                                        @if($isYourAnswer && !$isCorrect)
                                        <strong>(Your Answer)</strong>
                                        @elseif($isYourAnswer && $isCorrect)
                                        <strong>(Correct)</strong>
                                        @endif
                                    </span>
                                </li>
                                @endforeach
                            </ul>

                            @if($q->answer_explanation)
                            <div class="mt-2">
                                <button class="btn btn-sm btn-outline-info mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#explanation-{{ $loop->iteration }}" aria-expanded="false" aria-controls="explanation-{{ $loop->iteration }}">
                                    Show Explanation
                                </button>
                                <div class="collapse p-2 rounded bg-gray-100 dark:bg-gray-700 text-dark dark:text-white" id="explanation-{{ $loop->iteration }}">
                                    {{ $q->answer_explanation }}
                                </div>
                            </div>
                            @endif
                        </div>
                        @endforeach
                        <!-- Buttons -->
                        <a href="{{ route('quiz.download.certificate', $result->id) }}"
                            class="btn btn-primary ms-2 download-certificate">
                            Download Certificate
                        </a>
                    </div>
                </div>
            </div>

            <!-- /Main Content -->
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    document.querySelectorAll('.download-certificate').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();

            const downloadUrl = this.href;

            const a = document.createElement('a');
            a.href = downloadUrl;
            a.download = '';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);

            setTimeout(() => {
                window.location.href = "{{ route('frontend.dashboards.studentCertificates') }}";
            }, 500);
        });
    });
</script>

@endpush