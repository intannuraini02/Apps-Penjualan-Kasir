<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f4f4f9;
            margin: 0;
        }

        .sidebar {
            width: 260px;
            background: white;
            color: #6c757d;
            padding: 20px;
            height: 100vh;
            position: fixed;
            transition: width 0.3s;
            box-shadow: 2px 0px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .sidebar .logo img {
            width: 50px;
            height: 50px;
        }

        .menu-items {
            flex-grow: 1;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 12px;
            text-decoration: none;
            color: #6c757d;
            font-weight: 500;
            border-radius: 10px;
            transition: background 0.3s, color 0.3s;
        }

        .sidebar a:hover, .sidebar a.active {
            background: #e7dbff;
            color: #7a25ff;
        }

        .sidebar a i {
            font-size: 18px;
            margin-right: 12px;
            color: #6c757d;
        }

        .sidebar a:hover i, .sidebar a.active i {
            color: #7a25ff;
        }

        .logout {
            padding: 12px;
        }

        .logout form {
            width: 100%;
        }

        .logout button {
            width: 100%;
            background: #ff4d4d;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .logout button:hover {
            background: #cc0000;
        }

        .toggle-btn {
            position: absolute;
            top: 15px;
            right: -20px;
            background: white;
            border: none;
            cursor: pointer;
            padding: 6px 10px;
            border-radius: 5px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar.collapsed a span {
            display: none;
        }

        .sidebar.collapsed i {
            margin-right: 0;
            text-align: center;
            width: 100%;
        }

        .sidebar.collapsed .logout button {
            text-align: center;
        }

        .main-content {
            margin-left: 260px;
            padding: 20px;
            width: 100%;
            transition: margin-left 0.3s;
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: 80px;
        }
    </style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <div>
    <div class="logo">
    <i class="fas fa-store fa-3x"></i> <!-- Ikon toko dari Font Awesome -->
</div>

        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <div class="menu-items">
            @if(auth()->user()->role == 'Admin')
                <a href="{{ route('dashboard') }}" class="active">
                    <i class="fas fa-home"></i><span>Dashboard</span>
                </a>
                <a href="{{ route('produks.index') }}">
                    <i class="fas fa-box"></i><span>Produk</span>
                </a>
                <a href="{{ route('pelanggans.index') }}">
                    <i class="fas fa-user"></i><span>Pelanggan</span>
                </a>
                <a href="{{ route('penjualans.index') }}">
                    <i class="fas fa-shopping-cart"></i><span>Penjualan</span>
                </a>
            @elseif(auth()->user()->role == 'Kasir')

            <a href="{{ route('dashboard') }}" class="active">
                    <i class="fas fa-home"></i><span>Dashboard</span>
                </a>

                <a href="{{ route('produks.index') }}">
                    <i class="fas fa-box"></i><span>Produk</span>
                </a>
                <a href="{{ route('penjualans.index') }}">
                    <i class="fas fa-shopping-cart"></i><span>Penjualan</span>
                </a>
                <a href="{{ route('pelanggans.index') }}">
                    <i class="fas fa-user"></i><span>Pelanggan</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Tombol Logout di Bagian Bawah -->
    <div class="logout">
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</div>

<div class="main-content">
    @yield('main-content')
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('collapsed');
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
