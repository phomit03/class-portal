<div>
    <h3> Dear : {{ isset($data['name']) ? $data['name'] : '' }} </h3>
    <p>Notice you have a new assignment that needs to be completed </p>
    <p>{{ isset($data['title']) ? $data['title'] : '' }}</p>
    <p> @if(isset($data['due_date'])) Due date {{$data['due_date']}} @endif</p>
</div>
