<x-layout>
    <div class="btn-container">
        @guest
        <a href="{{ route('register') }}" class="toppage-btn">会員登録</a>
        <a href="{{ route('login') }}" class="toppage-btn">ログイン</a>
        @endguest
    </div>

    <div class="flex-container">
        <div class="flex-column flex-column1">
            @foreach ($posts as $post)
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
            @foreach ($posts as $post)
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
            @foreach ($posts as $post)
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

