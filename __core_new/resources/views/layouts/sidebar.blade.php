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
                            <span>Tania Andrew
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
            <li class="nav-item ">
                <a class="nav-link" href="{{ url('/') }}">
                    <i class="nc-icon nc-chart-pie-35"></i>
                    <p>Beranda</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#componentsExamples">
                    <i class="nc-icon nc-app"></i>
                    <p>
                        Elearning HO
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="sidebar_elearning_ho">
                    @php
                    $urlElearningHo = 'fnb/elearning-ho';
                    @endphp
                    <ul class="nav">
                        <li class="nav-item " id="sidebar_elearning_ho_materi">
                            <a class="nav-link" href="{{ url($urlElearningHo . '/materi') }}">
                                <span class="sidebar-mini">M</span>
                                <span class="sidebar-normal">Materi</span>
                            </a>
                        </li>
                        <li class="nav-item " id="sidebar_elearning_ho_soal">
                            <a class="nav-link" href="{{ url($urlElearningHo . '/soal') }}">
                                <span class="sidebar-mini">S</span>
                                <span class="sidebar-normal">Soal</span>
                            </a>
                        </li>
                        <li class="nav-item " id="sidebar_elearning_ho_jadwal">
                            <a class="nav-link" href="{{ url($urlElearningHo . '/jadwal') }}">
                                <span class="sidebar-mini">J</span>
                                <span class="sidebar-normal">Jadwal</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>