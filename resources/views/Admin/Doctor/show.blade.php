@extends('layouts.app')
@section('content')
<div id="main-show" class="">
    <div class="container p-3">

    
    <div id="titolo" class="d-flex align-items-center justify-content-between">
        <h1 class="col-1 me-2">Profilo</h1>
        <div class="col-10 "><hr style="color: grey; border: 2px solid grey;"></div>
    </div>
    <div id="left-box " class="col-12 col-md-12 col-lg-12">
        <!-- <h1 class="p-2">Il tuo profilo</h1> -->
        
        <div class="d-xxl-flex justify-content-between border1 ">
            <div class="p-3 col-sm-12 col-md-12 col-xl-12 col-xxl-3 bordo-r">
            @if($doctor->photo)
                <a class="img-link d-flex justify-content-center align-items-center" href="{{ asset('storage/' . $doctor->photo) }}" data-lightbox="image-preview">
                    <img class="doctor-img rounded-circle col-6"  src="{{ asset('storage/' . $doctor->photo) }}" alt="">
                </a>
                
            @else
                <div class="img-link d-flex justify-content-center align-items-center">
                    <img class="doctor-img rounded-circle" src="https://superawesomevectors.com/wp-content/uploads/2021/02/doctor-vector-icon.jpg" alt="">    
                </div>
                
            @endif
                <h5 class="mb-2 col-12 text-center pt-5">{{$user->name}} {{$user->lastname}}</h5>
            </div>
            <div id="info" class="p-3 col-sm-12 col-md-12 col-xl-12 col-xxl-3 bordo-r d-flex flex-column justify-content-around">
                
                   
                    <p class="m-0 py-1"><strong>Email:</strong> {{$user->email}}</p>
                    <p class="m-0 py-1"><strong>Indirizzo:</strong> {{$user->address}}</p>
                    @if($doctor->phone)
                        <p class="m-0 py-1"><strong>Tel:</strong> {{$doctor->phone}}</p>
                    @endif
                
                
                @if ($doctor->curriculum_vitae)
                <div class="py-1">
                    <strong >CV:</strong>
                    <a href="{{ asset('storage/' . $doctor->curriculum_vitae) }}" target="_blank">Preview</a>

                </div>
                @endif
                @if ($doctor->specializations)
                <div class="py-1">
                    <strong>Specializzazione:</strong><br>
                        <ul>
                            @foreach($doctor->specializations as $elem)	
                                <li>
                                    {{$elem->name}}
                                </li>  
                            @endforeach
                        </ul>            
                </div>
                @endif        
            </div>
            <div class="col-sm-12 col-md-12 col-xl-12 col-xxl-6 p-3 d-flex flex-column justify-content-between">
                <div class="">
                    @if($doctor->description)
                    <div class="mb-3">
                        <p class="card-text"><strong>Descrizione:</strong><br>{{$doctor->description}}</p>
                    </div>    
                    @endif   
                </div> 
                <div class="me-3 align-self-end">
                    <a href="{{route('admin.dashboard.edit', $doctor)}}" class="btn btn-culo">Modifica Profilo</a>
                </div>
            </div>
        </div>
    </div>
    @if ($doctor->sponsorships->isEmpty())
        <div class="border1 text-center">
            <button id="premium-button" class="btn my-3" data-bs-toggle="modal" data-bs-target="#{{$doctor->id}}">Sponsorizza il tuo profilo</button>
            <!-- <div class="d-flex justify-content-center align-items-center my-3">
                <div class="me-3">
                    <a href="{{route('admin.dashboard.edit', $doctor)}}" class="btn btn-culo">Modifica Profilo</a>
                </div>
                <div>
                <button type="button" class="btn btn-culo ms-3" data-bs-toggle="modal" data-bs-target="#{{$doctor->phone}}">
                Elimina profilo
                </button>           
                </div>    
            </div> -->
        </div>  
        
        @endif
        <div class="modal fade" id="{{$doctor->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center">Grazie alla Sponsorizzazione sarai inserito nei medici in evidenza, la sezione del sito che tutti vedranno! Inoltre verrai sempre visualizzato prima degli altri nella pagina di ricerca!</p>
                        <form id="payment-form" action="{{route('admin.token')}}" method="POST" >
                            @csrf
                            <div class=" justify-content-center my-3 text-center" id="premium-section" style="display: none;">
                                <div id="bronzo" class="card1 sponsor-base col-3 d-flex flex-column justify-content-center px-3 py-2 border">
                                    <h3 class="mb-2">Piano Bronzo</h3>
                                    <p class="mb-2">
                                        Sponsorizzazione per <b>24 ore.</b>
                                    </p>
                                    <input type="radio" name="amount" id="submit-button-1" class="btn btn-sm btn-success" data-amount="10" value="1"><span id="prezzo">€2.99</span></input>
                                </div>
                                <div id="argento" class="card1 sponsor-medium col-3 d-flex flex-column justify-content-center px-3 py-2 border">
                                    <h3 class="mb-2">Piano Argento</h3>
                                    <p class="mb-2">
                                        Sponsorizzazione per <b>72 ore.</b>
                                    </p>
                                    <input type="radio" name="amount" id="submit-button-2" class="btn btn-sm btn-success" data-amount="20" value="2"><span id="prezzo">€5.99</span></input>
                                </div>
                                <div id="oro" class="card1 sponsor-base col-3 d-flex flex-column justify-content-center px-3 py-2 border">
                                    <h3 class="mb-2">Piano <br> Oro</h3>
                                    <p class="mb-2">
                                        Sponsorizzazione per <b>144 ore.</b>
                                    </p>
                                    <input type="radio" name="amount" id="submit-button-3" class="btn btn-sm btn-success" data-amount="30" value="3"><span id="prezzo">€9.99</span></input>
                                </div>
                            </div>
                            <div id="dropin-container" style="display: none; justify-content: center; align-items: center;"></div>
                            <button id="submit-payment-btn" type="submit" class="mt-4 btn btn-sm btn-success" style="display: none;">Procedi al pagamento</button>
                            <input type="hidden" id="nonce" name="payment_method_nonce" />
                        </form>
                    </div>
                </div>
            </div>
        </div>    
        @if ($doctor->sponsorships->isNotEmpty())
        <div class="border1 px-3 text-center">
            <h2 class="my-3">Sponsorizzazione Attiva</h2>
            @foreach($doctor->sponsorships as $elem)	
            <p class="m-0"><strong>Level:</strong> {{$elem->level}}</p>
            <p class="m-0"><strong>Duration:</strong> {{$elem->duration}}h</p>
            <p class="m-0 mb-3" ><strong >Expire:</strong> {{$elem->pivot->expire}}</p>
            @endforeach
            <!-- <div class="my-5 d-flex justify-content-center align-items-center">
                
               <button type="button" class="btn btn-culo ms-3" data-bs-toggle="modal" data-bs-target="#{{$doctor->phone}}">
                    Elimina profilo
                </button> 
            </div> -->

        </div>
        @endif
        <div class="modal fade" id="{{$doctor->phone}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{$user->name}} {{$user->lastname}}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Sicuro di voler eliminare il tuo profilo?</p>
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
    <div id="right-box" class="col-12 col-lg-12 pb-5">
    
        <div id="msg-box" class="border1">
            <h2 >Messaggi</h2>
            @if ($doctor->messages->isEmpty())
            <p >Non ci sono messaggi.</p>
            @else
                <table class="table">
                    {{-- <thead>
                        <tr class="">
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Message</th>
                        </tr>
                    </thead> --}}
                    <tbody>
                        @foreach($doctor->messages->sortByDesc('created_at') as $message)
                            <tr class="d-flex flex-wrap mario">
                                <td class="col-12 col-sm-12 col-md-4"><b>{{$message->name}} {{$message->lastname}}</b><br>{{$message->email}}<br>{{$message->created_at->format('d/m/Y H:i')}}</td>
                                {{-- <td class="col-12 col-sm-12 col-md-3"></td> --}}
                                <td class="col-12 col-sm-12 col-md-8">
                                    <div class="wrapper-text">
                                        <input type="checkbox" class="read-more-state" id="{{$message->id}}" />
                                        <p class="read-more-wrap"><span class="read-more-target">{{$message->text}}</span></p>
                                        <label for="{{$message->id}}" class="read-more-trigger"></label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div id="review-box" class="border1">
            <h2>Recensioni</h2>
            @if($doctor->reviews->isEmpty())
            <p>Non ci sono recensioni.</p>
            @else
                <table class="table">
                    {{-- <thead>
                        <tr>
                            <th>Name</th>
                            <th>Review</th>
                            <th>Stars</th>
                            <th>Date</th>
                        </tr>
                    </thead> --}}
                    <tbody>
                        @foreach($doctor->reviews->sortByDesc('created_at') as $review)
                        <tr class="d-flex flex-wrap mario">
                            <td class="col-12 col-sm-12 col-md-4"><b>{{$review->name}} {{$review->lastname}}</b><br><b>Voto: </b>{{$review->stars}}<br>{{$review->created_at->format('d/m/Y H:i')}}</td>
                            <td class="col-12 col-sm-12 col-md-8">
                                <div class="wrapper-text">
                                    <input type="checkbox" class="read-more-state" id="{{$review->name}}" />
                                    <p class="read-more-wrap"><span class="read-more-target"> {{$review->text}}</span></p>
                                    <label for="{{$review->name}}" class="read-more-trigger"></label>
                                </div>
                               
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
</div>
 
