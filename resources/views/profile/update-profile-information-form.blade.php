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
