@extends('layouts.main')

@section('title', __('messages.instructor_dashboard_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/home.css') }}">
<link rel="stylesheet" href="{{ asset('main_pages_style/instructor_dashboard.css') }}">
<style>
    body { padding-top: 0 !important; }
    @if($currentDir === 'ltr')
    .layout .sidebar { border-left: none; border-right: 1px solid #e8eef8; }
    .side-link:hover { transform: translateX(5px); }
    @else
    .side-link:hover { transform: translateX(-5px); }
    @endif
    .side-link { position: relative; }
    .chat-badge {
        position: absolute;
        top: 50%;
        {{ $currentDir === 'rtl' ? 'left: 8px;' : 'right: 8px;' }}
        transform: translateY(-50%);
        background: #dc3545;
        color: #fff;
        font-size: 0.65rem;
        font-weight: 700;
        min-width: 18px;
        height: 18px;
        border-radius: 9px;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 0 5px;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.5); }
        70% { box-shadow: 0 0 0 8px rgba(220, 53, 69, 0); }
        100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }
</style>
@endsection

@section('footer')
@endsection

@section('content')
<div class="layout">
    <aside class="sidebar">
        @if($instructor->profile_photo)
            <img src="{{ asset($instructor->profile_photo) }}" class="avatar" alt="{{ $instructor->name }}">
        @else
            <div class="avatar">{{ strtoupper(substr($instructor->name, 0, 1)) }}</div>
        @endif
        <h5 class="text-center fw-bold mt-3 mb-1">{{ $instructor->name }}</h5>
        <p class="text-center text-muted small">{{ $instructor->job_title ?? __('messages.instructor_default_role') }}</p>
        <hr>
        <a class="side-link active" href="#courses"><i class="fa-solid fa-layer-group"></i> {{ __('messages.instructor_my_courses') }}</a>
        <a class="side-link" href="#free"><i class="fa-solid fa-unlock"></i> {{ __('messages.instructor_free_courses') }}</a>
        <a class="side-link" href="#paid"><i class="fa-solid fa-lock"></i> {{ __('messages.instructor_paid_courses') }}</a>
        <a class="side-link" href="#add-video"><i class="fa-solid fa-video"></i> {{ __('messages.instructor_upload_video') }}</a>
        <a class="side-link" href="{{ route('instructor.profile') }}"><i class="fa-solid fa-user-pen"></i> {{ __('messages.instructor_edit_profile') }}</a>
        <a class="side-link" href="{{ route('instructor.chat') }}"><i class="fa-solid fa-comments"></i> {{ __('messages.instructor_chat') }}<span class="chat-badge" id="chatBadge"></span></a>
        <a class="side-link" href="{{ route('instructor.student_chat') }}"><i class="fa-solid fa-envelope"></i> {{ __('messages.instructor_student_chat') }}</a>
        <form method="POST" action="{{ route('instructor.logout') }}" class="mt-3">
            @csrf
            <button class="btn btn-outline-danger w-100">{{ __('messages.instructor_logout') }}</button>
        </form>
    </aside>

    <main class="main">
        @if(session('success_profile') || session('success_course') || session('success_lesson') || session('success_login'))
            <div class="alert alert-success">{{ session('success_profile') ?? session('success_course') ?? session('success_lesson') ?? session('success_login') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="panel mb-4">
            <h2 class="fw-bold mb-1">{{ __('messages.instructor_dashboard_heading') }}</h2>
            <p class="text-muted mb-0">{{ __('messages.instructor_dashboard_sub') }}</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-5">
                <div class="panel" id="courses">
                    <h5 class="fw-bold mb-3">{{ __('messages.instructor_create_course') }}</h5>
                    <form method="POST" action="{{ route('instructor.course.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="title" class="form-control mb-3" placeholder="{{ __('messages.instructor_course_title') }}" required>
                        <div class="mb-3">
                            <label class="form-label text-muted small">{{ __('messages.instructor_course_image') }}</label>
                            
                            <input type="file" name="course_photo" class="form-control" accept="image">
                            
                        </div>
                        <select name="track_id" class="form-select mb-3">
                            <option value="">{{ __('messages.instructor_select_track') }}</option>
                            @foreach($tracks as $track)
                                <option value="{{ $track->id }}">{{ $track->name }}</option>
                            @endforeach
                        </select>
                        <select name="type" id="course_type" class="form-select mb-3" required onchange="toggleUniqueId(this.value)">
                            <option value="free">{{ __('messages.instructor_free') }}</option>
                            <option value="paid">{{ __('messages.instructor_paid') }}</option>
                        </select>
                        <div id="unique_id_wrapper" style="display: none;">
                            <label class="form-label">{{ __('messages.instructor_unique_id') }}</label>
                            <input type="text" name="unique_course_id" class="form-control mb-3" placeholder="{{ __('messages.instructor_enter_unique_id') }}">
                        </div>
                        <textarea name="description" class="form-control mb-3" rows="3" placeholder="{{ __('messages.instructor_description') }}"></textarea>
                        <textarea name="roadmap" class="form-control mb-3" rows="5" placeholder="{{ __('messages.instructor_roadmap') }}"></textarea>
                        <button class="btn btn-primary w-100">{{ __('messages.instructor_create_btn') }}</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="panel" id="add-video">
                    <h5 class="fw-bold mb-3">{{ __('messages.instructor_upload_video') }}</h5>
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
                    <form id="lessonUploadForm" method="POST" action="{{ route('instructor.lesson.store') }}" enctype="multipart/form-data">
                        @csrf
                        <select name="course_id" class="form-select mb-3" required>
                            <option value="">{{ __('messages.instructor_select_track') }}</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }} - {{ $course->type === 'paid' ? __('messages.instructor_paid') : __('messages.instructor_free') }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="title" class="form-control mb-3" placeholder="{{ __('messages.instructor_lesson_title') }}" required>
                        <textarea name="description" class="form-control mb-3" rows="3" placeholder="{{ __('messages.instructor_lesson_desc') }}"></textarea>
                        <input id="videoFileInput" type="file" name="video_file" class="form-control mb-2" accept="video">
                        <p class="small text-muted mb-3">{{ __('messages.instructor_video_hint') }}</p>
                        <input type="text" name="video_path" class="form-control mb-3" placeholder="{{ __('messages.instructor_video_link') }}">

                        <h6 class="fw-bold mt-4">{{ __('messages.instructor_quiz_questions') }}</h6>
                        @for($i = 0; $i < 5; $i++)
                            <div class="question-box">
                                <input type="text" name="questions[{{ $i }}][question]" class="form-control mb-2" placeholder="{{ __('messages.instructor_question', ['number' => $i + 1]) }}" required>
                                <div class="row g-2">
                                    <div class="col-md-6"><input type="text" name="questions[{{ $i }}][option_a]" class="form-control" placeholder="{{ __('messages.instructor_option_a') }}" required></div>
                                    <div class="col-md-6"><input type="text" name="questions[{{ $i }}][option_b]" class="form-control" placeholder="{{ __('messages.instructor_option_b') }}" required></div>
                                    <div class="col-md-6"><input type="text" name="questions[{{ $i }}][option_c]" class="form-control" placeholder="{{ __('messages.instructor_option_c') }}" required></div>
                                    <div class="col-md-6"><input type="text" name="questions[{{ $i }}][option_d]" class="form-control" placeholder="{{ __('messages.instructor_option_d') }}" required></div>
                                </div>
                                <select name="questions[{{ $i }}][correct_option]" class="form-select mt-2" required>
                                    <option value="">{{ __('messages.instructor_correct_answer') }}</option>
                                    <option value="a">A</option>
                                    <option value="b">B</option>
                                    <option value="c">C</option>
                                    <option value="d">D</option>
                                </select>
                            </div>
                        @endfor
                        <button id="lessonUploadButton" class="btn btn-primary w-100">{{ __('messages.instructor_save_video') }}</button>
                    </form>
                </div>
            </div>
        </div>

        @foreach(['free' => __('messages.instructor_free_courses'), 'paid' => __('messages.instructor_paid_courses')] as $type => $title)
            <div class="panel mt-4" id="{{ $type }}">
                <h5 class="fw-bold mb-3">{{ $title }}</h5>
                <div class="row g-3">
                    @forelse($courses->where('type', $type) as $course)
                        <div class="col-md-6 col-lg-4">
                            <div class="instructor-course-card" style="padding-top: 50px;">
                                <span class="course-type-badge {{ $type === 'free' ? 'badge-free' : 'badge-paid' }}">
                                    {{ $type === 'free' ? __('messages.instructor_free') : __('messages.instructor_paid') }}
                                </span>
                                <div class="course-card-image-wrapper mb-3" style="height: 150px; border-radius: 12px; overflow: hidden; position: relative; width: 100%;">
                                    @if($course->image_path)
                                        <img src="{{ asset($course->image_path) }}" alt="{{ $course->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #f8fafc; color: #1f2c9c; font-size: 2.5rem;">
                                            <i class="fa-solid fa-layer-group"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="course-info">
                                    <h6>{{ $course->title }}</h6>
                                </div>
                                <div class="course-stats">
                                    <span><i class="fa-solid fa-video"></i> {{ __('messages.instructor_lessons_count', ['count' => $course->lessons->count()]) }}</span>
                                    <span><i class="fa-solid fa-clock"></i> {{ $course->created_at->format('Y/m/d') }}</span>
                                </div>
                                <div class="course-actions">
                                    <a href="{{ route('courses.show', $course) }}" class="btn-premium-view text-decoration-none">{{ __('messages.instructor_view') }}</a>
                                    <a href="{{ route('instructor.course.edit', $course) }}" class="btn-premium-edit text-decoration-none">{{ __('messages.instructor_edit') }}</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12"><div class="alert alert-light border mb-0">{{ __('messages.instructor_no_courses') }}</div></div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </main>
</div>
@endsection

@section('scripts')
<script>
    function toggleUniqueId(type) {
        const wrapper = document.getElementById('unique_id_wrapper');
        const input = wrapper.querySelector('input');
        if (type === 'paid') {
            wrapper.style.display = 'block';
            input.setAttribute('required', 'required');
        } else {
            wrapper.style.display = 'none';
            input.removeAttribute('required');
        }
    }

    const minError = '{{ __('messages.instructor_video_min_error') }}';
    const maxError = '{{ __('messages.instructor_video_max_error') }}';
    const validMsg = '{{ __('messages.instructor_video_valid') }}';
    const fillQuestions = '{{ __('messages.instructor_fill_questions') }}';
    const uploading = '{{ __('messages.instructor_uploading') }}';
    const uploadProgress = '{{ __('messages.instructor_upload_progress', ['count' => '__CNT__']) }}';
    const uploadSuccess = '{{ __('messages.instructor_upload_success') }}';
    const saveLabel = '{{ __('messages.instructor_save_video') }}';

    const lessonUploadForm = document.getElementById('lessonUploadForm');
    const videoFileInput = document.getElementById('videoFileInput');
    const uploadStatus = document.getElementById('uploadStatus');
    const uploadStatusText = document.getElementById('uploadStatusText');
    const uploadPercent = document.getElementById('uploadPercent');
    const uploadProgressFill = document.getElementById('uploadProgressFill');
    const uploadMessage = document.getElementById('uploadMessage');
    const lessonUploadButton = document.getElementById('lessonUploadButton');

    if (videoFileInput) {
        videoFileInput.addEventListener('change', () => {
            uploadMessage.innerHTML = '';
            const file = videoFileInput.files[0];
            if (!file) return;
            const video = document.createElement('video');
            video.preload = 'metadata';
            const objectUrl = URL.createObjectURL(file);
            video.addEventListener('loadedmetadata', () => {
                URL.revokeObjectURL(objectUrl);
                const durationMinutes = video.duration / 60;
                if (durationMinutes < 3) {
                    uploadMessage.innerHTML = '<div class="alert alert-danger"><i class="fa-solid fa-circle-xmark me-2"></i>' + minError + '</div>';
                    videoFileInput.value = '';
                    return;
                }
                if (durationMinutes > 15) {
                    uploadMessage.innerHTML = '<div class="alert alert-danger"><i class="fa-solid fa-circle-xmark me-2"></i>' + maxError + '</div>';
                    videoFileInput.value = '';
                    return;
                }
                uploadMessage.innerHTML = '<div class="alert alert-success"><i class="fa-solid fa-circle-check me-2"></i>' + validMsg + '</div>';
            });
            video.addEventListener('error', () => URL.revokeObjectURL(objectUrl));
            video.src = objectUrl;
        });
    }

    if (lessonUploadForm) {
        lessonUploadForm.addEventListener('submit', (event) => {
            const file = videoFileInput ? videoFileInput.files[0] : null;
            if (!file) return;
            const questions = [];
            let hasAllQuestions = true;
            for (let i = 0; i < 5; i++) {
                const q = lessonUploadForm.querySelector(`input[name="questions[${i}][question]"]`)?.value;
                const oa = lessonUploadForm.querySelector(`input[name="questions[${i}][option_a]"]`)?.value;
                const ob = lessonUploadForm.querySelector(`input[name="questions[${i}][option_b]"]`)?.value;
                const oc = lessonUploadForm.querySelector(`input[name="questions[${i}][option_c]"]`)?.value;
                const od = lessonUploadForm.querySelector(`input[name="questions[${i}][option_d]"]`)?.value;
                const co = lessonUploadForm.querySelector(`select[name="questions[${i}][correct_option]"]`)?.value;
                if (!q || !oa || !ob || !oc || !od || !co) { hasAllQuestions = false; break; }
                questions.push({ q, oa, ob, oc, od, co });
            }
            if (!hasAllQuestions) {
                uploadMessage.innerHTML = '<div class="alert alert-warning"><i class="fa-solid fa-circle-exclamation me-2"></i>' + fillQuestions + '</div>';
                return;
            }
            event.preventDefault();
            uploadMessage.innerHTML = '';
            const CHUNK_THRESHOLD = 1 * 1024 * 1024;
            if (file.size > CHUNK_THRESHOLD) { uploadFileInChunks(file); return; }
            const formData = new FormData(lessonUploadForm);
            const request = new XMLHttpRequest();
            uploadStatus.style.display = 'block';
            uploadStatusText.textContent = uploading;
            uploadPercent.textContent = '0%';
            uploadProgressFill.style.width = '0%';
            lessonUploadButton.disabled = true;
            lessonUploadButton.textContent = '{{ __('messages.lesson_saving') }}';
            request.upload.addEventListener('progress', (event) => {
                if (!event.lengthComputable) return;
                const percent = Math.round((event.loaded / event.total) * 100);
                uploadPercent.textContent = percent + '%';
                uploadProgressFill.style.width = percent + '%';
                if (percent >= 100) uploadStatusText.textContent = uploadSuccess;
            });
            request.onload = function () {
                lessonUploadButton.disabled = false;
                lessonUploadButton.textContent = saveLabel;
                handleUploadResponse(request);
            };
            request.onerror = function () {
                lessonUploadButton.disabled = false;
                lessonUploadButton.textContent = saveLabel;
                uploadStatus.style.display = 'none';
                uploadMessage.innerHTML = '<div class="alert alert-danger"><i class="fa-solid fa-circle-xmark me-2"></i>{{ __('messages.instructor_server_error') }}</div>';
            };
            request.open('POST', lessonUploadForm.action);
            request.setRequestHeader('Accept', 'application/json');
            request.send(formData);
        });
    }

    function uploadFileInChunks(file) {
        const CHUNK_SIZE = 500 * 1024;
        const totalChunks = Math.ceil(file.size / CHUNK_SIZE);
        const identifier = 'chunk_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content') || '';
        let currentChunk = 0;
        let uploadError = false;
        const questions = [];
        for (let i = 0; i < 5; i++) {
            questions.push({
                question: lessonUploadForm.querySelector(`input[name="questions[${i}][question]"]`).value,
                option_a: lessonUploadForm.querySelector(`input[name="questions[${i}][option_a]"]`).value,
                option_b: lessonUploadForm.querySelector(`input[name="questions[${i}][option_b]"]`).value,
                option_c: lessonUploadForm.querySelector(`input[name="questions[${i}][option_c]"]`).value,
                option_d: lessonUploadForm.querySelector(`input[name="questions[${i}][option_d]"]`).value,
                correct_option: lessonUploadForm.querySelector(`select[name="questions[${i}][correct_option]"]`).value,
            });
        }
        uploadStatus.style.display = 'block';
        uploadStatusText.textContent = uploadProgress.replace('__CNT__', totalChunks);
        uploadPercent.textContent = '0%';
        uploadProgressFill.style.width = '0%';
        lessonUploadButton.disabled = true;
        lessonUploadButton.textContent = '{{ __('messages.lesson_saving') }}';

        function sendChunk() {
            if (uploadError) return;
            const start = currentChunk * CHUNK_SIZE;
            const end = Math.min(start + CHUNK_SIZE, file.size);
            const chunk = file.slice(start, end);
            const chunkFormData = new FormData();
            chunkFormData.append('file', chunk, file.name);
            chunkFormData.append('chunkIndex', currentChunk);
            chunkFormData.append('totalChunks', totalChunks);
            chunkFormData.append('identifier', identifier);
            chunkFormData.append('originalName', file.name);
            chunkFormData.append('course_id', lessonUploadForm.querySelector('select[name="course_id"]').value);
            chunkFormData.append('title', lessonUploadForm.querySelector('input[name="title"]').value);
            chunkFormData.append('description', lessonUploadForm.querySelector('textarea[name="description"]').value);
            chunkFormData.append('video_path', lessonUploadForm.querySelector('input[name="video_path"]').value);
            if (currentChunk === totalChunks - 1) {
                for (let i = 0; i < 5; i++) {
                    chunkFormData.append(`questions[${i}][question]`, questions[i].question);
                    chunkFormData.append(`questions[${i}][option_a]`, questions[i].option_a);
                    chunkFormData.append(`questions[${i}][option_b]`, questions[i].option_b);
                    chunkFormData.append(`questions[${i}][option_c]`, questions[i].option_c);
                    chunkFormData.append(`questions[${i}][option_d]`, questions[i].option_d);
                    chunkFormData.append(`questions[${i}][correct_option]`, questions[i].correct_option);
                }
            }
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route("instructor.lesson.store.chunked") }}');
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhr.onload = function () {
                if (uploadError) return;
                let response = {};
                try { response = JSON.parse(xhr.responseText); } catch (e) { response = { success: false, message: '{{ __('instructor.server_error') }}' }; }
                if (xhr.status >= 200 && xhr.status < 300 && response.success) {
                    currentChunk++;
                    const percent = Math.round((currentChunk / totalChunks) * 100);
                    uploadPercent.textContent = Math.min(percent, 99) + '%';
                    uploadProgressFill.style.width = Math.min(percent, 99) + '%';
                    if (currentChunk < totalChunks) {
                        sendChunk();
                    } else {
                        uploadPercent.textContent = '100%';
                        uploadProgressFill.style.width = '100%';
                        uploadStatusText.textContent = uploadSuccess;
                        lessonUploadButton.disabled = false;
                        lessonUploadButton.textContent = saveLabel;
                        uploadMessage.innerHTML = '<div class="alert alert-success"><i class="fa-solid fa-circle-check me-2"></i>' + uploadSuccess + '</div>';
                        if (response.redirect) setTimeout(() => window.location.href = response.redirect, 1500);
                    }
                } else {
                    uploadError = true;
                    lessonUploadButton.disabled = false;
                    lessonUploadButton.textContent = saveLabel;
                    uploadStatus.style.display = 'none';
                    uploadMessage.innerHTML = '<div class="alert alert-danger"><i class="fa-solid fa-circle-xmark me-2"></i>' + (response.message || '{{ __('messages.instructor_upload_error') }}') + '</div>';
                }
            };
            xhr.onerror = function () {
                uploadError = true;
                lessonUploadButton.disabled = false;
                lessonUploadButton.textContent = saveLabel;
                uploadStatus.style.display = 'none';
                uploadMessage.innerHTML = '<div class="alert alert-danger"><i class="fa-solid fa-circle-xmark me-2"></i>{{ __('messages.instructor_server_error') }}</div>';
            };
            xhr.send(chunkFormData);
        }
        sendChunk();
    }

    function handleUploadResponse(request) {
        let response = {};
        try { response = JSON.parse(request.responseText); } catch (e) { response = { message: '{{ __('messages.instructor_upload_error') }}' }; }
        if (request.status >= 200 && request.status < 300 && response.success) {
            uploadStatusText.textContent = uploadSuccess;
            uploadMessage.innerHTML = '<div class="alert alert-success"><i class="fa-solid fa-circle-check me-2"></i>' + uploadSuccess + '</div>';
            setTimeout(() => { if (response.redirect) window.location.href = response.redirect; }, 1500);
            return;
        }
        uploadStatus.style.display = 'none';
        uploadMessage.innerHTML = '<div class="alert alert-danger"><i class="fa-solid fa-circle-xmark me-2"></i>' + (response.message || '{{ __('messages.instructor_upload_error') }}') + '</div>';
    }

    function updateChatBadge() {
        fetch('{{ route("instructor.chat.unread") }}', {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            const badge = document.getElementById('chatBadge');
            if (badge) {
                if (data.count > 0) {
                    badge.style.display = 'flex';
                    badge.textContent = data.count;
                } else {
                    badge.style.display = 'none';
                }
            }
        })
        .catch(() => {});
    }
    updateChatBadge();
    setInterval(updateChatBadge, 10000);
</script>
@endsection
