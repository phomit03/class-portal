@extends('layouts.app')

@section('title', 'Assignments - Details')

@section('content')
    <div class="container">
        <article id="content-lesson-detail" class="content-lesson-detail detail-section">
            <ul class="breadcrumb none-list mg-0 mg-b-25 fs-16 text-normal"><li><a href="/home" class="text-decoration-none" title="Home">Home</a></li>
                <li class="separator">/</li>
                <li>
                    <a href="{{ route('student.assignment.show_all') }}" class="text-decoration-none" title="Assignment">
                        Assignments
                    </a>
                </li>
                <li class="separator">/</li>
                <li>
                    <span title="{{ $assignment->title }}">{{ $assignment->title }}</span>
                </li>
            </ul>

            <!--title-->
            <div class="entry-title edn-lesson-title fs-24 mg-b-16">
                <h1 class="left wrap-activity-title mg-0 fs-24 text-semibold"><span class="mg-r-5">{{ $assignment->title }}</span></h1>
            </div>

            <div id="main-content-lesson" class="main-content-lesson row">
                <div class="col-12 col-lg-12 col-xl-12">
                    <div id="live-stream-section" class="view-live-stream hidden">
                        <div class="wrap-view-live-stream">
                        </div>
                    </div>
                    <div id="live-stream-notify-section" class="mg-b-25 hidden">
                    </div>
                    <div class="entry-lesson-content">
                        <div class="wrap-main-activity">
                            <div class="wrap-entry-lesson-content">
                                <h4 class="mg-b-8">Content</h4>
                                <div class="wrap-activity-content">
                                    <p>{!! empty($assignment->description) ? '--' : $assignment->description !!}</p>
                                </div>
                            </div>
                        </div>

                        <div id="assignment-detail-content" class="assignment-detail-content">
                            <div class="assignment-overview mg-b-30">
                                <div class="attach-teacher mg-b-16">
                                    <label class="text-semibold">Additional files:</label>
                                    <div class="attachment-teacher-wrap">
                                        <a target="_blank" href="{{ asset('uploads/assignments/' . $assignment->source) }}"
                                           title="{{ $assignment->source }}" class="text-decoration-none text-lightbold link-attach assignment-downloadable" download="">
                                            {{ !($assignment->source) ? '--' : $assignment->source }}
                                        </a>
                                    </div>
                                </div>
                                <div class="duedate mg-b-16">
                                    <label class="text-semibold">Due date:</label>
                                    @if (!empty($assignment->due_date))
                                        <span class="label-duedate">{{ formatTime($assignment->due_date) }}</span>
                                    @endif
                                </div>

                                @if (
                                    ((!empty($assignment->due_date) && checkTime($assignment->due_date) <= 0)  || ($result && !empty($result->mark)))
                                    || (empty($assignment->due_date) && $result && !empty($result->mark))
                                )

                                @else
                                    <div class="btn input-group-btn" style="font-size: 18px; width: 100%; border: #c2d4f7 1px dashed">
                                        <i class="la la-clock-o" style="font-size: 20px"></i> Time remaining:
                                        <p style="margin: 10px 0; font-size: 25px" id="demo"></p>
                                    </div>
                                @endif

                            </div>
                            <div class="hr-assignment mg-b-30"></div>

                            <div class="submit-for-student col-lg-8 col-xl-8">
                                <h3 class="mg-0" >Your assignment: </h3>
                                <br>
                                <!--nếu mà hết giờ or được add điểm-->
                                @if (
                                    ((!empty($assignment->due_date) && checkTime($assignment->due_date) <= 0)  || ($result && !empty($result->mark)))
                                    || (empty($assignment->due_date) && $result && !empty($result->mark))
                                )
                                    <div class="submit-overview">
                                        <div class="mg-b-10">
                                            <i class="la la-calendar-check-o"></i>
                                            <span class="top text-lightbold">
                                                Mark:
                                            </span>
                                            @if (!empty($result->mark))
                                                <span class="fs-20 text-bold blue-02">
                                                    {{ $result->mark . '/100'}}
                                                </span>
                                            @else
                                                <span class="fs-16 text-danger">
                                                    __/100
                                                </span>
                                            @endif
                                        </div>
                                        <div class="mg-b-10">
                                            <label class="top text-lightbold">
                                                Lecturer comments:
                                            </label>
                                            @if (!empty($result->comments))
                                                <p class="fs-14 text-lightbold blue-02">
                                                    {{ $result->comments }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="submit-overview mg-b-30">
                                        <div class="mg-b-10">
                                            <p class="top text-lightbold">
                                                Submission status:
                                            </p>
                                            <span class="fs-14 text-lightbold {{ ($result && $result->status == 1) ? 'my-submission-status submitted' : 'my-submission-status' }}">
                                                {{ ($result && $result->status == 1) ? 'Submitted' : 'Not Submit'}}
                                            </span>
                                        </div>
                                        <div class="mg-b-10">
                                            <p class="top text-lightbold">
                                                Submission time:
                                            </p>
                                            <span class="my-submission-time text-bold">{{ ($result && $result->status == 1) ? $result->updated_at : '--' }}</span>
                                        </div>
                                        <div class="mg-b-10">
                                            <p class="top text-lightbold">
                                                Link/file assignment:
                                            </p>
                                            @if (!empty($result->source))
                                                <p>
                                                    <a href="{!! asset('uploads/assignments/' . $result->source) !!}" target="_blank">
                                                        {{ $result->source }}
                                                        <a href="{!! asset('uploads/assignments/' . $result->source) !!}" download="">
                                                            <i class="la la-download" style="font-size: 27px"></i>
                                                        </a>
                                                    </a>
                                                </p>
                                            @else
                                                <p>
                                                    <a href="{!! asset('uploads/assignments/' . $result->source) !!}" target="_blank">
                                                        --
                                                    </a>
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                @else
                                    <!--da nop, nhung con time-->
                                    @if( $result && $result->status == 1  )
                                        <div class="submit-overview mg-b-30">
                                            <div class="mg-b-10">
                                                <p class="top text-lightbold">
                                                    Submission status:
                                                </p>
                                                <span class="fs-14 text-lightbold my-submission-status submitted">Submitted</span>
                                            </div>
                                            <div class="mg-b-10">
                                                <p class="top text-lightbold">
                                                    Submission time:
                                                </p>
                                                <span class="my-submission-time text-bold">{{ $result->updated_at }}</span>
                                            </div>
                                            <div class="mg-b-10">
                                                <p class="top text-lightbold">
                                                    Link/file assignment:
                                                </p>
                                                @if (!empty($result->source))
                                                    <p>
                                                        <a href="{!! asset('uploads/assignments/' . $result->source) !!}" target="_blank">
                                                            {{ $result->source }}
                                                            <a href="{!! asset('uploads/assignments/' . $result->source) !!}" download="">
                                                                <i class="la la-download" style="font-size: 27px"></i>
                                                            </a>
                                                        </a>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    <!--chua nop, nhung con time-->
                                    <div class="form">
                                        <!--form-->
                                        <form role="form" action="{{ route('student.assignment.result', $assignment->id) }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method("post")

                                            <label for="inputEmail3" class="control-label default">Source <sup class="text-danger">(*)</sup></label>

                                            <div class="mg-b-20">
                                                <div style="margin-bottom: 10px">
                                                    <span class="text-danger"> {{ $errors->first('source') }}</span>
                                                </div>
                                                <select id="mySource" class="form-select btn-more-actions {{ $errors->first('source') ? 'btn-danger' : '' }}"
                                                        aria-label="Default select example" style="background-color: #c2d4f7; color: black !important;">
                                                    <option value="">--Choose a sending method--</option>
                                                    <option value="upload">method: Uploads</option>
                                                    <option value="link">method: Links</option>
                                                </select>
                                                <div style="margin-top: 10px">
                                                    @if (!empty($result->source))
                                                        <p><a href="{!! asset('uploads/assignments/' . $result->source) !!}" target="_blank">{{ $result->source }}</a></p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div id="uploadFiles" class="note" style="display: none">
                                                <div class="form-group {{ $errors->first('source') ? 'has-error' : '' }} ">
                                                    <input type="file" class="form-control" name="source" value="{{ old('source') }}">
                                                    <div>
                                                        @if ($errors->has('source'))
                                                            <span class="help-block"><strong>{{ $errors->first('source') }}</strong></span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="linkUrl" class="note" style="display: none">
                                                <p>
                                                    If you don't have a link to your exercise, please
                                                    <a href="https://docs.google.com/document/d/1SwMoPeWEQX5KuUTZhSeA5FlMk-aIrUfEPW2uiUqvSYo/edit" target="_blank">
                                                        click here
                                                    </a>
                                                    to create an answer or
                                                    <a href="https://drive.google.com/drive/u/0/my-drive" target="_blank">
                                                       click here
                                                    </a>
                                                    to upload your assignment directory. Then export the link to paste in the box below, thank you very muchhhh !!
                                                </p>
                                                <div class="form-group {{ $errors->first('source') ? 'has-error' : '' }}">
                                                    <input type="text" class="form-control" name="source" placeholder="https://..." value="{{ old('source') }}">
                                                    <div>
                                                        @if ($errors->has('source'))
                                                            <span class="help-block"><strong>{{ $errors->first('source') }}</strong></span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>


                                            <!--ck editer-->
                                            <div class="form-group {{ $errors->first('description') ? 'has-error' : '' }}">
                                                <label for="inputEmail3" class="control-label default">Description</label>
                                                <div>
                                                    <textarea name="description" style="resize:vertical" id="description" class="form-control" placeholder="">
                                                        {{ old('description', isset($result) ? $result->description : '') }}
                                                    </textarea>
                                                    <div>
                                                        @if ($errors->has('description'))
                                                            <span class="help-block"><strong>{{ $errors->first('description') }}</strong></span>
                                                        @endif
                                                    </div>

                                                    <script>
                                                        ckeditor(description);
                                                    </script>
                                                </div>
                                            </div>

                                            <br>

                                            <div class="submit-area mg-b-20 align-right">
                                                <div style="cursor: not-allowed; display: inline-block;">
                                                    <button class="btn submit-results white-color" type="submit">Submit</button>
                                                </div>
                                            </div>

                                        </form>
                                        <!--end form-->
                                    </div>

                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </article>
    </div>

    <!-- Display the countdown timer in an element -->
    <script>
        var countDownDate = {!! json_encode(formatTime($assignment->due_date)) !!};

        var updated = {!! json_encode($assignment->updated_at) !!};

        var checkLoad =0;

        // Update the count down every 1 second
        var x = setInterval(function() {
            checkLoad++;
            // Find the distance between now an the count down date
            var distance = new Date(countDownDate) - new Date();

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Output the result in an element with id="demo"
            document.getElementById("demo").innerHTML = days + "d : " + hours + "h : " +
                minutes + "m : " + seconds + "s ";

            // If the count down is over, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("demo").innerHTML = "<span class='red-color'>EXPIRED !!</span>";
                if(checkLoad>1)
                    window.location.reload();
            }
        }, 1000);
    </script>
@endsection

@push('scripts')
    <script>
        $('.note').hide();
        $('#mySource').change(function() {
            value = $(this).val();
            $('#uploadFiles').hide();
            $('#linkUrl').hide();
            if (value=="upload") {
                $('#uploadFiles').show();
            }else if (value == "link") {
                $('#linkUrl').show();
            }
        });
    </script>
@endpush



