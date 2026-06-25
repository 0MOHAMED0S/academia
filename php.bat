@echo off
set "PHP_BIN=C:\Users\lenovo\Desktop\php-8.4.22-nts-Win32-vs17-x64\php.exe"
if not exist "%PHP_BIN%" (
  echo PHP executable not found at %PHP_BIN%
  pause
  exit /b 1
)
"%PHP_BIN%" %*