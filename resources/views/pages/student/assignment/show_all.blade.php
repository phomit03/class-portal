@extends('layouts.app')

@section('title', 'List Assignments')

@section('content')
    <div class="container wrap-list-classes">
        @if (!$assignments->isEmpty())
            <div class="edn-tabs">
                <div id="tab-home-page" class="group-head-tab-control">
                    <div class="session-group ui-tabs-panel ui-widget-content" id="course-member" role="tabpanel" aria-hidden="false" style="" aria-labelledby="session-group-tab">
                        <section class="course-section">
                            <div class="wrap-slider-content">
                                <div class="wrap-course-section">
                                    <div class="list-course row">
                                        @foreach($assignments as $assignment)
                                            <article class="course-item col-md-4 col-sm-6 col-lg-3 publish" style="margin: 0 0 30px; padding: 0 15px;">
                                                <div class="wrap-course-item">
                                                    <div class="course-infor" style="padding: 20px">

                                                        <div class="assignment-state" style="padding-bottom: 10px">
                                                            @if (!empty($assignment->due_date) && checkTime($assignment->due_date) < 0)
                                                                <span title="Finished" class="slot-label finished ">Finished</span>
                                                            @else
                                                                <span title="Happenning" class="slot-label">Happenning</span>
                                                            @endif
                                                        </div>
                                                        <h3 class="course-title mg-b-15 fs-18">
                                                            <a href="{{ route('student.assignment.show-details', $assignment->id) }}" title="{{ $assignment->title }}" style="font-size: 16px">
                                                                {{ $assignment->title }}
                                                            </a>
                                                        </h3>
                                                        <ul class="bottom-course-sum none-list mg-0 fs-14 mg-b-15">
                                                            <li>
                                                                <i class="la la-book"></i>
                                                                <span class="hyper-row">Subject:
                                                                    <a href="{{ route('student.assignment.show', $assignment->subject->id) }}"
                                                                       class="course-code text-bold decoration-none"
                                                                       title="{{ isset($assignment->subject) ? $assignment->subject->name : '' }}">
                                                                        {{ isset($assignment->subject) ? $assignment->subject->name : '' }}
                                                                    </a>
                                                                </span>
                                                            </li>
                                                            <li>
                                                                <i class="las la-chalkboard-teacher"></i>
                                                                <span title="{{ isset($assignment->classes) ? $assignment->classes->name : '' }}">
                                                                    Class: {{ isset($assignment->classes) ? $assignment->classes->name : '' }}
                                                                </span>
                                                            </li>
                                                            <li>
                                                                <i class="la la-clock"></i>
                                                                <span title="{{ !empty($assignment->due_date) ? formatTime($assignment->due_date) : '--' }}">
                                                                    Due Date: {{ !empty($assignment->due_date) ? formatTime($assignment->due_date) : '--' }}
                                                                </span>
                                                            </li>
                                                        </ul>
                                                        <a class="view-detail text-decoration-none fs-14 mg-b-5" href="{{ route('student.assignment.show-details', $assignment->id) }}"
                                                           title="View assignment">
                                                            View assignment <i class="las la-arrow-right"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </article>
                                        @endforeach
                                    </div>

                                    @if($assignments->hasPages())
                                        <div class="pagination float-right margin-20">
                                            {{ $assignments->appends($query = '')->links() }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        @else
            <div class="align-right">
                <img src="{{ asset('uploads/landing/arrow.png') }}" style="height: 5rem;"/>
                <br>
                <p style="font-size: 13px; color: #6a6969; letter-spacing: 0.05rem; line-height: 1.25rem; font-weight: 450; text-align: right">
                    Don’t see your assignment? <br>
                    Try another account...
                </p>
            </div>
            <div class="align-center" style="font-size: 13px;">
                <img src="{{asset('uploads/landing/box-no-data.png')}}" style="height: 17rem"/>
                <p style="color: #6a6969; letter-spacing: 0.05rem; font-weight: 450; margin-top: 15px">
                    The exercise list is empty! <br>
                    Looks like your teacher hasn't assigned the assignment yet.
                </p>
            </div>
        @endif
    </div>
@endsection




