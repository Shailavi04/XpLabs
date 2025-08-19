<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Certificate</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        .certificate-wrapper {
            width: auto;
            /* min-height: 100vh; */
            /* padding: 10px 10px; */
            border: 10px solid #2c3e50;
        }

        .certificate-box {
            /* border: 4px solid #2980b9; */
            padding: 25px 35px 25px 35px;
            text-align: center;

        }

        .logo {
            width: 140px;
            margin-bottom: 20px;
        }

        .title {
            font-size: 32px;
            font-weight: bold;
            color: #2c3e50;
            margin: 20px 0 10px;
            letter-spacing: 1px;
        }

        .name {
            font-size: 26px;
            font-weight: bold;
            color: #34495e;
            margin: 30px 0 10px;
        }

        .desc {
            font-size: 18px;
            color: #555;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .signature {
            text-align: right;
            margin-top: 180px;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 220px;
            margin-left: auto;
            margin-bottom: 5px;
        }

        .signature-text {
            font-size: 14px;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="certificate-wrapper">
        <div class="certificate-box">
            {{-- Logo --}}
            <img src="{{ public_path('admin/assets/images/brand-logos/desktop-dark.png') }}" alt="Logo">
            {{-- Title --}}
            <div class="title">Certificate of Completion</div>

            {{-- Name --}}
            <div class="name">{{ $result->user?->name ?? ($result->guest_name ?? 'Participant') }}</div>

            {{-- Description --}}
            <div class="desc">
                This certificate is awarded for successfully completing the quiz<br>
                <strong>"{{ $result->quiz->title }}"</strong><br>
                with a score of <strong>{{ $result->score }}/{{ $result->quiz->questions->count() }}</strong><br>
                on <strong>{{ \Carbon\Carbon::parse($result->created_at)->format('F d, Y') }}</strong>.
            </div>

            {{-- Signature --}}
            <div class="signature">
                <div class="signature-line"></div>
                <div class="signature-text">Authorized Signature</div>
            </div>
        </div>
    </div>
</body>

</html>
