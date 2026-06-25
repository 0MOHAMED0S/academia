<script>
    function toggleUniqueId(type) {
        const wrapper = document.getElementById('unique_id_wrapper');
        const input = wrapper.querySelector('input');
        if (type === 'paid') {
            wrapper.style.display = 'block';
            input.setAttribute('required', 'required');
        } else {
            wrapper.style.display = 'none';
            input.removeAttribute('required');
        }
    }

    const lessonUploadForm = document.getElementById('lessonUploadForm');
    const videoFileInput = document.getElementById('videoFileInput');
    const uploadStatus = document.getElementById('uploadStatus');
    const uploadStatusText = document.getElementById('uploadStatusText');
    const uploadPercent = document.getElementById('uploadPercent');
    const uploadProgressFill = document.getElementById('uploadProgressFill');
    const uploadMessage = document.getElementById('uploadMessage');
    const lessonUploadButton = document.getElementById('lessonUploadButton');

    // Client-side video duration validation
    if (videoFileInput) {
        videoFileInput.addEventListener('change', () => {
            uploadMessage.innerHTML = '';
            const file = videoFileInput.files[0];
            if (!file) return;

            // Check duration using HTML5 video API
            const video = document.createElement('video');
            video.preload = 'metadata';
            const objectUrl = URL.createObjectURL(file);

            video.addEventListener('loadedmetadata', () => {
                URL.revokeObjectURL(objectUrl);
                const durationMinutes = video.duration / 60;

                if (durationMinutes < 2) {
                    uploadMessage.innerHTML =
                        '<div class="alert alert-danger">مدة الفيديو يجب أن تكون دقيقتين على الأقل</div>';
                    videoFileInput.value = '';
                    return;
                }

if (durationMinutes > 15) {
    uploadMessage.innerHTML =
        '<div class="alert alert-danger">مدة الفيديو يجب ألا تتجاوز 15 دقيقة</div>';
    videoFileInput.value = '';
    return;
}

                uploadMessage.innerHTML = '<div class="alert alert-success">مدة الفيديو مناسبة: ' + durationMinutes.toFixed(1) + ' دقيقة.</div>';
            });

            video.addEventListener('error', () => {
                URL.revokeObjectURL(objectUrl);
                // If we can't read metadata, let the server validate
            });

            video.src = objectUrl;
        });
    }

    if (lessonUploadForm) {
        lessonUploadForm.addEventListener('submit', (event) => {
            // Don't prevent default if there's no video file (external link)
            const file = videoFileInput ? videoFileInput.files[0] : null;
            if (!file) {
                return;
            }

            event.preventDefault();
            uploadMessage.innerHTML = '';

            const formData = new FormData(lessonUploadForm);

            // Use chunked upload for files larger than 1MB (to fit 2MB PHP limit)
            const CHUNK_THRESHOLD = 1 * 1024 * 1024; // 1MB
            if (file.size > CHUNK_THRESHOLD) {
                uploadFileInChunks(file, formData);
                return;
            }

            // Normal single-request upload
            const request = new XMLHttpRequest();

            uploadStatus.style.display = 'block';
            uploadStatusText.textContent = 'جاري رفع الفيديو...';
            uploadPercent.textContent = '0%';
            uploadProgressFill.style.width = '0%';
            lessonUploadButton.disabled = true;
            lessonUploadButton.textContent = 'جاري الحفظ...';

            request.upload.addEventListener('progress', (event) => {
                if (!event.lengthComputable) return;
                const percent = Math.round((event.loaded / event.total) * 100);
                uploadPercent.textContent = percent + '%';
                uploadProgressFill.style.width = percent + '%';
                if (percent >= 100) {
                    uploadStatusText.textContent = 'تم الرفع، جاري حفظ بيانات الفيديو...';
                }
            });

            request.onload = function () {
                lessonUploadButton.disabled = false;
                lessonUploadButton.textContent = 'حفظ الفيديو';
                handleUploadResponse(request);
            };

            request.onerror = function () {
                lessonUploadButton.disabled = false;
                lessonUploadButton.textContent = 'حفظ الفيديو';
                uploadStatus.style.display = 'none';
                uploadMessage.innerHTML = '<div class="alert alert-danger">تعذر الاتصال بالسيرفر أثناء الرفع.</div>';
            };

            request.open('POST', lessonUploadForm.action);
            request.setRequestHeader('Accept', 'application/json');
            request.send(formData);
        });
    }

    // Chunked upload for large files
    function uploadFileInChunks(file, formData) {
        const CHUNK_SIZE = 1 * 1024 * 1024; // 1MB per chunk (to fit 2MB PHP limit)
        const totalChunks = Math.ceil(file.size / CHUNK_SIZE);
        const identifier = 'chunk_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        const csrfToken = document.querySelector('meta[name="csrf-token"]')
            ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            : '';
        let currentChunk = 0;
        let uploadError = false;

        uploadStatus.style.display = 'block';
        uploadStatusText.textContent = 'جاري رفع الفيديو (تقسيم إلى ' + totalChunks + ' أجزاء)...';
        uploadPercent.textContent = '0%';
        uploadProgressFill.style.width = '0%';
        lessonUploadButton.disabled = true;
        lessonUploadButton.textContent = 'جاري الرفع...';

        function sendChunk() {
            if (uploadError) return;

            const start = currentChunk * CHUNK_SIZE;
            const end = Math.min(start + CHUNK_SIZE, file.size);
            const chunk = file.slice(start, end);

            const chunkFormData = new FormData();
            chunkFormData.append('file', chunk, file.name);
            chunkFormData.append('chunkIndex', currentChunk);
            chunkFormData.append('totalChunks', totalChunks);
            chunkFormData.append('identifier', identifier);
            chunkFormData.append('originalName', file.name);

            // Copy all original form fields (except video_file)
            for (const pair of new FormData(lessonUploadForm)) {
                if (pair[0] !== 'video_file') {
                    // Handle array fields (questions[])
                    if (pair[0].endsWith('[]')) {
                        chunkFormData.append(pair[0], pair[1]);
                    } else {
                        chunkFormData.append(pair[0], pair[1]);
                    }
                }
            }

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route('instructor.lesson.store.chunked') }}');
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

            xhr.onload = function () {
                if (uploadError) return;

                let response = {};
                try {
                    response = JSON.parse(xhr.responseText);
                } catch (e) {
                    response = { success: false, message: 'خطأ في استجابة السيرفر.' };
                }

                if (xhr.status >= 200 && xhr.status < 300 && response.success) {
                    currentChunk++;
                    const percent = Math.round((currentChunk / totalChunks) * 100);
                    uploadPercent.textContent = Math.min(percent, 99) + '%';
                    uploadProgressFill.style.width = Math.min(percent, 99) + '%';
                    uploadStatusText.textContent = 'جاري رفع الفيديو... الجزء ' + currentChunk + ' من ' + totalChunks;

                    if (currentChunk === totalChunks) {
                        uploadPercent.textContent = '100%';
                        uploadProgressFill.style.width = '100%';
                        uploadStatusText.textContent = 'the Video is Uploaded Successfully';
                        lessonUploadButton.disabled = false;
                        lessonUploadButton.textContent = 'حفظ الفيديو';
                        uploadMessage.innerHTML = '<div class="alert alert-success">the Video is Uploaded Successfully</div>';

                        if (response.redirect) {
                            setTimeout(() => {
                                window.location.href = response.redirect;
                            }, 1000);
                        }
                    } else if (currentChunk < totalChunks) {
                        sendChunk();
                    }
                } else {
                    uploadError = true;
                    lessonUploadButton.disabled = false;
                    lessonUploadButton.textContent = 'حفظ الفيديو';
                    uploadStatus.style.display = 'none';
                    uploadMessage.innerHTML = '<div class="alert alert-danger">' + (response.message || 'فشل رفع الفيديو.') + '</div>';
                }
            };

            xhr.onerror = function () {
                uploadError = true;
                lessonUploadButton.disabled = false;
                lessonUploadButton.textContent = 'حفظ الفيديو';
                uploadStatus.style.display = 'none';
                uploadMessage.innerHTML = '<div class="alert alert-danger">تعذر الاتصال بالسيرفر أثناء رفع الجزء ' + (currentChunk + 1) + '.</div>';
            };

            xhr.send(chunkFormData);
        }

        sendChunk();
    }

    // ── Shared response handler ─────────────────────────────────────────────
    function handleUploadResponse(request) {
        let response = {};
        try {
            response = JSON.parse(request.responseText);
        } catch (e) {
            response = { message: 'حدث خطأ غير متوقع أثناء حفظ الفيديو.' };
        }

        if (request.status >= 200 && request.status < 300 && response.success) {
            uploadStatusText.textContent = 'the Video is Uploaded Successfully';
            uploadMessage.innerHTML = '<div class="alert alert-success">the Video is Uploaded Successfully</div>';
            setTimeout(() => {
                window.location.href = response.redirect;
            }, 1000);
            return;
        }

        uploadStatus.style.display = 'none';
        uploadMessage.innerHTML = '<div class="alert alert-danger">' + (response.message || 'فشل رفع الفيديو. راجع حجم الملف والبيانات المطلوبة.') + '</div>';
    }
</script>
