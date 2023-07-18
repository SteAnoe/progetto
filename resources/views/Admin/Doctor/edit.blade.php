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
        <textarea name="description" id="description" class="form-control" rows="5">{{old ('description') ?? $doctor->description }}</textarea>
        <div class="invalid-feedback" id="description-feedback"></div>
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
        <input type="text" name="phone" id="phone" class="form-control" value="{{old ('phone') ?? $doctor->phone }}" pattern="\d*" title="Please enter only numbers">
        <div class="invalid-feedback" id="phone-feedback"></div>
    </div>

    <div class="form-group mb-3">
        @error('specializations')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
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
    document.getElementById('curriculum_vitae').addEventListener('change', function(event) {    
        const input = event.target;
        const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg'];

        if (!allowedTypes.includes(input.files[0].type)) {
            input.classList.add('is-invalid');
            document.getElementById('curriculum_vitae-feedback').textContent = 'Please upload a PDF, JPG, or JPEG file.';
        } else {
            input.classList.remove('is-invalid');
            document.getElementById('curriculum_vitae-feedback').textContent = '';
        }
    });
    document.getElementById('photo').addEventListener('change', function(event) {        
        const inputImg = event.target;
        const allowedTypesImg = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];

        if (!allowedTypesImg.includes(inputImg.files[0].type)) {
            inputImg.classList.add('is-invalid');
            document.getElementById('photo-feedback').textContent = 'Please upload a PNG, JPG, JPEG or GIF file.';
        } else {
            inputImg.classList.remove('is-invalid');
            document.getElementById('photo-feedback').textContent = '';
        }
    });

    function toggleInput() {
    const cvInput = document.getElementById("curriculum_vitae");
    const deleteCVCheckbox = document.getElementById("delete_cv");

    if (deleteCVCheckbox.checked) {
        cvInput.setAttribute("disabled","disabled");
    } else {
        cvInput.removeAttribute("disabled");
    }
 }
 function toggleInputImg() {
    const imgInput = document.getElementById("photo");
    const deleteImgCheckbox = document.getElementById("delete_photo");

    if (deleteImgCheckbox.checked) {
        imgInput.setAttribute("disabled","disabled");
    } else {
        imgInput.removeAttribute("disabled");
    }
 }

//     Funzione per bloccare tutto tranne numeri
//     document.getElementById('phone').addEventListener('input', function(event) {
//         const input = event.target;
//         const cleanedValue = input.value.replace(/\D/g, ''); // Remove all non-numeric characters
//         input.value = cleanedValue;
//     });
    
</script>
@endsection