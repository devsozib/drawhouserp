@extends('layout.app')
@section('title', 'HRIS | Applicant')
@section('content')
    <style>
        /* External CSS file (styles.css) */
        .rating {
            display: inline-block;
            font-size: 30px;
        }

        .star {
            cursor: pointer;
            color: #ccc;
        }

        .star.selected {
            color: gold; /* Change this to your desired color */
        }

        .star:hover,
        .star.selected {
            color: #ffcc00;
        }
    </style>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0" style="text-align: right;">Applicant details of <span
                            class="text-primary">{{ $applicant->Name }}</span></h1> --}}
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('employee/dashboard') !!}">Employee</a></li>
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Performance</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @forelse ($performanceDetails as $performance)
                                <div class="row">
                                    <div class="col-md-4 mt-2">
                                        <label>Evaluation Month: {{ \Carbon\Carbon::createFromFormat('Y-m', $performance['performance']['date'])->format('F Y') }} </label>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="text-bold">Total Rating: {{ $performance['lastTotalTopicRating'] }}</p>
                                        <p class="text-bold">Total Achieve Rating: {{ $performance['lastTotalAchiveTopicRating'] }}</p>
                                        <p class="text-bold">Step: {{ $performance['performance']['step'] }}</p>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Topic</th>
                                                    <th>Rating</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($performance['details'] as $detail)
                                                    <tr>
                                                        <td>{{ $detail['name'] }}</td>
                                                        <td>{{ $detail['rating'] }}/5</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <hr>
                            @empty
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="text-center">No Performance Records!</h5>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
