<!DOCTYPE html>
<html lang="{{ $currentLocale ?? 'ar' }}" dir="{{ $currentDir ?? 'rtl' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('main_images/images/Logo.jpg') }}" type="image/jpeg">
    <title>{{ __('messages.certificate_title', ['title' => $course->title]) }}</title>
    @if($currentLocale === 'ar')
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&display=swap" rel="stylesheet">
        <style>body { font-family: 'Cairo', sans-serif; }</style>
    @else
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
        <style>body { font-family: 'Inter', sans-serif; }</style>
    @endif
    <link rel="stylesheet" href="{{ asset('courses_pages/certificates.css') }}">
</head>
<body>
    <div class="certificate">
        <h1>{{ __('messages.certificate_heading') }}</h1>
        <p>{{ __('messages.certificate_given_by') }}</p>
        <div class="name">{{ $user->name }}</div>
        <p>{{ __('messages.certificate_for_completing') }}</p>
        <div class="course">{{ $course->title }}</div>
        <p>{{ __('messages.certificate_grade', ['grade' => $savedCourse->pivot->grade ?? 100]) }}</p>
        <p>{{ __('messages.certificate_date', ['date' => \Illuminate\Support\Carbon::parse($savedCourse->pivot->completed_at)->format('Y-m-d')]) }}</p>
        <a href="#" onclick="window.print();return false;" class="btn">{{ __('messages.certificate_download') }}</a>
    </div>
</body>
</html>
