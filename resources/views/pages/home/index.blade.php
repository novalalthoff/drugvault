@extends( 'pages.layouts.main' )

@section('css-library')
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
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
              <span class="text-muted"><i class="fas fa-tachometer-alt"></i> Dashboard</a></span>
            </span>
          </div>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  @if (isAccess('read', $get_menu, auth()->user()->role_id))
    <section class="content">
      <div class="container-fluid">

        <!-- Small boxes (Stat box) -->
        <div class="row">

          <div class="col-lg-3 col-6">
            <div class="small-box small-box-outline bg-light">
              <div class="inner">
                <div class="d-flex">
                  <div class="mr-auto font-weight-bold text-pink" style="font-size: 30px">Paratusin</div>
                  <div class="align-self-center" style="font-size: 20px"><b>115</b> <small class="text-pink">pcs</small></div>
                </div>
                <div class="d-flex">
                  <div class="mt-auto mr-auto"><span class="text-pink">Exp</span>: <b>20-11-2023</b></div>
                  <div class="mt-auto">
                    <h3 class="mb-0 text-danger" style="text-align: end">23</h3>
                    <small style="font-size: 15px"><b class="text-pink">days</b> remaining</small>
                  </div>
                </div>
              </div>
              <div class="icon">
                  <i class="fas fa-exclamation-triangle mr-5" style="color: rgba(255, 105, 180, 0.5)"></i>
              </div>
              <a href="#" class="small-box-footer text-danger">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box small-box-outline bg-light">
              <div class="inner">
                <div class="d-flex">
                  <div class="mr-auto font-weight-bold text-purple" style="font-size: 30px">Sanbe P.</div>
                  <div class="align-self-center" style="font-size: 20px"><b>1.140</b> <small class="text-purple">pcs</small></div>
                </div>
                <div class="d-flex">
                  <div class="mt-auto mr-auto"><span class="text-purple">Exp</span>: <b>20-11-2023</b></div>
                  <div class="mt-auto">
                    <h3 class="mb-0 text-danger" style="text-align: end">29</h3>
                    <small style="font-size: 15px"><b class="text-purple">days</b> remaining</small>
                  </div>
                </div>
              </div>
              <div class="icon">
                  <i class="fas fa-exclamation-triangle mr-5" style="color: rgba(138, 43, 226, 0.4)"></i>
              </div>
              <a href="#" class="small-box-footer text-danger">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

        </div>
        <!-- /.row -->

      </div><!-- /.container-fluid -->
    </section>
  @endif
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('js-library')
@endsection

@section('js-custom')
@endsection