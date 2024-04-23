@extends('base')

@section('content')
    <div class="page-breadcrumb align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{ $data->card->title }}</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard.index') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('board.index') }}"><i class="bi bi-clipboard2"></i></a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('list-card.index', ['board' => $data->board->slug]) }}"><i
                                class="bi bi-list"></i></a>
                    </li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('card.index', ['board' => $data->board->slug, 'list_card' => $data->list_card, 'card' => $data->card->id]) }}">
                            {{ $data->card->title }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Create Checklist</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <h4 class="card-header">
                    Create Checklist in {{ $data->card->title }}
                </h4>
                <form
                    action="{{ route('checklist.store', ['board' => $data->board->slug, 'list_card' => $data->list_card, 'card' => $data->card->id]) }}"
                    method="post">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                class="form-control @error('title') is-invalid @enderror" id="title">
                            @error('title')
                                <div class="form-text text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('card.index', ['board' => $data->board->slug, 'list_card' => $data->list_card, 'card' => $data->card->id]) }}"
                            class="btn btn-secondary">Back to Card</a>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
