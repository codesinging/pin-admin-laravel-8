@extends(admin_template('layouts.app'))

@section('title', $title)

@section('body')
    <div id="app">
        @{{ message }}
    </div>
    <script>
        createApp('#app', {
            data() {
                return {
                    message: 'Hello PinAdmin'
                }
            }
        })
    </script>
@endsection