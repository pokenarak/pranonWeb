@props(['submit'])

<div class="container-lg mb-5">
    <div class="card border-0">
        <div class="card-body">
            <div class="pb-4 mt-2 text-center">
                <h2>{{ $title }}</h2>
                <sub>{{ $description }}</sub>
            </div>
            <form wire:submit="{{ $submit }}">
                {{ $form }}
            </form>
            <form wire:submit="{{ $submit }}">
                {{-- <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                    <div class="grid grid-cols-6 gap-6">
                        {{ $form }}
                    </div>
                </div> --}}

                @if (isset($actions))
                    <div class="text-center">
                        {{ $actions }}
                    </div>
                @endif
            </form>
        </div>
    </div>
            {{-- <x-section-title>
                <x-slot name="title">{{ $title }}</x-slot>
                <x-slot name="description">{{ $description }}</x-slot>
            </x-section-title> --}}

</div>
