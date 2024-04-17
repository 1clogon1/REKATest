@extends('form')

@section('title')
    Заметки
@endsection

@section('view')
    <style>
        .imag_max {
            max-width: 150px;
            max-height: 150px;
        }
        .imag_WH {
            width: 150px;
            height: 150px;
        }
    </style>

    <div class="text-center">
        <h1>
            Ваши заметки
        </h1>
    </div>
    <div class="container py-3 col-12 col-md-9 col-lg-7 col-xl-6 ">
        <div class="card p-5 bg-light" style="border-radius: 15px">
            <div class="text-center">
                <h2>
                    Создание новой заметки
                </h2>
            </div>
            <form method="POST">
                @csrf
                <div class="mb-3 ">
                    <label class="form-label">Введите название</label>
                    <input type="text" class="form-control" id="nameNoteId" name="nameNote"
                           placeholder="Введите название новой заметки" required>
                    <div id="error_nameList"></div>

                </div>
                <div class="text-center">
                    <button type="submit" class="btn-dark btn" name="add_note" id="add_noteId">Создать новую заметку
                    </button>
                </div>
            </form>
        </div>
    </div>



    <div class="container py-3 col-12 col-md-9 col-lg-7 col-xl-4  ">
        <div class="p-1">
            <div class="text-center">
                <h2>
                    Фильтрация по тегу
                </h2>
            </div>
                <div class="mb-3 ">
                    <input type="text" class="form-control" id="nameFilter" name="nameFiltername" placeholder="Введите название тега" required>
                </div>
                <div class="text-center">
                    <input type="submit" class="btn-dark btn" name="add_note" id="filterteg_id" onclick="filterTag($('#nameFilter').val())" value="Добавить">
                    <input type="submit" class="btn-dark btn" name="add_note" id="filterteg_id" onclick="clearFilterTag()" value="Очистить">

                    <div id="filter">

                    </div>
                </div>
        </div>
    </div>






    <div class="container py-3 col-12 col-md-9 col-lg-7 col-xl-6">
        <div class="p-5" id="noteId" >
            @php $number=0; @endphp
            @php $checked=0; @endphp
            @php $idNote=0; @endphp
            @for($i=0;$i<count($note);$i++)

                @php $id=$note[$i]['list_id']; @endphp
                @php $idNote=$note[$i]['id']; @endphp
                <div class="card mb-3 p-2 bg-light" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-1">
                            <p>№ {{$number=$number+1}}</p>
                            <input class="form-check-input" type="checkbox" value=""  id="flexCheckChecked" onclick='addCheckBox({{$note[$i]['id']}})' @php if($note[$i]['checked'] == 1){echo "checked";} $id=$note[$i]["list_id"]; @endphp >

                        </div>
                        <div class="col-md-4">
                            <a class="nav-link link-dark "  @if($note[$i]['image']!=NULL)href="{{asset('/storage/images/'.$note[$i]['image'])}}" target="_blank" @endif  >
                                <img @if($note[$i]['image']!=NULL)src="{{asset('/storage/images/'.$note[$i]['image'])}}" @else src="{{asset('/storage/images/nullimage.jpg')}}" @endif  alt="Фотография заметки" class="imag_WH imag_max"  style="width: 150px; height: 150px;">
                            </a>

                        </div>
                        <div class="col-md-7">
                            <div class="card-body">
                                <h5 class="card-title">{{$note[$i]['name']}}</h5>
                                <p class="card-text"><small
                                        class="text-muted">Создано: {{$note[$i]['created_at']}}</small></p>
                            </div>
                        </div>
                        <div class="col-md-10 ">
                                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{$number}}">
                                    Добавить тег
                                </button>
                            <input type="button" class="btn btn-dark" value="&#128465;" onclick='deleteNote({{$note[$i]['id']}})'>
                            <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#staticBackdrop2{{$number}}">
                                Ред. &#9998;
                            </button>
                        </div>
                    </div>
                </div>


                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop{{$number}}" data-bs-backdrop="static" data-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Добавление тега для - {{$note[$i]['name']}}</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                                <div class="modal-body">
                                    <input class="form-control" type="text" id="nameTagNote{{$note[$i]['id']}}" placeholder="Введите tag">
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-primary" id="addNoteTag" onclick="addNoteTag({{$note[$i]['id']}}, $('#nameTagNote{{$note[$i]['id']}}').val())" value="Добавить">
                                </div>
                            <div class="text-center"> <h4>Список тегов</h4></div>
                            <div id="tag_id{{$note[$i]['id']}}">
                                @php $number_tag=1; @endphp
                                @foreach($note[$i]['tag'] as $tags)
                                    <div class="card">
                                        <div class="card-body">
                                            <input type="button" class="btn btn-dark" value="&#128465;" onclick='deleteTag({{$tags->id}},{{$note[$i]['id']}})'>
                                            № {{$number_tag++}} - {{$tags->name}}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop2{{$number}}" data-bs-backdrop="static" data-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content" id="image_nameModel_id{{$note[$i]['id']}}">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Редактирование фотографии - {{$note[$i]['name']}}</h1>
                                <input type="button" class="btn-close" data-bs-dismiss="modal" onclick="todoList()">
                            </div>
                            <div class="modal-body">
                                <label class="form-label">Введите название:</label>
                                <input type="text" class="form-control" id="name_id{{$note[$i]['id']}}" name="name">
                                <br>
                                <label class="form-label">Загрузи фотографию:</label>
                                <input type="file" class="form-control" id="image_id{{$note[$i]['id']}}" name="image">
                                <a class="nav-link link-dark "  @if($note[$i]['image']!=NULL)href="{{asset('/storage/images/'.$note[$i]['image'])}}" target="_blank" @endif  >
                                    <img id="image_img" @if($note[$i]['image']!=NULL)src="{{asset('/storage/images/'.$note[$i]['image'])}}" @else src="{{asset('/storage/images/nullimage.jpg')}}" @endif  alt="Фотография заметки" class="imag_WH imag_max"  style="width: 150px; height: 150px;">
                                </a>

                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-primary" id="add" onclick="updateNameNote({{$note[$i]['id']}},$('#name_id{{$note[$i]['id']}}').val())" value="Сохранить название">
                                <input type="submit" class="btn btn-primary" id="add" onclick="updateImage({{$note[$i]['id']}})" value="Сохранить изображение">
                                <input type="submit" class="btn btn-danger" id="add" onclick="deleteImage({{$note[$i]['id']}})" value="Удалить изображение">
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <!-- Modal -->
            @endfor
        </div>
    </div>





