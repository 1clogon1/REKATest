
@foreach($note as $note)
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Редактирование фотографии - {{$note->name}}</h1>
        <input type="button" class="btn-close" data-bs-dismiss="modal" onclick="todoList()">
    </div>
    <div class="modal-body">
        <label class="form-label">Введите название:</label>
        <input type="text" class="form-control" id="name_id{{$note->id}}" name="name">
        <br>
        <label class="form-label">Загрузи фотографию:</label>
        <input type="file" class="form-control" id="image_id{{$note->id}}" name="image">
        <a class="nav-link link-dark "  @if($note->image!=NULL)href="{{asset('/storage/images/'.$note->image)}}" target="_blank" @endif  >
            <img id="image_img" @if($note->image!=NULL)src="{{asset('/storage/images/'.$note->image)}}" @else src="{{asset('/storage/images/nullimage.jpg')}}" @endif  alt="Фотография заметки" class="imag_WH imag_max"  style="width: 150px; height: 150px;">
        </a>

        <div class="modal-footer">
            <input type="submit" class="btn btn-primary" id="add" onclick="updateNameNote({{$note->id}},$('#name_id{{$note->id}}').val())" value="Сохранить название">
            <input type="submit" class="btn btn-primary" id="add" onclick="updateImage({{$note->id}})" value="Сохранить изображение">
            <input type="submit" class="btn btn-danger" id="add" onclick="deleteImage({{$note->id}})" value="Удалить изображение">
        </div>
    </div>
@endforeach
