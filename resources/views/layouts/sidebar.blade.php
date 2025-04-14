<div class="sidebar-wrapper scrollbar scrollbar-inner">
  <div class="sidebar-content">
    <ul class="nav nav-secondary">
      <li class="nav-item active">
        <a data-bs-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
          <i class="fas fa-tachometer-alt"></i> <!-- Ikon Dashboard -->
          <p>Dashboard</p>
          <span class="caret"></span>
        </a>
        <div class="collapse" id="dashboard">
          <ul class="nav nav-collapse">
            <li>
              <a href="../">
                <span class="sub-item">Dashboard 1</span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section">Menu</h4>
      </li>

      <li class="nav-item">
        <a href="{{ route('produks.index') }}">
          <i class="fas fa-box"></i> <!-- Ikon Produk -->
          <p>Produk</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="/pelanggans">
          <i class="fas fa-users"></i> <!-- Ikon Pelanggan -->
          <p>Pelanggan</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="/penjualans">
          <i class="fas fa-shopping-cart"></i> <!-- Ikon Penjualan -->
          <p>Penjualan</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="/logout">
          <i class="fas fa-sign-out-alt"></i> <!-- Ikon Logout -->
          <p>Logout</p>
        </a>
      </li>
    </ul>
  </div>
</div>
