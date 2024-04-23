<div>
    <a href="#" class="text-decoration-none text-black" data-bs-toggle="modal" data-bs-target="#label">Label</a>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="label" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Label</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($body == 'show')
                        <div class="mb-3">
                            @forelse ($labels as $item)
                                <div class="form-check">
                                    <input class="form-check-input"
                                        @for ($i = 0; $i < count($labelCheckeds) ; $i++)
                                            @if ($item->id == $labelCheckeds[$i]->label_id)
                                                @checked(true)
                                                @php
                                                    break;
                                                @endphp
                                            @endif @endfor
                                        wire:click="cardLabel('{{ $item->id }}')" type="checkbox" value=""
                                        id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{ $item->label }}
                                    </label>
                                </div>
                            @empty
                                <div class="text-center">
                                    No label
                                </div>
                            @endforelse
                        </div>
                        <div class="d-grid">
                            <a href="javascript:;" wire:click="body('create')" class="btn btn-secondary btn-sm">Create
                                Label</a>
                        </div>
                    @elseif ($body == 'create')
                        <form wire:submit.prevent="store">
                            <div class="mb-3">
                                <label for="title">Title</label>
                                <input type="text" wire:model='title' name="title" id="title"
                                    class="form-control" />
                                @error('title')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="color">Select Color</label>
                                @error('color')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                                <div class="d-flex flex-wrap gap-1">
                                    <div class="">
                                        <input type="radio" wire:model="color" name="color" class="btn-check"
                                            id="primary" value="primary" autocomplete="off">
                                        <label class="btn btn-outline-primary py-3 px-4" for="primary"></label>
                                    </div>
                                    <div class="">
                                        <input type="radio" wire:model='color' name="color" class="btn-check"
                                            id="secondary" value="secondary" autocomplete="off">
                                        <label class="btn btn-outline-secondary py-3 px-4" for="secondary"></label>
                                    </div>
                                    <div class="">
                                        <input type="radio" wire:model='color' name="color" class="btn-check"
                                            id="danger" value="danger" autocomplete="off">
                                        <label class="btn btn-outline-danger py-3 px-4" for="danger"></label>
                                    </div>
                                    <div class="">
                                        <input type="radio" wire:model='color' name="color" class="btn-check"
                                            id="warning" value="warning" autocomplete="off">
                                        <label class="btn btn-outline-warning py-3 px-4" for="warning"></label>
                                    </div>
                                    <div class="">
                                        <input type="radio" wire:model='color' name="color" class="btn-check"
                                            id="success" value="success" autocomplete="off">
                                        <label class="btn btn-outline-success py-3 px-4" for="success"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-sm mb-3">Create</button>
                                <button type="button" wire:click="body('show')" class="btn btn-secondary btn-sm">back
                                    to
                                    labels</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
