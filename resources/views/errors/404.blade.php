<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta charset="utf-8">
    <meta name="description" content="">
    <title>Error</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
<div class="no-container">
    <img src="/images/404.png" class="icon">
    <section class="info">
        @if (isset($message) && $message)
            <div class="title">{{ $message }}</div>
        @else
        <div class="title">404&nbsp;error</div>
        @endif
        <div class="txt">别着急，点击<a href="{{ (isset($url) && $url) ? $url : url('/') }}" class="link">这里</a>可以继续访问</div>
    </section>
</div>
</body>
</html>