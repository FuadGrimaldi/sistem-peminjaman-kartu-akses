<button class="sidebar-toggle" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>

        <!-- Sidebar Overlay (Mobile) -->
        <div class="sidebar-overlay" onclick="closeSidebar()"></div>

        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <a href="#" class="sidebar-brand">
                    <i class="bi bi-speedometer2"></i>
                    Admin Panel
                </a>
            </div>
            
            <div class="sidebar-nav">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" style="color: white;" href="{{route('admin.home')}}" onclick="setActive(this)">
                            <i class="bi bi-house-door"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.kartu-akses')}}" style="color: white;" onclick="setActive(this)">
                            <i class="bi bi-credit-card"></i>
                            Kartu Aset
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.peminjaman')}}" style="color: white;" onclick="setActive(this)">
                            <i class="bi bi-arrow-left-right"></i>
                            Peminjaman
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.users')}}" style="color: white;" onclick="setActive(this)">
                            <i class="bi bi-people"></i>
                            Pengguna
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: white;" onclick="setActive(this)">
                            <i class="bi bi-bar-chart"></i>
                            Laporan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: white;" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                            <i class="bi bi-bar-chart"></i>
                                {{ __('Logout') }}
                            
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                    </li>
                    
                </ul>
            </div>
        </nav>