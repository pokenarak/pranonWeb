{{-- <x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" id="photo" class="hidden"
                            wire:model.live="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-secondary-button>
                @endif

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model="state.name" required autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" type="email" class="mt-1 block w-full" wire:model="state.email" required autocomplete="username" />
            <x-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-sm mt-2">
                    {{ __('Your email address is unverified.') }}

                    <button type="button" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" wire:click.prevent="sendEmailVerification">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section> --}}

<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="container mt-3">
                <div class="row">
                    <div class="col-3">
                        <!-- Current Profile Photo -->
                        <div class="mt-2" x-show="! photoPreview">
                            @if ($this->user->profile_photo_path)
                                <img src="{{ asset('images/'.$this->user->profile_photo_path) }}" alt="{{ $this->user->name }}" class="rounded img-fluid img-thumbnail ">
                            @else
                                <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
                            @endif
                        </div>
                        <div class="text-center">
                            @if (!$this->user->profile_photo_path)
                                <div class="mb-3">
                                    <x-label for="photo" value="{{ __('เลือกรูปภาพ') }}" class="form-label"/>
                                    <input class="form-control" type="file" wire:model.live="photo" x-ref="photo" x-on:change="
                                            photoName = $refs.photo.files[0].name;
                                            const reader = new FileReader();
                                            reader.onload = (e) => {
                                                photoPreview = e.target.result;
                                            };
                                            reader.readAsDataURL($refs.photo.files[0]);
                                    ">
                                </div>
                            @else
                                <button type="button" class="btn btn-outline-danger mt-3" wire:click="deleteProfilePhoto">
                                    {{ __('ลบรูปภาพ') }}
                                </button>
                                <x-input-error for="photo" class="mt-2" />
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">ชื่อ นามสกุล</label>
                            <div class="col-sm-10">
                                <input id="name" type="text" class="form-control" wire:model="state.name" required autocomplete="name" />
                                <x-input-error for="name" class="mt-2" />
                            </div>
                        </div>
                        <div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">E-mail</label>
                                <div class="col-sm-10">
                                    <input id="email" type="email" class="form-control" wire:model="state.email" required autocomplete="username" />
                                    <x-input-error for="email" class="mt-2" />
                                </div>
                            </div>
                            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                                <p class="text-sm mt-2 dark:text-white">
                                    {{ __('อีเมลล์ของคุณยังไม่ได้ยืนยัน') }}

                                    <button type="button" class="btn btn-outline-danger" wire:click.prevent="sendEmailVerification">
                                        {{ __('คลิกที่นี้เพื่อส่งลิงค์ยืนยันไปยังอีเมลล์ของท่าน') }}
                                    </button>
                                </p>

                                @if ($this->verificationLinkSent)
                                    <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                        {{ __('ลิงค์สำหรับการยืนยันได้ทำการส่งไปยังอีเมลล์เรียบร้อยแล้ว') }}
                                    </p>
                                @endif
                            @endif
                        </div>
                        <div class="row mb-3">
                            <x-slot name="actions">
                                <x-action-message class="mr-3" on="saved">
                                    {{ __('บันทึก.') }}
                                </x-action-message>

                                <x-button wire:loading.attr="disabled" wire:target="photo">
                                    {{ __('บันทึก') }}
                                </x-button>
                            </x-slot>
                        </div>
                    </div>

                </div>
            </div>
        @endif
    </x-slot>


</x-form-section>
