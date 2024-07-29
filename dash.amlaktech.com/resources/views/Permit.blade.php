<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$page_title ?? 'تصريح دخول'}}</title>

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css"
          integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;800&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>

    <style>
        body {
            background: #EEE;
            direction: rtl;
            font-family: 'Cairo', sans-serif;
        }

        .invoice {
            width: 970px !important;
            margin: 50px auto;
        }

        .invoice .invoice-header {
            padding: 25px 25px 15px;
        }

        .invoice .invoice-header h1 {
            margin: 0;
            text-align: right; /* Align the heading to the right */
        }

        .invoice .invoice-header .media .media-body {
            font-size: 0.9em;
            margin: 0;
            text-align: right; /* Align the text in media body to the right */
        }

        .invoice .invoice-body {
            border-radius: 10px;
            padding: 25px;
            background: #FFF;
        }

        .invoice .invoice-footer {
            padding: 15px;
            font-size: 0.9em;
            text-align: center; /* Keep the center alignment for the footer */
            color: #999;
        }

        .logo {
            max-height: 70px;
            border-radius: 10px;
        }

        .dl-horizontal dt {
            float: right; /* Float the definition term (dt) to the right */
            width: 80px;
            overflow: hidden;
            clear: right; /* Clear right instead of left */
            text-align: right;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .dl-horizontal dd {
            margin-right: 90px; /* Margin-right instead of margin-left */
        }

        @media (max-width: 768px) {
            .invoice {
                -webkit-transform-origin: 100% 0;
                /* width: 184.857143%; */
                position: absolute;
                right: -110%;
                width: 220% !important;
                /* left: 50%; */
                transform: translate(-50%) scale(.45);
                -webkit-transform: translate(-50%) scale(.45);
            }
        }
    </style>

    <script>
        $(document).ready(function () {
            // Your link
            // var link = "https://example.com";

            // Generate QR code
            var qrcode = new QRCode("qr-code", {
                text: "{{route('permits.show', $permit->code)}}",
                width: 128,
                height: 128,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
        });
    </script>
</head>
<body class="rtl">
<div class="container invoice" style="direction: rtl;">
    <div class="invoice-header">
        <div class="row">
            <div class="col-md-6 col-6">
                <div class="media text-left">
                    <div class="media-left">
                        <img class="media-object logo" src="{{asset('assets/images/brand/logo.png')}}"
                             alt="logo"/>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-6 text-right">
                <h1>بيانات <small>التصريح</small></h1>
                <h5 class="text-muted">نوع التصريح: {{trans('labels.permit.'.$permit->type)}}</h5>
                <h5 class="text-muted">الجمعية: {{$permit->association->name}}</h5>
            </div>
        </div>
    </div>

    <div class="invoice-body">

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="d-flex mb-3 justify-content-center">
                    <div id="qr-code"></div>
                </div>
            </div>

            <table class="table table-bordered table-condensed">
                <thead>
                <tr>
                    <th>اسم المالك</th>
                    <th>{{$permit?->member?->name}}</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>تاريخ الاصدار</td>
                    <td>{{$permit->created_at->format('Y/m/d')}}</td>
                </tr>

                <tr>
                    <td>تاريخ الدخول</td>
                    <td>{{$permit->start_date->format('Y/m/d')}}</td>
                </tr>

                <tr>
                    <td>عدد مرات الدخول بالتصريح</td>

                    <td>{{$permit->login_attempts}}</td>
                </tr>

                <tr>
                    <td>عدد أيام التصريح</td>

                    <td>{{$permit->permit_days}}</td>
                </tr>

                </tbody>
            </table>
        </div>

        <div class="panel panel-default">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>اسم الزائر</th>
                    <th>رقم الهوية</th>
                </tr>
                </thead>
                <tbody>
                @foreach($permit->visitors as $visitor)
                    <tr>
                        <td>{{$visitor?->visitor_name}}</td>
                        <td>{{$visitor?->national_id}}</td>
                    </tr>
                </tbody>
                @endforeach
            </table>
        </div>

    </div>

    <div class="invoice-footer">
        شكرا لاستخدامكم تطبيق اتحاد الملاك
    </div>
</div>

</body>
</html>
