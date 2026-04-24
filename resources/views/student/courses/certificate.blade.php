<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Completion - {{ $course->title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3f4f6;
            font-family: 'Outfit', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .certificate-container {
            width: 100%;
            max-width: 1000px;
            background: white;
            padding: 10px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            position: relative;
        }
        .certificate-border {
            border: 15px solid #1e293b;
            padding: 50px;
            text-align: center;
            position: relative;
            background-image: url('data:image/svg+xml,%3Csvg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"%3E%3Cpath d="M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z" fill="%23e2e8f0" fill-opacity="0.5" fill-rule="evenodd"/%3E%3C/svg%3E');
        }
        .cert-header {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 5px;
            margin-bottom: 20px;
        }
        .cert-subheader {
            font-size: 1.2rem;
            color: #64748b;
            margin-bottom: 40px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .cert-name {
            font-family: 'Playfair Display', serif;
            font-size: 4.5rem;
            color: #6366f1;
            font-style: italic;
            border-bottom: 2px solid #cbd5e1;
            display: inline-block;
            padding: 0 40px 10px;
            margin-bottom: 30px;
        }
        .cert-course {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin: 20px 0 40px;
        }
        .cert-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 60px;
            padding: 0 50px;
        }
        .signature-line {
            width: 250px;
            border-top: 1px solid #1e293b;
            margin-top: 50px;
            padding-top: 10px;
            font-weight: 600;
        }
        .badge-icon {
            width: 120px;
            height: 120px;
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
        }
        .print-btn {
            position: fixed;
            top: 30px;
            right: 30px;
            z-index: 1000;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .print-btn {
                display: none;
            }
            .certificate-container {
                box-shadow: none;
                max-width: none;
            }
        }
    </style>
</head>
<body>

    <button class="btn btn-primary btn-lg print-btn shadow" onclick="window.print()">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-printer me-2" viewBox="0 0 16 16">
            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/>
            <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1"/>
        </svg>
        Download / Print PDF
    </button>

    <div class="certificate-container">
        <div class="certificate-border">
            <div class="cert-header">Certificate</div>
            <div class="cert-subheader">of Completion</div>
            
            <p class="text-muted mb-4 fs-5">This is to proudly certify that</p>
            
            <div class="cert-name">{{ $user->name }}</div>
            
            <p class="text-muted fs-5">has successfully completed the program</p>
            
            <div class="cert-course">"{{ $course->title }}"</div>
            
            <p class="text-muted fs-6">demonstrating dedication, growth, and mastery of the course material.</p>

            @if($course->badge && $course->badge->icon)
                <img src="{{ asset('storage/' . $course->badge->icon) }}" class="badge-icon rounded-circle shadow-sm bg-white p-1">
            @else
                <!-- Default Badge Icon -->
                <div class="badge-icon rounded-circle shadow-sm bg-white d-flex align-items-center justify-content-center" style="border: 4px solid #f8b400;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="#f8b400" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                    </svg>
                </div>
            @endif
            
            <div class="cert-footer">
                <div>
                    <div class="signature-line">{{ date('F d, Y') }}</div>
                    <div class="text-muted small mt-2">Date Awarded</div>
                </div>
                
                <div>
                    <div class="signature-line" style="font-family: 'Playfair Display', serif; font-size: 1.5rem; border-top: none; padding-top: 0; margin-top: 20px;">
                        {{ $course->coach->name ?? 'Course Coach' }}
                    </div>
                    <div class="signature-line" style="margin-top: 0;">{{ $course->coach->name ?? 'Course Coach' }}</div>
                    <div class="text-muted small mt-2">Lead Coach / Instructor</div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
