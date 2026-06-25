@echo off
set "PHP_BIN=C:\Users\lenovo\Desktop\php-8.4.22-nts-Win32-vs17-x64"
if not exist "%PHP_BIN%\php.exe" (
  echo PHP 8.4 executable not found at %PHP_BIN%\php.exe
  pause
  exit /b 1
)
set "PATH=%PHP_BIN%;%PATH%"
composer %*
