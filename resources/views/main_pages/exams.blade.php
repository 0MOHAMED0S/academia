@extends('layouts.main')

@section('title', __('messages.exams_page_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/exams.css') }}">
<style>
    main { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<h1 id="examTitle">{{ __('messages.exam_loading') }}</h1>

<div class="progress-container">
  <div class="progress-bar" id="progressBar"></div>
</div>

<div class="question-card" id="questionCard" style="display:none;">
  <div class="question-text" id="questionText"></div>
  <ul class="options" id="optionsList"></ul>
</div>
<div style="display: flex;">
  <button id="backBtn" disabled>{{ __('messages.exam_back') }}</button>
  <button id="nextBtn" style="display:none;">{{ __('messages.exam_next') }}</button>
</div>

<div class="result-card" id="resultCard" style="display:none;">
  <div id="scoreText"></div>
  <div class="feedback" id="feedbackText"></div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('main_pages_js/exams.js') }}"></script>
@endsection
