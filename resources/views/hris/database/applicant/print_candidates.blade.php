<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Candidates</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('public/backend/assets/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ asset('public/backend/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('public/backend/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('public/backend/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('public/backend/assets/dist/css/adminlte.min.css') }}">
</head>

<body>
    {{-- {{ dd($uniqueOrders) }} --}}
    <strong>
        <h1 class="text-center m-5">Today's Shortlisted Candidates</h1>
    </strong> <br>
    {{-- <strong>Order Unique ID:</strong> {{ $uniqueDetails[0]->order_unique_id }} <br>
    <strong>Ordered By:</strong> {{ $orderBy->name }} --}}
    


    <table id="orderDetailsTable" class="table table-head-fixed text-nowrap mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Department</th>
                <th>Item</th>
                <th>Unit</th>
                <th>Qty Request</th>
                {{-- <th>Qty Deliver</th> --}}
                {{-- <th>Unit Price</th> --}}
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($uniqueOrders as $order)
                <tr id="tr{{ $order['id'] }}">
                    <td>{{ $i }}</td>
                    <td>{{ $order['department'] }}</td>
                    <td>{{ $order['item'] }}</td>
                    <td>{{ $order['unit'] }}</td>
                    <td>{{ $order['qty_requo'] }}</td>
                    {{-- <td>{{ $order['qty_deliver'] }}</td> --}}
                    {{-- <td> <input type="number" value={{ $order['qty_deliver']?:0 }}></td> --}}
                    {{-- <td>{{ $order['unit_price'] }}</td> --}}
                    <td>{{ $order['remarks'] }}</td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
        </tbody>
    </table>

    <div>
        Venue: {{ $uniqueDetails[0]->venue }} <br>
        Event Starting Time: {{ date('d-m-y h:m:s', strtotime($uniqueDetails[0]->event_starting_date)) }} <br>
        Event Ending Time: {{ date('d-m-y h:m:s', strtotime($uniqueDetails[0]->event_ending_date)) }} <br>
        Event Type: {{ $uniqueDetails[0]->event_type }} <br>
        In Charge: {{ $uniqueDetails[0]->inCharge }} <br>
        Remarks: {{ $uniqueDetails[0]->remarks }} <br>
        {{-- Ordered By: {{ $uniqueOrder['created_by']->name }} <br>
        Ordered At: {{ $tmpUniqueOrder->created_at }} --}}
        {{-- Ordered By: {{ $orderBy->name }} <br> --}}
        Ordered At: {{  $uniqueDetails[0]->created_at }}
        {{-- Deleted By: {{ Auth::user()->name }} <br>
                        Deleted At: {{ $uniqueOrders[0]['deleted_at'] }} --}}
    </div>


    <script src="{{ asset('public/backend/assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('public/backend/assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script src="{{ asset('public/backend/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/backend/assets/dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('public/backend/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/backend/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('public/backend/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}">
    </script>
    <script src="{{ asset('public/backend/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}">
    </script>
    <script src="{{ asset('public/backend/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('public/backend/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>

    <script type="application/javascript">
    window.onafterprint = window.close;
    window.print();
</script>

</body>

</html>
