@extends('layouts.app');
@section('content')
<h1>Modifica Profilo {{$user->lastname}}</h1>

<form id="form" action="{{route ('admin.dashboard.update', $doctor['id'])}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="form-group mb-3">
        <label for="curriculum_vitae" class="form-label @error('curriculum_vitae') is-invalid @enderror">Curriculum Vitae</label>
        @error('curriculum_vitae')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input type="file" name="curriculum_vitae" id="curriculum_vitae" class="form-control" accept=".pdf, .jpg, .jpeg">
        <div class="invalid-feedback" id="curriculum_vitae-feedback"></div>
    </div>
    @if($doctor->curriculum_vitae)
    <div>
        <input type="checkbox" name="delete_cv" id="delete_cv" onclick="toggleInput()">
        <label for="delete_cv">Cancella il cv</label>
    </div>
    @endif
    <div class="form-group mb-3">
        <label for="description" class="form-label @error('description') is-invalid @enderror">Description</label>
        @error('description')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <textarea name="description" id="description" class="form-control" rows="5" maxlength="500" placeholder="Describe yourself and your performances...">{{old ('description') ?? $doctor->description }}</textarea>
        <div class="invalid-feedback" id="description-feedback"></div>
        <div id="counter" class="text-muted"></div>
    </div>
    <div class="form-group mb-3">
        <label for="photo" class="form-label @error('photo') is-invalid @enderror">Photo</label>
        @error('photo')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input type="file" name="photo" id="photo" class="form-control" accept=".png, .jpg, .jpeg, .gif" >
        <div class="invalid-feedback" id="photo-feedback"></div>
    </div>
    @if($doctor->photo)
    <div>
        <input type="checkbox" name="delete_photo" id="delete_photo" onclick="toggleInputImg()">
        <label for="delete_photo">Cancella la foto</label>
    </div>
    @endif

    <div class="form-group mb-3">
        <label for="phone" class="form-label @error('phone') is-invalid @enderror">Phone Number</label>
        @error('phone')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input type="text" name="phone" id="phone" class="form-control" value="{{old ('phone') ?? $doctor->phone }}" placeholder="Insert your phone number">
        <div class="invalid-feedback" id="phone-feedback"></div>
    </div>

    <div class="form-group mb-3">
        @error('specializations')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <h4>Specializations</h4>
        <div class="invalid-feedback" id="specializations-feedback"></div>
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
    if (isValid) {
        event.target.submit();
    }
});

    document.getElementById('curriculum_vitae').addEventListener('change', function(event) {    
        let input = event.target;
        let allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg'];

        if (!allowedTypes.includes(input.files[0].type)) {
            input.classList.add('is-invalid');
            document.getElementById('curriculum_vitae-feedback').textContent = 'Please upload a PDF, JPG, or JPEG file.';
        } else {
            input.classList.remove('is-invalid');
            document.getElementById('curriculum_vitae-feedback').textContent = '';
        }
    });
    document.getElementById('photo').addEventListener('change', function(event) {        
        let inputImg = event.target;
        let allowedTypesImg = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];

        if (!allowedTypesImg.includes(inputImg.files[0].type)) {
            inputImg.classList.add('is-invalid');
            document.getElementById('photo-feedback').textContent = 'Please upload a PNG, JPG, JPEG or GIF file.';
        } else {
            inputImg.classList.remove('is-invalid');
            document.getElementById('photo-feedback').textContent = '';
        }
    });

    function toggleInput() {
    let cvInput = document.getElementById("curriculum_vitae");
    let deleteCVCheckbox = document.getElementById("delete_cv");

    if (deleteCVCheckbox.checked) {
        cvInput.setAttribute("disabled","disabled");
    } else {
        cvInput.removeAttribute("disabled");
    }
 }
 function toggleInputImg() {
    let imgInput = document.getElementById("photo");
    let deleteImgCheckbox = document.getElementById("delete_photo");

    if (deleteImgCheckbox.checked) {
        imgInput.setAttribute("disabled","disabled");
    } else {
        imgInput.removeAttribute("disabled");
    }
 }

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