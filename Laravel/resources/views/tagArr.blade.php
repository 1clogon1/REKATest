@php $number_tag=1; @endphp
@foreach($tag as $tags)
    <div class="card">
        <div class="card-body">
            <input type="button" class="btn btn-dark" value="&#128465;" onclick='deleteTag({{$tags->id}},{{$tags->note_id}})'>
            № {{$number_tag++}} - {{$tags->name}}
        </div>
    </div>
@endforeach
