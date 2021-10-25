<x-layout>
    <h2 class="page-title">{{ $post_user->name }} の投稿</h2>
    <div class="show-container">
        <div class="image-size">
            <img src="{{ $post->file_path }}" alt="{{ $post->title }}">
            @auth
                <div id="app">
                    <like :post_id="{{$post->id}}"></like>
                </div>
            @endauth
        </div>

        <div class="show-description">
            <p>{{ $date }}</p>
            <p>{{$post->title}}</p>
            <p>{!! nl2br(e($post->description)) !!}</p>

            <div class="show-tag">
                @for ($i = 0; $i < count($tags); $i++)
                        <a href="{{ route('tag.list', $tags[$i]['id']) }}">#{{$tags[$i]['tag_name'];}}</a>
                @endfor
            </div>

            @if ($post->user_id === $auth)
                <div class="delete-btn-container">
                    <form action="{{ route('post.destroy', $post->id) }}" method="post">
                        @method('DELETE')
                        @csrf
                        <button id="delete-btn" name="delete">投稿を削除</button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <div class="show-modal">
        <img src="{{ $post->file_path }}" alt="{{ $post->title }}" class="modal-image">
        <p class="close-btn"><a href="">×</a></p>
        <div class="modal-mask"></div>
    </div>

    <div class="comment-container">
        <div class="post-comment-container">
            @guest
                <a href="{{ route('login') }}"><h3 class="guest-text">ログインするとコメントを投稿できます</h3></a>
            @endguest
            @auth
                <form action="{{ route('comment.create', $post->id) }}" method="post">
                    @csrf
                    <textarea name="comment" placeholder="200文字以内">{{ old('comment') }}</textarea>
                    @error('comment')
                        <div class="image-alert alert alert-danger py-1">
                            {{ $message }}
                        </div>
                    @enderror
                    <button>コメントを送信</button>
                    <input name="position" type="hidden" value="0">
                </form>
            @endauth
        </div>

        <div class="show-comment-container">
            <h3>コメント一覧</h3>
                <ul>
                    @foreach ($comments as $comment)
                        <form action="{{ route('comment.destroy', $comment->id) }}" method="post">
                            @method('DELETE')
                            @csrf
                                <li>
                                    <p>{{ $comment->user->name }} より</p>
                                    <p>{{ $comment->created_at }}</p>
                                    <p>{!! nl2br(e($comment->comment)) !!}</p>
                                    @if ($comment->user_id === $auth)
                                        <button id="comment-delete-btn"><span class="x-btn">×</span><span class="comment-delete-btn">削除</span></button>
                                    @endif
                                </li>
                        </form>
                    @endforeach
                </ul>
        </div>
    </div>

</x-layout>
