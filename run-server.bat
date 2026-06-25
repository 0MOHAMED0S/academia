@echo off
set "PHP_BIN=C:\Users\lenovo\Desktop\php-8.4.22-nts-Win32-vs17-x64\php.exe"
if not exist "%PHP_BIN%" (
  echo PHP executable not found at %PHP_BIN%
  pause
  exit /b 1
)
cd /d "%~dp0public"
"%PHP_BIN%" -d upload_max_filesize=0 -d post_max_size=0 -d memory_limit=-1 -d max_execution_time=0 -d max_input_time=0 -S 127.0.0.1:8000 ..\vendor\laravel\framework\src\Illuminate\Foundation\resources\server.php
