@extends('layouts.main')

@section('title', __('messages.instructor_chat_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/home.css') }}">
<link rel="stylesheet" href="{{ asset('main_pages_style/instructor_dashboard.css') }}">
<style>
    main { padding-top: 0 !important; }
    footer.academia-footer { display: none !important; }
    body { background: #f0f4f8; }

    .layout { display: grid; grid-template-columns: 250px 1fr; min-height: 100vh; }

    .chat-area {
        display: flex;
        flex-direction: column;
        height: 100vh;
        background: #fff;
    }

    .chat-header {
        padding: 20px 30px;
        border-bottom: 1px solid #e8eef8;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .chat-header h4 {
        margin: 0;
        font-weight: 800;
        color: #1e3c72;
    }

    .chat-header .back-link {
        color: #1e3c72;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .chat-header .back-link:hover { text-decoration: underline; }

    .chat-messages {
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

    .message.broadcast {
        justify-content: center !important;
    }

    .message.broadcast .message-bubble {
        background: #fff8e1;
        border: 1px solid #ffe082;
        color: #6d4c00;
        text-align: center;
        max-width: 85%;
        border-radius: 12px;
    }

    .message.broadcast .broadcast-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #b8860b;
        display: block;
        margin-bottom: 4px;
    }

    .chat-input-area {
        padding: 20px 30px;
        border-top: 1px solid #e8eef8;
        background: #fff;
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .chat-input-area input {
        flex: 1;
        padding: 12px 18px;
        border: 1.5px solid #e2e8f0;
        border-radius: 25px;
        font-size: 0.95rem;
        outline: none;
        transition: border-color 0.2s;
    }

    .chat-input-area input:focus {
        border-color: #1e3c72;
        box-shadow: 0 0 0 3px rgba(30, 60, 114, 0.1);
    }

    .chat-input-area button {
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

    .chat-input-area button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(30, 60, 114, 0.3);
    }

    .chat-input-area button:disabled {
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

    .alert-success-box {
        background: #d4edda;
        color: #155724;
        padding: 12px 16px;
        border-radius: 12px;
        margin: 15px 30px 0;
        text-align: center;
        font-weight: 500;
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

    @media (max-width: 768px) {
        .layout { grid-template-columns: 1fr; }
        .layout .sidebar { display: none; }
        .chat-messages { padding: 15px; }
        .chat-input-area { padding: 15px; }
        .chat-header { padding: 15px 20px; }
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
        <a class="side-link active" href="{{ route('instructor.chat') }}"><i class="fa-solid fa-comments"></i> {{ __('messages.instructor_chat') }}</a>
        <a class="side-link" href="{{ route('instructor.student_chat') }}"><i class="fa-solid fa-envelope"></i> {{ __('messages.instructor_student_chat') }}</a>
        <form method="POST" action="{{ route('instructor.logout') }}" class="mt-3">
            @csrf
            <button class="btn btn-outline-danger w-100">{{ __('messages.instructor_logout') }}</button>
        </form>
    </aside>

    <div class="chat-area">
        <div class="chat-header">
            <h4><i class="fa-solid fa-comments me-2"></i> {{ __('messages.instructor_chat_heading') }}</h4>
            <a href="{{ route('instructor.dashboard') }}" class="back-link"><i class="fa-solid fa-arrow-{{ $currentDir === 'rtl' ? 'right' : 'left' }}"></i> {{ __('messages.chat_back_to_dashboard') }}</a>
        </div>

        @if(session('success'))
            <div class="alert-success-box">{{ session('success') }}</div>
        @endif

        <div class="chat-messages" id="chatMessages">
            @forelse($messages as $msg)
                @php
                    $isSent = $msg->sender_type === 'instructor';
                    $isBroadcast = $msg->sender_type === 'admin' && $msg->receiver_type === 'all';
                @endphp

                @if($isBroadcast)
                    <div class="message broadcast">
                        <div class="message-bubble">
                            <span class="broadcast-label"><i class="fa-solid fa-bullhorn"></i> {{ __('messages.chat_broadcast') }}</span>
                            {{ $msg->message }}
                            <span class="message-time">{{ $msg->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @else
                    <div class="message {{ $isSent ? 'sent' : 'received' }}">
                        <div class="message-bubble">
                            @if($msg->type === 'audio' && $msg->media_path)
                                <div class="audio-label"><i class="fa-solid fa-microphone"></i> {{ __('messages.chat_audio_message') }}</div>
                                <div class="audio-player">
                                    <audio controls src="{{ asset('storage/' . $msg->media_path) }}"></audio>
                                </div>
                            @else
                                {{ $msg->message }}
                            @endif
                            <span class="message-time">{{ $msg->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endif
            @empty
                <div class="no-messages">
                    <i class="fa-regular fa-message"></i>
                    <p>{{ __('messages.chat_no_messages') }}</p>
                </div>
            @endforelse
        </div>

        <div class="recording-status" id="recordingStatus">
            <div class="recording-dot"></div>
            <span id="recordingTimer">00:00</span>
            <span>{{ __('messages.chat_recording') }}</span>
        </div>
        <div class="chat-input-area">
            <button type="button" class="record-btn" id="recordBtn" onclick="toggleRecording()" title="{{ __('messages.chat_record') }}">
                <i class="fa-solid fa-microphone"></i>
            </button>
            <input type="text" id="messageInput" placeholder="{{ __('messages.chat_placeholder') }}" maxlength="5000" autofocus>
            <button type="button" id="sendBtn" onclick="sendMessage()"><i class="fa-solid fa-paper-plane me-1"></i> {{ __('messages.chat_send') }}</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let mediaRecorder = null;
    let audioChunks = [];
    let isRecording = false;
    let recordingTimer = null;
    let recordingSeconds = 0;

    function sendMessage() {
        const input = document.getElementById('messageInput');
        const btn = document.getElementById('sendBtn');
        const message = input.value.trim();
        if (!message) return;

        btn.disabled = true;

        fetch('{{ route("instructor.chat.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ message: message })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                input.value = '';
                loadMessages();
            }
        })
        .catch(err => console.error(err))
        .finally(() => { btn.disabled = false; });
    }

    async function toggleRecording() {
        const btn = document.getElementById('recordBtn');
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
            document.getElementById('messageInput').disabled = true;

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
            document.getElementById('messageInput').disabled = false;
        }
    }

    function sendAudio(blob) {
        const formData = new FormData();
        formData.append('audio', blob, 'recording.webm');

        fetch('{{ route("instructor.chat.send_audio") }}', {
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
            if (data.success) loadMessages();
        })
        .catch(err => console.error(err));
    }

    function loadMessages() {
        fetch('{{ route("instructor.chat.messages") }}', {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('chatMessages');
            if (!data.messages || data.messages.length === 0) {
                container.innerHTML = '<div class="no-messages"><i class="fa-regular fa-message"></i><p>{{ __("messages.chat_no_messages") }}</p></div>';
                return;
            }

            let html = '';
            data.messages.forEach(msg => {
                const isSent = msg.sender_type === 'instructor';
                const isBroadcast = msg.sender_type === 'admin' && msg.receiver_type === 'all';
                const time = msg.time_formatted || '';

                if (isBroadcast) {
                    html += '<div class="message broadcast"><div class="message-bubble">';
                    html += '<span class="broadcast-label"><i class="fa-solid fa-bullhorn"></i> {{ __("messages.chat_broadcast") }}</span>';
                    if (msg.type === 'audio' && msg.media_path) {
                        html += '<div class="audio-label"><i class="fa-solid fa-microphone"></i> {{ __("messages.chat_audio_message") }}</div>';
                        html += '<div class="audio-player"><audio controls src="/storage/' + escapeHtml(msg.media_path) + '"></audio></div>';
                    } else {
                        html += escapeHtml(msg.message || '');
                    }
                    html += '<span class="message-time">' + time + '</span></div></div>';
                } else {
                    html += '<div class="message ' + (isSent ? 'sent' : 'received') + '" data-msg-id="' + msg.id + '"><div class="message-bubble">';
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
                }
            });

            container.innerHTML = html;
            container.scrollTop = container.scrollHeight;
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

        fetch('/instructor/chat/' + msgId + '/edit', {
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
            if (data.success) loadMessages();
        })
        .catch(err => console.error(err));
    }

    function cancelEdit(msgId, originalText) {
        const textDiv = document.querySelector('.msg-text-' + msgId);
        if (textDiv) textDiv.innerHTML = escapeHtml(originalText);
    }

    function deleteMessage(msgId) {
        if (!confirm('{{ __("messages.chat_delete_confirm") }}')) return;

        fetch('/instructor/chat/' + msgId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) loadMessages();
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
        document.getElementById('chatMessages').scrollTop = document.getElementById('chatMessages').scrollHeight;
        document.getElementById('messageInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') sendMessage();
        });
    });

    setInterval(loadMessages, 5000);
</script>
@endsection
