@extends('admin.layouts.app')

@section('content')

    <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h1 class="page-title fw-medium fs-18 mb-2">Course List</h1>
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


               
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">

                    <form method="POST" action="{{ route('web_pages.update', $key) }}" enctype="multipart/form-data">
                        @csrf

                        @foreach ($config['content'] ?? [] as $field => $type)
                            @if (is_array($type) && ($type['type'] ?? '') === 'repeater')
                                @php
                                    $items = $section->data[$field] ?? [];
                                @endphp
                                <div class="mb-4">
                                    <h5>{{ ucfirst($field) }}</h5>

                                    <button type="button" class="btn btn-primary mb-2"
                                        onclick="showRepeaterModal('{{ $field }}')">Add</button>

                                    <table class="table table-bordered" id="table_{{ $field }}">
                                        <thead>
                                            <tr>
                                                @foreach ($type['fields'] as $col => $colType)
                                                    <th>{{ ucfirst($col) }}</th>
                                                @endforeach
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody_{{ $field }}">
                                            @foreach ($items as $index => $item)
                                                <tr data-index="{{ $index }}">
                                                    @foreach ($type['fields'] as $col => $colType)
                                                        <td>{{ $item[$col] ?? '' }}</td>
                                                    @endforeach
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="removeRepeaterRow('{{ $field }}', {{ $index }})">Delete</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <input type="hidden" name="content[{{ $field }}]"
                                        id="input_{{ $field }}" value="{{ json_encode($items) }}">
                                </div>
                                @continue
                            @endif

                            {{-- Handle file/image upload if field key is "images" and it's an array --}}
                            @if ($field === 'images' && is_array($type))
                                <div class="mb-3">
                                    <label class="form-label">Upload Images</label>
                                    <input type="file" class="multiple-filepond" name="images[]" multiple
                                        data-allow-reorder="true" data-max-file-size="3MB" data-max-files="6"
                                        accept="image/*">
                                </div>

                                @if (!empty($section->data['images']) && is_array($section->data['images']))
                                    <div class="mb-3">
                                        <div class="d-flex flex-wrap gap-3">
                                            @foreach ($section->data['images'] as $img)
                                                <img src="{{ asset($img) }}" alt="Uploaded Image"
                                                    style="max-height: 100px; border-radius: 6px;">
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                @continue
                            @endif

                            {{-- Handle nested object like filter --}}
                            @if (is_array($type))
                                <div class="mb-3">
                                    <label class="form-label">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                                    @foreach ($type as $subfield => $subtype)
                                        <input type="text" name="content[{{ $field }}][{{ $subfield }}]"
                                            value="{{ $section->data[$field][$subfield] ?? '' }}"
                                            class="form-control mb-2">
                                    @endforeach
                                </div>
                                @continue
                            @endif

                            {{-- Rich textarea --}}
                            @if ($type === 'textarea-rich' || $type === 'textarea')
                                <div class="mb-3">
                                    <label class="form-label">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                                    <textarea name="content[{{ $field }}]" class="form-control" rows="5">{{ $section->data[$field] ?? '' }}</textarea>
                                </div>
                                @continue
                            @endif

                            {{-- Default input --}}
                            <div class="mb-3">
                                <label class="form-label">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                                <input type="text" name="content[{{ $field }}]"
                                    value="{{ $section->data[$field] ?? '' }}" class="form-control">
                            </div>
                        @endforeach

                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection


@push('script')
    <script>
        $(document).ready(function() {
            FilePond.registerPlugin(
                FilePondPluginImagePreview,
                FilePondPluginFileValidateSize,
                FilePondPluginFileEncode,
                FilePondPluginFileValidateType,
                FilePondPluginImageCrop,
                FilePondPluginImageResize,
                FilePondPluginImageTransform,
                FilePondPluginImageEdit
            );

            document.querySelectorAll('.multiple-filepond').forEach(input => {
                FilePond.create(input, {
                    allowMultiple: true,
                    allowReorder: true,
                    maxFiles: 6,
                    maxFileSize: '3MB',
                    acceptedFileTypes: ['image/*'],
                });
            });
        });
    </script>
@endpush
