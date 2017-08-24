@extends("layout")
@section('content')

@endsection
@section('javascript')
    <script>
        config.categoryId = {{ $categoryId }};
        config.articleId = {{ $articleId }};
        config.productsType = {!! json_encode($categories, JSON_UNESCAPED_UNICODE) !!};
        config.articleCategories = {!! json_encode($articleCategories, JSON_UNESCAPED_UNICODE) !!};
        config.articles = {!! json_encode($articles, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/head.js') }}"></script>
    <script src="{{ fct_cdn('/js/help.js') }}"></script>
@endsection