<x-layout>
    <h2 class="page-title">タグ検索</h2>
    <form action="{{ route('tag.result') }}" method="get">
        <div class="tag-search-container">
            <input type="text" name="tag" class="tag-search">
            <button>検索</button>
            @error('tag')
                <div class="image-alert alert alert-danger py-1 mt-1 w-1/2 mx-auto">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </form>
</x-layout>
