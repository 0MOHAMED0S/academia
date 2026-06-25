@extends('layouts.main')

@section('title', __('messages.lesson_edit_title', ['title' => $lesson->title]))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/home.css') }}">
<link rel="stylesheet" href="{{ asset('main_pages_style/instructor_lessons_edit.css') }}">
<style>
    body { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('courses.show', $lesson->course_id) }}" class="btn btn-outline-primary btn-back-custom">
                    <i class="fa-solid fa-arrow-right me-2"></i> {{ __('messages.lesson_back_to_course') }}
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                    <i class="fa-solid fa-circle-xmark me-2"></i>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div id="uploadStatus" class="upload-progress">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <strong id="uploadStatusText">{{ __('messages.instructor_uploading') }}</strong>
                    <span id="uploadPercent">0%</span>
                </div>
                <div class="upload-progress-bar">
                    <div id="uploadProgressFill" class="upload-progress-fill"></div>
                </div>
            </div>

            <div id="uploadMessage"></div>

            <div class="edit-card">
                <div class="edit-card-header">
                    <h2><i class="fa-solid fa-pen-to-square me-2"></i> {{ __('messages.lesson_edit_heading') }}</h2>
                    <p class="subtitle">{{ __('messages.lesson_current_label', ['title' => $lesson->course->title]) }}</p>
                </div>

                <div class="edit-card-body">
                    <form id="lessonEditForm" method="POST" action="{{ route('instructor.lesson.update', $lesson) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label"><i class="fa-solid fa-heading me-1 text-primary"></i> {{ __('messages.lesson_edit_video_title') }}</label>
                            <input type="text" name="title" id="lessonTitle" class="form-control"
                                value="{{ old('title', $lesson->title) }}" required
                                placeholder="{{ __('messages.lesson_edit_video_title') }}">
                        </div>

                        <div class="mb-4">
                            <label class="form-label"><i class="fa-solid fa-align-right me-1 text-primary"></i> {{ __('messages.lesson_edit_description') }}</label>
                            <textarea name="description" id="lessonDescription" class="form-control" rows="5"
                                placeholder="{{ __('messages.lesson_edit_description') }}">{{ old('description', $lesson->description) }}</textarea>
                        </div>

                        <div class="current-video-preview">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="video-icon">
                                    <i class="fa-solid fa-video"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ __('messages.lesson_video_current') }}</h6>
                                    <span class="badge bg-success mt-1">{{ __('messages.lesson_video_uploaded') }}</span>
                                </div>
                            </div>

                            @if(\Illuminate\Support\Str::startsWith($lesson->video_path, ['http://', 'https://']))
                                <div class="d-flex align-items-center gap-2 small text-muted">
                                    <i class="fa-solid fa-link"></i>
                                    <a href="{{ $lesson->video_path }}" target="_blank" class="text-decoration-none">{{ \Illuminate\Support\Str::limit($lesson->video_path, 60) }}</a>
                                </div>
                            @else
                                <div class="ratio ratio-16x9 video-wrapper">
                                    <video controls preload="metadata">
                                        <source src="{{ asset($lesson->video_path) }}" type="video/mp4">
                                        {{ __('messages.lesson_browser_not_supported') }}
                                    </video>
                                </div>
                            @endif
                        </div>

                        <div class="info-box">
                            <i class="fa-solid fa-circle-info text-warning me-1"></i>
                            <strong>{{ __('messages.lesson_video_note') }}</strong> {!! __('messages.lesson_video_replacement_note') !!}
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="fa-solid fa-cloud-arrow-up me-1 text-primary"></i> {{ __('messages.lesson_edit_video_file') }}</label>
                            <div class="file-upload-zone" onclick="document.getElementById('video_file_input').click()">
                                <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
                                <p class="file-name" id="file-name-display">{{ __('messages.lesson_click_to_choose') }}</p>
                                <p class="file-hint">{{ __('messages.lesson_file_hint') }}</p>
                            </div>
                            <input type="file" id="video_file_input" name="video_file"
                                accept="video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/webm"
                                class="d-none">
                        </div>

                        <div class="or-divider">{{ __('messages.lesson_or') }}</div>

                        <div class="mb-4">
                            <label class="form-label"><i class="fa-solid fa-link me-1 text-primary"></i> {{ __('messages.lesson_new_video_link') }}</label>
                            <input type="url" name="video_path" class="form-control"
                                value="{{ old('video_path') }}"
                                placeholder="https://www.youtube.com/watch?v=...">
                        </div>

                        <button type="submit" id="saveButton" class="btn btn-save w-100">
                            <i class="fa-solid fa-floppy-disk me-2"></i> {{ __('messages.lesson_edit_save') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const lessonEditForm     = document.getElementById('lessonEditForm');
    const videoFileInput     = document.getElementById('video_file_input');
    const fileNameDisplay    = document.getElementById('file-name-display');
    const uploadStatus       = document.getElementById('uploadStatus');
    const uploadStatusText   = document.getElementById('uploadStatusText');
    const uploadPercent      = document.getElementById('uploadPercent');
    const uploadProgressFill = document.getElementById('uploadProgressFill');
    const uploadMessage      = document.getElementById('uploadMessage');
    const saveButton         = document.getElementById('saveButton');
    const csrfToken          = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const clickText = '{{ __('messages.lesson_click_to_choose') }}';
    const minError = '{{ __('messages.lesson_video_min_error') }}';
    const maxError = '{{ __('messages.lesson_video_max_error') }}';
    const validMsg = '{{ __('messages.lesson_video_valid') }}';
    const saveLabel = '{{ __('messages.lesson_edit_save') }}';
    const editSuccess = '{{ __('messages.lesson_edit_success') }}';
    const uploadErrorMsg = '{{ __('messages.lesson_upload_error') }}';
    const serverErrorMsg = '{{ __('messages.lesson_server_error') }}';
    const uploadingBase = '{{ __('messages.lesson_uploading_status', ['count' => '__CNT__']) }}';

    videoFileInput.addEventListener('change', function () {
        uploadMessage.innerHTML = '';
        if (this.files && this.files[0]) {
            const file = this.files[0];
            fileNameDisplay.textContent = file.name;
            fileNameDisplay.style.color = '#1f2c9c';
            const video = document.createElement('video');
            video.preload = 'metadata';
            const objectUrl = URL.createObjectURL(file);
            video.addEventListener('loadedmetadata', () => {
                URL.revokeObjectURL(objectUrl);
                const mins = video.duration / 60;
                if (mins < 3) {
                    uploadMessage.innerHTML = '<div class="alert alert-danger"><i class="fa-solid fa-circle-xmark me-2"></i>' + minError + '</div>';
                    videoFileInput.value = '';
                    fileNameDisplay.textContent = clickText;
                    fileNameDisplay.style.color = '';
                    return;
                }
                if (mins > 15) {
                    uploadMessage.innerHTML = '<div class="alert alert-danger"><i class="fa-solid fa-circle-xmark me-2"></i>' + maxError + '</div>';
                    videoFileInput.value = '';
                    fileNameDisplay.textContent = clickText;
                    fileNameDisplay.style.color = '';
                    return;
                }
                uploadMessage.innerHTML = '<div class="alert alert-success"><i class="fa-solid fa-circle-check me-2"></i>' + validMsg + '</div>';
            });
            video.addEventListener('error', () => URL.revokeObjectURL(objectUrl));
            video.src = objectUrl;
        } else {
            fileNameDisplay.textContent = clickText;
            fileNameDisplay.style.color = '';
        }
    });

    lessonEditForm.addEventListener('submit', function (event) {
        const file = videoFileInput.files[0];
        if (!file) return;
        event.preventDefault();
        uploadMessage.innerHTML = '';
        uploadFileInChunks(file);
    });

    function uploadFileInChunks(file) {
        const CHUNK_SIZE  = 500 * 1024;
        const totalChunks = Math.ceil(file.size / CHUNK_SIZE);
        const identifier  = 'edit_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        let currentChunk  = 0;
        let uploadError   = false;

        uploadStatus.style.display  = 'block';
        uploadStatusText.textContent = uploadingBase.replace('__CNT__', totalChunks);
        uploadPercent.textContent    = '0%';
        uploadProgressFill.style.width = '0%';
        saveButton.disabled    = true;
        saveButton.textContent = '{{ __('messages.lesson_saving') }}';

        function sendChunk() {
            if (uploadError) return;
            const start = currentChunk * CHUNK_SIZE;
            const end   = Math.min(start + CHUNK_SIZE, file.size);
            const chunk = file.slice(start, end);
            const chunkFormData = new FormData();
            chunkFormData.append('file', chunk, file.name);
            chunkFormData.append('chunkIndex', currentChunk);
            chunkFormData.append('totalChunks', totalChunks);
            chunkFormData.append('identifier', identifier);
            chunkFormData.append('originalName', file.name);
            chunkFormData.append('title', document.getElementById('lessonTitle').value);
            chunkFormData.append('description', document.getElementById('lessonDescription').value);
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route("instructor.lesson.update.chunked", $lesson) }}');
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhr.onload = function () {
                if (uploadError) return;
                let response = {};
                try { response = JSON.parse(xhr.responseText); } catch (e) { response = { success: false, message: serverErrorMsg }; }
                if (xhr.status >= 200 && xhr.status < 300 && response.success && response.complete !== false) {
                    currentChunk++;
                    const percent = Math.round((currentChunk / totalChunks) * 100);
                    uploadPercent.textContent    = Math.min(percent, 99) + '%';
                    uploadProgressFill.style.width = Math.min(percent, 99) + '%';
                    if (currentChunk < totalChunks) {
                        uploadStatusText.textContent = uploadingBase.replace('__CNT__', totalChunks) + ' - ' + currentChunk + '/' + totalChunks;
                        sendChunk();
                    } else {
                        uploadPercent.textContent = '100%';
                        uploadProgressFill.style.width = '100%';
                        uploadStatusText.textContent = editSuccess;
                        saveButton.disabled = false;
                        saveButton.innerHTML = '<i class="fa-solid fa-floppy-disk me-2"></i> ' + saveLabel;
                        uploadMessage.innerHTML = '<div class="alert alert-success"><i class="fa-solid fa-circle-check me-2"></i>' + editSuccess + '</div>';
                        if (response.redirect) setTimeout(() => window.location.href = response.redirect, 1500);
                    }
                } else if (xhr.status >= 200 && xhr.status < 300 && response.success && response.complete === false) {
                    currentChunk++;
                    const percent = Math.round((currentChunk / totalChunks) * 100);
                    uploadPercent.textContent = Math.min(percent, 99) + '%';
                    uploadProgressFill.style.width = Math.min(percent, 99) + '%';
                    sendChunk();
                } else {
                    uploadError = true;
                    saveButton.disabled = false;
                    saveButton.innerHTML = '<i class="fa-solid fa-floppy-disk me-2"></i> ' + saveLabel;
                    uploadStatus.style.display = 'none';
                    uploadMessage.innerHTML = '<div class="alert alert-danger"><i class="fa-solid fa-circle-xmark me-2"></i>' + (response.message || uploadErrorMsg) + '</div>';
                }
            };
            xhr.onerror = function () {
                uploadError = true;
                saveButton.disabled = false;
                saveButton.innerHTML = '<i class="fa-solid fa-floppy-disk me-2"></i> ' + saveLabel;
                uploadStatus.style.display = 'none';
                uploadMessage.innerHTML = '<div class="alert alert-danger"><i class="fa-solid fa-circle-xmark me-2"></i>' + serverErrorMsg.replace(':number', currentChunk + 1) + '</div>';
            };
            xhr.send(chunkFormData);
        }
        sendChunk();
    }
</script>
@endsection
