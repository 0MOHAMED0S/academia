@extends('layouts.main')

@section('title', __('messages.instructor_student_chat_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/home.css') }}">
<link rel="stylesheet" href="{{ asset('main_pages_style/instructor_dashboard.css') }}">
<style>
    main { padding-top: 0 !important; }
    footer.academia-footer { display: none !important; }
    body { background: #f0f4f8; }

    .layout { display: grid; grid-template-columns: 250px 1fr; min-height: 100vh; }

    .student-chat-layout {
        display: grid;
        grid-template-columns: 300px 1fr;
        height: 100vh;
        background: #fff;
    }

    .chat-sidebar {
        background: #fff;
        border-{{ $currentDir === 'rtl' ? 'left' : 'right' }}: 1px solid #e8eef8;
        display: flex;
        flex-direction: column;
        height: 100vh;
    }

    .chat-sidebar-header {
        padding: 20px;
        border-bottom: 1px solid #e8eef8;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .chat-sidebar-header h5 {
        margin: 0;
        font-weight: 800;
        color: #1e3c72;
    }

    .chat-sidebar-header .back-link {
        color: #1e3c72;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .chat-sidebar-header .back-link:hover { text-decoration: underline; }

    .chat-sidebar-list {
        flex: 1;
        overflow-y: auto;
    }

    .conversation-item {
        padding: 15px 20px;
        border-bottom: 1px solid #f0f4f8;
        cursor: pointer;
        transition: background 0.2s;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .conversation-item:hover { background: #f8fbff; }
    .conversation-item.active { background: #eef2ff; border-{{ $currentDir === 'rtl' ? 'right' : 'left' }}: 3px solid #1e3c72; }

    .conversation-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .conversation-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .conversation-info {
        flex: 1;
        min-width: 0;
    }

    .conversation-info .name {
        font-weight: 700;
        font-size: 0.9rem;
        color: #1e2a3e;
        margin-bottom: 2px;
    }

    .conversation-info .last-msg {
        font-size: 0.8rem;
        color: #6c7f94;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .conversation-info .time {
        font-size: 0.7rem;
        color: #94a3b8;
    }

    .unread-badge {
        background: #dc3545;
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        min-width: 20px;
        height: 20px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 5px;
        flex-shrink: 0;
    }

    .chat-main {
        display: flex;
        flex-direction: column;
        height: 100vh;
        background: #fff;
    }

    .chat-main-header {
        padding: 20px 30px;
        border-bottom: 1px solid #e8eef8;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .chat-main-header h5 {
        margin: 0;
        font-weight: 800;
        color: #1e3c72;
    }

    .chat-main-messages {
        flex: 1;
        overflow-y: auto;
        padding: 25px 30px;
        background: #f8fbff;
    }

    .message {
        display: flex;
        margin-bottom: 20px;
        {{ $currentDir === 'rtl' ? 'flex-direction: row-reverse;' : '' }}
    }

    .message.sent {
        {{ $currentDir === 'rtl' ? 'justify-content: flex-start;' : 'justify-content: flex-end;' }}
    }

    .message.received {
        {{ $currentDir === 'rtl' ? 'justify-content: flex-end;' : 'justify-content: flex-start;' }}
    }

    .message-bubble {
        max-width: 75%;
        padding: 12px 18px;
        border-radius: 18px;
        font-size: 0.95rem;
        line-height: 1.5;
        position: relative;
        word-wrap: break-word;
    }

    .message.sent .message-bubble {
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        color: #fff;
        {{ $currentDir === 'rtl' ? 'border-bottom-left-radius: 4px;' : 'border-bottom-right-radius: 4px;' }}
    }

    .message.received .message-bubble {
        background: #fff;
        color: #1e2a3e;
        border: 1px solid #e2e8f0;
        {{ $currentDir === 'rtl' ? 'border-bottom-right-radius: 4px;' : 'border-bottom-left-radius: 4px;' }}
    }

    .message-time {
        font-size: 0.7rem;
        margin-top: 4px;
        opacity: 0.75;
        display: block;
    }

    .message.sent .message-time { text-align: {{ $currentDir === 'rtl' ? 'left' : 'right' }}; }
    .message.received .message-time { text-align: {{ $currentDir === 'rtl' ? 'right' : 'left' }}; }

    .sender-name {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6c7f94;
        margin-bottom: 3px;
        display: block;
    }

    .chat-main-input {
        padding: 20px 30px;
        border-top: 1px solid #e8eef8;
        background: #fff;
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .chat-main-input input {
        flex: 1;
        padding: 12px 18px;
        border: 1.5px solid #e2e8f0;
        border-radius: 25px;
        font-size: 0.95rem;
        outline: none;
        transition: border-color 0.2s;
    }

    .chat-main-input input:focus {
        border-color: #1e3c72;
        box-shadow: 0 0 0 3px rgba(30, 60, 114, 0.1);
    }

    .chat-main-input button {
        padding: 12px 28px;
        background: linear-gradient(95deg, #1e3c72, #2a5298);
        color: #fff;
        border: none;
        border-radius: 25px;
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.25s;
        white-space: nowrap;
    }

    .chat-main-input button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(30, 60, 114, 0.3);
    }

    .chat-main-input button:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .no-messages {
        text-align: center;
        padding: 60px 20px;
        color: #6c7f94;
    }

    .no-messages i {
        font-size: 3rem;
        margin-bottom: 15px;
        opacity: 0.4;
    }

    .no-messages p {
        font-size: 1rem;
        font-weight: 500;
    }

    .no-conversations {
        text-align: center;
        padding: 40px 20px;
        color: #6c7f94;
    }

    .record-btn {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        border: 1.5px solid #e2e8f0;
        background: #fff;
        color: #6c7f94;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.25s;
        flex-shrink: 0;
        font-size: 1.1rem;
    }

    .record-btn:hover {
        border-color: #dc3545;
        color: #dc3545;
        background: #fff5f5;
    }

    .record-btn.recording {
        background: #dc3545;
        color: #fff;
        border-color: #dc3545;
        animation: recPulse 1.2s infinite;
    }

    @keyframes recPulse {
        0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.5); }
        70% { box-shadow: 0 0 0 12px rgba(220, 53, 69, 0); }
        100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }

    .recording-status {
        display: none;
        align-items: center;
        gap: 8px;
        color: #dc3545;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 8px 30px 0;
        background: #fff;
    }

    .recording-status.active { display: flex; }

    .recording-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #dc3545;
        animation: blink 1s infinite;
    }

    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }

    .audio-player {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 4px;
    }

    .audio-player audio {
        height: 36px;
        max-width: 220px;
        border-radius: 18px;
    }

    .message.sent .audio-player audio::-webkit-media-controls-panel {
        background: rgba(255,255,255,0.15);
    }

    .audio-label {
        font-size: 0.7rem;
        font-weight: 600;
        opacity: 0.8;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .message-actions {
        display: none;
        gap: 6px;
        margin-top: 6px;
    }

    .message.sent:hover .message-actions { display: flex; }

    .message-actions button {
        background: none;
        border: none;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        padding: 2px 8px;
        border-radius: 10px;
        transition: all 0.2s;
        color: #6c7f94;
    }

    .message.sent .message-actions button { color: rgba(255,255,255,0.75); }
    .message.sent .message-actions button:hover { color: #fff; background: rgba(255,255,255,0.15); }

    .message-actions .edit-btn:hover { color: #0d6efd !important; }
    .message-actions .delete-btn:hover { color: #dc3545 !important; }

    .edit-input-area {
        display: flex;
        gap: 6px;
        margin-top: 6px;
    }

    .edit-input-area input {
        flex: 1;
        padding: 6px 12px;
        border: 1px solid #ced4da;
        border-radius: 12px;
        font-size: 0.85rem;
        outline: none;
    }

    .edit-input-area input:focus {
        border-color: #1e3c72;
    }

    .edit-input-area .save-edit {
        background: #0d6efd;
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 6px 14px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
    }

    .edit-input-area .cancel-edit {
        background: #e9ecef;
        color: #495057;
        border: none;
        border-radius: 12px;
        padding: 6px 14px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
    }

    .edit-input-area .save-edit:hover { background: #0b5ed7; }
    .edit-input-area .cancel-edit:hover { background: #dee2e6; }

    .select-prompt {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #6c7f94;
        text-align: center;
        padding: 40px;
    }

    .select-prompt i { font-size: 4rem; margin-bottom: 20px; opacity: 0.3; }
    .select-prompt p { font-size: 1.1rem; font-weight: 500; }

    @media (max-width: 992px) {
        .layout { grid-template-columns: 1fr; }
        .layout .sidebar { display: none; }
        .student-chat-layout { grid-template-columns: 1fr; }
        .chat-sidebar { display: none; }
        .chat-main-messages { padding: 15px; }
        .chat-main-input { padding: 15px; }
        .chat-main-header { padding: 15px 20px; }
        .message-bubble { max-width: 90%; }
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
        <a class="side-link" href="{{ route('instructor.dashboard') }}"><i class="fa-solid fa-layer-group"></i> {{ __('messages.instructor_my_courses') }}</a>
        <a class="side-link" href="{{ route('instructor.profile') }}"><i class="fa-solid fa-user-pen"></i> {{ __('messages.instructor_edit_profile') }}</a>
        <a class="side-link" href="{{ route('instructor.chat') }}"><i class="fa-solid fa-comments"></i> {{ __('messages.instructor_chat') }}</a>
        <a class="side-link active" href="{{ route('instructor.student_chat') }}"><i class="fa-solid fa-envelope"></i> {{ __('messages.instructor_student_chat') }}</a>
        <form method="POST" action="{{ route('instructor.logout') }}" class="mt-3">
            @csrf
            <button class="btn btn-outline-danger w-100">{{ __('messages.instructor_logout') }}</button>
        </form>
    </aside>

    <div class="student-chat-layout">
        {{-- Chat sidebar with student list --}}
        <div class="chat-sidebar">
            <div class="chat-sidebar-header">
                <h5><i class="fa-solid fa-comments me-1"></i> {{ __('messages.instructor_student_chat_heading') }}</h5>
                <a href="{{ route('instructor.dashboard') }}" class="back-link"><i class="fa-solid fa-arrow-{{ $currentDir === 'rtl' ? 'right' : 'left' }}"></i></a>
            </div>

            <div class="chat-sidebar-list" id="conversationList">
                @forelse($students as $student)
                    <div class="conversation-item" data-student-id="{{ $student->id }}" onclick="selectStudent({{ $student->id }})">
                        <div class="conversation-avatar">
                            @if($student->profile_photo)
                                <img src="{{ asset($student->profile_photo) }}" alt="{{ $student->name }}">
                            @else
                                {{ strtoupper(substr($student->name, 0, 1)) }}
                            @endif
                        </div>
                        <div class="conversation-info">
                            <div class="name">{{ $student->name }}</div>
                            <div class="last-msg" id="lastMsg_{{ $student->id }}">{{ $student->last_message ?? '' }}</div>
                        </div>
                        <div class="unread-badge" id="unreadBadge_{{ $student->id }}" style="{{ $student->unread_count > 0 ? '' : 'display: none;' }}">{{ $student->unread_count }}</div>
                    </div>
                @empty
                    <div class="no-conversations">
                        <p>{{ __('messages.chat_no_conversations') }}</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Chat main area --}}
        <div class="chat-main">
            <div class="chat-main-header">
                <h5 id="chatMainTitle">{{ __('messages.chat_select_conversation') }}</h5>
            </div>

            <div class="chat-main-messages" id="chatMainMessages">
                <div class="select-prompt">
                    <i class="fa-regular fa-comment-dots"></i>
                    <p>{{ __('messages.chat_select_student') }}</p>
                </div>
            </div>

            <div class="recording-status" id="recordingStatus">
                <div class="recording-dot"></div>
                <span id="recordingTimer">00:00</span>
                <span>{{ __('messages.chat_recording') }}</span>
            </div>
            <div class="chat-main-input" id="chatInputArea" style="display:none;">
                <button type="button" class="record-btn" id="recordBtn" onclick="toggleRecording()" title="{{ __('messages.chat_record') }}">
                    <i class="fa-solid fa-microphone"></i>
                </button>
                <input type="text" id="chatInput" placeholder="{{ __('messages.chat_placeholder') }}" maxlength="5000">
                <button type="button" id="sendBtn" onclick="sendMessage()"><i class="fa-solid fa-paper-plane me-1"></i> {{ __('messages.chat_send') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let activeStudentId = null;
    let pollInterval = null;
    let mediaRecorder = null;
    let audioChunks = [];
    let isRecording = false;
    let recordingTimer = null;
    let recordingSeconds = 0;

    function selectStudent(id) {
        activeStudentId = id;

        document.querySelectorAll('.conversation-item').forEach(el => el.classList.remove('active'));
        const item = document.querySelector(`.conversation-item[data-student-id="${id}"]`);
        if (item) item.classList.add('active');

        const studentName = item ? item.querySelector('.name').textContent : '';
        document.getElementById('chatMainTitle').textContent = '{{ __("messages.chat_with_student", ["name" => ""]) }}'.replace(':name', '') + ' ' + studentName;
        document.getElementById('chatInputArea').style.display = 'flex';
        document.getElementById('chatInput').focus();

        fetchMessages(id);
        markAsRead(id);

        if (pollInterval) clearInterval(pollInterval);
        pollInterval = setInterval(() => fetchMessages(activeStudentId), 5000);
    }

    function fetchMessages(studentId) {
        if (!studentId) return;

        fetch('{{ route("instructor.student_chat.messages") }}?student_id=' + studentId, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('chatMainMessages');
            if (!data.messages || data.messages.length === 0) {
                container.innerHTML = '<div class="no-messages"><i class="fa-regular fa-message"></i><p>{{ __("messages.chat_no_messages") }}</p></div>';
                return;
            }

            let html = '';
            data.messages.forEach(msg => {
                const isSent = msg.sender_type === 'instructor';
                const time = msg.time_formatted || '';

                html += '<div class="message ' + (isSent ? 'sent' : 'received') + '" data-msg-id="' + msg.id + '"><div class="message-bubble">';
                if (!isSent) {
                    html += '<span class="sender-name">{{ __("messages.chat_student") }}</span>';
                }
                if (msg.type === 'audio' && msg.media_path) {
                    html += '<div class="audio-label"><i class="fa-solid fa-microphone"></i> {{ __("messages.chat_audio_message") }}</div>';
                    html += '<div class="audio-player"><audio controls src="/storage/' + escapeHtml(msg.media_path) + '"></audio></div>';
                } else {
                    html += '<div class="msg-text-' + msg.id + '">' + escapeHtml(msg.message) + '</div>';
                }
                html += '<span class="message-time">' + time + '</span>';
                
                if (isSent) {
                    html += '<div class="message-actions">';
                    if (msg.type === 'text') {
                        html += '<button class="edit-btn" onclick="editMessage(' + msg.id + ', \'' + escapeHtml(msg.message).replace(/'/g, "\\'") + '\')"><i class="fa-solid fa-pen"></i></button>';
                    }
                    html += '<button class="delete-btn" onclick="deleteMessage(' + msg.id + ')"><i class="fa-solid fa-trash-can"></i></button>';
                    html += '</div>';
                }
                html += '</div></div>';
            });

            container.innerHTML = html;
            container.scrollTop = container.scrollHeight;

            // Clear unread badge on UI
            const badge = document.getElementById('unreadBadge_' + studentId);
            if (badge) {
                badge.style.display = 'none';
                badge.textContent = '0';
            }
        })
        .catch(err => console.error(err));
    }

    function sendMessage() {
        const input = document.getElementById('chatInput');
        const btn = document.getElementById('sendBtn');
        const message = input.value.trim();
        if (!message || !activeStudentId) return;

        btn.disabled = true;

        fetch('{{ route("instructor.student_chat.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ message: message, receiver_id: activeStudentId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                input.value = '';
                fetchMessages(activeStudentId);
            }
        })
        .catch(err => console.error(err))
        .finally(() => { btn.disabled = false; });
    }

    function markAsRead(studentId) {
        fetch('{{ route("instructor.student_chat.mark_read") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ student_id: studentId })
        })
        .then(res => res.json())
        .catch(err => console.error(err));
    }

    async function toggleRecording() {
        if (isRecording) {
            stopRecording();
        } else {
            await startRecording();
        }
    }

    async function startRecording() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
            mediaRecorder = new MediaRecorder(stream);
            audioChunks = [];
            recordingSeconds = 0;

            mediaRecorder.ondataavailable = (e) => { audioChunks.push(e.data); };

            mediaRecorder.onstop = () => {
                const blob = new Blob(audioChunks, { type: 'audio/webm' });
                sendAudio(blob);
                stream.getTracks().forEach(t => t.stop());
            };

            mediaRecorder.start();
            isRecording = true;

            document.getElementById('recordBtn').classList.add('recording');
            document.getElementById('recordBtn').innerHTML = '<i class="fa-solid fa-stop"></i>';
            document.getElementById('recordingStatus').classList.add('active');
            document.getElementById('chatInput').disabled = true;

            recordingTimer = setInterval(() => {
                recordingSeconds++;
                const min = String(Math.floor(recordingSeconds / 60)).padStart(2, '0');
                const sec = String(recordingSeconds % 60).padStart(2, '0');
                document.getElementById('recordingTimer').textContent = min + ':' + sec;
            }, 1000);
        } catch (err) {
            alert('{{ __("messages.chat_mic_denied") }}');
        }
    }

    function stopRecording() {
        if (mediaRecorder && isRecording) {
            mediaRecorder.stop();
            isRecording = false;
            clearInterval(recordingTimer);
            document.getElementById('recordBtn').classList.remove('recording');
            document.getElementById('recordBtn').innerHTML = '<i class="fa-solid fa-microphone"></i>';
            document.getElementById('recordingStatus').classList.remove('active');
            document.getElementById('chatInput').disabled = false;
        }
    }

    function sendAudio(blob) {
        if (!activeStudentId) return;

        const formData = new FormData();
        formData.append('audio', blob, 'recording.webm');
        formData.append('receiver_id', activeStudentId);

        fetch('{{ route("instructor.student_chat.send_audio") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) fetchMessages(activeStudentId);
        })
        .catch(err => console.error(err));
    }

    function editMessage(msgId, currentText) {
        const bubble = document.querySelector('.message[data-msg-id="' + msgId + '"] .message-bubble');
        if (!bubble) return;
        const textDiv = bubble.querySelector('.msg-text-' + msgId);
        if (!textDiv) return;

        const currentHtml = textDiv.innerHTML;
        textDiv.innerHTML = '<div class="edit-input-area">' +
            '<input type="text" id="editInput_' + msgId + '" value="' + currentHtml.replace(/"/g, '&quot;') + '" maxlength="5000">' +
            '<button class="save-edit" onclick="saveEdit(' + msgId + ')"><i class="fa-solid fa-check"></i></button>' +
            '<button class="cancel-edit" onclick="cancelEdit(' + msgId + ', \'' + currentHtml.replace(/'/g, "\\'").replace(/"/g, '&quot;') + '\')"><i class="fa-solid fa-xmark"></i></button>' +
            '</div>';
        document.getElementById('editInput_' + msgId).focus();
    }

    function saveEdit(msgId) {
        const input = document.getElementById('editInput_' + msgId);
        if (!input) return;
        const newText = input.value.trim();
        if (!newText) return;

        fetch('/instructor/student-chat/' + msgId + '/edit', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ message: newText })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) fetchMessages(activeStudentId);
        })
        .catch(err => console.error(err));
    }

    function cancelEdit(msgId, originalText) {
        const textDiv = document.querySelector('.msg-text-' + msgId);
        if (textDiv) textDiv.innerHTML = escapeHtml(originalText);
    }

    function deleteMessage(msgId) {
        if (!confirm('{{ __("messages.chat_delete_confirm") }}')) return;

        fetch('/instructor/student-chat/' + msgId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) fetchMessages(activeStudentId);
        })
        .catch(err => console.error(err));
    }

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const chatInput = document.getElementById('chatInput');
        if (chatInput) {
            chatInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') sendMessage();
            });
        }
    });
</script>
@endsection