@extends('base')

@section('content')
    <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-4">
        @foreach ($data->boards as $item)
            <div class="col">
                <div class="card overflow-hidden radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-stretch justify-content-between overflow-hidden">
                            <div class="w-50">
                                <h5 class="mb-3">
                                    <a href="{{ route('list-card.index', ['board' => $item->slug]) }}">
                                        {{ $item->title }}
                                    </a>
                                </h5>
                                <div class="mb-3">
                                    @for ($i = 0; $i < count($item->users); $i++)
                                        @if ($item->users[$i]->user->photo)
                                            <img src="{{ asset('/storage/photos/' . $item->users[$i]->user->photo) }}"
                                                alt="" class="rounded-circle" width="25" height="25"
                                                title="{{ $item->users[$i]->user->name }}">
                                        @else
                                            <img src="{{ asset('assets/images/empty-user.png') }}"
                                                class="rounded-circle imge" width="25" height="25" alt=""
                                                title="{{ $item->users[$i]->user->name }}">
                                        @endif
                                    @endfor
                                </div>
                                <div class="fw-bold">
                                    <span>Total List:</span>
                                    <span>{{ count($item->listCard) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('js')
    <script src="{{ asset('') }}assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="{{ asset('') }}assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="{{ asset('') }}assets/js/pace.min.js"></script>
    <script src="{{ asset('') }}assets/plugins/chartjs/js/Chart.min.js"></script>
    <script src="{{ asset('') }}assets/plugins/chartjs/js/Chart.extension.js"></script>
    <script src="{{ asset('') }}assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
    <script src="{{ asset('') }}assets/js/index2.js"></script>
@endpush
