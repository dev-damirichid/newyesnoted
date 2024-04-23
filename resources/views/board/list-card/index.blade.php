@extends('base')

@push('css')
@endpush

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
                    <li class="breadcrumb-item active" aria-current="page">{{ $data->board->title }}</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('list-card.create', ['board' => $data->board->slug]) }}" class="btn btn-primary">Create
                    List Card</a>
            </div>
        </div>
    </div>
    <div class="row sortableList">
        @forelse ($data->list_card as $item)
            <div class="col-lg-4" id="{{ $item->id }}">
                <div class="card shadow">
                    <div class="card-header text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div contentEditable="true" class="fw-bold text-primary p-1 fs-5 w-100 titleListCard"
                                data-url="{{ route('list-card.update.title', ['list_card' => $item->id]) }}">
                                {{ $item->title }}</div>
                            <div class="dropdown">
                                <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical fs-5 text-primary"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('card.create', ['board' => $data->board->slug, 'list_card' => $item->id]) }}">Create
                                            Card</a>
                                    </li>
                                    <li>

                                        <form class="archive-list-card"
                                            action="{{ route('list-card.destroy', ['list_card' => $item->id]) }}"
                                            method="post">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                Archive
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div class="row sortableCard pb-3">
                            @for ($i = 0; $i < count($item->cards); $i++)
                                <div class="col-12" id="{{ $item->cards[$i]->id }}" data-list="{{ $item->id }}">
                                    <a href="{{ route('card.index', ['board' => $data->board->slug, 'list_card' => $item->id, 'card' => $item->cards[$i]->id]) }}"
                                        class="text-decoration-none text-black">
                                        <div class="card shadow">
                                            <div class="card-header">
                                                <div class="d-flex">
                                                    @foreach ($item->cards[$i]->card_labels as $itemm)
                                                        <div class="rounded-2 bg-{{ $itemm->label->color }} text-white py-1 px-2 fw-bold me-2"
                                                            style="font-size: 10px">
                                                            {{ $itemm->label->label }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="card-body fw-bold">
                                                {{ $item->cards[$i]->title }}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center fw-bold pt-5">
                No list card
            </div>
        @endforelse
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            $(".sortableList").sortable({
                stop: function() {
                    $.map($(this).find('.col-lg-4'), function(el) {
                        let id = el.id;
                        let sorting = $(el).index() + 1;
                        $.ajax({
                            url: "{{ route('list-card.numbering') }}",
                            type: 'GET',
                            data: {
                                id: id,
                                sorting: sorting
                            },
                            success: function(res) {},
                            error: function(err) {
                                alert('something error')
                            }
                        });
                    });
                }
            }).disableSelection();
            $(".sortableCard").sortable({
                connectWith: '.sortableCard',
                stop: function(event, ui) {
                    $.map($(this).find('.col-12'), function(el) {
                        let id = el.id;
                        let sorting = $(el).index() + 1;
                        $.ajax({
                            url: "{{ route('card.numbering') }}",
                            type: 'GET',
                            data: {
                                id: id,
                                sorting: sorting
                            },
                            success: function(res) {},
                            error: function(err) {
                                alert('something error')
                            }
                        });
                    });
                }
            }).disableSelection();

            $('.titleListCard').blur(function() {
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
                    success: function() {},
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
            $('.archive-list-card').submit(function() {
                event.preventDefault();
                Swal.fire({
                    title: 'Archive list board!',
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
            })
        })
    </script>
@endpush
