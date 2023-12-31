@extends('layouts.app')
@section('content')

<div class="container pb-5">
    <!-- <h2 class="fs-4 my-4">
        {{ __('Profilo') }}
    </h2> -->
    <div class="card p-4 mb-4 bg-white shadow rounded-lg mt-4">

        @include('profile.partials.update-profile-information-form')

    </div>

    <div class="card p-4 mb-4 bg-white shadow rounded-lg">


        @include('profile.partials.update-password-form')

    </div>

    <div class="card p-4 mb-4 bg-white shadow rounded-lg">


        @include('profile.partials.delete-user-form')

    </div>
</div>

@endsection
