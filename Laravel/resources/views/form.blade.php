<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">    <title>@yield('title')</title>
    <title>@yield('title')</title>
</head>
<style>

</style>
<body>

<header>
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <a href="{{route('ToDo_View')}}" class="text-decoration-none">
            <H1>To Do</H1>
        </a>

            <ul class="nav justify-content-center">
                @auth
                    <li><a class="nav-link link-dark" href="{{route("ToDo_View")}}">Заметки</a></li>
                @endauth
            </ul>

            <ul class="nav justify-content-center">

                @guest
                <li><a class="nav-link link-dark" href="{{route("Login_View")}}">Авторизация</a></li>
                <li><a class="nav-link link-dark" href="{{route("Register_View")}}">Регистрация</a></li>
                @endguest
                @auth
                    <li><a class="nav-link link-dark" href="{{route("Logout")}}">Выход</a></li>
                @endauth
            </ul>
        </div>
    </div>
</header>

<div class="py-3 container">
    @yield('view')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@yield('script')
</body>
</html>
