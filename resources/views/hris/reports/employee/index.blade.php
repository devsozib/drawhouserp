<!DOCTYPE html>
<html>
<head>
    <title>History of {{ $employee->Name }}</title>
    @include('layout/pdfhead')
</head>
<style>
     ul li{
        list-style: none;
        font-size: 13px;
     }
</style>
<body>
    <div class="header">
        @include('layout/pdfheader')
        <h4>Employment History Of {{ $employee->Name }}</h4>        
    </div>

    <div class="row" style="margin-top: 20px;">   
        @if(count($interiviewEvaluations) > 0)
            <div class="interviewFeedBack">
                <br>
                <p>
                    <strong>Average Interview Feedback:</strong>
                </p>
            
                <table border="1">
                    <thead>
                        <tr>
                            <th>Aspect</th>
                            <th>Score</th>
                            <th>Out of</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Appearance</td>
                            <td>{{ $averages['appearance'] }}</td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <td>Attitude & Cooperation</td>
                            <td>{{ $averages['attitude_cooperation'] }}</td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <td>Expression & Communication</td>
                            <td>{{ $averages['expression_communication'] }}</td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <td>Job Knowledge</td>
                            <td>{{ $averages['job_knowledge'] }}</td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <td>Initiative & Decision Making</td>
                            <td>{{ $averages['initiative_decision_making'] }}</td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <td>Dependability & Leadership</td>
                            <td>{{ $averages['dependability_leadership'] }}</td>
                            <td>5</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif
       

        @if($appraisalAverages)
        <div class="interviewFeedBack">
            <br>
            <p>
                <strong>Average Performance Evaluations:</strong>
            </p>    
            <p> 
                <table border="1">
                    <thead>
                        <tr>
                            <th>Topic Name</th>
                            <th>Average</th>
                            <th>Out of</th>
                            <th>Total Evaluation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appraisalAverages as $appraisalId => $average)
                            <tr>                           
                                <td>{{ $average['topic_name'] }}</td>
                                <td>{{ $average['average'] }}</td>
                                <td>5</td>
                                <td>{{ $average['count'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </p>
        </div>         
        @endif


        <div style="font-size: 15px; text-align: center; color: darkorange; margin-top:100px">
            
        </div>       
        @include('layout/pdfprintby')
    </div>
</body>
</html>
