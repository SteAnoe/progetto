@extends('layouts.app');
@section('content')
<h1>show</h1>
<h3>{{$doctor->description}}</h3>
<h3>{{$doctor->address}}</h3>
<h3>{{$doctor->phone}}</h3>
<h3>{{$user->name}}</h3>
<div>
    Spec used: 
    @if ($doctor->specializations)
        @foreach($doctor->specializations as $elem)	
            {{$elem->name}}
        @endforeach
    @endif
</div>
<a href="{{route('admin.dashboard.edit', $doctor)}}">modifica</a>
@endsection