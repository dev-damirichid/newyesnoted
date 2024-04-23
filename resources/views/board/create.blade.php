@extends('base')

@push('css')
    <link href="{{ asset('') }}assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('') }}assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="page-breadcrumb d-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Boards</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('board.index') }}"><i class="bi bi-clipboard2"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Create Board</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <h4 class="card-header">
                    Create Board
                </h4>
                <form action="{{ route('board.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                id="title">
                            @error('title')
                                <div id="emailHelp" class="form-text text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Member</label>
                            <select class="multiple-select" name="member[]" data-placeholder="Choose anything"
                                multiple="multiple">
                                @foreach ($data->users as $item)
                                    <option value="{{ $item->id }}">{{ $item->email }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('board.index') }}" class="btn btn-secondary">Back to board</a>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('') }}assets/plugins/select2/js/select2.min.js"></script>
    <script src="{{ asset('') }}assets/js/form-select2.js"></script>
@endpush
