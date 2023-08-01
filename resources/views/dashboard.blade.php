@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="height: calc(100vh - 90px);">
    <!-- <h2 class="fs-4 text-secondary my-4">
        {{ __('Dashboard') }}
    </h2> -->
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                

                <div class="card-body d-flex justify-content-between align-items-center">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('You are logged in!') }} Now it's time to finish your registration! 
                    <a href="{{route('admin.dashboard.create')}}" class="btn btn-primary">Become a Doctor</a>
                </div>


                <h3></h3>
                
                

            </div>
          
          

        </div>
    </div>
</div>
@endsection
