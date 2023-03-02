@extends('layouts.app')
@section('title', 'Subject Form')
@section('page-header', 'Subject Form')

@section('content')
    <div class="col-xs-12 col-md-12">
        @include('pages.teacher.session-data')

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">
                    Add Subject
                </h4>
            </div>
            <div class="panel-body">
                <div class="col-xs-12 col-md-12">
                    <div class="container-fluid">
                        <form role="form" action="{{url('subject/create')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-primary">
                                        <!-- form start -->
                                        <div class="card-body">
                                            <div class="form-group {{ $errors->first('class_id') ? 'has-error' : '' }} ">
                                                <label for="inputEmail3" class="control-label default">Class <sup class="text-danger">(*)</sup></label>
                                                <div>
                                                    <select name="id" class="form-control select-class">
                                                        <option value="">Select Class</option>
                                                        @foreach($classes as $class)
                                                            <option value="{{$item->classID}}" @if($student->subjects->class_id == $item->classID) selected @endif>
                                                                {{$item->className}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger "><p class="mg-t-5">{{ $errors->first('id') }}</p></span>
                                                </div>
                                            </div>

                                            <div class="form-group {{ $errors->first('name') ? 'has-error' : '' }} ">
                                                <label for="inputEmail3" class="control-label default">Name <sup class="text-danger">(*)</sup></label>
                                                <div>
                                                    <input type="text" class="form-control"  placeholder="Name Subject" name="name"
                                                           value="{{ old('name', isset($subject) ? $subject->name : '') }}">
                                                    <span class="text-danger "><p class="mg-t-5">{{ $errors->first('name') }}</p></span>
                                                </div>
                                            </div>

                                            <div class="form-group {{ $errors->first('description') ? 'has-error' : '' }} ">
                                                <label for="inputEmail3" class="control-label default">Description</label>
                                                <div>
                                                    <input type="text" class="form-control"  placeholder="Description Subject" name="description"
                                                           value="{{ old('description', isset($subject) ? $subject->description : '') }}">
                                                    <span class="text-danger "><p class="mg-t-5">{{ $errors->first('description') }}</p></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="btn-set">
                                                <button type="submit" name="submit" class="btn btn-info">
                                                    <i class="fa fa-save"></i> Save
                                                </button>
                                                <button type="reset" name="reset" value="reset" class="btn btn-danger">
                                                    <i class="fa fa-undo"></i> Reset
                                                </button>
                                                <div class="pull-right">
                                                    <a href="{{ route('subjects.show_all') }}">
                                                        <button type="button" class="btn btn-primary" style="width: 120px">
                                                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                                            Back List
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
