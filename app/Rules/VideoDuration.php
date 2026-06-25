<?php

namespace App\Rules;

use Closure;
use getID3;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

class VideoDuration implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            // Handle UploadedFile OR path string
            $videoPath = is_string($value)
                ? $value
                : $value->getPathname();

            if (!file_exists($videoPath)) {
                $fail('ملف الفيديو غير موجود.');
                return;
            }

            // Use getID3 instead of ffprobe
            $getID3 = new getID3();
            $fileInfo = $getID3->analyze($videoPath);

            if (isset($fileInfo['error'])) {
                $fail('تعذر قراءة بيانات الفيديو: ' . implode(', ', $fileInfo['error']));
                return;
            }

            if (!isset($fileInfo['playtime_seconds'])) {
                $fail('تعذر قراءة مدة الفيديو.');
                return;
            }

            $durationSeconds = (float) $fileInfo['playtime_seconds'];

            // Minimum 3 minutes (180 seconds)
            if ($durationSeconds < 180) {
                $fail('مدة الفيديو يجب أن تكون 3 دقائق على الأقل.');
                return;
            }

            // Maximum 15 minutes (900 seconds)
            if ($durationSeconds > 900) {
                $fail('مدة الفيديو يجب ألا تتجاوز 15 دقيقة.');
                return;
            }
        } catch (\Throwable $e) {
            $fail('حدث خطأ أثناء فحص مدة الفيديو: ' . $e->getMessage());
        }
    }
}