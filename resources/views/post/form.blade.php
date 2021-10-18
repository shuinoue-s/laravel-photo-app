<x-layout>
    <div class="w-4/5 mx-auto text-center">
        <h2 class="page-title">写真を投稿する</h2>

        <form method="post" action="{{ route('post.upload') }}" enctype="multipart/form-data">
            @csrf
                <div class="post-container">
                    <div class="upload-container">
                        <img id="preview" class="preview-image" src="{{ asset('images/image-icon2.png') }}">
                        <div class="image-label-wrapper">
                            <label class="image-label">
                                <input id="myImage" class="file" type="file" name="image" accept="image/png, image/jpeg" onchange="previewImage(this);">写真を選択
                            </label>
                            @error('image')
                            <div class="image-alert alert alert-danger py-1">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="description-container">
                        <div class="title-container">
                            <label for="title">タイトル</label>
                            <input id="title" type="text" name="title" placeholder="必須" value="{{ old('title') }}">
                        </div>
                        @error('title')
                        <div class="alert alert-danger w-11/12 mx-auto py-1">
                            {{ $message }}
                        </div>
                        @enderror

                        <div class="tags-container">
                            <label for="tags">タグ</label>
                            <input id="tags" type="text" name="tags" placeholder="任意" value="{{ old('tags') }}">
                        </div>
                        <p>各タグの先頭に # を付けて入力してください ( 複数入力可 )</p>
                        @error('tags')
                        <div class="alert alert-danger w-11/12 mx-auto py-1">
                            {{ $message }}
                        </div>
                        @enderror

                        <div class="body-container">
                            <label for="description">説明文</label>
                            <textarea name="description" id="description" placeholder="任意">{{ old('description') }}</textarea>
                        </div>
                        @error('description')
                        <div class="alert alert-danger w-11/12 mx-auto py-1">
                            {{ $message }}
                        </div>
                        @enderror
                        <div class="post-btn">
                            <input type="submit" value="投稿する" class="btn-black block bg-black text-white py-2 rounded-5px px-6 h-12">
                        </div>
                    </div>
                </div>
        </form>
        <ul>
        </ul>
    </div>

</x-layout>
