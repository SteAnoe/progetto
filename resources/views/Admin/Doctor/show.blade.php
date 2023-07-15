@extends('layouts.app');
@section('content')
<h1>Benvenuto Dr./Drs. {{$user->lastname}}!</h1>
<div class="card" style="width: 18rem;">
    <img class="img-fluid" src="{{asset('storage/' . $doctor->photo)}}" alt="">
    <div class="card-body">
        <h5 class="card-title">{{$user->name}} {{$user->lastname}}</h5>
        <p class="card-text">Description: <br>{{$doctor->description}}</p>
        <p class="card-text">Address: {{$doctor->address}}</p>
        <p class="card-text">Phone: {{$doctor->phone}}</p>
        @if ($doctor->curriculum_vitae)
            <p class="card-text">CV/{{$user->name}}-{{$user->lastname}} caricato correttamente</p>
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
    </div>
</div>
@endsection