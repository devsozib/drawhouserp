<!DOCTYPE html>
<html>
<head>
    <title>HRIS || Attendance Reports</title>
    @include('layout/pdfhead')
</head>
<body>
    <div class="header">
        @include('layout/pdfheader')
        @if($title==1)
            Job Card
        @elseif($title==2)
            {!! $caption !!} <br>  Date: {!! date('d-m-Y', strtotime($date)) !!}
        @endif
        </p>
    </div>

    <div class="row" style="margin-top: 10px;">
        @if($title==2 && count($employees) > 0)
            
        @else
            <div style="font-size: 15px; text-align: center; color: darkorange; margin-top:100px">No Information Found With Provided Data Combination</div>
        @endif
        @include('layout/pdfprintby')
    </div>
</body>
</html>
