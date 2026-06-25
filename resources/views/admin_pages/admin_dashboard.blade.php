@extends('layouts.main')

@section('title', __('messages.admin_dashboard_title'))

@section('footer')
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/home.css') }}">
<link rel="stylesheet" href="{{ asset('admin_pages_style/admin_dashboard.css') }}">
<style>
    body { padding-top: 0 !important; }
    @if($currentDir === 'ltr')
    .layout { grid-template-columns: 1fr 280px; }
    .layout .main { order: 1; }
    .layout .sidebar { order: 2; border-left: none; border-right: 1px solid #e8eef8; }
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

@section('content')
<div class="layout">
    <aside class="sidebar">
        <div class="text-center mb-4">
            @if($admin->profile_photo)
                <img src="{{ asset($admin->profile_photo) }}" class="avatar" alt="{{ $admin->name }}">
            @else
                <div class="avatar">{{ strtoupper(substr($admin->name, 0, 1)) }}</div>
            @endif
            <h5 class="fw-bold mt-3 mb-1">{{ $admin->name }}</h5>
            <p class="text-muted small">{{ $admin->role ?? __('messages.admin_role_default') }}</p>
        </div>
        <hr>
        <a class="side-link active" href="#students-sec"><i class="fa-solid fa-user-graduate"></i> {{ __('messages.admin_students') }}</a>
        <a class="side-link" href="{{ route('admin.subscribed_students') }}"><i class="fa-solid fa-users-viewfinder"></i> {{ __('messages.admin_subscriptions') }}</a>
        <a class="side-link" href="#instructors-sec"><i class="fa-solid fa-chalkboard-user"></i> {{ __('messages.admin_instructors') }}</a>
        <a class="side-link" href="#subscriptions-sec"><i class="fa-solid fa-money-check-dollar"></i> {{ __('messages.admin_paid_courses') }}</a>
        <a class="side-link" href="#tracks-sec"><i class="fa-solid fa-road"></i> {{ __('messages.admin_tracks') }}</a>
        <a class="side-link" href="#free-sec"><i class="fa-solid fa-unlock"></i> {{ __('messages.admin_free_courses') }}</a>
        <a class="side-link" href="#paid-sec"><i class="fa-solid fa-lock"></i> {{ __('messages.admin_paid_courses') }}</a>
        <a class="side-link" href="{{ route('admin.profile') }}"><i class="fa-solid fa-user-pen"></i> {{ __('messages.admin_edit_profile') }}</a>
        <a class="side-link" href="{{ route('admin.chat') }}"><i class="fa-solid fa-comments"></i> {{ __('messages.admin_chat') }}<span class="chat-badge" id="chatBadge"></span></a>
        <hr>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button class="btn btn-outline-danger w-100"><i class="fa-solid fa-right-from-bracket"></i> {{ __('messages.admin_logout') }}</button>
        </form>
    </aside>

    <main class="main">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif

        <div class="panel mb-4">
            <h2 class="fw-bold mb-1">{{ __('messages.admin_dashboard_heading') }}</h2>
            <p class="text-muted mb-0">{{ __('messages.admin_dashboard_sub') }}</p>
        </div>

        {{-- Students --}}
        <div class="panel mb-4" id="students-sec">
            <h4 class="fw-bold mb-4 text-primary"><i class="fa-solid fa-user-graduate me-2"></i>{{ __('messages.admin_students') }}</h4>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>{{ __('messages.admin_name') }}</th>
                            <th>{{ __('messages.admin_email') }}</th>
                            <th>{{ __('messages.admin_register_date') }}</th>
                            <th class="text-center">{{ __('messages.admin_action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            <tr>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->created_at->format('Y-m-d') }}</td>
                                <td class="text-center">
                                    <form method="POST" action="{{ route('admin.delete.student', $student) }}" onsubmit="return confirm('{{ __('messages.admin_confirm_delete_student') }}')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i> {{ __('messages.admin_delete') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">{{ __('messages.admin_no_students') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Instructors --}}
        <div class="panel mb-4" id="instructors-sec">
            <h4 class="fw-bold mb-4 text-primary"><i class="fa-solid fa-chalkboard-user me-2"></i>{{ __('messages.admin_instructors') }}</h4>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>{{ __('messages.admin_name') }}</th>
                            <th>{{ __('messages.admin_email') }}</th>
                            <th>{{ __('messages.admin_job_title') }}</th>
                            <th>{{ __('messages.admin_register_date') }}</th>
                            <th class="text-center">{{ __('messages.admin_action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($instructors as $instructor)
                            <tr>
                                <td>{{ $instructor->name }}</td>
                                <td>{{ $instructor->email }}</td>
                                <td>{{ $instructor->job_title ?? '—' }}</td>
                                <td>{{ $instructor->created_at->format('Y-m-d') }}</td>
                                <td class="text-center">
                                    <form method="POST" action="{{ route('admin.delete.instructor', $instructor) }}" onsubmit="return confirm('{{ __('messages.admin_confirm_delete_instructor') }}')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i> {{ __('messages.admin_delete') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted">{{ __('messages.admin_no_instructors') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Subscriptions --}}
        <div class="panel mb-4" id="subscriptions-sec">
            <h4 class="fw-bold mb-4 text-primary"><i class="fa-solid fa-money-check-dollar me-2"></i>{{ __('messages.admin_subscription_heading') }}</h4>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>{{ __('messages.admin_sub_student_name') }}</th>
                            <th>{{ __('messages.admin_email') }}</th>
                            <th>{{ __('messages.admin_sub_course_name') }}</th>
                            <th>{{ __('messages.admin_sub_course_id') }}</th>
                            <th>{{ __('messages.admin_sub_activation_code') }}</th>
                            <th>{{ __('messages.admin_sub_date') }}</th>
                            <th class="text-center">{{ __('messages.admin_action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $subCount = 0; @endphp
                        @foreach($paidCourses as $pc)
                            @foreach($pc->savedBy as $student)
                                @php $subCount++; @endphp
                                <tr>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $pc->title }}</td>
                                    <td><code>{{ $pc->unique_course_id }}</code></td>
                                    <td><code>{{ $student->pivot->payment_cash_id }}</code></td>
                                    <td>{{ $student->pivot->payment_verified_at }}</td>
                                    <td class="text-center">
                                        <form method="POST" action="{{ route('admin.courses.remove_student', [$pc->id, $student->id]) }}" onsubmit="return confirm('{{ __('messages.admin_confirm_cancel_subscription') }}')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">{{ __('messages.admin_cancel_subscription') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                        @if($subCount == 0)
                            <tr><td colspan="6" class="text-center text-muted">{{ __('messages.admin_no_subscriptions') }}</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Tracks --}}
        <div class="panel mb-4" id="tracks-sec">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0 text-primary"><i class="fa-solid fa-road me-2"></i>{{ __('messages.admin_tracks') }}</h4>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addTrackModal"><i class="fa-solid fa-plus"></i> {{ __('messages.admin_add_track') }}</button>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>{{ __('messages.admin_track_name') }}</th>
                            <th>{{ __('messages.admin_track_desc') }}</th>
                            <th class="text-center">{{ __('messages.admin_action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tracks as $track)
                            <tr>
                                <td><span class="badge-custom">{{ $track->name }}</span></td>
                                <td>{{ Str::limit($track->description, 60) }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editTrackModal{{ $track->id }}"><i class="fa-solid fa-pen"></i> {{ __('messages.admin_edit') }}</button>
                                    <form method="POST" action="{{ route('admin.delete.track', $track) }}" class="d-inline" onsubmit="return confirm('{{ __('messages.admin_confirm_delete_track') }}')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i> {{ __('messages.admin_delete') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">{{ __('messages.admin_no_tracks') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Free courses --}}
        <div class="panel mb-4" id="free-sec">
            <h4 class="fw-bold mb-4 text-success"><i class="fa-solid fa-unlock me-2"></i>{{ __('messages.admin_free_courses') }}</h4>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>{{ __('messages.admin_course_name') }}</th>
                            <th>{{ __('messages.admin_course_desc') }}</th>
                            <th>{{ __('messages.admin_creation_date') }}</th>
                            <th class="text-center">{{ __('messages.admin_action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courses->where('type', 'free') as $course)
                            <tr>
                                <td><a href="{{ route('courses.show', $course) }}" class="text-decoration-none fw-bold" target="_blank">{{ $course->title }}</a></td>
                                <td>{{ Str::limit($course->description, 80) }}</td>
                                <td>{{ $course->created_at->format('Y-m-d') }}</td>
                                <td class="text-center">
                                    <form method="POST" action="{{ route('admin.delete.course', $course) }}" onsubmit="return confirm('{{ __('messages.admin_confirm_delete_course') }}')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i> {{ __('messages.admin_delete') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">{{ __('messages.admin_no_free_courses') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Paid courses --}}
        <div class="panel mb-4" id="paid-sec">
            <h4 class="fw-bold mb-4 text-warning"><i class="fa-solid fa-lock me-2"></i>{{ __('messages.admin_paid_courses') }}</h4>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>{{ __('messages.admin_course_name') }}</th>
                            <th>{{ __('messages.admin_course_desc') }}</th>
                            <th>{{ __('messages.admin_unique_id') }}</th>
                            <th>{{ __('messages.admin_creation_date') }}</th>
                            <th class="text-center">{{ __('messages.admin_action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courses->where('type', 'paid') as $course)
                            <tr>
                                <td><a href="{{ route('courses.show', $course) }}" class="text-decoration-none fw-bold" target="_blank">{{ $course->title }}</a></td>
                                <td>{{ Str::limit($course->description, 80) }}</td>
                                <td><code>{{ $course->unique_course_id }}</code></td>
                                <td>{{ $course->created_at->format('Y-m-d') }}</td>
                                <td class="text-center">
                                    <form method="POST" action="{{ route('admin.delete.course', $course) }}" onsubmit="return confirm('{{ __('messages.admin_confirm_delete_course') }}')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i> {{ __('messages.admin_delete') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted">{{ __('messages.admin_no_paid_courses') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>

{{-- Add Track Modal --}}
<div class="modal fade" id="addTrackModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:16px;">
            <div class="modal-header"><h5 class="modal-title fw-bold">{{ __('messages.admin_add_track_modal') }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form method="POST" action="{{ route('admin.store.track') }}">
                @csrf
                <div class="modal-body">
                    <label class="form-label fw-bold">{{ __('messages.admin_track_name_label') }}</label>
                    <input type="text" name="name" class="form-control mb-3" required placeholder="{{ __('messages.admin_track_placeholder') }}">
                    <label class="form-label fw-bold">{{ __('messages.admin_track_desc_label') }}</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="{{ __('messages.admin_track_desc_placeholder') }}"></textarea>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('messages.admin_cancel') }}</button>
                    <button type="submit" class="btn btn-primary px-4">{{ __('messages.admin_add') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($tracks as $track)
<div class="modal fade" id="editTrackModal{{ $track->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:16px;">
            <div class="modal-header"><h5 class="modal-title fw-bold">{{ __('messages.admin_edit_track_modal') }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form method="POST" action="{{ route('admin.update.track', $track) }}">
                @csrf @method('PUT')
                <div class="modal-body">
                    <label class="form-label fw-bold">{{ __('messages.admin_track_name_label') }}</label>
                    <input type="text" name="name" class="form-control mb-3" value="{{ $track->name }}" required>
                    <label class="form-label fw-bold">{{ __('messages.admin_track_desc_label') }}</label>
                    <textarea name="description" class="form-control" rows="3">{{ $track->description }}</textarea>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('messages.admin_cancel') }}</button>
                    <button type="submit" class="btn btn-primary px-4">{{ __('messages.admin_save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.side-link').forEach(link => {
        link.addEventListener('click', function() {
            document.querySelectorAll('.side-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });

    function updateChatBadge() {
        fetch('{{ route("admin.chat.unread") }}', {
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
