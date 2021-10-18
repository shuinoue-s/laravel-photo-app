<x-layout>
    <x-guest-layout>
        <x-jet-authentication-card>
            <x-slot name="logo">
                <x-jet-authentication-card-logo />
            </x-slot>

            <form method="POST" action="{{ route('mypage.passwordchange', $auth->id) }}">
                @method('PATCH')
                @csrf

                <div class="mt-4">
                    <x-jet-label for="current_password" value="現在のパスワード" />
                    <x-jet-input id="current_password" class="block mt-1 w-full" type="password" name="current_password" required autocomplete="new-password" />
                    @error('current_password')
                        <div class="image-alert alert alert-danger py-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mt-4">
                    <x-jet-label for="password" value="新しいパスワード" />
                    <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    @error('password')
                        <div class="image-alert alert alert-danger py-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mt-4">
                    <x-jet-label for="password_confirm" value="パスワードの確認" />
                    <x-jet-input id="password_confirm" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    @error('password_confirmation')
                        <div class="image-alert alert alert-danger py-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="profile-edit-btn">パスワードを変更</button>
                </div>
            </form>
        </x-jet-authentication-card>
    </x-guest-layout>
</x-layout>
