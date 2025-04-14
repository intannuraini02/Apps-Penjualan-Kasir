@extends('template')

@section('main-content')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-xl-12 col-sm-12 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-12">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Selamat Datang di halaman ini</p>
                <h5 class="font-weight-bolder">
                  Selamat datang, {{ auth()->user()->name }}
                </h5>
                <p class="mb-0">
                  Kami senang Anda bergabung dengan kami. Jelajahi untuk melihat berbagai informasi penting dan pembaruan terkini.
                </p>
              </div>
            </div>
            <div class="col-12 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                <i class="ni ni-greeting text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-md-3">
      <div class="card bg-primary text-white">
        <div class="card-body">
          <h5 class="card-title">Total Produk</h5>
          <p class="card-text fs-3">{{ $totalProduk }}</p> <!-- Data dari Controller -->
        </div>
      </div>
    </div>
  </div>

  

 
  <footer class="footer pt-3">
    <div class="container-fluid">
      <div class="row align-items-center justify-content-lg-between">
        <div class="col-lg-6 mb-lg-0 mb-4">
          <div class="copyright text-center text-sm text-muted text-lg-start">
            © <script>
              document.write(new Date().getFullYear())
            </script>
          </div>
        </div>
      </div>
    </div>
  </footer>
</div>
@endsection
