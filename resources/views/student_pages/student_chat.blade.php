@extends('layouts.main')

@section('title', __('messages.student_chat_title'))

@section('footer')
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/home.css') }}">
<link rel="stylesheet" href="{{ asset('student_pages_2/strudent_dashboard.css') }}">
<style>
    body { padding-top: 0 !important; background: #f8fafc; }
    footer.academia-footer { display: none !important; }

    @if($currentDir === 'ltr')
    .student-sidebar {
        right: auto !important;
        left: 0 !important;
        border-left: none !important;
        border-right: 1px solid #eef2f6 !important;
    }
    .student-sidebar.closed {
        transform: translateX(-100%) !important;
    }
    .student-sidebar.open {
        transform: translateX(0) !important;
    }
    .main {
        margin-right: 0 !important;
        margin-left: 280px !important;
    }
    .main.expanded {
        margin-left: 0 !important;
    }
    #desktopToggle {
        right: auto !important;
        left: 290px !important;
    }
    @media (max-width: 768px) {
        .main { margin-left: 0 !important; }
        .student-sidebar { transform: translateX(-100%) !important; }
        .student-sidebar.open { transform: translateX(0) !important; }
    }
    @endif

    /* Chat Container Styles */
    .chat-layout {
        display: grid;
        grid-template-columns: 320px 1fr;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        height: calc(100vh - 40px);
        overflow: hidden;
        border: 1px solid #eef2f6;
    }

    .chat-sidebar-list {
        border-{{ $currentDir === 'rtl' ? 'left' : 'right' }}: 1px solid #f1f5f9;
        display: flex;
        flex-direction: column;
        height: 100%;
        background: #fff;
    }

    .chat-sidebar-header {
        padding: 20px;
        border-bottom: 1px solid #f1f5f9;
    }

    .chat-sidebar-header h5 {
        margin: 0;
        font-weight: 800;
        color: #0f172a;
    }

    .instructor-list {
        flex: 1;
        overflow-y: auto;
    }

    .instructor-item {
        padding: 16px 20px;
        border-bottom: 1px solid #f8fafc;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
    }

    .instructor-item:hover {
        background: #f8fafc;
    }

    .instructor-item.active {
        background: #eff6ff;
        border-{{ $currentDir === 'rtl' ? 'right' : 'left' }}: 4px solid #3b82f6;
    }

    .instructor-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1rem;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(59, 130, 246, 0.15);
    }

    .instructor-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .instructor-info {
        flex: 1;
        min-width: 0;
    }

    .instructor-info .name {
        font-weight: 700;
        font-size: 0.95rem;
        color: #1e293b;
        margin-bottom: 3px;
    }

    .instructor-info .role {
        font-size: 0.75rem;
        color: #64748b;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .instructor-info .last-msg {
        font-size: 0.8rem;
        color: #64748b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .instructor-meta {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 6px;
        flex-shrink: 0;
    }

    .instructor-meta .time {
        font-size: 0.7rem;
        color: #94a3b8;
    }

    .unread-badge {
        background: #ef4444;
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        min-width: 20px;
        height: 20px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 6px;
        box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3);
    }

    .chat-main {
        display: flex;
        flex-direction: column;
        height: 100%;
        background: #f8fafc;
    }

    .chat-main-header {
        padding: 20px 30px;
        border-bottom: 1px solid #e2e8f0;
        background: #fff;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .chat-main-header h5 {
        margin: 0;
        font-weight: 800;
        color: #0f172a;
    }

    .chat-main-messages {
        flex: 1;
        overflow-y: auto;
        padding: 25px 30px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .message-row {
        display: flex;
        width: 100%;
    }

    .message-row.sent {
        justify-content: flex-end;
    }

    .message-row.received {
        justify-content: flex-start;
    }

    .message-wrapper {
        max-width: 70%;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .message-bubble {
        padding: 12px 18px;
        border-radius: 18px;
        font-size: 0.95rem;
        line-height: 1.5;
        position: relative;
        word-wrap: break-word;
    }

    .message-row.sent .message-bubble {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: #fff;
        border-bottom-{{ $currentDir === 'rtl' ? 'left' : 'right' }}-radius: 4px;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
    }

    .message-row.received .message-bubble {
        background: #fff;
        color: #1e293b;
        border: 1px solid #e2e8f0;
        border-bottom-{{ $currentDir === 'rtl' ? 'right' : 'left' }}-radius: 4px;
    }

    .message-time {
        font-size: 0.7rem;
        color: #94a3b8;
        display: block;
        margin-top: 2px;
    }

    .message-row.sent .message-time {
        text-align: {{ $currentDir === 'rtl' ? 'left' : 'right' }};
    }

    .message-row.received .message-time {
        text-align: {{ $currentDir === 'rtl' ? 'right' : 'left' }};
    }

    /* Message Actions */
    .message-actions {
        display: none;
        gap: 6px;
        margin-top: 4px;
    }

    .message-row.sent:hover .message-actions {
        display: flex;
        justify-content: flex-end;
    }

    .message-actions button {
        background: none;
        border: none;
        font-size: 0.75rem;
        cursor: pointer;
        padding: 2px 6px;
        border-radius: 6px;
        transition: all 0.2s;
        color: #94a3b8;
    }

    .message-actions button:hover {
        background: #f1f5f9;
        color: #475569;
    }

    .message-actions .delete-btn:hover {
        color: #ef4444;
        background: #fef2f2;
    }

    /* Edit Area */
    .edit-input-container {
        display: flex;
        gap: 6px;
        margin-top: 6px;
    }

    .edit-input-container input {
        flex: 1;
        padding: 6px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.85rem;
        outline: none;
    }

    .edit-input-container button {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
    }

    .edit-input-container .save-edit-btn {
        background: #3b82f6;
        color: #fff;
    }

    .edit-input-container .cancel-edit-btn {
        background: #e2e8f0;
        color: #475569;
    }

    /* Input Area */
    .chat-main-input {
        padding: 20px 30px;
        border-top: 1px solid #e2e8f0;
        background: #fff;
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .chat-main-input input {
        flex: 1;
        padding: 14px 20px;
        border: 1.5px solid #e2e8f0;
        border-radius: 30px;
        font-size: 0.95rem;
        outline: none;
        transition: all 0.2s;
        background: #f8fafc;
    }

    .chat-main-input input:focus {
        border-color: #3b82f6;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .chat-main-input button.send-msg-btn {
        padding: 14px 28px;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: #fff;
        border: none;
        border-radius: 30px;
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
    }

    .chat-main-input button.send-msg-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(59, 130, 246, 0.3);
    }

    .chat-main-input button.send-msg-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    /* Recording Button */
    .record-btn {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        border: 1.5px solid #e2e8f0;
        background: #fff;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        flex-shrink: 0;
        font-size: 1.1rem;
    }

    .record-btn:hover {
        border-color: #ef4444;
        color: #ef4444;
        background: #fef2f2;
    }

    .record-btn.recording {
        background: #ef4444;
        color: #fff;
        border-color: #ef4444;
        animation: recPulse 1.2s infinite;
    }

    @keyframes recPulse {
        0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.5); }
        70% { box-shadow: 0 0 0 12px rgba(239, 68, 68, 0); }
        100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }

    .recording-status {
        display: none;
        align-items: center;
        gap: 8px;
        color: #ef4444;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 8px 30px 0;
        background: #f8fafc;
    }

    .recording-status.active { display: flex; }

    .recording-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #ef4444;
        animation: blink 1s infinite;
    }

    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }

    /* Audio Player */
    .audio-player-wrapper {
        margin-top: 4px;
    }

    .audio-player-wrapper audio {
        height: 36px;
        max-width: 240px;
        border-radius: 18px;
    }

    .audio-msg-label {
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 2px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .message-row.sent .audio-msg-label { color: rgba(255,255,255,0.9); }
    .message-row.received .audio-msg-label { color: #64748b; }

    /* No selection view */
    .select-prompt {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #94a3b8;
        padding: 40px;
    }

    .select-prompt i {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.3;
    }

    .select-prompt p {
        font-size: 1.1rem;
        font-weight: 600;
    }

    .no-messages {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
    }

    .no-messages i {
        font-size: 3rem;
        margin-bottom: 15px;
        opacity: 0.3;
    }

    .no-messages p {
        font-size: 1rem;
        font-weight: 500;
    }

    @media (max-width: 992px) {
        .chat-layout {
            grid-template-columns: 1fr;
        }
        .chat-sidebar-list {
            display: flex;
        }
        .chat-sidebar-list.hidden-mobile {
            display: none;
        }
        .chat-main {
            display: none;
        }
        .chat-main.active-mobile {
            display: flex;
        }
    }
</style>
@endsection

@section('content')

<button id="mobileToggle" class="d-md-none"><i class="fas fa-bars"></i></button>

<!-- SIDEBAR -->
<div class="student-sidebar" id="sidebar">
    <div class="mb-4 d-flex justify-content-between align-items-center d-md-none">
        <h5 style="color:var(--main)" class="m-0 fw-bold"><i class="fas fa-graduation-cap me-2"></i> Academia+</h5>
        <button id="closeSidebar" class="btn btn-sm btn-light rounded-circle"><i class="fas fa-times"></i></button>
    </div>

    <div class="sidebar-profile">
        @if($student->profile_photo)
            <img src="{{ asset($student->profile_photo) }}" class="sidebar-avatar" alt="{{ $student->name }}">
        @else
            <div class="sidebar-avatar">
                {{ strtoupper(substr($student->name, 0, 1)) }}
            </div>
        @endif
        <h6>{{ $student->name }}</h6>
        <span><i class="fas fa-user-graduate me-1"></i> {{ __('messages.student_active') }}</span>
    </div>

    <div class="student-nav-title">{{ __('messages.student_main_menu') }}</div>
    <a href="{{ url('/') }}" class="student-side-link"><i class="fas fa-home"></i><span>{{ __('messages.student_home') }}</span></a>
    <a href="{{ url('/payedcources') }}" class="student-side-link"><i class="fas fa-play-circle"></i><span>{{ __('messages.student_available') }}</span></a>
    <a href="{{ url('/instructors') }}" class="student-side-link"><i class="fas fa-user-tie"></i><span>{{ __('messages.student_instructors') }}</span></a>

    <div class="student-nav-title">{{ __('messages.student_learning_space') }}</div>
    <a href="{{ route('student.dashboard') }}" class="student-side-link"><i class="fas fa-bookmark"></i><span>{{ __('messages.student_my_saved') }}</span></a>
    <a href="{{ url('/articles') }}" class="student-side-link"><i class="fas fa-newspaper"></i><span>{{ __('messages.student_articles') }}</span></a>
    <a href="{{ url('/exams') }}" class="student-side-link"><i class="fas fa-file-alt"></i><span>{{ __('messages.student_exams') }}</span></a>
    <a href="{{ route('student.chat') }}" class="student-side-link active"><i class="fas fa-comments"></i><span>{{ __('messages.student_chat') }}</span><span class="chat-badge ms-auto" id="studentChatBadge" style="display:none; background: #dc3545; color: #fff; font-size: 0.65rem; font-weight: 700; min-width: 18px; height: 18px; border-radius: 9px; align-items: center; justify-content: center; padding: 0 5px;"></span></a>

    <div class="student-nav-title">{{ __('messages.student_account_settings') }}</div>
    <a href="{{ route('student.profile') }}" class="student-side-link"><i class="fas fa-user-pen"></i><span>{{ __('messages.student_edit_profile') }}</span></a>

    <form id="logout-form" action="{{ route('student.logout') }}" method="POST" class="mt-4">
        @csrf
        <button type="submit" class="logout-btn w-100"><i class="fas fa-sign-out-alt me-2"></i> {{ __('messages.student_logout') }}</button>
    </form>
</div>

<div id="desktopToggle"><i class="fas fa-chevron-right"></i></div>

<!-- MAIN CONTENT -->
<div class="main pt-4" id="mainContent">
    <div class="chat-layout">
        <!-- Sidebar list -->
        <div class="chat-sidebar-list" id="chatSidebarList">
            <div class="chat-sidebar-header">
                <h5><i class="fas fa-comments me-2 text-primary"></i> {{ __('messages.student_chat_heading') }}</h5>
            </div>
            <div class="instructor-list">
                @forelse($instructors as $inst)
                    <div class="instructor-item" data-instructor-id="{{ $inst->id }}" onclick="selectInstructor({{ $inst->id }})">
                        <div class="instructor-avatar">
                            @if($inst->profile_photo)
                                <img src="{{ asset($inst->profile_photo) }}" alt="{{ $inst->name }}">
                            @else
                                {{ strtoupper(substr($inst->name, 0, 1)) }}
                            @endif
                        </div>
                        <div class="instructor-info">
                            <div class="name">{{ $inst->name }}</div>
                            <div class="role">{{ $inst->job_title ?? __('messages.instructor_default_role') }}</div>
                            <div class="last-msg" id="lastMsg_{{ $inst->id }}">{{ $inst->last_message ?? '' }}</div>
                        </div>
                        <div class="instructor-meta">
                            <div class="time" id="lastMsgTime_{{ $inst->id }}">{{ $inst->last_message_time ?? '' }}</div>
                            <div class="unread-badge" id="unreadBadge_{{ $inst->id }}" style="{{ $inst->unread_count > 0 ? '' : 'display: none;' }}">{{ $inst->unread_count }}</div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted small">
                        {{ __('messages.no_instructors') }}
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Chat main window -->
        <div class="chat-main" id="chatMainWindow">
            <div class="chat-main-header">
                <button class="btn btn-sm btn-light rounded-pill d-lg-none" onclick="goBackToList()"><i class="fas fa-arrow-{{ $currentDir === 'rtl' ? 'right' : 'left' }} me-1"></i> {{ __('messages.back') }}</button>
                <h5 id="chatHeaderName">{{ __('messages.student_chat_heading') }}</h5>
            </div>

            <div class="chat-main-messages" id="chatMessages">
                <div class="select-prompt">
                    <i class="far fa-comment-dots text-primary"></i>
                    <p>{{ __('messages.chat_select_conversation') }}</p>
                </div>
            </div>

            <div class="recording-status" id="recordingStatus">
                <div class="recording-dot"></div>
                <span id="recordingTimer">00:00</span>
                <span>{{ __('messages.chat_recording') }}</span>
            </div>

            <div class="chat-main-input" id="chatInputArea" style="display: none;">
                <button type="button" class="record-btn" id="recordBtn" onclick="toggleRecording()" title="{{ __('messages.chat_record') }}">
                    <i class="fas fa-microphone"></i>
                </button>
                <input type="text" id="messageInput" placeholder="{{ __('messages.chat_placeholder') }}" maxlength="5000">
                <button type="button" class="send-msg-btn" id="sendBtn" onclick="sendMessage()"><i class="fas fa-paper-plane me-1"></i> {{ __('messages.chat_send') }}</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const desktopToggle = document.getElementById('desktopToggle');
    const mobileToggle = document.getElementById('mobileToggle');
    const closeSidebar = document.getElementById('closeSidebar');
    const isLtr = document.documentElement.dir === 'ltr';

    let sidebarVisible = true;

    desktopToggle.addEventListener('click', () => {
        const side = isLtr ? 'left' : 'right';
        if (sidebarVisible) {
            sidebar.classList.add('closed');
            mainContent.classList.add('expanded');
            desktopToggle.style[side] = '20px';
            desktopToggle.innerHTML = isLtr
                ? '<i class="fas fa-chevron-right"></i>'
                : '<i class="fas fa-chevron-left"></i>';
        } else {
            sidebar.classList.remove('closed');
            mainContent.classList.remove('expanded');
            desktopToggle.style[side] = '290px';
            desktopToggle.innerHTML = isLtr
                ? '<i class="fas fa-chevron-left"></i>'
                : '<i class="fas fa-chevron-right"></i>';
        }
        sidebarVisible = !sidebarVisible;
    });

    mobileToggle.addEventListener('click', () => {
        sidebar.classList.add('open');
    });

    if (closeSidebar) {
        closeSidebar.addEventListener('click', () => {
            sidebar.classList.remove('open');
        });
    }

    /* Chat Logic */
    let activeInstructorId = null;
    let pollInterval = null;
    let mediaRecorder = null;
    let audioChunks = [];
    let isRecording = false;
    let recordingTimer = null;
    let recordingSeconds = 0;

    function selectInstructor(id) {
        activeInstructorId = id;

        document.querySelectorAll('.instructor-item').forEach(el => el.classList.remove('active'));
        const item = document.querySelector(`.instructor-item[data-instructor-id="${id}"]`);
        if (item) item.classList.add('active');

        // Responsive toggling
        if (window.innerWidth <= 992) {
            document.getElementById('chatSidebarList').classList.add('hidden-mobile');
            document.getElementById('chatMainWindow').classList.add('active-mobile');
        }

        const name = item ? item.querySelector('.name').textContent : '';
        document.getElementById('chatHeaderName').textContent = '{{ __("messages.chat_with_instructor", ["name" => ""]) }}'.replace(':name', '') + ' ' + name;
        document.getElementById('chatInputArea').style.display = 'flex';
        document.getElementById('messageInput').focus();

        fetchMessages(id);
        markAsRead(id);

        if (pollInterval) clearInterval(pollInterval);
        pollInterval = setInterval(() => fetchMessages(activeInstructorId), 5000);
    }

    function goBackToList() {
        document.getElementById('chatSidebarList').classList.remove('hidden-mobile');
        document.getElementById('chatMainWindow').classList.remove('active-mobile');
        if (pollInterval) clearInterval(pollInterval);
        activeInstructorId = null;
    }

    function fetchMessages(instructorId) {
        if (!instructorId) return;

        fetch('{{ route("student.chat.messages") }}?instructor_id=' + instructorId, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('chatMessages');
            if (!data.messages || data.messages.length === 0) {
                container.innerHTML = '<div class="no-messages"><i class="far fa-comment-alt"></i><p>{{ __("messages.chat_no_messages") }}</p></div>';
                return;
            }

            let html = '';
            data.messages.forEach(msg => {
                const isSent = msg.sender_type === 'student';
                const time = msg.time_formatted || '';

                html += '<div class="message-row ' + (isSent ? 'sent' : 'received') + '" data-msg-id="' + msg.id + '">';
                html += '<div class="message-wrapper">';
                html += '<div class="message-bubble">';

                if (msg.type === 'audio' && msg.media_path) {
                    html += '<div class="audio-msg-label"><i class="fas fa-microphone"></i> {{ __("messages.chat_audio_message") }}</div>';
                    html += '<div class="audio-player-wrapper"><audio controls src="/storage/' + escapeHtml(msg.media_path) + '"></audio></div>';
                } else {
                    html += '<div class="msg-text-' + msg.id + '">' + escapeHtml(msg.message) + '</div>';
                }

                html += '</div>';
                html += '<span class="message-time">' + time + '</span>';

                if (isSent && msg.type === 'text') {
                    html += '<div class="message-actions">';
                    html += '<button onclick="editMessage(' + msg.id + ', \'' + escapeHtml(msg.message).replace(/'/g, "\\'") + '\')"><i class="fas fa-pen"></i></button>';
                    html += '<button class="delete-btn" onclick="deleteMessage(' + msg.id + ')"><i class="fas fa-trash-alt"></i></button>';
                    html += '</div>';
                } else if (isSent && msg.type === 'audio') {
                    html += '<div class="message-actions">';
                    html += '<button class="delete-btn" onclick="deleteMessage(' + msg.id + ')"><i class="fas fa-trash-alt"></i></button>';
                    html += '</div>';
                }

                html += '</div></div>';
            });

            // Remember scroll position or scroll to bottom
            const isAtBottom = container.scrollHeight - container.clientHeight <= container.scrollTop + 100;
            container.innerHTML = html;
            if (isAtBottom || container.querySelector('.select-prompt')) {
                container.scrollTop = container.scrollHeight;
            }

            // Also clear unread badge dynamically
            const badge = document.getElementById('unreadBadge_' + instructorId);
            if (badge) {
                badge.style.display = 'none';
                badge.textContent = '0';
            }
        })
        .catch(err => console.error(err));
    }

    function sendMessage() {
        const input = document.getElementById('messageInput');
        const btn = document.getElementById('sendBtn');
        const message = input.value.trim();
        if (!message || !activeInstructorId) return;

        btn.disabled = true;

        fetch('{{ route("student.chat.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ message: message, receiver_id: activeInstructorId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                input.value = '';
                fetchMessages(activeInstructorId);
                
                // Update sidebar last message
                const lastMsgDiv = document.getElementById('lastMsg_' + activeInstructorId);
                const lastMsgTimeDiv = document.getElementById('lastMsgTime_' + activeInstructorId);
                if (lastMsgDiv) lastMsgDiv.textContent = message;
                if (lastMsgTimeDiv) lastMsgTimeDiv.textContent = '{{ __("messages.chat_just_now") }}';
            }
        })
        .catch(err => console.error(err))
        .finally(() => { btn.disabled = false; });
    }

    function markAsRead(instructorId) {
        fetch('{{ route("student.chat.mark_read") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ instructor_id: instructorId })
        })
        .then(res => res.json())
        .catch(err => console.error(err));
    }

    function editMessage(msgId, currentText) {
        const row = document.querySelector(`.message-row[data-msg-id="${msgId}"]`);
        if (!row) return;
        const bubble = row.querySelector('.message-bubble');
        const textDiv = bubble.querySelector('.msg-text-' + msgId);
        if (!textDiv) return;

        const originalHtml = textDiv.textContent;
        textDiv.innerHTML = `
            <div class="edit-input-container">
                <input type="text" id="editInput_${msgId}" value="${originalHtml.replace(/"/g, '&quot;')}" maxlength="5000">
                <button class="save-edit-btn" onclick="saveEdit(${msgId})"><i class="fas fa-check"></i></button>
                <button class="cancel-edit-btn" onclick="cancelEdit(${msgId}, '${originalHtml.replace(/'/g, "\\'").replace(/"/g, '&quot;')}')"><i class="fas fa-times"></i></button>
            </div>
        `;
        document.getElementById(`editInput_${msgId}`).focus();
    }

    function saveEdit(msgId) {
        const input = document.getElementById(`editInput_${msgId}`);
        if (!input) return;
        const newText = input.value.trim();
        if (!newText) return;

        fetch('/student/chat/' + msgId + '/edit', {
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
            if (data.success) {
                fetchMessages(activeInstructorId);
            }
        })
        .catch(err => console.error(err));
    }

    function cancelEdit(msgId, originalText) {
        const textDiv = document.querySelector(`.msg-text-${msgId}`);
        if (textDiv) textDiv.textContent = originalText;
    }

    function deleteMessage(msgId) {
        if (!confirm('{{ __("messages.chat_delete_confirm") }}')) return;

        fetch('/student/chat/' + msgId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                fetchMessages(activeInstructorId);
            }
        })
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
            document.getElementById('recordBtn').innerHTML = '<i class="fas fa-stop"></i>';
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
            document.getElementById('recordBtn').innerHTML = '<i class="fas fa-microphone"></i>';
            document.getElementById('recordingStatus').classList.remove('active');
            document.getElementById('messageInput').disabled = false;
        }
    }

    function sendAudio(blob) {
        if (!activeInstructorId) return;
        const formData = new FormData();
        formData.append('audio', blob, 'recording.webm');
        formData.append('receiver_id', activeInstructorId);

        fetch('{{ route("student.chat.send_audio") }}', {
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
            if (data.success) {
                fetchMessages(activeInstructorId);
            }
        })
        .catch(err => console.error(err));
    }

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function updateStudentChatBadge() {
        fetch('{{ route("student.chat.unread") }}', {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            const badge = document.getElementById('studentChatBadge');
            if (badge) {
                if (data.count > 0) {
                    badge.style.display = 'inline-flex';
                    badge.textContent = data.count;
                } else {
                    badge.style.display = 'none';
                }
            }
        })
        .catch(() => {});
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Handle enter key press on input
        document.getElementById('messageInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') sendMessage();
        });

        // Check if an instructor ID was passed in query parameter
        const initialInstructorId = '{{ $activeInstructorId }}';
        if (initialInstructorId) {
            selectInstructor(initialInstructorId);
        }

        updateStudentChatBadge();
        setInterval(updateStudentChatBadge, 15000);
    });
</script>
@endsection
