{{-- @props(['submit'])

<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6']) }}>
    <x-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit="{{ $submit }}">
            <div class="px-4 py-5 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                <div class="grid grid-cols-6 gap-6">
                    {{ $form }}
                </div>
            </div>

            @if (isset($actions))
                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-end sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    {{ $actions }}
                </div>
            @endif
        </form>
    </div>
</div> --}}

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
