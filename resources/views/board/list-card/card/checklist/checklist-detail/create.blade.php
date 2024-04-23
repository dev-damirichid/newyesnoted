@extends('base')

@push('css')
    <link href="{{ asset('') }}assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('') }}assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
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
                    <li class="breadcrumb-item"><a
                            href="{{ route('checklist-detail.index', ['checklist' => $data->checklist]) }}">
                            {{ $data->checklist->title }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <h4 class="card-header">
                    Create Detail of {{ $data->checklist->title }}
                </h4>
                <form action="{{ route('checklis-detail.store', ['checklist' => $data->checklist->id]) }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                class="form-control @error('title') is-invalid @enderror" id="title">
                            @error('title')
                                <div class="form-text text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="startDate" class="form-label">Start date</label>
                                    <input type="datetime-local" name="start_date" value="{{ old('start_date') }}"
                                        class="form-control @error('start_date') is-invalid @enderror" id="startDate">
                                    @error('start_date')
                                        <div class="form-text text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="endDate" class="form-label">End date</label>
                                    <input type="datetime-local" name="end_date" value="{{ old('end_date') }}"
                                        class="form-control @error('end_date') is-invalid @enderror" id="endDate">
                                    @error('end_date')
                                        <div class="form-text text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Add PIC</label>
                                <select class="single-select @error('member') is-invalid @enderror" name="pic"
                                    data-placeholder="Choose anything">
                                    <option value="">-- Choose one --</option>
                                    @foreach ($data->users as $item)
                                        <option value="{{ $item->id }}">{{ $item->email }}</option>
                                    @endforeach
                                </select>
                                @error('member')
                                    <div class="form-text text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('checklist-detail.index', ['checklist' => $data->checklist->id]) }}"
                            class="btn btn-secondary">Back to Cheklist</a>
                        <button type="submit" class="btn btn-primary">create</button>
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
