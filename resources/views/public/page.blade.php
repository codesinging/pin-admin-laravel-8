@extends(admin_template('layouts.admin'))

@section('title', $title ?? admin_config('name'))

@section('body')
    <div id="app"></div>

    <script>
        createPage('#app', '{{ $page }}')
    </script>
@endsection