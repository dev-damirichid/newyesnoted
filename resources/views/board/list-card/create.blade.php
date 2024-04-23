@extends('base')

@section('content')
    <div class="page-breadcrumb d-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{ $data->board->title }}</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('board.index') }}"><i class="bi bi-clipboard2"></i></a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('list-card.index', ['board' => $data->board->slug]) }}"><i
                                class="bi bi-list"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Create
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <h4 class="card-header">
                    Create List for {{ $data->board->title }}
                </h4>
                <form action="{{ route('list-card.store', ['board' => $data->board->slug]) }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                id="title">
                            @error('title')
                                <div class="form-text text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('list-card.index', ['board' => $data->board->slug]) }}"
                            class="btn btn-secondary">Back to List</a>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
