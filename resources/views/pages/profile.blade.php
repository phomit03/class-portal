@extends('layouts.app')

@section('title', 'Profile')

@section('page-header', 'General Account Information')

@section('content')
    <!-- Display flashed session data on successful update -->
    @include('pages.teacher.session-data')

    @if ($user->id == Auth::user()->id)
        <div class="row">
            <div class="col-xs-8 col-md-8" style="margin: 10px auto 40px">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            @if ($user->id == Auth::user()->id)
                                Your profile's information, <strong>{{ $user->first_name }}</strong>.
                            @else
                                Profile of {{ $user->first_name }} {{ $user->last_name }}.
                            @endif
                        </h4>
                    </div>
                    <div class="panel-body">
                        <div class="col-xs-12 col-md-12">
                            <p><strong>First name:</strong> {{ $user->first_name }}</p>
                            <p><strong>Last name:</strong> {{ $user->last_name }}</p>
                            <p><strong>Phone:</strong> {{ $user->phone }}</p>
                            <p><strong>Date Of Birth:</strong> {{ $user->date_of_birth }}</p>
                            <p><strong>Role:</strong> {{ $user->role }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Updated:</strong> {{ $user->updated_at }}</p>
                            <h3>Edit Information</h3>
                            <hr>

                            <!-- Edit Form -->
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/profile/update') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <!-- Avatar -->
                                <div class="form-group{{ $errors->has('avatar') ? ' has-error': ''}}">
                                    <label class="col-md-3 col-md-offset-1 control-label">Avatar</label>
                                    <div class="col-md-6">
                                        <input type="file" class="form-control" name="avatar"
                                               value="{{ $errors->has('avatar') ? old('avatar') : $user->avatar }}">

                                        @if ($errors->has('avatar'))
                                            <span class="help-block"><strong>{{ $errors->first('avatar') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <!-- First Name -->
                                <div class="form-group{{ $errors->has('first_name') ? ' has-error': ''}}">
                                    <label class="col-md-3 col-md-offset-1 control-label">First Name</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="first_name"
                                               value="{{ $errors->has('first_name') ? old('first_name') : $user->first_name }}">

                                        @if ($errors->has('first_name'))
                                            <span class="help-block"><strong>{{ $errors->first('first_name') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Last Name -->
                                <div class="form-group{{ $errors->has('last_name') ? ' has-error': ''}}">
                                    <label class="col-md-3 col-md-offset-1 control-label">Last Name</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="last_name"
                                               value="{{ $errors->has('last_name') ? old('last_name') : $user->last_name }}">

                                        @if ($errors->has('last_name'))
                                            <span class="help-block"><strong>{{ $errors->first('last_name') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('phone') ? ' has-error': ''}}">
                                    <label class="col-md-3 col-md-offset-1 control-label">Phone number</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="phone"
                                               value="{{ $errors->has('phone') ? old('phone') : $user->phone }}">

                                        @if ($errors->has('phone'))
                                            <span class="help-block"><strong>{{ $errors->first('phone') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('date_of_birth') ? ' has-error': ''}}">
                                    <label class="col-md-3 col-md-offset-1 control-label">Date of birth</label>
                                    <div class="col-md-6">
                                        <input type="date" class="form-control" name="date_of_birth"
                                               value="{{ $errors->has('date_of_birth') ? old('date_of_birth') : $user->date_of_birth }}">

                                        @if ($errors->has('date_of_birth'))
                                            <span class="help-block"><strong>{{ $errors->first('date_of_birth') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="form-group">
                                    <div class="col-md-4 col-md-offset-8">
                                        <button type="submit" class="btn btn-primary" style="width: 120px">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{{--
    @else
--}}

    @endif

@endsection
