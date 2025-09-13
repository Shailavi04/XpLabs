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
            padding: 20px;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .certificate-wrapper {
            width: 800px;
            /* fixed width for certificate */
            background: #fff;
            border: 10px solid #2c3e50;
            padding: 30px 40px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .certificate-box {
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
            margin-bottom: 30px;
        }

        .signature {
            text-align: right;
            margin-top: 60px;
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
            <img src="{{ asset('frontend/assets/img/icon/LightLogo.png') }}" alt="Logo" class="logo">

            {{-- Title --}}
            <div class="title">{{$certificateDetail->title}}</div><br>

            {{-- Description --}}
            <div class="desc">
                This certificate is awarded for successfully completing the quiz to

                {{-- Name --}}
                <div class="name">
                    {{ $student->name ??'Participant'}}
                </div>
                with a score of
                <strong>{{ $certificate->result->score }}/{{ $quiz->questions->count() }}</strong><br>
                on <strong>{{ \Carbon\Carbon::parse($certificate->created_at)->format('F d, Y') }}</strong>.
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