<script>
   let token = '{{ $token }}';
    const form = document.getElementById('payment-form');
    const dropinContainer = document.getElementById('dropin-container');
    const submitButton = document.getElementById('submit-payment-btn');

    // Function to show the drop-in container and submit button
    function showDropinAndSubmit() {
        dropinContainer.style.display = 'flex';
        submitButton.style.display = 'block';
    }

    // Function to hide the drop-in container and submit button
    function hideDropinAndSubmit() {
        dropinContainer.style.display = 'none';
        submitButton.style.display = 'none';
    }

    // Event listener for radio buttons with name "amount"
    const radioButtons = document.querySelectorAll('input[name="amount"]');
    radioButtons.forEach((radioButton) => {
        radioButton.addEventListener('change', (event) => {
            const selectedAmount = event.target.value;
            if (selectedAmount) {
                // Show the container and submit button when a radio button is selected
                showDropinAndSubmit();
            } else {
                // Hide the container and submit button when no radio button is selected
                hideDropinAndSubmit();
            }
        });
    });

    braintree.dropin.create({
        authorization: token,
        container: '#dropin-container'
    }, (error, dropinInstance) => {
        if (error) console.error(error);

        form.addEventListener('submit', event => {
            event.preventDefault();

            dropinInstance.requestPaymentMethod((error, payload) => {
                if (error) console.error(error);

                document.getElementById('nonce').value = payload.nonce;
                form.submit();
            });
        });
    });

    const premiumButton = document.getElementById('premium-button');
    const premiumSection = document.getElementById('premium-section');

    // Add a click event listener to the premium button
    premiumButton.addEventListener('click', () => {
        // Toggle the visibility of the premium section
        if (premiumSection.style.display === 'none') {
            premiumSection.style.display = 'flex'; // Show the premium section
        } else {
            premiumSection.style.display = 'none'; // Hide the premium section
        }
    });
    var dateString = document.getElementById("output").getAttribute("data-expire");

    // Create a Date object from the date string
    var date = new Date(dateString);

    // Format the date and time as "day-month-year hour-minute"
    var formattedDateTime = date.toLocaleString('en-GB', {
        day: 'numeric',
        month: 'numeric',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });

    // Output the formatted date and time
    document.getElementById("output").textContent = formattedDateTime;
</script>

@endsection