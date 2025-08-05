<section>
    {{-- Header asli Breeze telah dihapus karena sudah dihandle di profile/edit.blade.php --}}

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="update_password_current_password">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password"
                class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                autocomplete="current-password" />
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="update_password_password">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password"
                class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                autocomplete="new-password" />
            @error('password', 'updatePassword')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="update_password_password_confirmation">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                autocomplete="new-password" />
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="d-flex align-items-center gap-2 mt-4">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-muted text-sm ml-2">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
