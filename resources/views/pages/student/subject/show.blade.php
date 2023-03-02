@extends('layouts.app')

@section('title', 'Subjects')

@section('content')
    <div class="course-detail-overlay" style="height: 215px;"></div>
    <div class="container course-detail-site">
        <ul class="breadcrumb none-list mg-0 mg-b-25 fs-16 text-normal">
            <li>
                <a href="/home" class="text-decoration-none" title="Home">Home</a>
            </li>
            <li class="separator">/</li>
            <li>
                <span title="Name Class">{{ $class1->name }}</span>
            </li>
        </ul>
        <article class="course-detail-content">
            <div class="row">
                <div class="col-12 col-lg-8 course-detail-content__main">
                    <section class="top-bar-courseDetail mg-b-16">
                        <h1 class="course-name text-bold fs-34 white-space-pre-wrap">Class: {{ $class1->name }}</h1>
                    </section>
                    <p class="course-code-title">
                        Lecturer:
                        <span class="lecturer-chat">
                            <a href="" data-toggle="modal" data-target="#formChat">
                                {{ $lecturer->first_name }} {{ $lecturer->last_name }}
                            </a>
                        </span>
                    </p>

                    <div class="wrap-course-detail-content_main">
                        <div id="course-detail-main-content">
                            <!---Guide lines---->
                            <section id="guide-lines">
                                <!---lessons content--->
                                <div id="lessons-content" class="edn-tabs ui-tabs ui-widget ui-widget-content">
                                    <div id="list-lessons" class="edn-tab-content ui-tabs-panel ui-widget-content" aria-labelledby="list-slots-tab" role="tabpanel" aria-hidden="false">
                                        <h4>List Of Subjects: </h4>
                                        <ul class="list-slots none-list mg-0">
                                            <!--foreach()-->
                                            @foreach($subjects1 as $item)
                                                <li class="slot-item">
                                                    <div class="slot-item__thumb">
                                                        <div class="top-head-slot mg-b-12">
                                                            <div class="left-top-head-slot">
                                                                <b class="slot-label">{{$item->name}}</b>
                                                                <time class="fs-14"><i class="la la-calendar fs-18"></i>{{$item->created_at}} (GMT+07)</time>
                                                            </div>
                                                            <div class="right-top-head-slot">
                                                                <a href="{{ route('student.assignment.show', $item->id) }}" class="text-decoration-none text-lightbold">View assignments</a>
                                                            </div>
                                                        </div>
                                                        <div class="wrap-slot-name">
                                                            <div class="slot-name text-bold">{{!($item->description) ? '--' : $item->description}}</div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                            <!--end-foreach()-->
                                        </ul>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>

                <!--tab-panel-->
                <aside class="col-12 col-lg-4 col-xl-4 course-sidebar hide-on-992">
                    <div class="wrap-course-sidebar course-sidebar-sticky">
                        <div class="top">
                            <div class="course-sumary-desktop pd-15">
                                <div class="mg-b-16 filter-class">
                                    <span class="pd-r-5">Class</span>
                                    <select class="slot-by-class">
                                        <option value="{{--id class--}}" {{--check selected--}}>{{$class1->name}}</option>
                                    </select>
                                </div>
                                <div class="course-sumary">
                                    <div class="lectures-section mg-t-20">
                                        <div class="heading-lectures-section mg-b-20">
                                            <h4 class="fs-16 mg-0">Lecturer
                                                @if (Auth::user()->role == 'teacher')
                                                    ({{count($users)}})
                                                @endif
                                            </h4>
                                            <!--chat class-->
                                            <a href="" style="text-decoration: underline" title="Chat with lecturer" data-toggle="modal" data-target="#formChat">
                                                <i class='fas fa-comments' style='font-size:20px'></i>
                                                 Chat with lecturer
                                            </a>
                                        </div>
                                        <ul class="none-list mg-0">
                                            <li class="lecture-item mg-b-16">
                                                <div class="user-acc">
                                                    <img src="{{($lecturer->avatar) ? asset('uploads/avatar/'.$lecturer->avatar) : asset('uploads/avatar/user-default.png') }}"
                                                         alt="{{ $lecturer->email }}" class="user-avatar">
                                                    <div class="acc-content-right">
                                                        <div class="wrap-user-name">
                                                            <span class="user-name text-semibold fs-14 is-email" title="{{ $lecturer->email }}">
                                                                {{ $lecturer->email }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="heading-lectures-section mg-b-20">
                                            <h4 class="fs-16 mg-0">Students
                                                    ({{count($users)}})
                                            </h4>
                                        </div>
                                        @foreach($users as $item)
                                            <ul class="none-list mg-0">
                                                <li class="lecture-item mg-b-16">
                                                    <div class="user-acc">
                                                        <img src="{{($item->avatar) ? asset('uploads/avatar/'.$item->avatar) : asset('uploads/avatar/user-default.png') }}"
                                                             alt="{{ $item->email }}" class="user-avatar">
                                                        <div class="acc-content-right">
                                                            <div class="wrap-user-name">
                                                                <span class="user-name text-semibold fs-14 is-email" title="{{ $item->email }}">{{ $item->email }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </article>
    </div>

    <!--form chat-->
    <div class="modal fade" id="formChat" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Mailbox Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" role="form" method="POST"
                      action="{{ url('message/user/' . $lecturer->id) }}">
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
@endsection

