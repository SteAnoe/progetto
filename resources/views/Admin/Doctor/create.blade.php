@extends('layouts.app')
@section('content')
<div class="container">

    <h1>Creazione Profilo {{$user->lastname}}</h1>
    
    <form id="form" action="{{route ('admin.dashboard.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-3">
            <label for="curriculum_vitae" class="form-label @error('curriculum_vitae') is-invalid @enderror">Curriculum Vitae</label>
            @error('curriculum_vitae')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <input type="file" name="curriculum_vitae" id="curriculum_vitae" class="form-control" accept=".pdf, .jpg, .jpeg">
            <div class="invalid-feedback" id="curriculum_vitae-feedback"></div>
        </div>
        <div class="form-group mb-3">
            <label for="description" class="form-label @error('description') is-invalid @enderror"><span class="text-danger fs-5">*</span> Descrizione</label>
            @error('description')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <textarea name="description" id="description" class="form-control" rows="5" maxlength="500" placeholder="Describe yourself and your performances..."></textarea>
            <div class="invalid-feedback" id="description-feedback"></div>
            <div id="counter" class="text-muted"></div>
        </div>
        <div class="form-group mb-3">
            <label for="photo" class="form-label @error('photo') is-invalid @enderror">Foto</label>
            @error('photo')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <input type="file" name="photo" id="photo" class="form-control" accept=".png, .jpg, .jpeg, .gif">
            <div class="invalid-feedback" id="photo-feedback"></div>
        </div>
    
        <div class="form-group mb-3">
            <label for="phone" class="form-label @error('phone') is-invalid @enderror"><span class="text-danger fs-5">*</span> Telefono</label>
            @error('phone')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <input type="text" name="phone" id="phone" class="form-control" placeholder="Insert your phone number">
            <div class="invalid-feedback" id="phone-feedback"></div>
        </div>
    
        <div class="form-group mb-3">
            @error('specializations')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <h4><span class="text-danger">*</span> Specializzazioni</h4>
            <div class="invalid-feedback" id="specializations-feedback"></div>
            <div class="check-specialization col-sm-12">
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
        </div>
    
        <button class="btn btn-primary">Crea doctor</button>
    </form>
</div>
    
@endsection

@section('script')
<script>
document.querySelector('#form').addEventListener('submit', function(event) {
    event.preventDefault();
 
    function validateField(inputId, feedbackId, errorMessage) {
        let inputField = document.getElementById(inputId);
        let feedbackField = document.getElementById(feedbackId);
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

    let phoneInput = document.getElementById('phone');
    let phoneFeedback = document.getElementById('phone-feedback');
    let phoneValue = phoneInput.value.trim();
    let numberRegex = /^\d+$/;
    
    if (phoneValue.length > 10) {
        phoneInput.classList.add('is-invalid');
        phoneFeedback.textContent = 'Phone number should not exceed 10 digits.';
        isValid = false;
    } else if (phoneValue.length < 7) {
        phoneInput.classList.add('is-invalid');
        phoneFeedback.textContent = 'Phone number should have at least 7 digits.';
        isValid = false;
    } else if (!numberRegex.test(phoneValue)) {
        phoneInput.classList.add('is-invalid');
        phoneFeedback.textContent = 'Phone number should contain only digits.';
        isValid = false;
    } else {
        phoneInput.classList.remove('is-invalid');
        phoneFeedback.textContent = '';
    }

    function checkSpecializations() {
        let specializationCheckboxes = document.querySelectorAll('input[name="specializations[]"]');
        let feedbackField = document.getElementById('specializations-feedback');
        let isAnySpecializationChecked = Array.from(specializationCheckboxes).some(cb => cb.checked);
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
    const cvInput = document.getElementById('curriculum_vitae');
    const cvFeedback = document.getElementById('curriculum_vitae-feedback');
    const allowedTypesCV = ['application/pdf', 'image/jpeg', 'image/jpg'];

    if (cvInput.files.length > 0 && !allowedTypesCV.includes(cvInput.files[0].type)) {
        cvInput.classList.add('is-invalid');
        cvFeedback.textContent = 'Please upload a PDF, JPG, or JPEG file.';
        isValid = false;
    } else {
        cvInput.classList.remove('is-invalid');
        cvFeedback.textContent = '';
    }

    const photoInput = document.getElementById('photo');
    const photoFeedback = document.getElementById('photo-feedback');
    const allowedTypesPhoto = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];

    if (photoInput.files.length > 0 && !allowedTypesPhoto.includes(photoInput.files[0].type)) {
        photoInput.classList.add('is-invalid');
        photoFeedback.textContent = 'Please upload a PNG, JPG, JPEG, or GIF file.';
        isValid = false;
    } else {
        photoInput.classList.remove('is-invalid');
        photoFeedback.textContent = '';
    }

    
    if (isValid) {
        event.target.submit();
    }
});

let descriptionInput = document.getElementById("description");
let counterElement = document.getElementById("counter");
let maxLength = 500;

descriptionInput.addEventListener("input", updateCounter);

function updateCounter() {
  let description = descriptionInput.value;
  let remainingCharacters = maxLength - description.length;

  counterElement.innerText = remainingCharacters + "/" + maxLength;

  if (description.length > maxLength) {
    descriptionInput.classList.add("is-invalid");
  } else {
    descriptionInput.classList.remove("is-invalid");
  }
}
    
</script>
@endsection