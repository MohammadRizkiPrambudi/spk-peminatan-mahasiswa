<section class="mt-4">
    {{-- Header asli Breeze telah dihapus karena sudah dihandle di profile/edit.blade.php --}}

    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmUserDeletionModal">
        {{ __('Delete Account') }}
    </button>

    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" role="dialog"
        aria-labelledby="confirmUserDeletionLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
                    @csrf
                    @method('delete')

                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title" id="confirmUserDeletionLabel">
                            {{ __('Are you sure you want to delete your account?') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body pt-0">
                        <p class="mt-1 text-muted text-sm">
                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                        </p>

                        <div class="form-group mt-3">
                            <label for="password" class="sr-only">{{ __('Password') }}</label> {{-- sr-only untuk sembunyikan label secara visual tapi tetap ada untuk aksesibilitas --}}
                            <input id="password" name="password" type="password"
                                class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                                placeholder="{{ __('Password') }}" />
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer border-0 pt-0 d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">
                            {{ __('Cancel') }}
                        </button>

                        <button type="submit" class="btn btn-danger">
                            {{ __('Delete Account') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
