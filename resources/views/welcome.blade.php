<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-51872798-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-51872798-1');
    </script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>
    <link href="https://unpkg.com/vuetify/dist/vuetify.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/default.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="https://cocktail.trc-vlackhistory.net/">
    <meta property="og:type" content="website">
    <meta property="og:title" content="宅飲みカクテルデータベース">
    <meta property="og:description" content="読んで楽しい、を目指したデータベース。">
    <meta property="og:image" content="">
    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="宅飲みカクテルデータベース">
    <meta name="twitter:description" content="読んで楽しい、を目指したデータベース。">
    <meta name="twitter:image" content="">

</head>
<body>

<div id="app">
    <router-view></router-view>
</div>
<script>
    window.Laravel=
    @php echo json_encode([
            'csrfToken' => csrf_token(),
        ]).PHP_EOL;
    @endphp
</script>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    $(document).ready(function(){
        $('iframe').load(function(){
            if (typeof $(this).attr('height') == 'undefined') {
                $(this).height(this.contentWindow.document.documentElement.scrollHeight+10);
            }
        });
        $('iframe').triggerHandler('load');
    });
</script>
</body>
</html>
