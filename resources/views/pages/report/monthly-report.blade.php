@extends( 'pages.layouts.main' )

@section('css-library')
@endsection

@section('css-custom')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content mt-3">
    <div class="container-fluid">
      <div class="card">
        <div class="row p-3">
          <div class="col-sm-12">
            <span class="align-middle">
              <a href="{{ route('home') }}" class="text-purple"><i class="fas fa-home"></i> Home</a> &nbsp;/&nbsp;
              <span class="text-muted">Report and Analytics</span> &nbsp;/&nbsp;
              <span class="text-muted">Monthly {{ $page }}</span>
            </span>
          </div>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- column -->
        <div class="col-12">
          <!-- jquery validation -->
          @if (isAccess('list', $get_menu, auth()->user()->role_id))
            <div class="card card-outline card-purple">
              <div class="card-header h3 font-weight-light">
                <span class="align-middle">
                  Monthly Recap <span class="text-pink font-weight-bold">{{ $page }}</span>
                </span>

                @if (isAccess('read', $get_menu_yearly, auth()->user()->role_id))
                  <div class="card-tools">
                    <a href="{{ route('report.yearly') }}" class="btn bg-purple"><i class="fas fa-chart-line text-sm mr-1"></i> Yearly Report</a>
                  </div>
                @endif
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <div class="row">
                  <div class="col-md-12">
                    <h1 class="text-center text-purple">
                      <b>June</b>, <span class="text-pink">2023</span>
                    </h1>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <h3 class="text-center">
                      Drugs <b class="text-success">In</b>:<br>
                    </h3>
                    <div class="chart">
                      <canvas id="drugIn" height="150" style="display: block;"></canvas>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <h3 class="text-center">
                      Drugs <b class="text-danger">Out</b>:<br>
                    </h3>
                    <div class="chart">
                      <canvas id="drugOut" height="150" style="display: block;"></canvas>
                    </div>
                  </div>
                </div>

                <div class="row mb-4">
                  <div class="col-md-6">
                    <h3 class="text-center">
                      Drugs <b class="text-success">In</b> <b class="text-info">Distribution</b>:<br>
                    </h3>
                    <div class="chart">
                      <canvas id="drugInDist" height="150" style="display: block;"></canvas>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <h3 class="text-center">
                      Drugs <b class="text-danger">Out</b> <b class="text-info">Distribution</b>:<br>
                    </h3>
                    <div class="chart">
                      <canvas id="drugOutDist" height="150" style="display: block;"></canvas>
                    </div>
                  </div>
                </div>

              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-6 col-6">
                    <div class="description-block border-right">
                      {{-- <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span> --}}
                      <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                      <h5 class="description-header">33.000</h5>
                      <span class="description-text">TOTAL DRUGS <b class="text-success">IN</b></span>
                    </div>
                  </div>
                  <div class="col-sm-6 col-6">
                    <div class="description-block">
                      <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                      <h5 class="description-header">26.000</h5>
                      <span class="description-text">TOTAL DRUGS <b class="text-danger">OUT</b></span>
                    </div>
                  </div>
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-footer -->

            </div>
            <!-- /.card -->
          @endif

        </div>
        <!--/.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('js-library')
<!-- ChartJS -->
<script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
@endsection

