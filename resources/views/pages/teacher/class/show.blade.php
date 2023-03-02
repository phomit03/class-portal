@extends('layouts.app')

@section('title', 'Class Details')

@section('page-header', 'Class Details')

@section('content')
    <!--side-content-->
    <div class="col-xs-12 col-md-4">
        <div class="well">
            <h4>Classes</h4>
            @if (count(Auth::user()->classes()->get()) > 0)
                <div class="list-group">
                    @foreach (Auth::user()->classes()->get() as $class)
                        <a href="{{ url('class/' . $class->id) }}" class="list-group-item list-group-item-info">
                            <h4 class="list-group-item-heading">
                                {{ $class->name }} {{ $class->room }}-{{ $class->section }}
                            </h4>
                            <p class="list-group-item-text">{{ $class->title }}</p>
                        </a>
                    @endforeach
                </div>
            @else
                @if (Auth::user()->role == 'teacher')
                    <div class="alert alert-danger" role="alert">You do not have any active classes.</div>
                @else
                    <div class="alert alert-danger" role="alert">You are no taking any classes.</div>
                @endif
            @endif
        </div>

        <div class="well">
            <span style="width: 20%; margin: 0; text-decoration: underline">Class Code: </span> <h4 style="margin-top: 10px; margin-left: 10px">{{$class1->class_code}}</h4>

            <span style="text-decoration: underline">Class Link: </span>
            <div class="row">
                <div class="col-md-12 class-form" style="margin-bottom: 20px; margin-top: 5px">
                    <input type="text" id="copy_link_join_class" value="{{ route('join.class', $class1->class_code)}}" style="margin-left: 10px; width: 265px;">
                    <button value="copy" onclick="copyToClipboard()" style="margin-left: 20px">Copy link</button>
                </div>
            </div>
            <a href="{{ url('/class/' . $class1->id . '/students') }}">
                <button type="button" class="btn btn-success btn-block">Add Students</button>
            </a>
            <table class="table table-bordered" style="margin-top: 5%">
                <thead>
                <tr>
                    <th scope="col" style="width: 15%">STT</th>
                    <th scope="col">Name</th>
                    @if (Auth::user()->role == 'teacher')
                        <th scope="col" style="width: 22%">Action</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                    @foreach($users as $item)
                        <tr>
                            <th scope="row" style="vertical-align: middle">{{ $loop->iteration }}</th>
                            <td style="vertical-align: middle">{{ $item->first_name }} {{ $item->last_name }}</td>
                            @if (Auth::user()->role == 'teacher')
                                <td style="vertical-align: middle">
                                    <a class="btn btn-danger btn-sm btn-delete btn-confirm-delete" href="{{ route('remove.student.class', $item->id) }}"
                                       onclick="return confirm('You want delete student: {{$item->first_name}}')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <!--end side-content-->

    <!-- Display flashed session data on successful action -->
    <div class="col-xs-12 col-md-8">
        @include('pages.teacher.session-data')

        <!-- Show class title and instructor's name -->
        <div class="row">
            @if ($instructor->role == "teacher" && $class1 != null)
                <div class="col-md-10">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="white-color fs-20">{{ $class1->name }}</h3>
                            <h4 class="panel-title">
                                Title: {{ !($class1->title) ? 'null' : $class1->title}} -
                                Section: {{ !($class1->section) ? 'null' : $class1->section}} -
                                Room: {{ !($class1->room) ? 'null' : $class1->room}}
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <form role="form" method="POST" action="{{ url('/class/delete/' . $class1->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <button type="submit" class="btn btn-danger btn-block" style="margin-top: 2px"
                                onclick="return confirm('You want delete class: {{$class1->name}}')">
                            Delete
                        </button>
                    </form>
                </div>
            @else
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                {{ $class1->name }} - {{ $class1->section }} - {{ $class1->title }} - {{ $class1->room }} -
                                <a> {{ $instructor->first_name }} {{ $instructor->last_name }}</a>
                            </h4>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{--Edit + Add--}}
        @if ($instructor->role == "teacher")
            <!-- Edit Class Information -->
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" href="#collapseOne" aria-expanded="true"
                           aria-controls="collapseOne">Edit Class Information</a>
                    </h4>
                </div>

                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labellledby="headingOne">
                    <div class="panel-body">
                        <div class="col-xs-12 col-md-12">
                            <form class="form-horizontal" role="form" method="POST"
                                  action="{{ url('class/update/' . $class1->id) }}">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <!-- Name -->
                                <div class="form-group{{ $errors->has('name') ? ' has-error': '' }}">
                                    <label class="col-md-3 control-label">Class Name <sup class="text-danger">(*)</sup></label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="name"
                                               value="{{ old('name') ? old('name') : $class1->name }}">

                                        @if ($errors->has('name'))
                                            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Title -->
                                <div class="form-group{{ $errors->has('title') ? ' has-error': '' }}">
                                    <label class="col-md-3 control-label">Title</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="title"
                                               value="{{ old('title') ? old('title') : $class1->title }}">

                                        @if ($errors->has('title'))
                                            <span class="help-block"><strong>{{ $errors->first('title') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Room -->
                                <div class="form-group{{ $errors->has('room') ? ' has-error': '' }}">
                                    <label class="col-md-3 control-label">Room</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="room"
                                               value="{{ old('room') ? old('room') : $class1->room }}">

                                        @if ($errors->has('room'))
                                            <span class="help-block"><strong>{{ $errors->first('room') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Section -->
                                <div class="form-group{{ $errors->has('section') ? ' has-error': '' }}">
                                    <label class="col-md-3 control-label">Section</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="section"
                                               value="{{ old('section') ? old('section') : $class1->section }}">

                                        @if ($errors->has('section'))
                                            <span class="help-block"><strong>{{ $errors->first('section') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Edit Button -->
                                <div class="form-group">
                                    <div class="col-md-4 col-md-offset-7">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>

                            </form>

                            <hr>

                        </div>
                    </div>
                </div>
            </div>
        @endif


        {{-- add subject theo class--}}
        @if (Auth::user()->role == 'teacher' && Auth::user()->id == $instructor->id)
            <!-- Add Quizzes, Assignments, and Annoucements -->
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" href="#collapseTwo" aria-expanded="true"
                           aria-controls="collapseOne">Add Subject</a>
                    </h4>
                </div>

                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labellledby="headingTwo">
                    <div class="panel-body">
                        <div class="col-xs-12 col-md-12">
                            {{--start form--}}
                            <form class="form-horizontal" role="form" method="POST"
                                  action="{{ url('/subject/new/save') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="class_id" value="{{$class_id}}"/>
                                <!--Name-->
                                <div class="form-group{{ $errors->has('name') ? ' has-error': '' }}">
                                    <label class="col-md-4 control-label">Name <sup class="text-danger">(*)</sup></label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                               placeholder="HTML">
                                        <div>
                                            @if ($errors->has('name'))
                                                <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Title -->
                                <div class="form-group{{ $errors->has('description') ? ' has-error': '' }}">
                                    <label class="col-md-4 control-label">Description</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="description" value="{{ old('description') }}"
                                               placeholder="Easy">
                                        <div>
                                            @if ($errors->has('description'))
                                                <span class="help-block"><strong>{{ $errors->first('description') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="form-group">
                                    <div class="col-md-4 col-md-offset-6">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>

                            </form>
                            {{--end form--}}
                        </div>
                    </div>
                </div>

            </div>
        @endif

        <div class="panel panel-default">
            <table class="table table-hover text-nowrap">
                <thead>
                <tr>
                    <th>Subject Name</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                @foreach($subjects1 as $item)
                    <tr>
                        <td>{{$item->name}}</td>
                        <td>{{$item->description}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!--End Subject-->

        @if (Auth::user()->role == 'teacher' && Auth::user()->id == $instructor->id)
            <div class="panel panel-default">
                <div class="panel-heading" role="tab">
                    <h4 class="panel-title">
                        List Assignments
                    </h4>
                </div>
                <div class="panel-body">
                    <div>
                        <a href="{{ route('teacher.assignment.create', ['class_id' => $class1->id]) }}" class="btn-add">
                            <button type="button" class="btn btn-success" style="float: right; margin: 0 15px 15px">Add Assignment</button>
                        </a>
                        <div>
                            @include('pages.teacher.assignment.table-assignment', compact('assignments'))
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

{{--chuyển phần này qua subjects--}}
@push('scripts')
    <script>
        $(document).ready(function () {
            $('.note').hide();
            $('#subject').change(function () {
                $('.note').hide();
                var val = $(this).val();
                $('#avai_subject').hide();
                $('#new_subject').hide();
                if (val == 'avai_Subject') {
                    $('#avai_subject').show();
                }
                else if (val == 'new_Subject') {
                    $('#new_subject').show();
                }
            });
        });
    </script>

    <script>
        function copyToClipboard() {
            document.getElementById("copy_link_join_class").select();
            document.execCommand('copy');
        }
    </script>
    <script src=" {{ asset('js/toggle-assignment-type.js') }}"></script>
@endpush
