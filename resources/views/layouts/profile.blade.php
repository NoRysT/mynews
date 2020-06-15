<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- Csrf Token ? -->
        {{-- あとで --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        {{-- 各ページごとにタイトルタグを入れるため@yieldで開けておく？ --}}
        <title>@yield('title')</title>
        
        <!-- Scripts -->
        {{-- Laravel標準で用意されているJavaすクリプトを読込みます --}}
        <script src="{{ secure_asset('js/app.js') }}" defer></script>
        
        <!-- Fonts -->
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" ref="stylesheet" type="text/css">
        
        <!--Styles -->
        {{-- Laravel標準css読込み  --}}
        <link href="{{ secure_asset('css/app.css') }}" rel="sylesheet">
        {{-- 次の１行を削除 --}}
        <link href="{{ secure_asset('css/admin.css') }}" rel="stylesheet">
        {{-- 次の1行を追記 --}}
        <link href="{{ secure_asset('css/profile.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            {{-- 画面上部に表示するナビゲーションバーです。 --}}
            <nav class="navbar navbar-expand-md navbar-dark navbar-laravel">
                <div calss="container">
                    <a calss="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <div class="collapse navbar-collapse" id="navbarSupportedConten">
                        <!-- Left side of Navbar -->
                        <ul calss="navbar-nav mr-auto">
                            
                        </ul>
                        
                        <!-- Right side of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            {{-- 以下を追記 --}}
                        <!-- Authentication Links -->
                        {{-- ログインしていなかったらログイン画面へのリンクを表示 --}}
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                        {{-- ログインしていたらユーザー名とログアウトボタンを表示 --}}
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @endguest
                            {{-- 以上までを追記 --}}
                        </ul>
                    </div>
                </div>
            </nav>
            {{-- ここまでNavbar --}}
            
            <main calss="py-4">
                {{-- コンテンツをここに入れるため@yield空け　--}}
                @yield('content')
            </main>
        </div>
    </body>
</html>