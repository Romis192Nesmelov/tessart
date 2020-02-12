@include('layouts._modal_block',['id' => 'message', 'message' => (Session::has('message') ? Session::get('message') : Session::get('status'))])
@if (Session::has('message') || Session::has('status'))
    <script>$('#message').modal('show');</script>
@endif