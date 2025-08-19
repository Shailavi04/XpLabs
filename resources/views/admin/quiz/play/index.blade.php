@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="my-2 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Play Quiz</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Play</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Quiz</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">



                <div class="card custom-card mt-4 {{ !$isStudent ? 'd-none' : '' }}" id="quizContainer">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Quiz: {{ $quiz->title }}</h5>
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <span class="badge bg-secondary">{{ $quiz->questions->count() }} Questions</span>
                            <span class="badge bg-warning text-dark" id="quizTimer">Time: 0s</span>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="mb-3 text-end">
                            <span id="stepCount" class="badge bg-primary fs-6 px-3 py-2"></span>
                        </div>
                        <div id="questionContainer" class="mb-4"></div>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <button type="button" class="btn btn-secondary" id="prevBtn" disabled>Previous</button>
                            <button type="button" class="btn btn-primary" id="nextBtn">Next</button>
                            <button type="button" class="btn btn-success d-none" id="finishBtn">Finish</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const questions = {!! $questionsJson !!};
        let currentStep = 0;
        const totalSteps = questions.length;
        const container = document.getElementById('questionContainer');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const finishBtn = document.getElementById('finishBtn');
        const stepCount = document.getElementById('stepCount');
        const answers = {};

        function updateStepCount() {
            stepCount.textContent = `Question ${currentStep + 1} of ${totalSteps}`;
        }

        function renderQuestion() {
            const q = questions[currentStep];
            container.innerHTML = `
                <div>
                    <h5 class="mb-3">Q${currentStep + 1}: ${q.text}</h5>
                    ${q.options.map((opt, i) => `
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="question_${q.id}" id="opt_${q.id}_${i}" value="${opt.id}"
                                ${answers[q.id] == opt.id ? 'checked' : ''}>
                            <label class="form-check-label" for="opt_${q.id}_${i}">${opt.text}</label>
                        </div>
                    `).join('')}
                </div>
            `;

            container.querySelectorAll('input[type="radio"]').forEach(r => {
                r.addEventListener('change', () => {
                    answers[q.id] = parseInt(r.value);
                    updateStepCount();
                });
            });

            prevBtn.disabled = currentStep === 0;
            nextBtn.classList.toggle('d-none', currentStep === totalSteps - 1);
            finishBtn.classList.toggle('d-none', currentStep !== totalSteps - 1);

            updateStepCount();
        }

        prevBtn.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                renderQuestion();
            }
        });

        nextBtn.addEventListener('click', () => {
            if (currentStep < totalSteps - 1) {
                currentStep++;
                renderQuestion();
            }
        });

        let secondsSpent = 0;
        let timerInterval = null;

        function startTimer() {
            timerInterval = setInterval(() => {
                secondsSpent++;
                document.getElementById('quizTimer').textContent = `Time: ${secondsSpent}s`;
            }, 1000);
        }

        function stopTimer() {
            clearInterval(timerInterval);
        }

        finishBtn.addEventListener('click', () => {
            Swal.fire({
                title: 'Submit Quiz?',
                text: `You attempted ${Object.keys(answers).length} out of ${totalSteps} questions.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Submit',
            }).then((result) => {
                if (result.isConfirmed) {
                    const payload = {
                        quiz_id: {{ $quiz->id }},
                        answers: answers,
                        guest_name: null, // or pass if needed
                        time_spent: secondsSpent,
                    };

                    fetch("{{ route('quiz.submit') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success && data.redirect_url) {
                            window.location.href = data.redirect_url;
                        } else {
                            Swal.fire('Error', 'Something went wrong!', 'error');
                        }
                    })
                    .catch(err => Swal.fire('Error', 'Submission failed.', 'error'));
                }
            });
        });

        // Hide quiz container initially (in Blade it should have d-none)
        // Show SweetAlert right away
        Swal.fire({
            title: 'Start Quiz?',
            text: `Get ready for the quiz: {{ $quiz->title }}`,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Start',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('quizContainer').classList.remove('d-none');
                startTimer();
                renderQuestion();
            } else {
                // Optional: you can redirect or show a message here if needed
            }
        });

    });
</script>
@endpush

