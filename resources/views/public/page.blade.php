@extends(admin_template('layouts.app'))

@section('title', $title ?? admin_config('name'))

@section('body')
    <div id="app"></div>

    <script>
        createPage('#app', '{{ $page }}')
    </script>
@endsection