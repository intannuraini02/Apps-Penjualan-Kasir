<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tambah Detail Penjualan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
        crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <h2 class="mt-4">Tambah Detail Penjualan</h2>
    
    <!-- Tampilkan error validasi jika ada -->
    <?php if ($errors->any()): ?>
      <div class="alert alert-danger">
          <ul>
              <?php foreach ($errors->all() as $error): ?>
                  <li><?= $error ?></li>
              <?php endforeach; ?>
          </ul>
      </div>
    <?php endif; ?>

    <form action="<?= route('detail_penjualan.store') ?>" method="POST">
      <!-- CSRF token -->
      <input type="hidden" name="_token" value="<?= csrf_token() ?>">
      
      <!-- Pilih Penjualan -->
      <div class="mb-3">
        <label for="PenjualanID" class="form-label">Nama Penjual</label>
        <select name="PenjualanID" id="PenjualanID" class="form-select" required>
          <option value="">Pilih Penjualan</option>
          <?php foreach ($penjualans as $penjualan): ?>
            <option value="<?= $penjualan->PenjualanID ?>">
              <?= $penjualan->PenjualanID ?> - <?= $penjualan->pelanggan->NamaPelanggan ?? '' ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      
      <!-- Pilih Produk -->
      <div class="mb-3">
        <label for="ProdukID" class="form-label">Produk</label>
        <select name="ProdukID" id="ProdukID" class="form-select" required>
          <option value="">Pilih Produk</option>
          <?php foreach ($produks as $produk): ?>
            <option value="<?= $produk->ProdukID ?>" data-harga="<?= $produk->Harga ?>">
            <?= $produk->NamaProduk ?> - Rp <?= number_format($produk->Harga, 0, ',', '.') ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      
      <!-- Jumlah -->
      <div class="mb-3">
        <label for="jumlah" class="form-label">Jumlah</label>
        <input type="number" name="jumlah" id="jumlah" class="form-control" required min="1" 
               value="<?= old('jumlah') ?>">
      </div>
      
      <!-- Subtotal (hanya tampilan) -->
      <div class="mb-3">
        <label for="subtotal_display" class="form-label">Subtotal</label>
        <input type="text" id="subtotal_display" class="form-control" readonly>
        <!-- Input hidden untuk mengirim subtotal ke backend -->
        <input type="hidden" name="subtotal" id="subtotal">
      </div>
      
      <!-- Tombol Submit & Batal -->
      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="<?= route('detail_penjualan.index') ?>" class="btn btn-secondary">Batal</a>
    </form>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const produkSelect = document.getElementById('ProdukID');
      const jumlahInput = document.getElementById('jumlah');
      const subtotalDisplay = document.getElementById('subtotal_display');
      const subtotalHidden = document.getElementById('subtotal');
  
      function hitungSubtotal() {
        const selectedOption = produkSelect.options[produkSelect.selectedIndex];
        const harga = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
        const jumlah = parseInt(jumlahInput.value) || 0;
        const subtotal = harga * jumlah;
  
        subtotalDisplay.value = subtotal ? subtotal.toLocaleString('id-ID') : '';
        subtotalHidden.value = subtotal;
      }
  
      produkSelect.addEventListener('change', hitungSubtotal);
      jumlahInput.addEventListener('input', hitungSubtotal);
    });
  </script>
</body>
</html>
