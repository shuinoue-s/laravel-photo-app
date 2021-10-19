<x-layout>
    @if (!empty($posts))
        <h2 class="page-title">検索結果 | {{ $tag_name }}</h2>
        <div class="flex-container">
            <div class="flex-column flex-column1">
                @foreach ($posts as $post)
                @if ($loop->index % 3 === 0)
                <div class="hover-container hover-image">
                    <a href="{{ route('post.show', $post->id) }}"><div><img data-src="{{ $post->file_path }}" src="{{ asset('images/dummy_800x450.png') }}" alt="{{ $post->title }}" class="lazyload"></div>
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
                    <a href="{{ route('post.show', $post->id) }}"><div><img data-src="{{ $post->file_path }}" src="{{ asset('images/dummy_800x450.png') }}" alt="{{ $post->title }}" class="lazyload"></div>
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
                    <a href="{{ route('post.show', $post->id) }}"><div><img data-src="{{ $post->file_path }}" src="{{ asset('images/dummy_800x450.png') }}" alt="{{ $post->title }}" class="lazyload"></div>
                        <div class="hover-title">
                            <p>{{ $post->title }}</p>
                        </div>
                    </a>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    @else
        <div class="nothing-result">
            <p>{{ $message }}</p>
            <a href="{{ route('tag.search') }}">戻る</a>
        </div>
    @endif
</x-layout>

