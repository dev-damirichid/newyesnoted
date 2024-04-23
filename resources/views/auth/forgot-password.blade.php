@extends('auth.base')

@section('content')
    <div class="col-sm-8 col-lg-8">
        <div class="card shadow rounded-0 overflow-hidden">
            <div class="row g-0">
                <div class="col-lg-12">
                    <div class="card-body p-4 p-sm-5">
                        <h5 class="card-title text-center">Forgot Password?</h5>
                        <p class="card-text mb-5 text-center">Enter your registered email to reset the password</p>
                        <form class="form-body" action="{{ route('forgot-password') }}" method="post">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="inputEmailAddress" class="form-label">Email
                                        Address</label>
                                    <div class="ms-auto position-relative">
                                        <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                                            <i class="bi bi-envelope-fill"></i>
                                        </div>
                                        <input type="email" name="email" value="{{ old('email') }}"
                                            class="form-control radius-30 ps-5 @error('email') is-invalid @enderror"
                                            id="inputEmailAddress" placeholder="Email Address">
                                    </div>
                                    @error('email')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary radius-30">Send</button>
                                    </div>
                                </div>
                                <div class="col-12 text-center">
                                    <p class="mb-0">back to <a href="{{ route('login') }}">login</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
