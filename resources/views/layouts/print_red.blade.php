<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="content-type" content="text-html; charset=utf-8">
    <title>SMS document</title>
    <style type="text/css">
        html, body, div, span, applet, object, iframe,
        h1, h2, h3, h4, h5, h6, p, blockquote, pre,
        a, abbr, acronym, address, big, cite, code,
        del, dfn, em, img, ins, kbd, q, s, samp,
        small, strike, strong, sub, sup, tt, var,
        b, u, i, center,
        dl, dt, dd, ol, ul, li,
        fieldset, form, label, legend,
        table, caption, tbody, tfoot, thead, tr, th, td,
        article, aside, canvas, details, embed,
        figure, figcaption, footer, header, hgroup,
        menu, nav, output, ruby, section, summary,
        time, mark, audio, video {
            margin: 0;
            padding: 0;
            border: 0;
            font-family: DejaVu Sans;
            vertical-align: baseline;
        }

        html {
            line-height: 1;
        }

        ol, ul {
            list-style: none;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        caption, th, td {
            text-align: left;
            font-weight: normal;
            vertical-align: middle;
        }

        body {
            font-family: DejaVu Sans;
            font-weight: 300;
            font-size: 12px;
            margin: 0;
            padding: 0;
            color: #777777;
        }

        body a {
            text-decoration: none;
            color: inherit;
        }

        body .container {
            min-width: 10px;
            margin: 0 auto;
            padding: 0 30px;
        }

        section table {
            width: 100%;
            margin-bottom: -20px;
            table-layout: fixed;
            border-color: #CC5A6A;
            border-collapse: separate;
            border-spacing: 5px 20px;
        }

        section table tbody {
            vertical-align: middle;
            border-color: inherit;
        }

        section table thead tr th {
            text-align: center;
            color: #CC5A6A;
            font-weight: 600;
            text-transform: uppercase;
        }

        section table tbody tr td {
            padding: 10px 5px;
            background: #F3F3F3;
            text-align: center;
        }

        h1, .h1 {
            font-size: 33px!important;
            color: #CC5A6A;
        }

        h2, .h2 {
            font-size: 27px!important;
            color: #777777;
        }

        h3, .h3 {
            font-size: 23px!important;
        }

        h4, .h4 {
            font-size: 17px!important;
        }

        h5, .h5 {
            font-size: 13px!important;
        }

        h6, .h6 {
            font-size: 12px!important;
        }

        p {
            margin: 0 0 12px!important;
        }
    </style>
</head>

<body>
<header class="clearfix">
    <div class="container">
        <div class="company-info">
            @yield('header')
        </div>
    </div>
</header>

<section>
    <div class="container">
        @yield('content')
    </div>
</section>
</body>

</html>
