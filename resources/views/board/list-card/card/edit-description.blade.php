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
                    <li class="breadcrumb-item active" aria-current="page">Edit Description</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <h4 class="card-header">
                    Edit {{ $data->card->title }}
                </h4>
                <form
                    action="{{ route('card.update.description', ['board' => $data->board->slug, 'list_card' => $data->list_card, 'card' => $data->card->id]) }}"
                    method="post">
                    @method('put')
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <input id="description" type="hidden" name="description"
                                    value="{{ old('description', $data->card->description) }}">
                                <trix-editor input="description"></trix-editor>
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

@push('js')
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
    <script>
        $(document).ready(function() {
            document.addEventListener('trix-file-accept', function(e) {
                e.preventDefault();
            })
        })
    </script>
@endpush
