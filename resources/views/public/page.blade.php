@extends(admin_template('layouts.app'))

@section('title', $title ?? admin_config('name'))

@section('body')
    <div id="app"></div>

    <script>
        const data = @json($data);
        const page = '{{ $page }}'
        createPage('#app', page, data)
    </script>
@endsection