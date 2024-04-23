@extends('auth.base')

@section('content')
    <div class="col-md-10 col-lg-8">
        <div class="card shadow rounded-0 overflow-hidden">
            <div class="row g-0">
                <div class="col-lg-12">
                    <div class="card-body p-4 p-sm-5">
                        <h6 class="card-title text-center mb-4">Register to {{ env('APP_NAME') }}</h6>
                        <form class="form-body" action="{{ route('register') }}" method="post">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6 ">
                                    <label for="inputName" class="form-label">Name</label>
                                    <div class="ms-auto position-relative">
                                        <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i
                                                class="bi bi-person-circle"></i></div>
                                        <input type="text"
                                            class="form-control radius-30 ps-5 @error('name') is-invalid @enderror"
                                            id="inputName" name="name" value="{{ old('name') }}"
                                            placeholder="Enter Name">
                                    </div>
                                    @error('name')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="inputEmailAddress" class="form-label">Email Address</label>
                                    <div class="ms-auto position-relative">
                                        <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i
                                                class="bi bi-envelope-fill"></i></div>
                                        <input type="email" name="email"
                                            class="form-control radius-30 ps-5 @error('email') is-invalid @enderror"
                                            id="inputEmailAddress" name="email" value="{{ old('email') }}"
                                            placeholder="Email Address">
                                    </div>
                                    @error('email')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="inputChoosePassword" class="form-label">Enter Password</label>
                                    <div class="ms-auto position-relative">
                                        <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i
                                                class="bi bi-lock-fill"></i></div>
                                        <input type="password" name="password"
                                            class="form-control radius-30 ps-5 @error('password') is-invalid @enderror"
                                            id="inputChoosePassword" placeholder="Enter Password">
                                    </div>
                                    @error('password')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="inputChoosePassword" class="form-label">Enter Re-password</label>
                                    <div class="ms-auto position-relative">
                                        <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i
                                                class="bi bi-lock-fill"></i></div>
                                        <input type="password" name="password_confirmation"
                                            class="form-control radius-30 ps-5" id="inputChoosePassword"
                                            placeholder="Enter Re-password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input @error('trems_&conditions') is-invalid @enderror"
                                            type="checkbox" id="flexSwitchCheckChecked" name="trems_&_conditions"
                                            @if (old('trems_&_conditions')) checked @endif>
                                        <label class="form-check-label" for="flexSwitchCheckChecked">I Agree to the Trems &
                                            Conditions</label>
                                    </div>
                                    @error('trems_&_conditions')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary radius-30">Register</button>
                                    </div>
                                </div>
                                <div class="login-separater text-center my-0"> <span>OR</span>
                                    <hr>
                                </div>
                                <div class="d-grid mb-2">
                                    <a class="btn btn-white radius-30" href="javascript:;"><span
                                            class="d-flex justify-content-center align-items-center">
                                            <img class="me-2" src="{{ asset('') }}assets/images/icons/search.svg"
                                                width="16" alt="">
                                            <span>Continue with Google</span>
                                        </span>
                                    </a>
                                </div>
                                <hr>
                                <div class="col-12 text-center">
                                    <p class="mb-0">Already have an account? <a href="{{ route('login') }}">Log in
                                            here</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
