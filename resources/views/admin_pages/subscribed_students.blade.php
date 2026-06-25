@extends('layouts.main')

@section('title', __('messages.admin_subscribed_title'))

@section('footer')
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/home.css') }}">
<style>
    main { padding-top: 0 !important; }
    .panel { background: #fff; border-radius: 16px; padding: 24px; box-shadow: 0 12px 35px rgba(0,0,0,.06); border: 1px solid #edf2f7; }
    .badge-custom { background: #eef2ff; color: #1f2c9c; padding: 4px 12px; border-radius: 999px; font-size: 13px; font-weight: 700; }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0 text-primary"><i class="fa-solid fa-users-viewfinder me-2"></i>{{ __('messages.admin_subscribed_heading') }}</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-right"></i> {{ __('messages.admin_subscribed_back') }}</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="panel">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>{{ __('messages.admin_sub_student_name') }}</th>
                        <th>{{ __('messages.admin_sub_course_name') }}</th>
                        <th>{{ __('messages.admin_sub_course_desc') }}</th>
                        <th>{{ __('messages.admin_sub_unique_course_id') }}</th>
                        <th>{{ __('messages.admin_sub_student_code') }}</th>
                        <th class="text-center">{{ __('messages.admin_actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscriptions as $sub)
                        <tr>
                            <td>{{ $sub->student_name }}</td>
                            <td>{{ $sub->course_name }}</td>
                            <td>{{ Str::limit($sub->course_description, 50) }}</td>
                            <td><code>{{ $sub->unique_course_id }}</code></td>
                            <td>
                                @if($sub->student_course_id)
                                    <code>{{ $sub->student_course_id }}</code>
                                @else
                                    <span class="text-muted">{{ __('messages.admin_sub_no_code') }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.edit.subscribed_course', $sub->course_id) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i> {{ __('messages.admin_sub_edit_course_btn') }}</a>
                                    
                                    <form method="POST" action="{{ route('admin.delete.subscribed_course', $sub->course_id) }}" onsubmit="return confirm('{{ __('messages.admin_sub_confirm_delete_course') }}')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i> {{ __('messages.admin_sub_delete_course_btn') }}</button>
                                    </form>

                                    <a href="{{ route('admin.add.student_id_view', ['course' => $sub->course_id, 'user' => $sub->user_id]) }}" class="btn btn-sm btn-outline-success"><i class="fa-solid fa-plus"></i> {{ __('messages.admin_sub_add_ids_btn') }}</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted">{{ __('messages.admin_no_subscriptions') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
