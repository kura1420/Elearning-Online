<div class="sidebar" data-color="orange" data-image="{{ asset('assets/img/sidebar-5.jpg') }}">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="{{ url('/') }}" class="simple-text logo-mini">
                {{ config('app.shortname', 'LRV') }}
            </a>
            <a href="{{ url('/') }}" class="simple-text logo-normal">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>
        <div class="user">
            <div class="photo">
                <img src="{{ asset('assets/img/faces/face-0.jpg') }}" />
            </div>
            <div class="info ">
                <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                            <span> {{ Auth::user()->name }}
                                <b class="caret"></b>
                            </span>
                </a>
                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li>
                            <a class="profile-dropdown" href="#pablo">
                                <span class="sidebar-mini">MP</span>
                                <span class="sidebar-normal">My Profile</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav">
            <li class="nav-item " id="sidebarBeranda">
                <a class="nav-link" href="{{ route('magenta_beranda') }}">
                    <i class="nc-icon nc-chart-pie-35"></i>
                    <p>Beranda</p>
                </a>
            </li>
            <li class="nav-item" id="sidebar_masterData">
                <a class="nav-link" data-toggle="collapse" href="#sidebarMasterData">
                    <i class="nc-icon nc-app"></i>
                    <p>
                        Master Data
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="sidebarMasterData">
                    <ul class="nav">
                        @if (Auth::user()->level == 'rot')
                        <li class="nav-item " id="sidebarUser">
                            <a class="nav-link" href="{{ url('/mgt/user') }}">
                                <span class="sidebar-mini">U</span>
                                <span class="sidebar-normal">User</span>
                            </a>
                        </li>
                        @endif
                        <li class="nav-item " id="sidebarSekolah">
                            <a class="nav-link" href="{{ url('/mgt/sekolah') }}">
                                <span class="sidebar-mini">S</span>
                                <span class="sidebar-normal">Sekolah</span>
                            </a>
                        </li>
                        <li class="nav-item " id="sidebarPicSekolah">
                            <a class="nav-link" href="{{ url('/mgt/pic-sekolah') }}">
                                <span class="sidebar-mini">PS</span>
                                <span class="sidebar-normal">Pic Sekolah</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>