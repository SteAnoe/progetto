@extends('layouts.app');
@section('content')
<h1>Modifica Profilo {{$user->lastname}}</h1>

<form action="{{route ('admin.dashboard.update', $doctor['id'])}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="form-group mb-3">
        <label for="curriculum_vitae" class="form-label @error('curriculum_vitae') is-invalid @enderror">Curriculum Vitae</label>
        @error('curriculum_vitae')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input type="file" name="curriculum_vitae" id="curriculum_vitae" class="form-control">
    </div>
    @if($doctor->curriculum_vitae)
    <div>
        <input type="checkbox" name="delete_cv" id="delete_cv">
        <label for="delete_cv">Cancella il cv</label>
    </div>
    @endif
    <div class="form-group mb-3">
        <label for="description" class="form-label @error('description') is-invalid @enderror">Description</label>
        @error('description')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <textarea name="description" id="description" class="form-control" rows="5">{{old ('description') ?? $doctor->description }}</textarea>
    </div>
    <div class="form-group mb-3">
        <label for="photo" class="form-label @error('photo') is-invalid @enderror">Photo</label>
        @error('photo')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input type="file" name="photo" id="photo" class="form-control">
    </div>
    @if($doctor->photo)
    <div>
        <input type="checkbox" name="delete_photo" id="delete_photo">
        <label for="delete_photo">Cancella la foto</label>
    </div>
    @endif

    <div class="form-group mb-3">
        <label for="phone" class="form-label @error('phone') is-invalid @enderror">Phone Number</label>
        @error('phone')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input type="text" name="phone" id="phone" class="form-control" value="{{old ('phone') ?? $doctor->phone }}">
    </div>

    <div class="form-group mb-3">
        @error('specializations')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        @foreach($specializations as $specialization)
        <div class="form-check">
            
            {{-- <input 
                class="form-check-input" 
                type="checkbox" 
                name="specializations[]" 
                value="{{$specialization->id}}"
                id="specialization-checkbox-{{$specialization->id}}"> --}}

                @if($errors->any())
                <input 
                    class="form-check-input" 
                    type="checkbox" 
                    name="specializations[]" 
                    value="{{$specialization->id}}"
                    id="specialization-checkbox-{{$specialization->id}}"
                    {{in_array($specialization->id, old('specializations',[])) ? 'checked' : ''}}>
    
            @else
                <input 
                class="form-check-input" 
                type="checkbox" 
                name="specializations[]" 
                value="{{$specialization->id}}"
                id="specialization-checkbox-{{$specialization->id}}"
                {{($doctor->specializations->contains($specialization)) ? 'checked' : ''}}>
    
            @endif


            <label class="form-check-label" for="specialization-checkbox-{{$specialization->id}}">
            {{$specialization->name}}
            </label>
        </div>
        @endforeach
    </div>

    <button class="btn btn-primary">modifica doctor</button>
</form>
    
@endsection