@extends('base')

@push('css')
    <link href="{{ asset('') }}assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('') }}assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="page-breadcrumb d-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{ $data->board->title }}</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard.index') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('board.index') }}"><i class="bi bi-clipboard2"></i></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a
                            href="{{ route('list-card.index', ['board' => $data->board->slug]) }}">{{ $data->board->title }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">User</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <h4 class="card-header d-flex justify-content-between">
                    User of {{ $data->board->title }}
                    <a href="{{ route('board.index') }}" class="btn btn-secondary btn-sm">Back to board</a>
                </h4>
                <div class="card-body">
                    <div class="mb-3 d-flex flex-wrap">
                        @foreach ($data->board->users as $item)
                            <div class="d-flex flex-column me-2 align-items-center">
                                @if ($item->user->photo)
                                    <img src="{{ asset('/storage/photos/' . $item->user->photo) }}" alt=""
                                        class="rounded-circle" width="45" height="45"
                                        title="{{ $item->user->name }}">
                                @else
                                    <img src="{{ asset('assets/images/empty-user.png') }}" class="rounded-circle imge"
                                        width="45" height="45" alt="" title="{{ $item->user->name }}">
                                @endif
                                <div class="">
                                    @if ($data->board->user_id == auth()->user()->id && $item->user->id != auth()->user()->id)
                                        <form class="deleteUserBoard"
                                            action="{{ route('board.destroy.user', ['id' => $item->id]) }}" method="post">
                                            @method('delete')
                                            @csrf
                                            <button class="text-danger border-0 bg-transparent">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if ($data->board->user_id == auth()->user()->id)
                        <form action="{{ route('board.store.user') }}" method="post">
                            @csrf
                            <input type="hidden" name="slug" value="{{ $data->board->id }}">
                            <div class="mb-3">
                                <label class="form-label">Add new Member</label>
                                <select class="multiple-select @error('member') is-invalid @enderror" name="member[]"
                                    data-placeholder="Choose anything" multiple="multiple">
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
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('') }}assets/plugins/select2/js/select2.min.js"></script>
    <script src="{{ asset('') }}assets/js/form-select2.js"></script>
    <script>
        $('.deleteUserBoard').submit(function() {
            event.preventDefault();
            Swal.fire({
                title: 'Delete user!',
                text: "Are you sure you want to delete?",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).trigger('submit')
                    Swal.close()
                }
            });
        });
    </script>
@endpush
