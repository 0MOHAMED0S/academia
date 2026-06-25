@extends('layouts.main')

@section('title', __('messages.notifications_page_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/home.css') }}">
<link rel="stylesheet" href="{{ asset('notifications/index.css') }}">
<style>
    main { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="notif-page-card p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold mb-0">{{ __('messages.notifications_heading') }}</h3>
                    <form method="POST" action="{{ url('/notifications/api/read-all') }}" style="display:inline;">
                        @csrf
                        <button class="btn btn-outline-primary btn-sm">{{ __('messages.notifications_mark_read') }}</button>
                    </form>
                </div>

                @forelse($notifications as $notif)
                    <div class="notif-page-item {{ $notif->is_read ? '' : 'unread' }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong>{{ $notif->type === 'video_deleted' ? __('messages.notifications_type_deleted') : __('messages.notifications_type_default') }}</strong>
                                <p class="mb-1 mt-1">{{ $notif->message }}</p>
                            </div>
                            <small class="text-muted" style="min-width:80px;text-align:left;">{{ $notif->created_at->diffForHumans() }}</small>
                        </div>
                        @if(!$notif->is_read)
                            <a href="{{ url('/notifications/api/' . $notif->id . '/read') }}" class="btn btn-sm btn-link p-0 mt-1" style="text-decoration:none;" onclick="event.preventDefault(); fetch(this.href, {method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}}).then(() => location.reload());">{{ __('messages.notifications_mark_one') }}</a>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="fa-solid fa-bell-slash fa-3x mb-3"></i>
                        <p>{{ __('messages.notifications_empty') }}</p>
                    </div>
                @endforelse

                <div class="mt-4">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
