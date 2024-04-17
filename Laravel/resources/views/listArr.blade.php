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
