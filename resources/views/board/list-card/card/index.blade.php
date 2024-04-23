@extends('base')

@section('content')
    <div class="page-breadcrumb d-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Card</div>
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
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $data->card->title }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <h5 class="card-header d-flex justify-content-between align-items-center">
                    <span contentEditable="true" id="titleCard" class="p-2 pe-3 fw-bold text-primary"
                        data-url="{{ route('card.update.title', ['card' => $data->card->id]) }}">{{ $data->card->title }}</span>
                    <a href="{{ route('list-card.index', ['board' => $data->board->slug]) }}"
                        class="btn btn-secondary btn-sm">
                        Back to List
                    </a>
                </h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <h6 class="fw-bold">Member</h6>
                            <div class="mb-3 d-flex align-items-center">
                                <a
                                    href="{{ route('card.user', ['board' => $data->board->slug, 'list_card' => $data->list_card, 'card' => $data->card->id]) }}">
                                    @foreach ($data->card->users as $item)
                                        @if ($item->user->photo)
                                            <img src="{{ asset('/storage/photos/' . $item->user->photo) }}" alt=""
                                                class="rounded-circle me-2" width="25" height="25"
                                                title="{{ $item->user->name }}">
                                        @else
                                            <img src="{{ asset('assets/images/empty-user.png') }}"
                                                class="rounded-circle imge" width="25" height="25" alt=""
                                                title="{{ $item->user->name }}">
                                        @endif
                                    @endforeach
                                    <i class="bi bi-plus-circle fs-5"></i>
                                </a>
                            </div>
                            <div class="mb-2">
                                <h6 class="fw-bold">Label</h6>
                                <div class="d-flex">
                                    @foreach ($data->card->card_labels as $item)
                                        <div class="rounded-2 bg-{{ $item->label->color }} text-white py-1 px-2 fw-bold me-2"
                                            style="font-size: 10px">
                                            {{ $item->label->label }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="mb-1">
                                    <label for="estimate" class="fw-bold">Estimate</label>
                                    <a href="{{ route('card.edit.estimate', ['board' => $data->board->slug, 'list_card' => $data->list_card, 'card' => $data->card->id]) }}"
                                        class="">edit</a>
                                </div>
                                <div class="border rounded form-group p-2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            Start date : {{ $data->card->start_date }}
                                        </div>
                                        <div class="col-md-6">
                                            End date : {{ $data->card->end_date }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="mb-1">
                                    <label for="description" class="fw-bold">Description</label>
                                    <a href="{{ route('card.edit.description', ['board' => $data->board->slug, 'list_card' => $data->list_card, 'card' => $data->card->id]) }}"
                                        class="">edit</a>
                                </div>
                                <div class="form-group p-2 border rounded">
                                    {!! $data->card->description !!}
                                </div>
                            </div>
                            <div class="fw-bold mb-2">Checklist</div>
                            <div class="row checklistsList">
                                @foreach ($data->card->checklists as $item)
                                    <div class="col-12">
                                        <div class="mb-3 ms-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="text-primary pe-2 checklist-title" contentEditable="true"
                                                    data-url="{{ route('checklist.update.title', ['checklist' => $item->id]) }}">
                                                    {{ $item->title }}</div>
                                                <div class="d-flex">
                                                    <a href="{{ route('checklist-detail.index', ['checklist' => $item->id]) }}"
                                                        class="text-decoration-none text-primary me-3">Show</a>
                                                    <form
                                                        action="{{ route('checklist.delete', ['checklist' => $item->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit"
                                                            class="text-danger bg-transparent border-0 p-0 m-0">delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <ul class="list-group">
                                                <div id="progress{{ $item->id }}">
                                                    <div class="progress my-2" role="progressbar"
                                                        aria-label="Example with label" aria-valuenow="25"
                                                        aria-valuemin="{{ $item->percentage }}" aria-valuemax="100">
                                                        <div class="progress-bar" style="width: {{ $item->percentage }}%">
                                                            {{ $item->percentage }}%</div>
                                                    </div>
                                                </div>
                                                <div class="check-list">
                                                    @for ($i = 0; $i < count($item->details); $i++)
                                                        <div
                                                            class="d-flex ms-3 justify-content-between align-items-center my-1">
                                                            <div class="form-check">
                                                                <input class="form-check-input checklists" value="checked"
                                                                    type="checkbox" data-checklist-id="{{ $item->id }}"
                                                                    data-url="{{ route('checklist_detail.update.check', ['checklist_detail' => $item->details[$i]->id]) }}"
                                                                    @checked($item->details[$i]->check == 'checked') id="flexCheckDefault">
                                                                <label
                                                                    class="form-check-label pe-2 checklist-detail-title text-primary"
                                                                    contentEditable="true"
                                                                    data-url="{{ route('checklist_detail.update.title', ['checklist_detail' => $item->details[$i]->id]) }}">
                                                                    {{ $item->details[$i]->title }}
                                                                </label>
                                                            </div>
                                                            <div class="d-flex">
                                                                <div class="me-2">
                                                                    {{ $item->details[$i]->start_date }}
                                                                    {{ $item->details[$i]->end_date }}
                                                                </div>
                                                                @if ($item->details[$i]->user)
                                                                    @if ($item->details[$i]->user->photo)
                                                                        <img src="{{ asset('/storage/photos/' . $item->details[$i]->user->photo) }}"
                                                                            alt="" class="rounded-circle me-2"
                                                                            width="25" height="25"
                                                                            title="{{ $item->details[$i]->user->name }}">
                                                                    @else
                                                                        <img src="{{ asset('assets/images/empty-user.png') }}"
                                                                            class="rounded-circle imge" width="25"
                                                                            height="25" alt=""
                                                                            title="{{ $item->details[$i]->user->name }}">
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endfor
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="accordion my-3" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            Log activity
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse p-0"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body p-0">
                                            <ul class="list-group p-0">
                                                @foreach ($data->log as $item)
                                                    <li
                                                        class="list-group-item border-0 border-bottom d-flex align-items-center">
                                                        <img src="{{ asset('') }}assets/images/avatars/avatar-1.png"
                                                            alt="" class="rounded-circle me-2" width="25"
                                                            height="25" title="{{ $item->user->name }}">
                                                        <div class="d-flex flex-column">
                                                            <div class="">
                                                                {{ $item->subject }}
                                                            </div>
                                                            <div style="font-size: 12px; color: gray">
                                                                {{ $item->created_at }}
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col p-3 mb-3">
                            <h6>
                                Action to card
                            </h6>
                            <div class="card">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <a href="{{ route('checklist.create', ['board' => $data->board->slug, 'list_card' => $data->list_card, 'card' => $data->card->id]) }}"
                                            class="text-decoration-none text-black">Checklist</a>
                                    </li>
                                    <li class="list-group-item">
                                        {{-- @livewire('labels', ['board_id' => $data->board->id, 'card_id' => $data->card->id]) --}}
                                        <livewire:labels :board_id="$data->board->id" :card_id="$data->card->id">
                                    </li>
                                    <li class="list-group-item">
                                        <form action="{{ route('card.destroy', ['card' => $data->card->id]) }}"
                                            method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit"
                                                class="text-decoration-none text-black bg-transparent border-0 p-0 m-0 text-danger">Archive</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            $('.checklistsList').sortable()
            $('.check-list').sortable()
            $('#titleCard').blur(function() {
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
            $('.checklist-title').blur(function() {
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
                    success: function(res) {},
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
            $('.checklist-detail-title').blur(function() {
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
                    success: function(res) {},
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
            $('.checklists').change(function() {
                const url = $(this).attr('data-url');
                const e = $(this)
                const checklist = $(this).attr('data-checklist-id')
                let check = 'uncheck';
                if ($(this).is(':checked')) {
                    check = $(this).val()
                }
                $.ajax({
                    url: url,
                    type: 'put',
                    data: {
                        check: check
                    },
                    success: function(res) {
                        $(`#progress${checklist}`).load(location.href +
                            ` #progress${checklist}`);
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
                                    toast.addEventListener('mouseenter',
                                        Swal
                                        .stopTimer)
                                    toast.addEventListener('mouseleave',
                                        Swal
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
            });
        })
    </script>
@endpush
