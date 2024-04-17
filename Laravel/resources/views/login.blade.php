@extends('form')

@section('title')
    Авторизация
@endsection


@section('view')
    <div class="text-center">
        <h1>
            Авторизация
        </h1>
    </div>

    <div class="container py-3 col-12 col-md-9 col-lg-7 col-xl-6">
        <div class="card p-5" style="border-radius: 15px">
            <form action="{{route('Login')}}" method="post">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Логин</label>
                    <input type="text" class="form-control"  id="emailId" name="email" placeholder="Введите логин" required>
                    @error('email')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Пароль</label>
                    <input type="password" class="form-control" id="passwordId" name="password" placeholder="Введите пароль" required>
                    @error('password')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>

                <div class="text-center">
                    <button type="submit" class="btn-dark btn">Авторизоваться</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')

@endsection
