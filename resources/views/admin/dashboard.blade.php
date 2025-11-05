<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sistem Reservasi Wisata</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
            background: #0f172a;
            color: #e2e8f0;
        }
        
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: #1e293b;
            border-right: 1px solid #334155;
            padding: 20px;
            overflow-y: auto;
        }
        
        .sidebar-header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #334155;
        }
        
        .sidebar-title {
            font-size: 18px;
            font-weight: 700;
            color: #f1f5f9;
            margin-bottom: 5px;
        }
        
        .sidebar-subtitle {
            font-size: 12px;
            color: #94a3b8;
            font-weight: 500;
        }
        
        .sidebar-menu {
            list-style: none;
        }
        
        .sidebar-menu li {
            margin-bottom: 8px;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.2s;
            font-size: 14px;
        }
        
        .sidebar-menu a:hover {
            background: #334155;
            color: #f1f5f9;
        }
        
        .sidebar-menu a.active {
            background: #3b82f6;
            color: white;
        }
        
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
        }
        
        .topbar {
            background: #1e293b;
            border-bottom: 1px solid #334155;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .topbar-title {
            font-size: 16px;
            font-weight: 600;
            color: #f1f5f9;
        }
        
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .user-info-top {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 15px;
            background: #334155;
            border-radius: 6px;
        }
        
        .user-info-top span {
            font-size: 13px;
            color: #cbd5e1;
        }
        
        .logout-btn {
            background: #dc2626;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            transition: background 0.2s;
        }
        
        .logout-btn:hover {
            background: #b91c1c;
        }
        
        .container {
            padding: 30px;
        }
        
        .page-header {
            margin-bottom: 30px;
        }
        
        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #f1f5f9;
            margin-bottom: 8px;
        }
        
        .page-subtitle {
            font-size: 14px;
            color: #94a3b8;
        }
        
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 8px;
            padding: 24px;
            transition: all 0.2s;
        }
        
        .card:hover {
            border-color: #475569;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
        }
        
        .stat-card .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #3b82f6;
            margin-bottom: 8px;
        }
        
        .stat-card .stat-label {
            font-size: 13px;
            color: #94a3b8;
            font-weight: 500;
        }
        
        .management-section {
            margin-bottom: 30px;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #f1f5f9;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #94a3b8;
        }
        
        .button-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
        }
        
        .btn {
            padding: 12px 16px;
            border: 1px solid #334155;
            background: #1e293b;
            color: #cbd5e1;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 13px;
            font-weight: 500;
            text-align: center;
            text-decoration: none;
            display: block;
        }
        
        .btn:hover {
            background: #334155;
            border-color: #475569;
            color: #f1f5f9;
        }
        
        .btn-primary {
            background: #3b82f6;
            border-color: #3b82f6;
            color: white;
        }
        
        .btn-primary:hover {
            background: #2563eb;
            border-color: #2563eb;
        }
        
        .info-card {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        
        .info-item {
            background: #0f172a;
            padding: 15px;
            border-radius: 6px;
            border-left: 3px solid #3b82f6;
        }
        
        .info-label {
            font-size: 12px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        
        .info-value {
            font-size: 16px;
            font-weight: 600;
            color: #f1f5f9;
        }
        
        @media (max-width: 1024px) {
            .sidebar {
                width: 220px;
            }
            
            .main-content {
                margin-left: 220px;
            }
            
            .info-card {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .topbar {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-title">🏖️ Wisata Admin</div>
            <div class="sidebar-subtitle">Sistem Reservasi Wisata</div>
        </div>
        
        <ul class="sidebar-menu">
            <li><a href="/dashboard-admin" class="active">📊 Dashboard</a></li>
            <li><a href="#">👥 Kelola Users</a></li>
            <li><a href="#">📅 Kelola Reservasi</a></li>
            <li><a href="#">🗺️ Kelola Destinasi</a></li>
            <li><a href="#">📈 Laporan Penjualan</a></li>
            <li><a href="#">⚙️ Pengaturan</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="topbar">
            <div class="topbar-left">
                <div class="topbar-title">Dashboard</div>
            </div>
            <div class="topbar-right">
                <div class="user-info-top">
                    <span>{{ auth()->user()->username }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
        
        <div class="container">
            <div class="page-header">
                <div class="page-title">Selamat Datang, Admin! 👨‍💼</div>
                <div class="page-subtitle">Kelola sistem reservasi wisata dari panel ini</div>
            </div>
            
            <div class="grid">
                <div class="card stat-card">
                    <div class="stat-value">{{ \App\Models\Users::where('role', 'user')->count() }}</div>
                    <div class="stat-label">Total Users</div>
                </div>
                <div class="card stat-card">
                    <div class="stat-value">0</div>
                    <div class="stat-label">Total Reservasi</div>
                </div>
                <div class="card stat-card">
                    <div class="stat-value">0</div>
                    <div class="stat-label">Destinasi Wisata</div>
                </div>
            </div>
            
            <div class="management-section">
                <div class="section-title">📋 Menu Manajemen</div>
                <div class="button-group">
                    <a href="#" class="btn btn-primary">👥 Kelola Users</a>
                    <a href="#" class="btn btn-primary">📅 Kelola Reservasi</a>
                    <a href="#" class="btn btn-primary">🗺️ Kelola Destinasi</a>
                    <a href="#" class="btn btn-primary">📈 Laporan Penjualan</a>
                </div>
            </div>
            
            <div class="management-section">
                <div class="section-title">👤 Informasi Admin</div>
                <div class="card">
                    <div class="info-card">
                        <div class="info-item">
                            <div class="info-label">Username</div>
                            <div class="info-value">{{ auth()->user()->username }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Email</div>
                            <div class="info-value">{{ auth()->user()->email }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Nomor Handphone</div>
                            <div class="info-value">{{ auth()->user()->No_Handphone }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Role</div>
                            <div class="info-value">{{ ucfirst(auth()->user()->role) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

