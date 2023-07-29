@extends('layouts.app')
@section('content')
<h1>grazie</h1>

<button class="btn btn-primary"><a href="{{route('admin.dashboard.show', $doctor)}}">torna alla dashboard</a></button>

@endsection