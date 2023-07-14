@extends('layouts.app');
@section('content')
<h1>pag create</h1>

<form action="{{route ('admin.dashboard.update',$doctor)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group mb-3">
        <label for="curriculum_vitae" class="form-label @error('curriculum_vitae') is-invalid @enderror">Curriculum Vitae</label>
        @error('curriculum_vitae')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input type="file" name="curriculum_vitae" id="curriculum_vitae" class="form-control">
    </div>
    <div class="form-group mb-3">
        <label for="description" class="form-label @error('description') is-invalid @enderror">Description</label>
        @error('description')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <textarea name="description" id="description" class="form-control" rows="5">{{old ('description') ?? $doctor->description }}</textarea>
    </div>
    <div class="form-group mb-3">
        <label for="address" class="form-label @error('address') is-invalid @enderror">Address</label>

        <input type="text" name="address" id="address" class="form-control" value="{{old ('address') ?? $doctor->address }}">
    </div>
    <div class="form-group mb-3">
        <label for="photo" class="form-label @error('photo') is-invalid @enderror">Photo</label>

        <input type="file" name="photo" id="photo" class="form-control">
    </div>

    <div class="form-group mb-3">
        <label for="phone" class="form-label @error('phone') is-invalid @enderror">Phone Number</label>

        <input type="text" name="phone" id="phone" class="form-control" value="{{old ('phone') ?? $doctor->phone }}">
    </div>

    <div class="form-group mb-3">
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

    <button class="btn btn-primary">Crea Project</button>
</form>
    
@endsection