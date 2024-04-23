@extends('base')

@push('css')
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">

    <style>
        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;
        }
    </style>
@endpush

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
                    <li class="breadcrumb-item active" aria-current="page">Edit Estimate</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <h4 class="card-header">
                    Edit Estimate for {{ $data->card->title }}
                </h4>
                <form
                    action="{{ route('card.update.estimate', ['board' => $data->board->slug, 'list_card' => $data->list_card, 'card' => $data->card->id]) }}"
                    method="post">
                    @method('put')
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="startDate" class="form-label">Start date</label>
                                        <input type="datetime-local" class="form-control"
                                            value="{{ $data->card->start_date }}" name="start_date" id="startDate">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="endDate" class="form-label">End date</label>
                                        <input type="datetime-local" class="form-control"
                                            value="{{ $data->card->end_date }}" name="end_date" id="endDate">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('card.index', ['board' => $data->board->slug, 'list_card' => $data->list_card, 'card' => $data->card->id]) }}"
                            class="btn btn-secondary">Back to Card</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
