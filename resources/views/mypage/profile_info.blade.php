<x-layout>
    <h2 class="page-title">{{ $post_user->name }}さん</h2>

    <div class="mypage-container">
        <div class="mypage-image-container">
            @if (!empty($post_user->profile->profile_image))
                <img id="preview" class="mypage-image" src="{{ $post_user->profile->profile_image }}" alt="icon">
            @else
                <img id="preview" class="mypage-image" src="{{ asset('images/profile-icon.png') }}">
            @endif
        </div>

        <div class="mypage-description-container">
            <div class="mypage-description">
                <h3>名前</h3>
                <p>{{ $post_user->name }}</p>
            </div>

            <div class="mypage-body-container">
                <h3>自己紹介</h3>
                <div class="mypage-textarea">
                    @if (!empty($post_user->profile->profile_body))
                    <p>{!! nl2br(e($post_user->profile->profile_body)) !!}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="flex-container">
        <div class="flex-column flex-column1">
            @foreach ($post_user->posts as $post)
                    @if ($loop->index % 3 === 0)
                        <div class="hover-container hover-image">
                            <a href="{{ route('post.show', ['id' => $post->id]) }}"><div><img data-src="{{ $post->file_path }}" src="{{ asset('images/dummy_800x450.png') }}" alt="{{ $post->title }}" class="lazyload"></div>
                                <div class="hover-title">
                                    <p>{{ $post->title }}</p>
                                </div>
                            </a>
                        </div>
                    @endif
            @endforeach
        </div>
        <div class="flex-column flex-column2">
            @foreach ($post_user->posts as $post)
                @if ($loop->index % 3 === 1)
                <div class="hover-container hover-image">
                    <a href="{{ route('post.show', ['id' => $post->id]) }}"><div><img data-src="{{ $post->file_path }}" src="{{ asset('images/dummy_800x450.png') }}" alt="{{ $post->title }}" class="lazyload"></div>
                        <div class="hover-title">
                            <p>{{ $post->title }}</p>
                        </div>
                    </a>
                </div>
                @endif
            @endforeach
        </div>
        <div class="flex-column flex-column3">
            @foreach ($post_user->posts as $post)
                @if ($loop->index % 3 === 2)
                <div class="hover-container hover-image">
                    <a href="{{ route('post.show', ['id' => $post->id]) }}"><div><img data-src="{{ $post->file_path }}" src="{{ asset('images/dummy_800x450.png') }}" alt="{{ $post->title }}" class="lazyload"></div>
                        <div class="hover-title">
                            <p>{{ $post->title }}</p>
                        </div>
                    </a>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</x-layout>
