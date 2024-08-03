<!-- Navbar -->
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
  <div class="container">
    <a href="{{ url('') }}" class="navbar-brand" style="width: 15%">
      {{-- <img src="{{ url('') }}/assets/dist/img/B-logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
      <span class="brand-text font-weight-light"><i class="fas fa-capsules text-pink"></i> <b>Drug</b>Vault</span>
    </a>

    <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse order-3" id="navbarCollapse">
      <!-- Left navbar links -->
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <a href="#" class="nav-link"><b>Why DrugVault</b></a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link"><b>Features</b></a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link"><b>Pricing</b></a>
        </li>
        <li class="nav-item">
          <a target="_blank" rel="noopener noreferrer" href="https://github.com/novalalthoff" class="nav-link"><b>Contact Us</b></a>
        </li>
      </ul>
    </div>

    <!-- Right navbar links -->
    <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto" style="width: 20%">
      <!-- Login Modal Trigger -->
      <li class="nav-item">
        <a class="nav-link text-purple" href="#" data-toggle="modal" data-target="#modal-default">
          <i class="fas fa-door-open"></i> <b>Log In</b>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-pink" href="#" data-toggle="modal" data-target="#modal-default">
          <b class="opacity-50">Get Started</b>
        </a>
      </li>
    </ul>
  </div>
</nav>
<!-- /.navbar -->
