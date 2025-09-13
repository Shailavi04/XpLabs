@extends('frontend.web_layout.master')

@section('content')

<!-- Breadcrumb -->
<div class="breadcrumb-bar text-center" style="padding: 100px 0; margin-top: 80px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
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
        <!-- profile box -->
        @include('frontend.dashboards.profileBox')

        <div class="row">
            <!-- sidebar -->
            @include('frontend.dashboards.sidebar')
            <!-- sidebar -->

            <div class="col-lg-9 quiz-wizard">
                <fieldset id="first-field">
                    <div class="page-title d-flex align-items-center justify-content-between">
                        <h5>My Quiz Attempts</h5>
                    </div>
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
                </fieldset>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log("Script is running!");
    
    const questions = @json($questions);
    let currentStep = 0;
    const totalSteps = questions.length;
    const container = document.getElementById('questionContainer');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const finishBtn = document.getElementById('finishBtn');
    const stepCount = document.getElementById('stepCount');
    const answers = {};
    let secondsSpent = 0;
    let timerInterval = null;

    function updateStepCount() {
        stepCount.textContent = `Question ${currentStep + 1} of ${totalSteps}`;
    }

    function renderQuestion() {
        const q = questions[currentStep];

        container.innerHTML = `
            <div class="border p-3 mb-3 rounded-2">
                <h6 class="mb-3">${q.text}</h6>
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

    finishBtn.addEventListener('click', () => {
        Swal.fire({
            title: 'Submit Quiz?',
            text: `You attempted ${Object.keys(answers).length} out of ${totalSteps} questions.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Submit',
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("{{ route('frontend.dashboards.submitQuiz') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        quiz_id: {{ $quiz->id }},
                        answers: answers,
                        time_spent: secondsSpent
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.redirect_url) {
                        window.location.href = data.redirect_url;
                    } else {
                        Swal.fire('Error', 'Something went wrong!', 'error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire('Error', 'Something went wrong!', 'error');
                });
            }
        });
    });

    function startTimer() {
        timerInterval = setInterval(() => {
            secondsSpent++;
            document.getElementById('quizTimer').textContent = `Time: ${secondsSpent}s`;
        }, 1000);
    }

    function stopTimer() {
        clearInterval(timerInterval);
    }

    renderQuestion();
    startTimer();
});
</script>
@endpush
