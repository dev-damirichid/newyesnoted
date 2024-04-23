@extends('auth.base')

@section('content')
    <div class="col-sm-8 col-lg-6">
        <div class="card shadow rounded-0 overflow-hidden">
            <div class="row g-0">
                <div class="col-lg-12">
                    <div class="card-body p-4 p-sm-5">
                        <h5 class="card-title text-center">Reset Password</h5>
                        <p class="card-text mb-3 text-center">Enter new password for {{ $data->email }}</p>
                        <form class="form-body" action="{{ route('reset-password', ['token' => $data->token]) }}"
                            method="post">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="password" class="form-label">Enter Password</label>
                                    <div class="ms-auto position-relative">
                                        <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                                            <i class="bi bi-envelope-fill"></i>
                                        </div>
                                        <input type="password" name="password" value=""
                                            class="form-control radius-30 ps-5 @error('password') is-invalid @enderror"
                                            id="password" placeholder="Enter Password">
                                    </div>
                                    @error('password')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="passwordConfirmation" class="form-label">Enter Password Confirmation</label>
                                    <div class="ms-auto position-relative">
                                        <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                                            <i class="bi bi-envelope-fill"></i>
                                        </div>
                                        <input type="password" name="password_confirmation" value=""
                                            class="form-control radius-30 ps-5" id="passwordConfirmation"
                                            placeholder="Email Password Confirmation">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary radius-30">Send</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
