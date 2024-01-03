    <div class="row">
        <div class="col-12 col-md-4">
        <div class="card card-danger">
            <div class="card-header">
            <h3 class="card-title">Donut Chart</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
                </button>
            </div>
            </div>
            <div class="card-body">
            <div class="chartjs-size-monitor">
                <div class="chartjs-size-monitor-expand">
                <div class=""></div>
                </div>
                <div class="chartjs-size-monitor-shrink">
                <div class=""></div>
                </div>
            </div>
            <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 580px;" width="725" height="312" class="chartjs-render-monitor"></canvas>
            </div>
        </div>
        </div>

        <div class="col-12 col-md-8">
            <div class="card card-danger">
                <div class="card-header">
                <h3 class="card-title">Category wise Pie Chart</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
                </div>
                <div class="card-body">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                        <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                        <div class=""></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6" style="display: flex;">
                            <div style="max-height: 250px; overflow-y: auto; " class="d-none d-md-block">
                                <input onkeyup="searchCategory(this)" type="text" style="border: 2px solid #4a7ad6; position: sticky; top: 0;" placeholder="Search">
                                @foreach ($categories as $key => $category)
                                    <p id="category{{ $key }}" onclick="generateCategoryWisePaiChart({{ $key }})" class="categoryList" style="cursor:pointer; padding: 3px 20px; background-color:#1452cac4; margin:1px 0; color:#fff; text-align:center; font-weight: bold;">{{ $category }}</p>
                                @endforeach
                            </div>

                            <div class="d-md-none" style="width:100%;">
                                <select class="js-example-basic-single " style="width:100%;" onchange="generateCategoryWisePaiChart(this.value)" name="" id="">
                                    <option value="">--Select--</option>
                                    @foreach ($categories as $key => $category)
                                        <option value="{{ $key }}">{{ $category }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div  class="col-12 col-md-6 " style="border: 1px solid #000;">
                            <h4 id="categoryName" style=" text-align: center;"></h4>
                            @foreach ($categoryWiseProductIds as $category => $value)
                                    <div id="categoryWiseChart{{ $category }}" class="categoryWiseChart" style="display: none;">
                                        <canvas id="pieChart{{ $category }}" style=" min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 580px;" width="725" height="312" class="chartjs-render-monitor"></canvas>
                                    </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card card-success">
                <div class="card-header">
                <h3 class="card-title">POS and Web</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
                </div>
                <div class="card-body">
                <div class="chart">
                    <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                        <div class=""></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                        <div class=""></div>
                    </div>
                    </div>
                    <canvas id="posOrWeb" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 580px;" width="725" height="312" class="chartjs-render-monitor"></canvas>
                </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card card-success">
                <div class="card-header">
                <h3 class="card-title">Dine In or Delivered</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
                </div>
                <div class="card-body">
                <div class="chart">
                    <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                        <div class=""></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                        <div class=""></div>
                    </div>
                    </div>
                    <canvas id="dineinOrDelivered" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 580px;" width="725" height="312" class="chartjs-render-monitor"></canvas>
                </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col" style="text-align: center;">Sl</th>
                    <th scope="col" style="text-align: center;">Category</th>
                    <th scope="col" style="text-align: center;">Product</th>
                    <th scope="col" style="text-align: center;">Quantity</th>
                    {{-- <th scope="col" style="text-align: center;">Amount</th> --}}
                    <th scope="col" style="text-align: center;">% of sales</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($categoryWiseItem as $items)
                    @foreach ($items as $item)
                        <tr >
                            @if($loop->index == 0)
                            <th rowspan="{{ count($items) }}" style="border: 1px solid #000;text-align: center; vertical-align: middle;">{{ $loop->index + 1 }}</th>
                            <td rowspan="{{ count($items) }}" style="border: 1px solid #000;text-align: center; vertical-align: middle;">{{ $libCategories[$item->category_id] }}</td>
                            @endif
                            <td style="border: 1px solid #000;">{{ $products[$item->product_id] }}</td>
                            <td style="border: 1px solid #000;">{{ $item->product_quantity }}</td>
                            {{-- <td style="border: 1px solid #000;">{{ $item->product_total_price }}</td> --}}
                            <td style="border: 1px solid #000;">{{  number_format((($item->product_quantity/$total) * 100), 2) }}%</td>

                        </tr>
                    @endforeach
                @endforeach

            </tbody>
          </table>
    </div>


  <script>


        generateCategoryWisePaiChart({{ array_key_first($categories) }});

    $(function () {

      var areaChartData = {
        labels  : ['Orders Compair'],
        datasets: [
          {
            label               : 'Pos Orders(%)',
            backgroundColor     : 'rgba(60,141,188,0.9)',
            borderColor         : 'rgba(60,141,188,0.8)',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data                : [{{ $posOrder }},1]
          },
          {
            label               : 'Web Orders(%)',
            backgroundColor     : 'rgba(210, 214, 222, 1)',
            borderColor         : 'rgba(210, 214, 222, 1)',
            pointRadius         : false,
            pointColor          : 'rgba(210, 214, 222, 1)',
            pointStrokeColor    : '#c1c7d1',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data                : [{{ $webOrder }},1]
          },
        ]
      }

      var areaChartOptions = {
        maintainAspectRatio : false,
        responsive : true,
        legend: {
          display: false
        },
        scales: {
          xAxes: [{
            gridLines : {
              display : false,
            }
          }],
          yAxes: [{
            gridLines : {
              display : false,
            }
          }]
        }
      }


      var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
      var donutData        = {
        labels: [
            @foreach ($categoryWiseSales as $category_Id => $sales)
                '{{ $libCategories[$category_Id] }}({{ $sales }}%)',
            @endforeach
        ],
        datasets: [
          {
            data: [
                @foreach ($categoryWiseSales as $category_Id => $sales)
                    {{ $sales }},
                @endforeach
            ],
            backgroundColor : [
                @foreach ($categoryColor as $color)
                    '{{ $color }}',
                @endforeach
            ],
          }
        ]
      }

      var donutOptions     = {
        maintainAspectRatio : false,
        responsive : true,
      }

      new Chart(donutChartCanvas, {
        type: 'doughnut',
        data: donutData,
        options: donutOptions
      })

      //-------------
      //- PIE CHART -
      //-------------
      @foreach ($categoryWiseProductIds as $category => $productsIds)
        var pieChartCanvas{{ $category }} = $('#pieChart{{ $category }}').get(0).getContext('2d');


        var pieData{{ $category }}        = {
            labels: [
                @foreach ($productsIds as $product_Id)
                    '{{ $products[$product_Id] }}({{ $productWiseSales[$product_Id] }}%)',
                @endforeach
            ],
            datasets: [
            {
                data: [
                    @foreach ($productsIds as $product_Id)
                        {{  $productWiseSales[$product_Id] }},
                    @endforeach
                ],
                backgroundColor : [
                    @php $dx=0; @endphp
                    @foreach ($categoryWiseProductColor[$category] as $color)
                        '{{  $color }}',
                    @endforeach
                ],
            }
            ]
        };

        var pieOptions{{ $category }}     = {
            maintainAspectRatio : false,
            responsive : true,
        }

        new Chart(pieChartCanvas{{ $category }}, {
            type: 'pie',
            data: pieData{{ $category }},
            options: pieOptions{{ $category }}
        });

      @endforeach



      var posOrWebCanvas = $('#posOrWeb').get(0).getContext('2d');

      var posOrWebPieData        = {
            labels: ['POS', 'Web'],
            datasets: [
            {
                data: [
                    {{ $posOrder }}, {{ $webOrder }},
                ],
                backgroundColor : [
                        '#e63737','green'
                ],
            }
            ]
        };

        var posOrWebPieOptions    = {
            maintainAspectRatio : false,
            responsive : true,
        }

        new Chart(posOrWebCanvas, {
            type: 'pie',
            data: posOrWebPieData,
            options: posOrWebPieOptions
        });


        var dineinOrDeliveredCanvas = $('#dineinOrDelivered').get(0).getContext('2d');

        var dineinOrDeliveredPieData = {
            labels: ['Dine In', 'Delivered'],
            datasets: [
                {
                    data: [
                        {{ $dineIn }}, {{ $delivered }},
                    ],
                    backgroundColor : [
                            '#911a62c4','#0b7e99c4'
                    ],
                }
            ]
        };

        var dineinOrDeliveredPieOptions    = {
            maintainAspectRatio : false,
            responsive : true,
        }

        new Chart(dineinOrDeliveredCanvas, {
            type: 'pie',
            data: dineinOrDeliveredPieData,
            options: dineinOrDeliveredPieOptions
        });





      //-------------
      //- BAR CHART -
      //-------------

    //   var barChartCanvas = $('#barChart').get(0).getContext('2d')
    //   var barChartData = $.extend(true, {}, areaChartData)
    //   var temp0 = areaChartData.datasets[0]
    //   var temp1 = areaChartData.datasets[1]
    //   barChartData.datasets[0] = temp1;
    //   barChartData.datasets[1] = temp0;

    //   var barChartOptions = {
    //     responsive              : true,
    //     maintainAspectRatio     : false,
    //     datasetFill             : false
    //   }

    //   new Chart(barChartCanvas, {
    //     type: 'bar',
    //     data: barChartData,
    //     options: barChartOptions
    //   })


    });
</script>
