<x-layout>
    <h2 class="page-title">マイページ</h2>

        <div class="mypage-container">
            <div class="mypage-image-container">
                @if (!empty($user_profile->profile_image))
                    <a href="{{ route('mypage.edit') }}"><img id="preview" class="mypage-image" src="{{ $user_profile->profile_image }}" alt="icon"></a>
                @else
                    <a href="{{ route('mypage.edit') }}"><img id="preview" class="mypage-image" src="{{ asset('images/profile-icon.png') }}"></a>
                @endif
            </div>

            <div class="mypage-description-container">
                <a class="mypage-description" href="{{ route('mypage.edit') }}">
                    <h3>名前</h3>
                    <p>{{ $auth->name }}</p>
                    <h3>メールアドレス</h3>
                    <p>{{ $auth->email }}</p>
                </a>

                <div class="mypage-body-container">
                    <a href="{{ route('mypage.edit') }}"><h3>自己紹介</h3></a>
                    <a href="{{ route('mypage.edit') }}"><div class="mypage-textarea">
                        @if (!empty($user_profile->profile_body))
                        <p>{!! nl2br(e($user_profile->profile_body)) !!}</p>
                        @endif
                    </div></a>
                </div>
            </div>
        </div>

        <div class="mypage-btn-container">
            <a href="{{ route('mypage.edit') }}" class="mypage-btn">プロフィールを編集</a>
        </div>
</x-layout>
