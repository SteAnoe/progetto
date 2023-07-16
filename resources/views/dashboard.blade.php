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

                <h1>Benvenuto</h1>
                <h2>{{$user->name}}</h2>
                @if ( $doctor = $user->doctor)

                    <p>{{$doctor->description}}</p>
                    <div>
                        @if($doctor->specializations)
                        @foreach($doctor->specializations as $elem)
                        {{$elem->name}}
                        @endforeach
                        @endif
                    </div>
                @endif
                  
            </div>
            @if($doctor)
            <a class="btn btn-warning" href="{{route('admin.dashboard.edit',$doctor)}}">modifica il tuo profilo</a>
            @else
          <a class="btn btn-primary" href="{{route('admin.dashboard.create')}}">completa il tuo profilo</a>
          @endif

        </div>
    </div>
</div>
@endsection