@section('js-custom')
  <script>
    var drugIn = document.getElementById('drugIn').getContext('2d');
    var drugOut = document.getElementById('drugOut').getContext('2d');
    var drugInDist = document.getElementById('drugInDist').getContext('2d');
    var drugOutDist = document.getElementById('drugOutDist').getContext('2d');

    var drugInChart = new Chart(drugIn, {
      type: 'line',
      data: {
        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
        datasets: [
          {
            label: 'This Month',
            fill: false,
            borderWidth:2,
            borderColor: 'rgba(60, 186, 159, 1)',
            backgroundColor: 'rgba(60, 186, 159, 1)',
            data: ['{{ $storage_in->week_1 }}', '{{ $storage_in->week_2 }}', '{{ $storage_in->week_3 }}', '{{ $storage_in->week_4 }}']
          },
          {
            label: 'Last Month',
            fill: false,
            borderWidth:2,
            borderColor: 'rgba(201, 203, 207, 1)',
            data: ['{{ $storage_in->last_week_1 }}', '{{ $storage_in->last_week_2 }}', '{{ $storage_in->last_week_3 }}', '{{ $storage_in->last_week_4 }}']
          }
        ]
      },
      options: {
        responsive: true,
        tooltips: {
          intersect: false,
          mode: "index",
          position: "nearest",
          callbacks: {}
        },
        scales: {
          xAxes: [
            {
              scaleLabel: {
                display: true,
                labelString: "Time Period"
              },
              stacked: false,
              ticks: {
                autoSkip: true,
                beginAtZero: true
              },
              gridLines: {
                display: false
              }
            }
          ],
          yAxes: [
            {
              scaleLabel: {
                display: true,
                labelString: "Quantity"
              },
              stacked: false,
              ticks: {
                beginAtZero: true
              }
            }
          ]
        },
      }
    });

    var drugOutChart = new Chart(drugOut, {
      type: 'line',
      data: {
        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
        datasets: [
          {
            label: 'This Month',
            fill: false,
            borderWidth:2,
            borderColor: 'rgba(196, 88, 80, 1)',
            backgroundColor: 'rgba(196, 88, 80, 1)',
            data: ['{{ $storage_out->week_1 }}', '{{ $storage_out->week_2 }}', '{{ $storage_out->week_3 }}', '{{ $storage_out->week_4 }}']
          },
          {
            label: 'Last Month',
            fill: false,
            borderWidth:2,
            borderColor: 'rgba(201, 203, 207, 1)',
            data: ['{{ $storage_out->last_week_1 }}', '{{ $storage_out->last_week_2 }}', '{{ $storage_out->last_week_3 }}', '{{ $storage_out->last_week_4 }}']
          }
        ]
      },
      options: {
        responsive: true,
        tooltips: {
          intersect: false,
          mode: "index",
          position: "nearest",
          callbacks: {}
        },
        scales: {
          xAxes: [
            {
              scaleLabel: {
                display: true,
                labelString: "Time Period"
              },
              stacked: false,
              ticks: {
                autoSkip: true,
                beginAtZero: true
              },
              gridLines: {
                display: false
              }
            }
          ],
          yAxes: [
            {
              scaleLabel: {
                display: true,
                labelString: "Quantity"
              },
              stacked: false,
              ticks: {
                beginAtZero: true
              }
            }
          ]
        },
      }
    });

    var drugInDistChart = new Chart(drugInDist, {
      type: 'doughnut',
        data: {
          labels: ["Drug 1", "Drug 2", "Drug 3", "Drug 4", "Drug 5", "Others"],
          datasets: [{ 
            data: [50, 30, 20, 13, 9, 6],
            borderColor:
            [
              'rgba(75, 192, 192, 1)',
              'rgba(153, 102, 255, 1)',
              'rgba(255, 159, 64, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 99, 132, 1)',
              'rgba(255, 206, 86, 1)'
            ],
            backgroundColor:
            [
              'rgba(75, 192, 192, 0.1)',
              'rgba(153, 102, 255, 0.1)',
              'rgba(255, 159, 64, 0.1)',
              'rgba(54, 162, 235, 0.1)',
              'rgba(255, 99, 132, 0.1)',
              'rgba(255, 206, 86, 0.1)'
            ],
            borderWidth: 3,
          }]
        },
      options: {
        legend: {
          display: true,
          position: 'left',
          align: 'start',
          labels: {
            usePointStyle: true
          }
        },
        scales: {
          xAxes: [{ 
            display: false,
          }],
          yAxes: [{
            display: false,
          }],
        }
      },
    });

    var drugOutDistChart = new Chart(drugOutDist, {
      type: 'doughnut',
        data: {
          labels: ["Drug 1", "Drug 2", "Drug 3", "Drug 4", "Drug 5", "Others"],
          datasets: [{ 
            data: [50, 30, 20, 13, 9, 6],
            borderColor:
            [
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(153, 102, 255, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(255, 159, 64, 1)'
            ],
            backgroundColor:
            [
              'rgba(255, 99, 132, 0.1)',
              'rgba(54, 162, 235, 0.1)',
              'rgba(255, 206, 86, 0.1)',
              'rgba(153, 102, 255, 0.1)',
              'rgba(75, 192, 192, 0.1)',
              'rgba(255, 159, 64, 0.1)'
            ],
            borderWidth: 3,
          }]
        },
      options: {
        legend: {
          display: true,
          position: 'left',
          align: 'start',
          labels: {
            usePointStyle: true
          }
        },
        scales: {
          xAxes: [{ 
            display: false,
          }],
          yAxes: [{
            display: false,
          }],
        }
      },
    });

    // Document Ready Function
    $(function() {
      //
    });
  </script>
@endsection