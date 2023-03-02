@extends('layouts.app')

@section('title', 'List Subjects')

@section('content')
    <div class="container wrap-list-classes">
        @if (!$subjects->isEmpty())
            <div class="edn-tabs">
                <div id="tab-home-page" class="group-head-tab-control">
                    <div class="session-group ui-tabs-panel ui-widget-content" id="course-member" role="tabpanel" aria-hidden="false" style="" aria-labelledby="session-group-tab">
                        <section class="course-section">
                            <div class="wrap-slider-content">
                                <div class="wrap-course-section">
                                    <div class="list-course row">
                                        @foreach($subjects as $subject)
                                            <article class="course-item col-md-4 col-sm-6 col-lg-3 publish" style="margin: 0 0 30px; padding: 0 15px;">
                                                <div class="wrap-course-item">
                                                    <div class="course-infor" style="padding: 20px">
                                                        <h3 class="course-title mg-b-15 fs-18">
                                                            <a href="{{'class/'. $subject->classes->first()->id}}" title="{{ $subject->name }}" style="font-size: 16px">
                                                                {{ $subject->name }}
                                                            </a>
                                                        </h3>
                                                        <ul class="bottom-course-sum none-list mg-0 fs-14 mg-b-15">
                                                            <li>
                                                                <i class="las la-chalkboard-teacher"></i>Class:&nbsp;
                                                                <a href="{{'class/'. $subject->classes->first()->id}}"
                                                                   class="course-code text-bold decoration-none"
                                                                   title="{{ $subject->classes->first()->name }}">
                                                                    {{ $subject->classes->first()->name }}
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <i class="la la-clock"></i>
                                                                <span title="{{ !empty($subject->created_at) ? formatTime($subject->created_at) : '--' }}">
                                                                    Due Date: {{ !empty($subject->created_at) ? formatTime($subject->created_at) : '--' }}
                                                                </span>
                                                            </li>
                                                            <li>
                                                                <i class="la la-cubes"></i>
                                                                <span title="Number of students: ">Number of assignments: {{$subject->assignments_count}}</span>
                                                            </li>
                                                        </ul>
                                                        <a class="view-detail text-decoration-none fs-14 mg-b-5"
                                                           href="{{ route('student.assignment.show', $subject->id) }}"
                                                           title="View assignment">
                                                            View assignment <i class="las la-arrow-right"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </article>
                                        @endforeach
                                    </div>
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




