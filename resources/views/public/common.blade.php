@extends(admin_template('layouts.admin'))

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