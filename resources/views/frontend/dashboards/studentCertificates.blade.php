@extends('frontend.web_layout.master')

@section('content')

<!-- Breadcrumb -->
<div class="breadcrumb-bar text-center" style="padding: 100px 0; margin-top: 80px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title mb-2">My Certificates</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('frontend.layout.index') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Certificates</li>
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
        <!-- /profile box -->

        <div class="row">

            <!-- sidebar -->
            @include('frontend.dashboards.sidebar')
            <!-- /sidebar -->

            <div class="col-lg-9">
                <div class="page-title d-flex align-items-center justify-content-between mb-3">
                    <h5>My Certificates</h5>
                </div>

                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Certificate Name</th>
                                        <th>Date</th>
                                        <th>Marks</th>
                                        <th>Out of</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($certificates as $index => $certificate)
                                    <tr>
                                        <td>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>

                                        {{-- Make certificate name clickable --}}
                                        <td>
                                            @if($certificate->image)
                                            <a href="{{ route('viewCertificate', $certificate->id) }}" target="_blank" class="fw-semibold view-certificate" data-url="{{ route('viewCertificate', $certificate->id) }}">
                                                {{ $certificate->about ?? 'Certificate' }}
                                            </a>
                                            @else
                                            {{ $certificate->about ?? 'Certificate' }}
                                            @endif
                                        </td>
                                        <td>{{ date('d M Y', strtotime($certificate->created_at)) }}</td>
                                        <td>{{ $certificate->result->score ?? '0' }}</td>
                                        <td>{{ $certificate->quiz->questions->count() ?? '0' }}</td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                {{-- View certificate --}}
                                                @if($certificate->image)

                                                @endif

                                                {{-- Download certificate --}}
                                                @if($certificate->image)
                                                <a href="{{ route('quiz.download.certificate', $certificate->id) }}">
                                                    <i class="isax isax-import"></i>
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No certificates found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Certificate viewer section --}}
                <div id="certificate-viewer" class="mt-4" style="display: none;">
                    <h5>Certificate Preview</h5>
                    <iframe id="certificate-frame" src="" width="100%" height="600px" style="border: 1px solid #ccc;"></iframe>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Open certificate in iframe when clicking on name
        document.querySelectorAll('.view-certificate').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                const pdfUrl = this.getAttribute('data-url');
                const viewer = document.getElementById('certificate-viewer');
                const frame = document.getElementById('certificate-frame');

                frame.src = pdfUrl;
                viewer.style.display = 'block';
                frame.scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Existing download logic remains unchanged
        document.querySelectorAll('.download-certificate').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const downloadUrl = this.href;

                const a = document.createElement('a');
                a.href = downloadUrl;
                a.download = ''; // optional: browser uses filename from response
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            });
        });
    });
</script>
@endpush