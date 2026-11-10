<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CryptoLab - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background:#07142b; color:#e6edf7; min-height:100vh; }
        .sidebar { width:230px; background:#0a1a36; border-right:1px solid #16315c;
                   position:fixed; top:0; bottom:0; left:0; padding:20px 14px;
                   display:flex; flex-direction:column; z-index:1040;
                   overflow-y:auto; transition:transform .25s ease; }
        .brand { text-align:center; margin-bottom:24px; }
        .brand svg { display:block; margin:0 auto 6px; }
        .brand .name { font-size:1.3rem; font-weight:700; }
        .brand span { color:#2f7bff; }
        .sidebar a { display:flex; align-items:center; gap:10px; color:#b8c7e0;
                     text-decoration:none; padding:10px 12px; border-radius:8px; margin-bottom:4px; }
        .sidebar a:hover { background:#10264a; color:#fff; }
        .sidebar a.active { background:#1f6bff; color:#fff; }
        .sidebar .bottom { margin-top:auto; padding-top:16px; }
        .topbar { display:flex; justify-content:space-between; align-items:center; gap:16px; margin-bottom:10px; }
        .topbar .right { display:flex; align-items:center; gap:16px; margin-left:auto; }
        .topbar .avatar { width:34px; height:34px; border-radius:50%; background:#1f6bff;
                          display:flex; align-items:center; justify-content:center; color:#fff; }
        .topbar i { font-size:1.2rem; color:#b8c7e0; cursor:pointer; }
        .menu-btn { display:none; background:#0d2142; border:1px solid #16315c; color:#e6edf7;
                    border-radius:8px; width:40px; height:38px; align-items:center; justify-content:center; }
        .menu-btn i { color:#e6edf7; font-size:1.4rem; }
        .overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.55); z-index:1030; }
        .content { margin-left:230px; padding:20px 30px 30px; }

        /* ===== Tampilan HP / tablet ===== */
        @media (max-width: 991px) {
            .sidebar { transform:translateX(-100%); }
            .sidebar.open { transform:translateX(0); }
            .overlay.show { display:block; }
            .menu-btn { display:flex; }
            .content { margin-left:0; padding:14px 16px 24px; }

            /* Dashboard */
            .hero { flex-direction:column !important; align-items:flex-start !important; }
            .hero h1 { font-size:2.2rem !important; }
            .shield-wrap { width:100% !important; height:auto !important; margin-top:10px; }
            .shield-wrap svg { width:200px; height:210px; }

            /* About */
            .about-wrap { flex-direction:column !important; gap:20px !important; text-align:center; }
            .about-wrap svg { width:180px; height:195px; }
        }
    </style>
</head>
<body>
    <div class="overlay" id="overlay"></div>

    <div class="sidebar" id="sidebar">
        <div class="brand">
            <svg width="44" height="48" viewBox="0 0 44 48">
                <path d="M22 3 L38 9 V24 C38 34 31 42 22 46 C13 42 6 34 6 24 V9 Z" fill="#1f6bff" stroke="#6db0ff" stroke-width="2"/>
                <rect x="15" y="21" width="14" height="12" rx="2" fill="#fff"/>
                <path d="M18 21 v-3 a4 4 0 0 1 8 0 v3" fill="none" stroke="#fff" stroke-width="2"/>
            </svg>
            <div class="name">Crypto<span>Lab</span></div>
        </div>

        <a href="/" class="{{ request()->is('/') ? 'active' : '' }}"><i class="bi bi-house-fill"></i> Dashboard</a>
        <a href="/block-cipher" class="{{ request()->is('block-cipher') ? 'active' : '' }}"><i class="bi bi-lock-fill"></i> Block Cipher</a>
        <a href="/stream-cipher" class="{{ request()->is('stream-cipher') ? 'active' : '' }}"><i class="bi bi-shuffle"></i> Stream Cipher</a>
        <a href="/fungsi-utama" class="{{ request()->is('fungsi-utama') ? 'active' : '' }}"><i class="bi bi-fingerprint"></i> Fungsi Utama</a>
        <a href="/dasar-matematika" class="{{ request()->is('dasar-matematika') ? 'active' : '' }}"><i class="bi bi-calculator"></i> Dasar Matematika</a>

        <div class="bottom">
            <a href="/about" class="{{ request()->is('about') ? 'active' : '' }}"><i class="bi bi-info-circle"></i> About</a>
        </div>
    </div>

    <div class="content">
        <div class="topbar">
            <button class="menu-btn" id="menuBtn" type="button" aria-label="Menu"><i class="bi bi-list"></i></button>
            <div class="right">
                <i class="bi bi-moon"></i>
                <div class="avatar"><i class="bi bi-person-fill" style="color:#fff;font-size:1rem"></i></div>
            </div>
        </div>
        @yield('content')
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const toggle = (open) => {
            sidebar.classList.toggle('open', open);
            overlay.classList.toggle('show', open);
        };
        document.getElementById('menuBtn').onclick = () => toggle(!sidebar.classList.contains('open'));
        overlay.onclick = () => toggle(false);
    </script>
</body>
</html>