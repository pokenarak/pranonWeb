<x-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('Update Password') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </x-slot>

    <x-slot name="form">
        <div class="row mb-3">
            <label for="colFormLabel" class="col-sm-3 col-form-label">รหัสผ่านเก่า</label>
            <div class="col-sm-9">
                <input id="current_password" type="password" class="form-control" wire:model="state.current_password" autocomplete="current-password" />
                <x-input-error for="current_password" class="mt-2" />
            </div>
        </div>
        <div class="row mb-3">
            <label for="colFormLabel" class="col-sm-3 col-form-label">รหัสผ่านใหม่</label>
            <div class="col-sm-9">
                <input id="password" type="password" class="form-control" wire:model="state.password" autocomplete="new-password" />
            <x-input-error for="password" class="mt-2" />
            </div>
        </div>
        <div class="row mb-3">
            <label for="colFormLabel" class="col-sm-3 col-form-label">ยืนยันรหัสผ่านใหม่</label>
            <div class="col-sm-9">
                <input id="password_confirmation" type="password" class="form-control" wire:model="state.password_confirmation" autocomplete="new-password" />
                <x-input-error for="password_confirmation" class="mt-2" />
            </div>
        </div>
        {{-- <div class="col-span-6 sm:col-span-4">
            <x-label for="current_password" value="{{ __('Current Password') }}" />
            <x-input id="current_password" type="password" class="mt-1 block w-full" wire:model="state.current_password" autocomplete="current-password" />
            <x-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password" value="{{ __('New Password') }}" />
            <x-input id="password" type="password" class="mt-1 block w-full" wire:model="state.password" autocomplete="new-password" />
            <x-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
            <x-input id="password_confirmation" type="password" class="mt-1 block w-full" wire:model="state.password_confirmation" autocomplete="new-password" />
            <x-input-error for="password_confirmation" class="mt-2" />
        </div> --}}
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ __('บันทึกเรียบร้อย.') }}
        </x-action-message>

        <x-button>
            {{ __('บันทึก') }}
        </x-button>
    </x-slot>
</x-form-section>
