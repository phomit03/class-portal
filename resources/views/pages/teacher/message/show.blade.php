@extends('layouts.app')

@section('title', 'Messages')

@section('page-header', 'Chat Mailbox')

@section('content')
    <!-- Display flashed session data on successful update -->
    @include('pages.teacher.session-data')

    <div class="container wrap-list-classes">
        <div class="edn-tabs">
            @if (isset($messages) && count($messages) > 0)
                @foreach ($messages as $message)
                    <div class="wrap-main-activity">
                        <div class="wrap-entry-lesson-content">
                            <b class="mg-b-8 fs-18">From: <span style="color: var(--accent-color);">{{ $message->from_fullname }}</span></b>
                            <br>
                            <span>{{ $message->created_at }}</span>
                            <form role="form" method="POST" action="{{ url('/message/' . $message->id) }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button class="btn btn-study-now" style="float: right; margin-top: -50px;"
                                        onclick="return confirm('You want delete message from: {{ $message->from_fullname }}')">
                                    <i class="la la-trash" style="font-size: 17px; color: red"></i>
                                </button>
                            </form>

                            <div class="wrap-activity-content" style="margin-top: 20px">
                                <b>Title: </b>{{ $message->title }} <br>
                                <b>Message: </b>{{ $message->message }} <br>


                                <div style="float: right">
                                    <a data-toggle="modal" data-target="#replyMail" title="Reply Mail">
                                        <button class="btn btn-study-now" style="width: 120px">
                                            <span class="fs-16 text-bold"><i class="la la-mail-reply fs-18"></i> Reply</span>
                                        </button>
                                    </a>
                                </div>
                            </div>

                            <!--form reply-->
                            <div class="modal fade" id="replyMail" role="dialog" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Mailbox Form</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form class="form-horizontal" role="form" method="POST"
                                              action="{{ url('message/user/' . $message->from) }}">
                                            {{ csrf_field() }}

                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <span>Please fill out the form below to discuss the matter with your teacher or student!
                                                        <span class="red-color">Note:</span> Teacher can only reply if they receive a letter from a student,
                                                        cannot actively send a letter first.
                                                    </span>
                                                </div>

                                                <div class="form-group {{ $errors->first('title') ? 'has-error' : '' }}">
                                                    <label>Title</label>
                                                    <input type="text" class="form-control" name="title"
                                                           value="{{ $errors->has('title') ? old('title') : '' }}"
                                                           placeholder="Do you have a question you want to discuss?">

                                                    @if ($errors->has('title'))
                                                        <span class="help-block"><strong>{{ $errors->first('title') }}</strong></span>
                                                    @endif
                                                </div>

                                                <div class="form-group {{ $errors->first('message') ? 'has-error' : '' }}">
                                                    <label>Message</label>
                                                    <textarea class="form-control" name="message" rows="4">
                                                        {{ $errors->has('message') ? old('message') : '' }}
                                                    </textarea>

                                                    @if ($errors->has('message'))
                                                        <span class="help-block"><strong>{{ $errors->first('message') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" value="Accept" class="btn btn-primary">Send Mail</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            @else
                <div class="wrap-main-activity">
                    <div class="wrap-entry-lesson-content">
                        <div class="alert alert-danger">You don't have any messages at the moment.</div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
