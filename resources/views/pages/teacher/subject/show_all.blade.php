@extends('layouts.app')
@section('title', 'Subjects List')
@section('page-header', 'Subjects List')
@section('content')
    <div class="col-xs-12 col-md-12">
        @include('pages.teacher.session-data')

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">
                    Subjects List
                </h4>
            </div>{{--
            <div class="col-md-12">
                <a href="{{ route('teacher.assignment.create') }}" class="btn-add">
                    <button type="button" class="btn btn-success" style="margin: 20px 15px; float: right">Add Subject</button>
                </a>
            </div>--}}
            <div class="panel-body">
                <div class="col-xs-12 col-md-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col" style="width: 5%">STT</th>
                            <th scope="col">Subject Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Number of assignments</th>
                            <th scope="col">Class Name</th>
                            <th scope="col">Due date</th>
                            <th scope="col" style="width: 12%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (!$subjects->isEmpty())
                            @php $i = 1 @endphp
                            @foreach($subjects as $i=>$subject)
                                <tr>
                                    <th scope="row" style="vertical-align: middle">{{++$i}}</th>
                                    <td style="vertical-align: middle">{{ $subject->name }}</td>
                                    <td style="vertical-align: middle">{{ !empty($subject->description) ? $subject->description: '--' }}</a></td>
                                    <td style="vertical-align: middle">{{$subject->assignments_count}}</td>
                                    <td style="vertical-align: middle"><a href="{{'class/'. $subject->classId}}" target="_blank">{{ $subject->classes->first()->name }}</a></td>
                                    <td style="vertical-align: middle">{{ $subject->created_at }}</td>
                                    <td style="vertical-align: middle;" class="btn-fix">
                                        <a href="{{ route('class.detail', $subject->classes->first()->id) }}" class="btn btn-success btn-sm"><i class="fa fa-fw fa-eye"></i></a>

                                        <a class="btn btn-primary btn-sm" href="{{ route('class.detail', $subject->classes->first()->id) }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>

                                        <a class="btn btn-danger btn-sm btn-delete btn-confirm-delete"
                                           href="{{ route('delete.subject', $subject->id) }}"
                                           onclick="return confirm('You want delete subject {{$subject->name}} in class: {{ $subject->classes->first()->name }}')"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            @php $i++ @endphp
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
