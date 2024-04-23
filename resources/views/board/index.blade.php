@extends('base')

@section('content')
    <div class="page-breadcrumb d-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Boards</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Boards</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('board.create') }}" class="btn btn-primary">Create Board</a>
            </div>
        </div>
    </div>
    <div class="row">
        @forelse ($data->board as $item)
            <div class="col-lg-3">
                <div class="card shadow">
                    <h5 class="card-body d-flex flex-column rounded-3">
                        @if ($item->user_id == auth()->user()->id)
                            <span contentEditable="true" class="title-board w-100 p-1 pe-2"
                                data-url="{{ route('board.update.title', ['slug' => $item->slug]) }}">{{ $item->title }}</span>
                        @else
                            {{ $item->title }}
                        @endif
                        <hr>
                        <div class="d-flex align-items-center">
                            <a href="{{ route('board.show.user', ['slug' => $item->slug]) }}">
                                @for ($i = 0; $i < count($item->users); $i++)
                                    @if ($item->users[$i]->user->photo)
                                        <img src="{{ asset('/storage/photos/' . $item->users[$i]->user->photo) }}"
                                            alt="" class="rounded-circle" width="25" height="25"
                                            title="{{ $item->users[$i]->user->name }}">
                                    @else
                                        <img src="{{ asset('assets/images/empty-user.png') }}" class="rounded-circle imge"
                                            width="25" height="25" alt=""
                                            title="{{ $item->users[$i]->user->name }}">
                                    @endif
                                @endfor
                            </a>
                        </div>
                        </h4>
                        <div class="card-footer">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    @if ($item->user_id == auth()->user()->id)
                                        <form class="deleteBoard"
                                            action="{{ route('board.destroy', ['slug' => $item->slug]) }}" method="post">
                                            @method('delete')
                                            @csrf
                                            <button class="text-danger border-0 bg-transparent"><i
                                                    class="bi bi-trash-fill fs-5"></i></button>
                                        </form>
                                    @endif
                                </div>
                                <div class="col-6 text-end">
                                    <a href="#" class="text-warning me-2" data-bs-toggle="modal"
                                        data-bs-target="#modalShare{{ $item->id }}"><i class="bi bi-share"></i></a>
                                    <!-- Modal -->
                                    <div class="modal fade" id="modalShare{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="modalShareLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="modalShareLabel">Share
                                                        {{ $item->title }}</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="text" readonly class="form-control"
                                                        value="{{ route('board.invite', ['board' => $item->id]) }}">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('list-card.index', ['board' => $item->slug]) }}"
                                        class="text-primary"><i class="bi bi-box-arrow-in-up-right fs-5"></i></a>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center pt-5 fw-bold">
                No board
            </div>
        @endforelse
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('.title-board').blur(function() {
                event.preventDefault();
                const iner = $(this);
                const text = $(this).text();
                const url = $(this).attr('data-url');
                $.ajax({
                    url: url,
                    type: 'put',
                    data: {
                        title: text
                    },
                    success: function() {

                    },
                    error: function(err) {
                        if (err.status == 422) {
                            iner.text(err.responseJSON.title)
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal
                                        .stopTimer)
                                    toast.addEventListener('mouseleave', Swal
                                        .resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'error',
                                title: err.responseJSON.error.title
                            })
                        }
                    }
                })
            })

            $('.deleteBoard').submit(function() {
                event.preventDefault();
                Swal.fire({
                    title: 'Archive board!',
                    text: "Are you sure you want to archive?",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Archive'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).trigger('submit')
                        Swal.close()
                    }
                });
            });
        });
    </script>
@endpush
