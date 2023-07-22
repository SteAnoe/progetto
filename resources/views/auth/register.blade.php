@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form id="form" method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-4 row">
                            <label for="name" class="col-md-4 col-form-label text-md-right"><span class="text-danger">*</span> {{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" onblur="capitalizeFirstLetter('name')" oninput="validateField('name', 'name-feedback', 'Name is required.')" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>
                                <div class="invalid-feedback" id="name-feedback"></div>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="lastname" class="col-md-4 col-form-label text-md-right"><span class="text-danger">*</span> {{ __('Lastname') }}</label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" onblur="capitalizeFirstLetter('lastname')" oninput="validateField('lastname', 'lastname-feedback', 'Lastname is required.')" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}"  autocomplete="lastname" autofocus>
                                <div class="invalid-feedback" id="lastname-feedback"></div>
                                @error('lastname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="email" class="col-md-4 col-form-label text-md-right"><span class="text-danger">*</span> {{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" oninput="validateField('email', 'email-feedback', 'Email is required.')" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email">
                                <div class="invalid-feedback" id="email-feedback"></div>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="password" class="col-md-4 col-form-label text-md-right"><span class="text-danger">*</span> {{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" oninput="validateField('password', 'password-feedback', 'Password is required.')" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                                <div class="invalid-feedback" id="password-feedback"></div>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right"><span class="text-danger">*</span> {{ __('Confirm Password') }}</label>
                            
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" oninput="validateField('password-confirm', 'password-confirm-feedback', 'Password confirmation is required.')" class="form-control @error('password-confirm') is-invalid @enderror"  name="password_confirmation"  autocomplete="new-password">
                                <div class="invalid-feedback" id="password-confirm-feedback"></div>
                                @error('password-confirm')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="address" class="col-md-4 col-form-label text-md-right"><span class="text-danger">*</span> {{ __('Address') }}</label>                            
                            <div class="col-md-6">
                                <input id="address" type="text" oninput="validateField('address', 'address-feedback', 'Address is required.')" class="form-control @error('address') is-invalid @enderror" placeholder="Es. Via/Piazza Roma 15" name="address" >
                                <div class="invalid-feedback" id="address-feedback"></div>
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group mb-3">
                            @error('specializations')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <h4><span class="text-danger">*</span> Specializations</h4>
                            <div class="invalid-feedback" id="specializations-feedback"></div>
                            
                            @foreach($specializations as $specialization)
                            <div class="form-check">
                                <input 
                                    class="form-check-input @error('specializations') is-invalid @enderror" 
                                    type="checkbox" 
                                    name="specializations[]" 
                                    value="{{$specialization->id}}"
                                    id="specialization-checkbox-{{$specialization->id}}"
                                    onchange="checkSpecializations()">

                                <label class="form-check-label" for="specialization-checkbox-{{$specialization->id}}">
                                {{$specialization->name}}
                                </label>
                            </div>
                            @endforeach
                            
                        </div>

                        <div class="mb-4 row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" onclick="submitForm(event)">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('script')
<script>
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
  function validateEmailFormat(email) {
    return email.includes('@');
    }
  function checkPasswordMatch() {
  const password = document.getElementById('password').value;
  const confirmPassword = document.getElementById('password-confirm').value;
  const confirmPasswordInput = document.getElementById('password-confirm');
  const confirmPasswordError = document.getElementById('password-confirm-feedback');

  if (password === confirmPassword) {
    confirmPasswordInput.classList.remove('is-invalid');
    confirmPasswordInput.classList.add('is-valid');
    confirmPasswordError.textContent = '';
  } else {
    confirmPasswordError.textContent = 'The two passwords do not match';
    confirmPasswordInput.classList.remove('is-valid');
    confirmPasswordInput.classList.add('is-invalid');
  }
}

function submitForm(event) {
  event.preventDefault();

  let isValidName = validateField('name', 'name-feedback', 'Name is required.');
  let isValidLastname = validateField('lastname', 'lastname-feedback', 'Lastname is required.');
  let isValidEmail = validateField('email', 'email-feedback', 'Email is required.');
  let isValidPassword = validateField('password', 'password-feedback', 'Password is required.');
  let isValidPasswordConfirm = validateField('password-confirm', 'password-confirm-feedback', 'Password confirmation is required.');
  let isValidAddress = validateField('address', 'address-feedback', 'Address is required.');
  let isValidSpecializations = checkSpecializations();

  let password = document.getElementById('password').value;
  let confirmPassword = document.getElementById('password-confirm').value;
  let confirmPasswordInput = document.getElementById('password-confirm');
  let confirmPasswordError = document.getElementById('password-confirm-feedback');

  if (password !== confirmPassword) {
    confirmPasswordInput.classList.remove('is-valid');
    confirmPasswordInput.classList.add('is-invalid');
    isValidPasswordConfirm = false;
  } else {
    confirmPasswordError.textContent = ''; 
    confirmPasswordInput.classList.add('is-valid');
    isValidPasswordConfirm = true;
  }
  const emailInput = document.getElementById('email');
  const emailError = document.getElementById('email-feedback');
  const emailValue = emailInput.value.trim();

  if (!validateEmailFormat(emailValue)) {
    emailInput.classList.remove('is-valid');
    emailInput.classList.add('is-invalid');
    emailError.textContent = 'Invalid email format.';
    isValidEmail = false;
  } else {
    emailError.textContent = '';
    emailInput.classList.add('is-valid');
    isValidEmail = true;
  }

  
  if (isValidName && isValidLastname && isValidEmail && isValidPassword && isValidPasswordConfirm && isValidAddress && isValidSpecializations) {
    document.getElementById('form').submit();
  }
}


    function capitalizeFirstLetter(inputId){
        const inputField = document.getElementById(inputId);
        const inputValue = inputField.value.trim();

        if (inputValue !== "") {
            const words = inputValue.split(" ");
            const capitalizedWords = words.map(word => word.charAt(0).toUpperCase() + word.slice(1));
            const capitalizedValue = capitalizedWords.join(" ");

            inputField.value = capitalizedValue;
        }
    }

    document.getElementById('password-confirm').addEventListener('input', checkPasswordMatch);
</script>
@endsection