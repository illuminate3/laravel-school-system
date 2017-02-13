<meta charset="UTF-8">
<title>
    {{$title or 'SMS'}} | {{ Settings::get('name') }}
</title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

<link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
<link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">

<meta id="token" name="token" value="{{ csrf_token() }}">