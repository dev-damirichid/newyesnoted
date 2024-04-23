@extends('auth.base')

@section('content')
    <div class="col-sm-8 col-lg-8">
        <div class="card shadow rounded-0 overflow-hidden">
            <div class="row g-0">
                <div class="col-lg-12">
                    <div class="card-body text-center">
                        <h5 class="card-title text-center mb-4">Verification Email Successfully</h5>
                        <div class="text-center">
                            <a href="{{ route('dashboard.index') }}" class="btn btn-primary btn-lg btn-shadow">Go to
                                dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
