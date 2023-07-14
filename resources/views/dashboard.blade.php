@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fs-4 text-secondary my-4">
        {{ __('Dashboard') }}
    </h2>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('User Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>


                <h3>{{$user->name}}</h3>
                <p>{{$doctor->description}}</p>
                <div>
                    @if($doctor->specializations)
                    @foreach($doctor->specializations as $elem)
                    {{$elem->name}}
                    @endforeach
                    @endif
                </div>


            </div>
          <a href="{{route('admin.dashboard.create')}}">compila</a>
          <a href="{{route('admin.dashboard.edit',$doctor)}}">modifica</a>

        </div>
    </div>
</div>
@endsection
