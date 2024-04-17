@extends('form')

@section('title')
    Регистрация
@endsection

@section('view')
    <div class="text-center">
        <H1>Регистрация</H1>
    </div>


    <div class="container py-3 col-12 col-md-9 col-lg-7 col-xl-6">
        <div class="card p-5 " style="border-radius: 15px;">
            <form method="post">
                @csrf
            <div class="mb-3">
                <label class="form-label">Имя</label>
                <input type="text" class="form-control" id="nameId" name="name" required
                       placeholder="Введите Имя">
                <div id="error_name"></div>

            </div>
            <div class="mb-3">
                <label class="form-label">Фамилия</label>
                <input type="text" class="form-control" id="surnameId" name="surname" required
                       placeholder="Введите фамилию">
                <div id="error_surname"></div>

            </div>
            <div class="mb-3">
                <label class="form-label">Отчество</label>
                <input type="text" class="form-control" id="patronymicId" name="patronymic" required
                       placeholder="Введите отчество" >
                <div id="error_patronymic"></div>

            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" id="emailId" name="email" aria-describedby="emailHelp"
                       required placeholder="Введите email">
                <div id="error_email"></div>

            </div>
            <div class="mb-3">
                <label class="form-label">Пароль</label>
                <input type="password" class="form-control" id="passwordId" name="password" required
                       placeholder="Введите пароль">
                <div id="error_password"></div>

            </div>
            <div class="mb-3">
                <label class="form-label">Повторите пароль</label>
                <input type="password" class="form-control" id="password_confirmationId" name="password_confirmation"
                       required placeholder="Повторите пароль">
                <div id="error_password_confirmation"></div>

            </div>
                <div class="mb-3 text-center">
                    <input type="checkbox" id="checkboxId" name="checkbox" >
                    <label class="form-label">Даю согласие на обработку данных</label>
                    <br><div id="error_checkbox"></div>
                </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success" id="register">Зарегистрироваться</button>
            </div>
            </form>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function (){
            $(document).on('click','#register',function (e){
                e.preventDefault();
                var data = new FormData();
                data.append("name",$('#nameId').val());
                data.append("surname",$('#surnameId').val());
                data.append("patronymic",$('#patronymicId').val());
                data.append("email",$('#emailId').val());
                data.append("password",$('#passwordId').val());
                data.append("password_confirmation",$('#password_confirmationId').val());
                data.append("checkbox",$('#checkboxId').is(":checked"));

                $.ajax({
                    type:"POST",
                    url:"/Register",
                    data:data,
                    dataType:"json",
                    processData:false,
                    contentType:false,
                    mimeType:"multipart/form-data",
                    timeout:0,

                    success:function (response){
                        //Елси вернулась ошибка кода 400
                        if(response.status===400){
                            if(response.errors.name){
                                $('#error_name').addClass(' text-danger');
                                $('#error_name').html("");
                                $('#error_name').append('<p>'+response.errors.name+'</p>');
                            }else {
                                $('#error_name').html("");
                            }
                            if(response.errors.surname){
                                $('#error_surname').addClass(' text-danger');
                                $('#error_surname').html("");
                                $('#error_surname').append('<p>'+response.errors.surname+'</p>');
                            }else {
                                $('#error_surname').html("");
                            }
                            if(response.errors.patronymic){
                                $('#error_patronymic').addClass(' text-danger');
                                $('#error_patronymic').html("");
                                $('#error_patronymic').append('<p>'+response.errors.patronymic+'</p>');
                            }else {
                                $('#error_patronymic').html("");
                            }
                            if(response.errors.email){
                                $('#error_email').addClass(' text-danger');
                                $('#error_email').html("");
                                $('#error_email').append('<p>'+response.errors.email+'</p>');
                            }else {
                                $('#error_email').html("");
                            }
                            if(response.errors.login){
                                $('#error_login').addClass(' text-danger');
                                $('#error_login').html("");
                                $('#error_login').append('<p>'+response.errors.login+'</p>');
                            }else {
                                $('#error_login').html("");
                            }
                            if(response.errors.password){
                                $('#error_password').addClass(' text-danger');
                                $('#error_password').html("");
                                $('#error_password').append('<p>'+response.errors.password+'</p>');
                            }else {
                                $('#error_password').html("");
                            }
                            if(response.errors.password_confirmation){
                                $('#error_password_confirmation').addClass(' text-danger');
                                $('#error_password_confirmation').html("");
                                $('#error_password_confirmation').append('<p>'+response.errors.password_confirmation+'</p>');
                            }else {
                                $('#error_password_confirmation').html("");
                            }
                            if(response.errors.checkbox){
                                $('#error_checkbox').addClass(' text-danger');
                                $('#error_checkbox').html("");
                                $('#error_checkbox').append('<p>'+response.errors.checkbox+'</p>');
                            }else {
                                $('#error_checkbox').html("");
                            }
                        }
                        else if(response.status===200){
                            window.location = "/ToDo"
                        }
                    }
                });

            });

        });
    </script>
@endsection
