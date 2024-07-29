<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">

    <style>
        :root{
            --primary-bg-color: #4dc8b9;
            --header-bg-color: #748383;
        }

        a {
            color: #5D6975;
            text-decoration: underline;
        }

        body,
        #page {
            font-family: 'XBRiyaz', 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            position: relative;
        }
    </style>
</head>

<body>

<div id="page">{!! $request->content !!}</div>

</body>
</html>
