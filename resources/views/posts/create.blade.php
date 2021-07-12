<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        legend {
            padding-top: 50px;
        }
    </style>
      <!-- Scripts -->
<!-- 합쳐지고 최소화된 최신 CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<!-- 부가적인 테마 -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/29.0.0/classic/ckeditor.js"></script>
</head>
<body>
 <div class="container">
<form action="/posts/store" method="post" enctype="multipart/form-data">
    @csrf
    <fieldset>
    <legend>게시글 작성</legend>
    <div class="form-group">
        <label for="title">제목</label>
        <input type="text" name="title" class="form-control" id="title" placeholder="제목을 입력하세요" value="{{ old('title') }}">

        @error('title')
        <div>
            {{ $message }}
        </div>
    @enderror
      </div>
      <label for="title">내용</label>
      <div class="form-group">
        <textarea type="text" id="content" name="content" class="form-control"></textarea>
        @error('content')
        <div> {{ $message }}</div>
        @enderror
    </div>
      <div class="form-group">
        <label for="image">이미지</label>
        <input type="file" id="file" name="imageFile">
        @error('imageFile')
        <div> {{ $message }}</div>
        @enderror
      </div>

    <input type="submit" class="btn btn-primary" value="제출">  
    </fieldset>
    </form>
</div>
<script>
  ClassicEditor
                         .create( document.querySelector( '#content' ) )
                         .then( editor => {
                                 console.log( editor );
                         } )
                         .catch( error => {
                                 console.error( error );
                         } );
</script>
</body>
</html>