@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $(document).on('click', '#add_noteId', function (e) {
                e.preventDefault();
                var data = new FormData();
                data.append("nameNote", $('#nameNoteId').val());
                data.append("idList", {{$idList}});
                $.ajax({
                    type: "POST",
                    url: "/AddNote",
                    data: data,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    mimeType: "multipart/form-data",
                    timeout: 0,

                    success: function (response) {
                        if (response.status === 200) {
                            todoList();
                        }
                    }
                });
            });
        });

        function todoList(){

            $.ajax({
                type: 'GET',
                url: '/NoteArr/'+{{$idList}},
                contentType: "application/json",
                success: function(data) {
                    console.log(data)
                    $("#noteId").html("");
                    $("#noteId").append(data);
                }

            })
        }

        function filterTag($name) {
            console.log("222222");
            console.log($name);
            $.ajax({
                type: 'POST',
                url: '/AddFilterList?name='+$name,
                contentType: "application/json",
                success: function(data) {
                    console.log(data)
                    $("#filter").html("");
                    $("#filter").append(data);
                    todoList();
                }

            })

        }



        function  clearFilterTag() {
            $.ajax({
                type: 'GET',
                url: '/ClearTag',
                contentType: "application/json",
                success: function(data) {
                    console.log(data)
                    $("#filter").html("");
                    $("#filter").append(data);
                    todoList();
                }

            })

        }

        function addCheckBox($id) {
                    $.ajax({
                        type: "PATCH",
                        url: "/AddChecked?idNote="+$id,
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        mimeType: "multipart/form-data",
                        timeout: 0,

                    });

        }

        function addNoteTag($id,$name) {
            var data = new FormData();
            data.append("nameNoteTag", $name);
            data.append("idNote", $id);
            $.ajax({
                type: "POST",
                url: "/AddNoteTag",
                dataType: "json",
                data: data,
                processData: false,
                contentType: false,
                mimeType: "multipart/form-data",
                timeout: 0,
                success: function (response) {
                    $.ajax({
                        type: 'GET',
                        url: '/TagArr/'+$id,
                        contentType: "application/json",
                        success: function(data) {
                            $("#tag_id"+$id).html("");
                            $("#tag_id"+$id).append(data);
                        }

                    })
                }
            });
        }

        function updateImage($id) {
            var data = new FormData();
            var files = $('#image_id'+$id)[0].files[0];
            data.append("image",files);
            data.append("idNote", $id);
            $.ajax({
                type: "POST",
                url: "/UpdateImage",
                dataType: "json",
                data: data,
                processData: false,
                contentType: false,
                mimeType: "multipart/form-data",
                timeout: 0,
                success: function (response) {
                    image_nameModel_id($id)
                }
            });
        }

        function updateNameNote($id,$name) {
            var data = new FormData();
            data.append("idNote", $id);
            data.append("name",$name);
            $.ajax({
                type: "POST",
                url: "/UpdateName",
                dataType: "json",
                data: data,
                processData: false,
                contentType: false,
                mimeType: "multipart/form-data",
                timeout: 0,
                success: function (response) {
                    image_nameModel_id($id)
                }
            });
        }

        function deleteImage($id) {
            $.ajax({
                type: "DELETE",
                url: "/DeleteImage?idNote="+$id,
                dataType: "json",
                processData: false,
                contentType: false,
                mimeType: "multipart/form-data",
                timeout: 0,
                success: function (response) {
                    if (response.status === 200) {
                        image_nameModel_id($id)

                    }

                }
            });
        }

            function image_nameModel_id($id){
                $.ajax({
                    type: 'GET',
                    url: '/ImageNameModel/'+$id,
                    contentType: "application/json",
                    success: function(data) {
                        $("#image_nameModel_id"+$id).html("");
                        $("#image_nameModel_id"+$id).append(data);
                    }

                })
            }


        function deleteNote($id) {
            $.ajax({
                type: "DELETE",
                url: "/DeleteNote?idNote="+$id,
                dataType: "json",
                processData: false,
                contentType: false,
                mimeType: "multipart/form-data",
                timeout: 0,
                success: function (response) {
                    if (response.status === 200) {
                        todoList();

                    }

                }
            });
        }

        function deleteTag($idTag,$idNote) {
            $.ajax({
                type: "DELETE",
                url: "/DeleteTag?idTag="+$idTag,
                dataType: "json",
                processData: false,
                contentType: false,
                mimeType: "multipart/form-data",
                timeout: 0,
                success: function (response) {
                    if (response.status === 200) {
                        $.ajax({
                            type: 'GET',
                            url: '/TagArr/'+$idNote,
                            contentType: "application/json",
                            success: function(data) {
                                $("#tag_id"+$idNote).html("");
                                $("#tag_id"+$idNote).append(data);
                            }

                        })

                    }

                }
            });



        }



    </script>
@endsection
