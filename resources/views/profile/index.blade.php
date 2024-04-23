@extends('base')

@section('content')
    <div class="page-breadcrumb d-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Profile</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form id="profileForm" action="{{ route('profile.update') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 d-flex flex-column align-items-center gap-3">
                            @if (auth()->user()->photo)
                                <img src="{{ asset('storage/photos/' . auth()->user()->photo) }}"
                                    class="rounded-circle imge" width="80" height="80" alt="">
                            @else
                                <img src="{{ asset('assets/images/empty-user.png') }}" class="rounded-circle imge"
                                    width="80" height="80" alt="">
                            @endif
                            <input type="file" class="form-control" name="photo" id="photo" accept="image/*">
                            @error('photo')
                                <div class="form-text text-danger mt-0 pt-0">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" readonly class="form-control" id="email"
                                value="{{ auth()->user()->email }}">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="name"
                                value="{{ auth()->user()->name }}">
                            @error('name')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="company" class="form-label">Company</label>
                            <input type="text" class="form-control" name="company" id="company"
                                value="{{ auth()->user()->company }}">
                            @error('company')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" id="notes" rows="3">{{ auth()->user()->notes }}</textarea>
                            @error('notes')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $('#notes').keydown(function(e) {
            if ((e.keyCode == 10 || e.keyCode == 13) && e.ctrlKey) {
                $('#profileForm').submit()
            }
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.imge').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#photo").change(function() {
            readURL(this);
        });
    </script>
@endpush
