@extends('layouts.app')
@section('content')
<div class="row">
    <h1 class="my-3 p-0">Benvenuto <br> {{$user->name}} {{$user->lastname}}!</h1>
</div>


<div class="row my-3">
    <h2 class="p-0">Il tuo profilo:</h2>
    <div class="col-lg-12 col-md-10 col-sm-12 d-flex justify-content-between" id="doctor-card">
        <div class="col-sm-12 col-md-5 col-lg-5">
            <h5 class="card-title">{{$user->name}} {{$user->lastname}}</h5>
            @if($doctor->description)
            <div id="description-show">
                <p class="card-text">Description: <br>{{$doctor->description}}</p>
            </div>    
            @endif
            <p class="card-text">Address: {{$user->address}}</p>
            @if($doctor->phone)
                <p class="card-text">Phone: {{$doctor->phone}}</p>
            @endif
            @if ($doctor->curriculum_vitae)
                CV:
                <a href="{{ asset('storage/' . $doctor->curriculum_vitae) }}" target="_blank">Preview</a>
            @endif
            @if ($doctor->specializations)
            <div>
                Specializations:<br>
                    <ul>
                        @foreach($doctor->specializations as $elem)	
                            <li>
                                {{$elem->name}}
                            </li>  
                        @endforeach
                    </ul>
                    
            </div>
            @endif
            <div class="d-flex col-6">
                <div>
                    <a href="{{route('admin.dashboard.edit', $doctor)}}" class="btn btn-warning">Modifica Profilo</a>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{$doctor->id}}">
                          Delete
                        </button>
                    
                <div class="modal fade" id="{{$doctor->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{$user->name}} {{$user->lastname}}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete your profile?</p>
                    </div>
                    <div class="modal-footer">
                        <form class="mx-3" action="{{ route('admin.dashboard.destroy', $doctor) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                    </div>
                </div>
                </div>
                
            </div> 
        </div>
                
        <div id="img-box" class="col-sm-12 col-md-6 col-lg-6">
            <a id="img-link" href="{{ asset('storage/' . $doctor->photo) }}" data-lightbox="image-preview">
                <img id="doctor-img" class="img-fluid" src="{{ asset('storage/' . $doctor->photo) }}" alt="">
            </a>
        </div>
    </div>
</div>


<div class="row my-3">
    <h2>Messaggi</h2>
    @if ($doctor->messages->isEmpty())
    <p>Non ci sono messaggi.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Message</th>
                </tr>
            </thead>
            <tbody>
                @foreach($doctor->messages->sortByDesc('created_at') as $message)
                    <tr>
                        <td>{{$message->name}} {{$message->lastname}}</td>
                        <td>{{$message->email}}</td>
                        <td>{{$message->text}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
<div class="row">
    <h2>Recensioni</h2>
    @if($doctor->reviews->isEmpty())
    <p>Non ci sono recensioni.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Review</th>
                    <th>Stars</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($doctor->reviews->sortByDesc('created_at') as $review)
                <tr>
                    <td>{{$review->name}} {{$review->lastname}}</td>
                    <td>{{$review->text}}</td>
                    <td>{{$review->stars}}</td>
                    <td>{{$review->created_at}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    </div>
@endsection