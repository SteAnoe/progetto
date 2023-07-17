@extends('layouts.app');
@section('content')
<h1>Benvenuto Dr./Drs. {{$user->lastname}}!</h1>
<div class="card" style="width: 18rem;">
    <a href="{{ asset('storage/' . $doctor->photo) }}" data-lightbox="image-preview">
      <img class="img-fluid" src="{{ asset('storage/' . $doctor->photo) }}" alt="">
    </a>
    <div class="card-body">
        <h5 class="card-title">{{$user->name}} {{$user->lastname}}</h5>
        <p class="card-text">Description: <br>{{$doctor->description}}</p>
        <p class="card-text">Address: {{$user->address}}</p>
        <p class="card-text">Phone: {{$doctor->phone}}</p>
        @if ($doctor->curriculum_vitae)
            CV:
            <a href="{{ asset('storage/' . $doctor->curriculum_vitae) }}" target="_blank">Preview</a>
        @endif
        @if ($doctor->specializations)
        <div>
            Specializations<br>
                <ul>
                    @foreach($doctor->specializations as $elem)	
                        <li>
                            {{$elem->name}}
                        </li>  
                    @endforeach
                </ul>
                
        </div>
        @endif
        <a href="{{route('admin.dashboard.edit', $doctor)}}" class="btn btn-primary">Modifica Profilo</a>
        <form class="mx-3" action="{{ route('admin.dashboard.destroy', $doctor) }}" method="POST" onclick="return confirm('Are you sure you want to delete your profile?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</div>
<div class="row">
    <h2>Messaggi</h2>
    @if($doctor->messages->isEmpty())
        <p>Non ci sono messaggi.</p>
    @else
        @foreach($doctor->messages as $message)
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">{{$message-> name}} {{$message-> lastname}}</h5>
                <p class="card-text">{{$message-> text}}</p>
                <p class="card-text">{{$message-> email}}</p>
            </div>
        </div>
        @endforeach
    @endif
</div>
<div class="row">
    <h2>Recensioni</h2>
    @if($doctor->reviews->isEmpty())
        <p>Non ci sono recensioni.</p>
    @else
        @foreach($doctor->reviews as $review)
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">{{$review-> name}} {{$review-> lastname}}</h5>
                <p class="card-text">{{$review-> text}}</p>
                <p class="card-text">{{$review-> stars}}</p>
            </div>
        </div>
        @endforeach
    @endif
</div>
@endsection