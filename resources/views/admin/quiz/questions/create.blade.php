@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Add Question </h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Tables</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Tables</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <div class="d-flex gap-2">
                    <div class="position-relative">
                        <button class="btn btn-primary btn-wave" type="button" id="dropdownMenuClickableInside"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            Filter By <i class="ri-arrow-down-s-fill ms-1"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuClickableInside">
                            <li><a class="dropdown-item" href="javascript:void(0);">Today</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Yesterday</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Last 7 Days</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Last 30 Days</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Last 6 Months</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Last Year</a></li>
                        </ul>
                    </div>
                    <a href="{{ route('quiz.questions.index') }}" class="btn btn-secondary">← Back to List</a>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <h5 class="mb-4">Question Generator</h5>
                    </div>
                    <div class="card-body">

                        {{-- Generator Form --}}
                        <form id="generateForm" onsubmit="generateQuestions(event)">
                            <div class="row align-items-end mb-4">
                                <div class="col-md-2">
                                    <label class="form-label">Question Type <span class="text-danger">*</span></label>
                                    <select id="questionType" class="form-select" required>
                                        <option value="" disabled selected>Select question type</option>
                                        <option value="multiple_choice">Multiple Choice</option>
                                        <option value="true_false">True / False</option>
                                        <option value="fill_in_blanks">Fill in the Blanks</option>
                                    </select>
                                    <span class="text-danger d-none" id="typeError">Please select a question type.</span>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Topic <span class="text-danger">*</span></label>
                                    <input type="text" id="topic" class="form-control" required
                                        placeholder="e.g., PHP, Laravel, JavaScript">
                                    <span class="text-danger d-none" id="topicError">Please enter a topic.</span>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Number of Questions <span class="text-danger">*</span></label>
                                    <input type="number" id="questionCount" class="form-control" min="1"
                                        max="20" required>
                                    <span class="text-danger d-none" id="countError">Enter a number between 1 and 20.</span>
                                </div>

                                <div class="col-md">
                                    <button type="submit" class="btn btn-success w-100">Generate</button>
                                </div>
                            </div>
                        </form>


                        <form action="{{ route('quiz.questions.store') }}" method="POST" id="saveForm" class="mt-4">
                            @csrf
                            <div id="generatedQuestions"></div>
                            <button type="submit" class="btn btn-primary mt-4 d-none" id="saveBtn">Save All
                                Questions</button>
                        </form>

                        {{-- <hr class="my-5">
                        <h3>Existing Questions</h3>
                        @if ($questions->count())
                            @foreach ($questions as $question)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5>{{ $question->text }}</h5>
                                        <ul class="list-unstyled">
                                            @php $labels = ['A','B','C','D']; @endphp
                                            @foreach ($question->options as $key => $opt)
                                                <li><strong>{{ $labels[$key] ?? '?' }})</strong> {{ $opt->text }}
                                                    @if ($opt->correct)
                                                        <span class="badge bg-success">Correct</span>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                        @if ($question->answer_explanation)
                                            <p><strong>Explanation:</strong> {{ $question->answer_explanation }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>No questions found.</p>
                        @endif --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#questionType').select2({
                placeholder: "Select question type",
                allowClear: true,
                minimumResultsForSearch: Infinity // hides search box since only 3 options
            });
        });

        async function generateQuestions(e) {
            e.preventDefault();

            const selectedType = $('#questionType').val(); // single string
            const topic = document.getElementById('topic').value.trim();
            const count = parseInt(document.getElementById('questionCount').value);

            const container = document.getElementById('generatedQuestions');
            container.innerHTML = '<p>Generating questions using AI...</p>';
            document.getElementById('saveBtn').classList.add('d-none');

            if (!selectedType) {
                container.innerHTML = `<p class="text-danger">Please select a question type.</p>`;
                return;
            }
            if (!topic) {
                container.innerHTML = `<p class="text-danger">Please enter a topic.</p>`;
                return;
            }
            if (!count || count < 1) {
                container.innerHTML = `<p class="text-danger">Please enter a valid number of questions.</p>`;
                return;
            }

            try {
                const response = await fetch("{{ route('quiz.questions.generate.ai') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        type: [selectedType], // Wrap in array to keep API consistent
                        topic,
                        count
                    })
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    container.innerHTML =
                        `<p class="text-danger">Error: ${errorData.error || 'Failed to generate questions'}</p>`;
                    return;
                }

                const data = await response.json();

                if (!data.questions || !Array.isArray(data.questions)) {
                    container.innerHTML = `<p class="text-danger">Invalid question data received.</p>`;
                    return;
                }

                container.innerHTML = '';
                document.getElementById('saveBtn').classList.remove('d-none');

                data.questions.forEach((q, i) => {
                    if (!q.type) {
                        q.type = selectedType;
                    }

                    let html = `<div class="card mb-3"><div class="card-body">
                    <strong>Q${i + 1} (${q.type.replace('_', ' ')}):</strong> ${q.text}
                    <input type="hidden" name="questions[${i}][text]" value="${q.text}">
                    <input type="hidden" name="questions[${i}][type]" value="${q.type}">
                    <input type="hidden" name="questions[${i}][answer_explanation]" value="${q.explanation || ''}">
                    <input type="hidden" name="questions[${i}][code_snippet]" value="${q.code || ''}">
                    <input type="hidden" name="questions[${i}][more_info_link]" value="${q.more_info || ''}">`;

                    if (q.type === 'multiple_choice') {
                        html += `<ul class="list-unstyled mt-2">`;
                        if (Array.isArray(q.options)) {
                            q.options.forEach((opt, j) => {
                                html +=
                                    `<li><strong>${String.fromCharCode(65 + j)})</strong> ${opt.text} ${opt.correct ? '<span class="badge bg-success">Correct</span>' : ''}</li>
                            <input type="hidden" name="questions[${i}][options][${j}][text]" value="${opt.text}">
                            <input type="hidden" name="questions[${i}][options][${j}][correct]" value="${opt.correct ? 1 : 0}">`;
                            });
                        }
                        html += `</ul>`;
                    } else if (q.type === 'true_false') {
                        html += `<p class="mt-2"><strong>Answer:</strong> ${q.correct ? 'TRUE' : 'FALSE'}</p>
                    <input type="hidden" name="questions[${i}][true_false_correct]" value="${q.correct ? 1 : 0}">`;
                    } else if (q.type === 'fill_in_blanks') {
                        html += `<ul class="list-unstyled mt-2">`;
                        if (Array.isArray(q.options)) {
                            q.options.forEach((opt, j) => {
                                html += `<li>
                <strong>${String.fromCharCode(65 + j)})</strong> ${opt.text} 
                ${opt.correct ? '<span class="badge bg-success">Correct</span>' : ''}
            </li>
            <input type="hidden" name="questions[${i}][options][${j}][text]" value="${opt.text}">
            <input type="hidden" name="questions[${i}][options][${j}][correct]" value="${opt.correct ? 1 : 0}">`;
                            });
                        }
                        html += `</ul>`;
                    }

                    html += `</div></div>`;

                    container.insertAdjacentHTML('beforeend', html);
                });

            } catch (error) {
                container.innerHTML = `<p class="text-danger">Error generating questions: ${error.message}</p>`;
            }
        }
    </script>
@endpush
