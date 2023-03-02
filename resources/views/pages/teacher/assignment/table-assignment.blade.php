<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col" style="width: 5%">STT</th>
        <th scope="col">Title</th>
        <th scope="col">Class</th>
        <th scope="col">Source</th>
        <th scope="col">Due date</th>
        <th scope="col">Subject</th>
        @if (Auth::user()->role == 'teacher')
        <th scope="col" style="width: 12%">Action</th>
        @endif
    </tr>
    </thead>
    <tbody>
    @if (!$assignments->isEmpty())
        @php $i = $assignments->firstItem(); @endphp
        @foreach($assignments as $assignment)
            <tr>
                <th scope="row" style="vertical-align: middle">{{ $i }}</th>
                <td style="vertical-align: middle">{{ $assignment->title }}</td>
                <td style="vertical-align: middle">{{ isset($assignment->classes) ? $assignment->classes->name : '' }}</td>
                <td style="vertical-align: middle"><a href="{!! asset('uploads/assignments/' . $assignment->source) !!}" target="_blank">{!! $assignment->source !!}</a></td>
                <td style="vertical-align: middle">{{ !empty($assignment->due_date) ? convertDatetimeLocal($assignment->due_date) : '' }}</td>
                <th style="vertical-align: middle">{{ isset($assignment->subject) ? $assignment->subject->name : ''  }}</th>
                @if (Auth::user()->role == 'teacher')
                <td style="vertical-align: middle;" class="btn-fix">
                    <a href="{{ route('teacher.assignment.answers', $assignment->id) }}" class="btn btn-success btn-sm"><i class="fa fa-fw fa-eye"></i></a>

                    <a class="btn btn-primary btn-sm" href="{{ route('teacher.assignment.update', $assignment->id) }}">
                        <i class="fas fa-pencil-alt"></i>
                    </a>

                    <a class="btn btn-danger btn-sm btn-delete btn-confirm-delete"
                       href="{{ route('teacher.assignment.delete', $assignment->id) }}"
                       onclick="return confirm('You want delete assignment id = {{$i}} in subject: {{$assignment->subject->name}}')"
                    >
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
                @endif
            </tr>
            @php $i++ @endphp
        @endforeach
    @endif
    </tbody>
</table>
@if($assignments->hasPages())
    <div class="pagination float-right margin-20">
        {{ $assignments->appends($query = '')->links() }}
    </div>
@endif
