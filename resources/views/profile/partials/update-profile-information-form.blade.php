<section>
    <header>
        <h2 class="text-secondary">
            {{ __('Info Utente') }}
        </h2>

        <p class="mt-1 text-muted">
            {{ __("Aggiorna il tuo nome, cognome, indirizzo e mail.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('admin.profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="mb-2">
            <label for="name">{{__('Nome')}}</label>
            <input class="form-control" type="text" name="name" id="name" autocomplete="name" value="{{old('name', $user->name)}}" required autofocus>
            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->get('name')}}</strong>
            </span>
            @enderror
        </div>

        <div class="mb-2">
            <label for="lastname">{{__('Cognome')}}</label>
            <input class="form-control" type="text" name="lastname" id="lastname" autocomplete="lastname" value="{{old('lastname', $user->lastname)}}" required autofocus>
            @error('lastname')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->get('lastname')}}</strong>
            </span>
            @enderror
        </div>

        <div class="mb-2">
            <label for="email">
                {{__('Mail') }}
            </label>

            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email)}}" required autocomplete="username" />

            @error('email')
            <span class="alert alert-danger mt-2" role="alert">
                <strong>{{ $errors->get('email')}}</strong>
            </span>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-muted">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification" class="btn btn-outline-dark">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 text-success">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
                @endif
            </div>
            @endif

            <div class="mb-2">
            <label for="address">{{__('Indirizzo')}}</label>
            <input class="form-control" type="text" name="address" id="address" autocomplete="address" value="{{old('address', $user->address)}}" required autofocus>
            @error('address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->get('address')}}</strong>
            </span>
            @enderror
        </div>
        </div>

        <div class="d-flex align-items-center gap-4">
            <button class="btn btn-primary" type="submit">{{ __('Salva') }}</button>

            @if (session('status') === 'profile-updated')
            <script>
                const show = true;
                setTimeout(() => show = false, 2000)
                const el = document.getElementById('profile-status')
                if (show) {
                    el.style.display = 'block';
                }
            </script>
            <p id='profile-status' class="fs-5 text-muted">{{ __('Aggiornato!') }}</p>
            @endif
        </div>
    </form>
</section>
