@extends('base')

@section('content')
    <div class="page-breadcrumb d-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Checklist</div>
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
                    <li class="breadcrumb-item active" aria-current="page">{{ $data->checklist->title }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card mt-3">
                <div class="card-header h5 d-flex justify-content-between align-items-center">
                    <span>{{ $data->checklist->title }}</span>

                    <div class="">
                        <a href="{{ route('card.index', ['board' => $data->board->slug, 'list_card' => $data->list_card, 'card' => $data->card->id]) }}"
                            class="btn btn-secondary btn-sm">Back to Card</a>
                        <a href="{{ route('checklis-detail.create', ['checklist' => $data->checklist->id]) }}"
                            class="btn
                            btn-primary btn-sm">
                            Create Detail
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="progress my-2" role="progressbar" aria-label="Example with label" aria-valuenow="25"
                        aria-valuemin="{{ $data->checklist->percentage }}" aria-valuemax="100">
                        <div class="progress-bar" style="width: {{ $data->checklist->percentage }}%">
                            {{ $data->checklist->percentage }}%</div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Start date</th>
                                    <th scope="col">End date</th>
                                    <th scope="col">PIC</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->checklist->details as $item)
                                    <tr>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->start_date }}</td>
                                        <td>{{ $item->end_date }}</td>
                                        <td>
                                            @if ($item->user)
                                                {{ $item->user->email }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#check{{ $item->id }}"
                                                class="@if ($item->check == 'checked') text-primary @else text-warning @endif">
                                                {{ $item->check }}
                                            </a>
                                            <div class="modal fade" id="check{{ $item->id }}" tabindex="-1"
                                                aria-labelledby="checkLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="checkLabel">
                                                                Edit Status {{ $item->title }}
                                                            </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <form
                                                            action="{{ route('checklis-detail.status', ['checklist_detail' => $item->id]) }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <select class="form-select" name="check"
                                                                    aria-label="Default select example">
                                                                    <option @selected($item->check == 'uncheck') value="uncheck">
                                                                        Uncheck</option>
                                                                    <option @selected($item->check == 'checked') value="checked">
                                                                        Checked</option>
                                                                </select>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="d-flex">
                                            <a href="{{ route('checklist-detail.edit', ['checklist' => $data->checklist->id, 'checklist_detail' => $item->id]) }}"
                                                class="btn btn-primary btn-sm me-2">
                                                Edit
                                            </a>
                                            <form
                                                action="{{ route('checklis-detail.destroy', ['checklist_detail' => $item->id]) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
