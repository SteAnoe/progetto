@extends('layouts.app')
@section('content')
<div class="container bg-danger">
    <div class="card border  border-danger" style="width: 18rem;">
        <img src="#" class="card-img-top" alt="...">
        <div class="card-body">
          
            <h1 class="card-title">{{$user['name']}}</h1>
            <p class="card-text">{{$showDoctor['description']}}</p>
            <p class="card-text">{{$showDoctor['address']}}</p>

            @if( $showDoctor->specializations )
              @foreach ( $showDoctor->specializations as $elem )
                <div> {{ $elem->name }} </div>
              @endforeach
            @endif
        </div>
    </div>
    <a class="btn btn-warning" href="{{route('admin.dashboard.edit',$showDoctor)}}">modifica il tuo profilo</a>

    <form action="{{ route('admin.dashboard.destroy', $showDoctor['id']) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger bg-danger-subtle text-danger me-2 w-100">
          <i class="fa-regular fa-trash-can text-danger me-2"></i>
          Delete
        </button>
      </form>
</div>

@endsection