@extends('layouts.app')
@section('content')
<div class="container pb-5">

    
    
    <form class="pt-5" id="form" action="{{route ('admin.dashboard.update', $doctor['id'])}}" method="POST" enctype="multipart/form-data">
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
            <label for="description" class="form-label @error('description') is-invalid @enderror"><span class="text-danger fs-5">*</span> Descrizione</label>
            @error('description')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <textarea name="description" id="description" class="form-control" rows="5" maxlength="1000" placeholder="Descrivi te stesso e le tue prestazioni...">{{old ('description') ?? $doctor->description }}</textarea>
            <div class="invalid-feedback" id="description-feedback"></div>
            <div id="counter" class="text-muted"></div>
        </div>
        <div class="form-group mb-3">
            <label for="photo" class="form-label @error('photo') is-invalid @enderror">Foto</label>
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
            <label for="phone" class="form-label @error('phone') is-invalid @enderror"><span class="text-danger fs-5">*</span> Telefono</label>
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
            <h4><span class="text-danger">*</span> Specializzazione</h4>
            <div class="invalid-feedback" id="specializations-feedback"></div>
            <div class="check-specialization col-sm-12">
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
        </div>
    
        <button class="btn btn-primary">Modifica profilo</button>
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
    isValid &= validateField('description', 'description-feedback', 'Il campo è obbligatorio.');
    isValid &= validateField('phone', 'phone-feedback', 'Il campo è obbligatorio.');
    isValid &= checkSpecializations();

    let phoneInput = document.getElementById('phone');
    let phoneFeedback = document.getElementById('phone-feedback');
    let phoneValue = phoneInput.value.trim();
    let numberRegex = /^\d+$/;
    
    if (phoneValue.length > 10) {
        phoneInput.classList.add('is-invalid');
        phoneFeedback.textContent = 'Il numero non deve superare 10 cifre.';
        isValid = false;
    } else if (phoneValue.length < 7) {
        phoneInput.classList.add('is-invalid');
        phoneFeedback.textContent = 'Il numero deve avere almeno 7 cifre.';
        isValid = false;
    } else if (!numberRegex.test(phoneValue)) {
        phoneInput.classList.add('is-invalid');
        phoneFeedback.textContent = 'Il numero deve contenere solo cifre.';
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
            feedbackField.textContent = 'Selezionare almeno una specializzazione.';
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
        cvFeedback.textContent = 'Il file caricato deve essere PDF, JPG, o JPEG.';
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
        photoFeedback.textContent = 'Il file caricato deve essere PNG, JPG, JPEG, o GIF.';
        isValid = false;
    } else {
        photoInput.classList.remove('is-invalid');
        photoFeedback.textContent = '';
    }

    
    if (isValid) {
        event.target.submit();
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
let maxLength = 1000;

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