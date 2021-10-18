<x-layout>
    <x-guest-layout>
        <x-jet-authentication-card>
            <x-slot name="logo">
                <x-jet-authentication-card-logo />
            </x-slot>

            @if (session('flash_message'))
            <div class="flash_message alert-success text-center py-3 my-2">
                {{ session('flash_message') }}
            </div>
            @endif

            <form method="POST" action="{{ route('mypage.emailchange') }}">
                @method('PATCH')
                @csrf

                <div class="mt-4 current-email">
                    <h3>現在のメールアドレス</h3>
                    <p>{{ $auth->email }}</p>
                </div>

                <div class="mt-4">
                    <x-jet-label for="new_email" value="新しいメールアドレス" />
                    <x-jet-input id="new_email" class="block mt-1 w-full" type="text" name="new_email"/>
                    @error('new_email')
                        <div class="image-alert alert alert-danger py-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <p class="mt-4">メールを送信して変更のお手続きを行ってください</p>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="profile-edit-btn">メールを送信</button>
                </div>
            </form>
        </x-jet-authentication-card>
    </x-guest-layout>
</x-layout>
