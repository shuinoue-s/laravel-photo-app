<x-layout>
    <h2 class="page-title">プロフィールの編集</h2>

    @if (!empty(session('error_message')))
        <div class="image-alert alert alert-danger py-1 text-center">
            {{ session('error_message') }}
        </div>
    @endif

    <form method="post" action="{{ route('mypage.create', $auth->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="profile-container">
            <div class="profile-image-container">
                @if (!empty($user_profile->profile_image))
                    <img id="preview" class="profile-image profile-image-label" src="{{ $user_profile->profile_image }}" alt="icon">
                @else
                    <img id="preview" class="profile-image profile-image-label" src="{{ asset('images/profile-icon.png') }}">
                @endif
                <label class="image-label">
                    <input id="myImage" class="file" type="file" name="image" accept="image/png, image/jpeg" onchange="previewImage(this);">写真を選択
                </label>
                @error('image')
                <div class="image-alert alert alert-danger py-1">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="profile-description-container">
                <div class="profile-description">
                    <label for="name">名前</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $auth->name) }}">
                    @error('name')
                    <div class="image-alert alert alert-danger py-1">
                        {{ $message }}
                    </div>
                    @enderror
                    <p>メールアドレス</p>
                    <p>{{ $auth->email }}</p>
                    <a href="{{ route('mypage.emailchange_show') }}">メールアドレスの変更はこちら</a>
                    <a href="{{ route('mypage.passwordchange_show') }}">パスワードの変更はこちら</a>
                </div>

                <div class="profile-textarea">
                    <label for="body">自己紹介</label>
                    @if (!empty($user_profile->profile_body))
                        <textarea name="body" id="body" placeholder="150文字以内">{{ old('body', $user_profile->profile_body) }}</textarea>
                    @else
                        <textarea name="body" id="body" placeholder="150文字以内">{{ old('body') }}</textarea>
                    @endif
                    @error('body')
                    <div class="image-alert alert alert-danger py-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="profile-btn-container">
            <button class="btn-shadow profile-btn-edit">変更を保存</button>
        </div>
    </form>

    <form action="{{ route('mypage.destroy', $auth->id) }}" method="post">
        @method('DELETE')
        @csrf
        <div class="profile-delete-btn-container">
            <button id="profile-delete-btn">アカウントを削除</button>
        </div>
    </form>
</x-layout>
