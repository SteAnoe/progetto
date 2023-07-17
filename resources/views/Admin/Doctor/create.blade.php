@extends('layouts.app');
@section('content')
<h1>Creazione Profilo {{$user->lastname}}</h1>

<form id="form" action="{{route ('admin.dashboard.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
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
        <textarea name="description" id="description" class="form-control" rows="5"></textarea>
        <div class="invalid-feedback" id="description-feedback"></div>
    </div>
    <div class="form-group mb-3">
        <label for="photo" class="form-label @error('photo') is-invalid @enderror">Photo</label>
        @error('photo')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input type="file" name="photo" id="photo" class="form-control">
    </div>

    <div class="form-group mb-3">
        <label for="phone" class="form-label @error('phone') is-invalid @enderror">Phone Number</label>
        @error('phone')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input type="text" name="phone" id="phone" class="form-control" pattern="\d*" title="Please enter only numbers">
        <div class="invalid-feedback" id="phone-feedback"></div>
    </div>

    <div class="form-group mb-3">
        @error('specializations')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="invalid-feedback" id="specializations-feedback"></div>
        @foreach($specializations as $specialization)
        <div class="form-check">
            <input 
                class="form-check-input" 
                type="checkbox" 
                name="specializations[]" 
                value="{{$specialization->id}}"
                id="specialization-checkbox-{{$specialization->id}}">

            <label class="form-check-label" for="specialization-checkbox-{{$specialization->id}}">
            {{$specialization->name}}
            </label>
        </div>
        @endforeach
        
    </div>

    <button class="btn btn-primary">Crea doctor</button>
</form>
    
@endsection

@section('script')
<script>
document.querySelector('#form').addEventListener('submit', function(event) {
    event.preventDefault();
 
    function validateField(inputId, feedbackId, errorMessage) {
        const inputField = document.getElementById(inputId);
        const feedbackField = document.getElementById(feedbackId);
        if (inputField.value.trim() === '') {
            inputField.classList.add('is-invalid');
            feedbackField.textContent = errorMessage;
            return false;
        } else {
            inputField.classList.remove('is-invalid');
            feedbackField.textContent = '';
            return true;
        }
    }
 
    let isValid = true;
    isValid &= validateField('description', 'description-feedback', 'Description is required.');
    isValid &= validateField('phone', 'phone-feedback', 'Phone is required.');
    isValid &= checkSpecializations();

    function checkSpecializations() {
        const specializationCheckboxes = document.querySelectorAll('input[name="specializations[]"]');
        const feedbackField = document.getElementById('specializations-feedback');
        const isAnySpecializationChecked = Array.from(specializationCheckboxes).some(cb => cb.checked);
        if (!isAnySpecializationChecked) {
            feedbackField.textContent = 'Please select at least one specialization.';
            feedbackField.style.display = 'block';
            return false;
        } else {
            feedbackField.textContent = '';
            feedbackField.style.display = 'none';
            return true;
        }
    }
    if (isValid) {
        event.target.submit();
    }
});

//     Funzione per bloccare tutto tranne numeri
//     document.getElementById('phone').addEventListener('input', function(event) {
//         const input = event.target;
//         const cleanedValue = input.value.replace(/\D/g, ''); // Remove all non-numeric characters
//         input.value = cleanedValue;
//     });
    
</script>
@endsection