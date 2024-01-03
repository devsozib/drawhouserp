

    <style>
        @page {
            size: auto;
            /* margin: 0mm; */
            /* size: A4 portrait; */
            margin: 20px;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
                /* width: 100%; */
            }
        }

        .fk-print__title {
        font-size: 28px;
            line-height: 1;
        }
        .fk-print-text--bold {
            font-weight: 600;
        }
        .fk-print-text {
            font-family: "Roboto Mono", monospace;
        }
        .text-center {
            text-align: center !important;
        }
        .text-uppercase {
            text-transform: uppercase !important;
        }
        .mb-2 {
            margin-bottom: 0.5rem !important;
        }

        .fk-print-text {
            font-family: "Roboto Mono", monospace;
        }
        .xsm-text {
            font-size: 12px;
        }
        .text-center {
            text-align: center !important;
        }
        .text-capitalize {
            text-transform: capitalize !important;
        }
        .mb-0 {
            margin-bottom: 0 !important;
        }
        td,th {
            text-transform: capitalize !important;
            font-family: "Roboto Mono", monospace;
        }
    </style>
    {{-- <link rel="stylesheet" href="{{ asset('pos/style.css') }}"> --}}







    <div>
        <div class="fk-print t-pt-30 t-pb-30">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">

                        <span class="d-block fk-print-text fk-print-text--bold text-uppercase fk-print__title text-center mb-2">{{ getHostInfo()['name'] }}</span>
                        <p class="mb-0 xsm-text fk-print-text text-center text-capitalize">{{ getHostInfo()['location'] }}</p>
                        <p class="mb-0 xsm-text fk-print-text text-center text-capitalize" id="report_type">(Daily Sales report)</p>
                        <p class="mb-0 xsm-text fk-print-text text-center text-capitalize" id="date_range">Date: {{ date('Y-m-d') }}</p>

                        <div class="row">
                            <div class="col" style="padding:15px; padding-top: 0px; padding-bottom: 0px;">
                                <table style="width: 20%; min-width: 300px;">
                                    <thead>
                                        <tr>
                                            <th style="text-align: left; ">Total</th>
                                            <th colspan="2" style="text-align: right; ">{{ $totalSales }}</th>
                                        </tr>
                                        <tr>
                                            <th style="text-align: left; ">Retail</th>
                                            <th style="text-align: left; "></th>
                                            <th style="text-align: right; ">{{ $retail }}</th>
                                        </tr>
                                        <tr>
                                            <th style="text-align: left; ">Wholesale</th>
                                            <th style="text-align: left; "></th>
                                            <th style="text-align: right; ">{{ $wholesale }}</th>
                                        </tr>
                                        <tr>
                                            <th style="text-align: left; ">Corporate</th>
                                            <th style="text-align: left; "></th>
                                            <th style="text-align: right; ">{{ $corporate }}</th>
                                        </tr>
                                        <tr>
                                            <th style="text-align: left; ">Online</th>
                                            <th style="text-align: left; ">{{ numberFormat(($onlineSales/divisor($totalSales)*100),2) }}% </th>
                                            <th style="text-align: right; ">{{ $onlineSales }}</th>
                                        </tr>
                                        <tr>
                                            <th style="text-align: left; ">Dine In</th>
                                            <th style="text-align: left; ">{{  numberFormat(($dineInSales/divisor($totalSales)*100),2) }}%</th>
                                            <th style="text-align: right; ">{{ $dineInSales }}</th>
                                        </tr>
                                        <tr>
                                            <th style="text-align: left; ">Discount</th>
                                            <th style="text-align: left; ">{{  numberFormat(($discount/(divisor($totalSales+$discount))*100),2) }}%</th>
                                            <th style="text-align: right; ">{{ $discount }}</th>
                                        </tr>
                                        <tr>
                                            <th style="text-align: left; ">Complimentary</th>
                                            <th style="text-align: left; ">{{  numberFormat(($complimentary/(divisor($totalSales+$discount+$complimentary))*100),2) }}%</th>
                                            <th style="text-align: right; ">{{ $complimentary }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-12 col-md-6 " style="padding:15px; padding-top: 0px;">
                                <table style="width: 100%">
                                    <thead>
                                        <tr><th colspan="3" style="text-align: left; color: red;">Payment Method Summary</th></tr>
                                        <tr><th colspan="3" ></th></tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($methodCategoryWiseSales as $sales)

                                            <tr>
                                                <td style="text-align: left;">{{ $sales['name'] }}</td>
                                                <td style="text-align: left;">{{ numberFormat((($sales['amount'] / divisor($totalSales)) * 100), 2) }}%</td>
                                                <td style="text-align: right;">{{ $sales['amount'] }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <div class="col-12 mt-0" style="border-bottom: 1px dashed"></div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td style="text-align: left; "><b>Total</b></td>
                                            <td colspan="2" style="text-align: right;"><b>{{ $totalSales }}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12 col-md-6" style="padding:15px; padding-top: 0px;">
                                <table style="width: 100%">
                                    <thead>
                                        <tr><th colspan="3" style="text-align: left; color: red;">Payment Method Details</th></tr>
                                        <tr><th colspan="3" ></th></tr>
                                    </thead>
                                    <tbody >
                                        @php
                                            $total = 0;
                                        @endphp
                                        {{-- @foreach ($methodWiseSales as $sales)
                                            @php
                                                $total += $sales['amount'];
                                            @endphp
                                            <tr>
                                                <td style="text-align: left;">{{ $sales['name'] }}</td>
                                                <td style="text-align: right;">{{ $sales['amount'] }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <div class="col-12 mt-0" style="border-bottom: 1px dashed"></div>
                                                </td>
                                            </tr>
                                        @endforeach --}}

                                        @foreach ($methodCategoryWiseSales as $sales)
                                            @if($loop->index > 0) <tr ><td colspan="3" ></td></tr> @endif
                                            <tr >
                                                <td colspan="3" style="text-align: left;"><b>{{ $sales['name'] }}</b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <div class="col-12 mt-0" style="border-bottom: 1px dashed"></div>
                                                </td>
                                            </tr>
                                            @foreach ($sales['method'] as $method)

                                                <tr>
                                                    <td style="text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;{{ $methodWiseSales[$method]['name'] }}</td>
                                                    <td style="text-align: left;">{{ numberFormat((($methodWiseSales[$method]['amount'] / divisor($totalSales)) * 100), 2) }}%</td>
                                                    <td style="text-align: right;">{{ $methodWiseSales[$method]['amount'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <div class="col-12 mt-0" style="border-bottom: 1px dashed"></div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                        <tr>
                                            <td style="text-align: left;"><b>Total</b></td>
                                            <td colspan="2" style="text-align: right;"><b>{{ $totalSales }}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>



                        <div class="d-print-none">
                            <button onclick="print()" class="btn btn-sm btn-primary mt-2">Print</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="application/javascript">

       function print(){
            window.onafterprint = window.close;
            window.print();
        }



    </script>

