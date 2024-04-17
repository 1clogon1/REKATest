@extends('form')

@section('title')
    Заметки
@endsection

@section('view')
    <div class="text-center">
        <h1>
            Ваши списки
        </h1>
    </div>

    <div class="container py-3 col-12 col-md-9 col-lg-7 col-xl-6">
        <div class="card p-5 bg-light bg-gradient" style="border-radius: 15px">
            <div class="text-center">
                <h2>
                    Создание нового списка
                </h2>
            </div>
            <form method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Введите название</label>
                    <input type="text" class="form-control" id="nameListId" name="nameList"
                           placeholder="Введите название нового списка" required>
                    <div id="error_nameList"></div>

                </div>
                <div class="text-center">
                    <button type="submit" class="btn-dark btn" name="add_list" id="add_listId">Создать новый список
                    </button>
                </div>
            </form>
        </div>
    </div>


    <div class="container py-3 col-12 col-md-9 col-lg-7 col-xl-6">
        <div class="p-5" id="listID">
            @foreach($list as $list)
                <a class="nav-link link-dark " href="{{route('NoteList',$list->id)}}">
                    <div class="card mb-3 bg-light" style="max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{$list->name}}</h5>
                                    <p class="card-text"><small
                                            class="text-muted">Создано: {{$list->created_at}}</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $(document).on('click', '#add_listId', function (e) {
                e.preventDefault();
                var data = new FormData();
                data.append("nameList", $('#nameListId').val());

                $.ajax({
                    type: "POST",
                    url: "http://127.0.0.1:8000/AddList",
                    data: data,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    mimeType: "multipart/form-data",
                    timeout: 0,

                    success: function (response) {
                        //Елси вернулась ошибка кода 400
                        if (response.status === 400) {
                            if (response.errors.nameList) {
                                $('#error_nameList').addClass(' text-danger');
                                $('#error_nameList').html("");
                                $('#error_nameList').append('<p>' + response.errors.nameList + '</p>');
                            } else {
                                $('#error_nameList').html("");
                            }

                        }
                        else{
                            $.ajax({
                                type: 'GET',
                                url: '/ListArr/'+{{$user_id}},
                                contentType: "application/json",
                                success: function(data) {
                                    $("#listID").html("");
                                    $("#listID").append(data);
                                }

                            })
                        }
                    }
                });

            });

        });
    </script>
@endsection
