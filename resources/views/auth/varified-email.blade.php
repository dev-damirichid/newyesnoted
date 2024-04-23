@extends('auth.base')

@section('content')
    <div class="col-sm-8 col-lg-8">
        <div class="card shadow rounded-0 overflow-hidden">
            <div class="row g-0">
                <div class="col-lg-12">
                    <div class="card-body text-center">
                        <h5 class="card-title text-center mb-4">Email Verification</h5>
                        <p class="card-text mb-3">Email Verification for {{ auth()->user()->email }}</p>
                        <div class="row g-3">
                            <div class="col-12">
                                <p>
                                    Please check your email, to verification your account.
                                <form action="{{ route('verified') }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Send again</button>
                                </form>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
