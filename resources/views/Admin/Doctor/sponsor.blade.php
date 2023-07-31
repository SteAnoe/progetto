@extends('layouts.app')
@section('content')
<div id="main-sponsor" class="d-flex justify-content-center align-items-center">
    <div class="text-center">
        <h2>Grazie per aver acquistato il servizio!</h2>
        <h5>Sei a tutti gli effetti un Medico Sponsorizzato BDoctors!</h5>
        <p>Stai per essere reindirizzato alla tua dashboard...</p>
    </div>  
</div>



@section('script')
<script>
  
  // document.addEventListener('DOMContentLoaded', function () {
  //   setTimeout(function () {
  //     window.location.href = "{{ route('admin.dashboard.show', $doctor) }}";
  //   }, 4000); // 5000 milliseconds = 5 seconds
  // });
</script>
@endsection
@endsection