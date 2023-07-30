@extends('layouts.app')
@section('content')
<div id="main-sponsor" class="d-flex justify-content-center align-items-center">
    <div class="text-center">
        <h2>Grazie per aver acquistato il servizio!</h2>
        <h5>Sei a tutti gli effetti un Medico Sponsorizzato BDoctors!</h5>
    </div>  
</div>



@section('script')
<script>
  // JavaScript code to trigger the button click after 5 seconds
  document.addEventListener('DOMContentLoaded', function () {
    setTimeout(function () {
      window.location.href = "{{ route('admin.dashboard.show', $doctor) }}";
    }, 4000); // 5000 milliseconds = 5 seconds
  });
</script>
@endsection
@endsection