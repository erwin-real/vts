<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<body>
    <img src="{{asset('img/letterhead.jpg')}}" style="width: 100%; height: 100%; opacity: 0.7; position: absolute;" alt="">

    <div style="position: relative; margin-top: 120px;">
        <h1>{{ (Auth::user()->type == 'supervisor') ? Auth::user()->department['name'] : '' }} {{ucfirst(trans($type))}} Ticket Reports</h1>
        <div class="card-body mt-4">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Total Tickets</th>
                    <th>Solved</th>
                    <th>Pending</th>
                </tr>
                </thead>
                <tbody>

                    @php
                        foreach ($tickets as $ticket) {
                            $count = 0;
                            $pending = 0;

                            foreach ($ticket as $item) {
                                if (Auth::user()->type == 'admin' || $item->department['name'] == Auth::user()->department['name']) {
                                    echo '<tr><td>';
                                    if ($type == 'weekly') echo 'Week ';
                                    echo date($format, strtotime($item->created_at)).'</td>';
                                    break;
                                }
                            }

                            foreach ($ticket as $item) {
                                if (Auth::user()->type == 'admin' || $item->department['name'] == Auth::user()->department['name']) {
                                    $count += 1;
                                    $pending += $item->status;
                                }
                            }
                            if ($count > 0) echo '<td>'. $count .'</td><td>'. $pending .'</td><td>'. ($count-$pending) .'</td></tr>';
                        }
                    @endphp

                </tbody>
            </table>
        </div>
    </div>

</body>