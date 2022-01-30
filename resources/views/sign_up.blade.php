@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Sign Up') }}</div>

                <div class="card-body">
                    @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{!! \Session::get('success') !!}</li>
                        </ul>
                    </div>
                    @endif
                    @if (\Session::has('error'))
                    <div class="alert alert-danger">
                        <ul>
                            <li>{!! \Session::get('error') !!}</li>
                        </ul>
                    </div>
                    @endif
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{URL('sign_up')}}" method="Post">
                        @csrf
                        <div>
                            <label for="email">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control" required value="{{$invitation->email}}" readonly>
                        </div>
                        <div>
                            <label for="username">Username</label>
                            <input type="text" name="user_name" id="user_name" class="form-control" required value="{{ old('user_name') }}">
                        </div>
                        <div>
                            <label for="username">Pin</label>
                            <input type="text" name="pin" id="pin" class="form-control" required value="{{ old('pin') }}">

                        </div>
                        <div>
                            <button type="button" id="send_pin">Send Pin</button>
                            Pin will be sent to your email address
                        </div>
                        <div>
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}">
                        </div>
                        <div>
                            <label for="password">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" value="{{ old('confirm_password') }}">
                        </div>
                        <div class="mt-2">
                            <button class="btn btn-success">Sign Up</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#send_pin').click(function() {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "../send_pin",
            dataType: 'JSON',
            type: 'POST',
            data: {
                'invitation_token': "{{$invitation->invitation_token}}"
            },
            success: function(result) {
                alert('Pin has been sent to your email address.');
            },
            error: function(result) {
                alert(result.responseJSON.error);
            }
        });
    });
</script>
@endsection