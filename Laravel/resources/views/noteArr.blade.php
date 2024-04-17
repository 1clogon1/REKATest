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
            <div class="col-md-10">
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{$number}}">
                    Добавить тег
                </button>
                <input type="button" class="btn btn-dark" value="&#128465;" onclick='deleteNote({{$note[$i]['id']}})'>
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#staticBackdrop2{{$number}}">
                    Ред. изображение &#9998;
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
            <div class="modal-content" id="imageModel_id{{$note[$i]['id']}}">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Редактирование фотографии - {{$note[$i]['name']}}</h1>
                    <input type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="ToDoList()">
                </div>
                <div class="modal-body">
                    <a class="nav-link link-dark "  @if($note[$i]['image']!=NULL)href="{{asset('/storage/images/'.$note[$i]['image'])}}" target="_blank" @endif  >
                        <img id="image_img" @if($note[$i]['image']!=NULL)src="{{asset('/storage/images/'.$note[$i]['image'])}}" @else src="{{asset('/storage/images/nullimage.jpg')}}" @endif  alt="Фотография заметки" class="imag_WH imag_max"  style="width: 150px; height: 150px;">
                    </a>
                    <label class="form-label">Загрузи фотографию:</label>
                    <input type="file" class="form-control" id="image_id{{$note[$i]['id']}}" name="image">
                    <br>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" id="addNoteTag" onclick="updateImage({{$note[$i]['id']}})" value="Сохранить изображение">
                        <input type="submit" class="btn btn-danger" id="addNoteTag" onclick="deleteImage({{$note[$i]['id']}})" value="Удалить">
                    </div>
                </div>


            </div>
        </div>
    </div>
@endfor
