@echo off
set "PHP_BIN=C:\Users\lenovo\Desktop\php-8.4.22-nts-Win32-vs17-x64\php.exe"
if not exist "%PHP_BIN%" (
  echo PHP executable not found at %PHP_BIN%
  pause
  exit /b 1
)
set "PATH=C:\Users\lenovo\Desktop\php-8.4.22-nts-Win32-vs17-x64;%PATH%"
set "COMPOSER_EXE="
for /f "delims=" %%i in ('where composer 2^>nul ^| findstr /i /v /c:"%~nx0"') do (
  if not defined COMPOSER_EXE set "COMPOSER_EXE=%%i"
)
if not defined COMPOSER_EXE (
  echo composer executable not found in PATH.
  pause
  exit /b 1
)
"%COMPOSER_EXE%" %*
