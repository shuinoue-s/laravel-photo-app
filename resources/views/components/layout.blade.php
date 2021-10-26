<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Phototte</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>
</head>

<body class="antialiased">
    <!-- header -->
    <header class="fixed opacity-90 w-full bg-black text-white p-8 h-20 flex items-center header-shadow z-20">
        <h1 class="text-3xl ml-12"><a href="/" class="text-white">Phototte</a></h1>

        <div class="pr-8 w-full flex justify-end items-center">
            <div id="hamburger-menu" class="relative w-8 inline-block box-border text-white align-middle cursor-pointer">
                <div class="hamburger hamburger-menu1 absolute left-0 inline-block box-border rounded-sm bg-white h-0.5 w-8"></div>
                <div class="hamburger hamburger-menu2 absolute left-0 inline-block box-border rounded-sm bg-white h-0.5 w-8"></div>
                <div class="hamburger hamburger-menu3 absolute left-0 inline-block box-border rounded-sm bg-white h-0.5 w-8"></div>
            </div>
        </div>
    </header>
    <!-- hamburger-menu -->
    <div id="menu-wrapper">
        <div class="menu-display">
            <ul class="mx-auto my-8 w-3/4 text-center text-lg">
                <li><a href="{{ route('index') }}" class="inline-block mt-8">トップページ</a></li>
                <li><a href="{{ route('mypage.profile') }}" class="inline-block mt-8">マイページ</a></li>
                <li><a href="{{ route('post.form') }}" class="inline-block mt-8">投稿する</a></li>
                @auth
                <li><a href="{{ route('post.list') }}" class="inline-block mt-8">投稿一覧</a></li>
                @endauth
                <li><a href="{{ route('tag.search') }}" class="inline-block mt-8">タグ検索</a></li>
                @guest
                <li><a href="{{ route('login') }}" class="inline-block mt-8">ログイン</a></li>
                @endguest
                @auth
                <li><a href="{{ route('user.logout') }}" class="inline-block mt-8">ログアウト</a></li>
                @endauth
            </ul>
        </div>
    </div>
    <div id="mask-wrapper">
        <div id="mask" class="mask"></div>
    </div>


    <!-- body -->
    <div class="absolute top-20 w-full">

        {{ $slot }}

        <!-- footer -->
        <footer class="mt-12 h-12">

        </footer>
    </div>


    <!-- javascript -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ mix('js/main.js') }}"></script>
    <script src="{{ mix('js/jquery.js') }}"></script>
    <script src="{{ mix('js/lazyload.min.js') }}"></script>
    <script>
        lazyload();
    </script>
</body>
</html>
