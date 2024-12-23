@if (Session::has('success'))
    <div class="alert alert-success alert-dismissable fade show d-flex justify-content-between" role="alert">
        {{ Session::get('success') }}

    </div>
@elseif(Session::has('error'))
    <div class="alert alert-danger alert-dismissable fade show d-flex justify-content-between" role="alert">
        {{ Session::get('error') }}

    </div>
@elseif($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissable fade show d-flex justify-content-between" role="alert">
            {{ $error }}

        </div>
    @endforeach
@endif
