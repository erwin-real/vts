<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<body>
<img src="{{asset('img/letterhead.jpg')}}" style="width: 100%; height: 100%; opacity: 0.7; position: absolute;" alt="">

    <div style="position: relative; margin-top: 120px;">
        <h1>{{$type == 'weekly' ? 'Week ' : ''}}{{$date}} {{ (Auth::user()->type == 'supervisor') ? Auth::user()->department['name'] : '' }} Ticket Reports</h1>
        <div class="card-body mt-2">
            <table class="table table-hover table-responsive-lg">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Created by</th>
                    <th>Created at</th>
                    <th>Department</th>
                    <th>Solved at</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tickets as $ticket)
                    @if($ticket->department['name'] == Auth::user()->department['name'] || Auth::user()->type == 'admin' || Auth::user()->id == $ticket->user['id'])
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->title }}</td>
                            <td>{{ $ticket->status ? 'Pending' : 'Solved' }}</td>
                            <td>{{ $ticket->user['fname'] }} {{ $ticket->user['lname'] }}</td>
                            <td>{{date('D M d,Y H:i', strtotime($ticket->created_at))}}</td>
                            <td>{{ $ticket->department['name'] }}</td>
                            <td>{{ ($ticket->solved_at != null) ? date('D M d,Y H:i', strtotime($ticket->solved_at)) : 'N/A' }}</td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>