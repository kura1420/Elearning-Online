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
            @if (auth()->user()->level == 'ss')
            <li class="nav-item" id="sidebar_masterData">
                <a class="nav-link" data-toggle="collapse" href="#sidebarUjian">
                    <i class="nc-icon nc-layers-3"></i>
                    <p>
                        Ujian
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="sidebarUjian">
                    <ul class="nav">
                        <li class="nav-item " id="sidebarUjianHarian">
                            <a class="nav-link" href="{{ url('/sch/ujian-harian-siswa') }}">
                                <span class="sidebar-mini">H</span>
                                <span class="sidebar-normal">Harian</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            @if (auth()->user()->level == 'asc')
            <li class="nav-item " id="sidebarBeranda">
                <a class="nav-link" href="{{ route('sekolah_beranda') }}">
                    <i class="nc-icon nc-chart-pie-35"></i>
                    <p>Beranda</p>
                </a>
            </li>
            
            <li class="nav-item" id="sidebar_masterData">
                <a class="nav-link" data-toggle="collapse" href="#sidebarData">
                    <i class="nc-icon nc-app"></i>
                    <p>
                        Data
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="sidebarData">
                    <ul class="nav">
                        <li class="nav-item " id="sidebarKelas">
                            <a class="nav-link" href="{{ url('/sch/kelas') }}">
                                <span class="sidebar-mini">K</span>
                                <span class="sidebar-normal">Kelas</span>
                            </a>
                        </li>
                        <li class="nav-item " id="sidebarPelajaran">
                            <a class="nav-link" href="{{ url('/sch/pelajaran') }}">
                                <span class="sidebar-mini">P</span>
                                <span class="sidebar-normal">Pelajaran</span>
                            </a>
                        </li>
                        <li class="nav-item " id="sidebarPelajaranTipe">
                            <a class="nav-link" href="{{ url('/sch/tipe-pelajaran') }}">
                                <span class="sidebar-mini">TP</span>
                                <span class="sidebar-normal">Tipe Pelajaran</span>
                            </a>
                        </li>
                        <li class="nav-item " id="sidebarGuru">
                            <a class="nav-link" href="{{ url('/sch/guru') }}">
                                <span class="sidebar-mini">G</span>
                                <span class="sidebar-normal">Guru</span>
                            </a>
                        </li>
                        <li class="nav-item " id="sidebarTahunAjaran">
                            <a class="nav-link" href="{{ url('/sch/tahun-ajaran') }}">
                                <span class="sidebar-mini">TA</span>
                                <span class="sidebar-normal">Tahun Ajaran</span>
                            </a>
                        </li>
                        <li class="nav-item " id="sidebarSiswa">
                            <a class="nav-link" href="{{ url('/sch/siswa') }}">
                                <span class="sidebar-mini">S</span>
                                <span class="sidebar-normal">Siswa</span>
                            </a>
                        </li>
                        <li class="nav-item " id="sidebarFileUpload">
                            <a class="nav-link" href="{{ url('/sch/file-upload') }}">
                                <span class="sidebar-mini">FU</span>
                                <span class="sidebar-normal">File Upload</span>
                            </a>
                        </li>
                        <li class="nav-item " id="sidebarSoal">
                            <a class="nav-link" href="{{ url('/sch/soal') }}">
                                <span class="sidebar-mini">S</span>
                                <span class="sidebar-normal">Soal</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item" id="sidebar_masterData">
                <a class="nav-link" data-toggle="collapse" href="#sidebarUjian">
                    <i class="nc-icon nc-layers-3"></i>
                    <p>
                        Ujian
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="sidebarUjian">
                    <ul class="nav">
                        <li class="nav-item " id="sidebarUjianHarian">
                            <a class="nav-link" href="{{ url('/sch/ujian-harian') }}">
                                <span class="sidebar-mini">H</span>
                                <span class="sidebar-normal">Harian</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item" id="sidebar_masterData">
                <a class="nav-link" data-toggle="collapse" href="#sidebarRemedialUjian">
                    <i class="nc-icon nc-bullet-list-67"></i>
                    <p>
                        Remedial
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="sidebarRemedialUjian">
                    <ul class="nav">
                        <li class="nav-item " id="sidebarRemedialUjianHarian">
                            <a class="nav-link" href="#">
                                <span class="sidebar-mini">H</span>
                                <span class="sidebar-normal">Harian</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item" id="sidebar_masterData">
                <a class="nav-link" data-toggle="collapse" href="#sidebarReport">
                    <i class="nc-icon nc-chart-bar-32"></i>
                    <p>
                        Report Ujian
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="sidebarReport">
                    <ul class="nav">
                        <li class="nav-item " id="sidebarReportHarian">
                            <a class="nav-link" href="{{ url('/sch/report/ujian-harian') }}">
                                <span class="sidebar-mini">H</span>
                                <span class="sidebar-normal">Harian</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item" id="sidebar_masterData">
                <a class="nav-link" data-toggle="collapse" href="#sidebarPengaturan">
                    <i class="nc-icon nc-settings-gear-64"></i>
                    <p>
                        Pengaturan
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="sidebarPengaturan">
                    <ul class="nav">
                        <li class="nav-item " id="sidebarProfilSekolah">
                            <a class="nav-link" href="{{ url('/sch/profil-sekolah/' . session('sch_id')) }}">
                                <span class="sidebar-mini">PS</span>
                                <span class="sidebar-normal">Profil Sekolah</span>
                            </a>
                        </li>
                        <li class="nav-item " id="sidebarJenisUjian">
                            <a class="nav-link" href="{{ url('/sch/jenis-ujian') }}">
                                <span class="sidebar-mini">JU</span>
                                <span class="sidebar-normal">Jenis Ujian</span>
                            </a>
                        </li>
                        <li class="nav-item " id="sidebarRumusPenilaianUjian">
                            <a class="nav-link" href="{{ url('/sch/rumus-penilaian-ujian') }}">
                                <span class="sidebar-mini">RU</span>
                                <span class="sidebar-normal">Rumus Penilaian Ujian</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            @if (auth()->user()->level == 'gr')
            <li class="nav-item " id="sidebarBeranda">
                <a class="nav-link" href="{{ route('sekolah_beranda') }}">
                    <i class="nc-icon nc-chart-pie-35"></i>
                    <p>Beranda</p>
                </a>
            </li>
            
            <li class="nav-item" id="sidebar_masterData">
                <a class="nav-link" data-toggle="collapse" href="#sidebarData">
                    <i class="nc-icon nc-app"></i>
                    <p>
                        Data
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="sidebarData">
                    <ul class="nav">
                        <li class="nav-item " id="sidebarSiswa">
                            <a class="nav-link" href="{{ url('/sch/siswa') }}">
                                <span class="sidebar-mini">S</span>
                                <span class="sidebar-normal">Siswa</span>
                            </a>
                        </li>
                        <li class="nav-item " id="sidebarFileUpload">
                            <a class="nav-link" href="{{ url('/sch/file-upload') }}">
                                <span class="sidebar-mini">FU</span>
                                <span class="sidebar-normal">File Upload</span>
                            </a>
                        </li>
                        <li class="nav-item " id="sidebarSoal">
                            <a class="nav-link" href="{{ url('/sch/soal') }}">
                                <span class="sidebar-mini">S</span>
                                <span class="sidebar-normal">Soal</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item" id="sidebar_masterData">
                <a class="nav-link" data-toggle="collapse" href="#sidebarUjian">
                    <i class="nc-icon nc-layers-3"></i>
                    <p>
                        Ujian
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="sidebarUjian">
                    <ul class="nav">
                        <li class="nav-item " id="sidebarUjianHarian">
                            <a class="nav-link" href="{{ url('/sch/ujian-harian') }}">
                                <span class="sidebar-mini">H</span>
                                <span class="sidebar-normal">Harian</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item" id="sidebar_masterData">
                <a class="nav-link" data-toggle="collapse" href="#sidebarReport">
                    <i class="nc-icon nc-chart-bar-32"></i>
                    <p>
                        Report Ujian
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="sidebarReport">
                    <ul class="nav">
                        <li class="nav-item " id="sidebarReportHarian">
                            <a class="nav-link" href="{{ url('/sch/report/ujian-harian') }}">
                                <span class="sidebar-mini">H</span>
                                <span class="sidebar-normal">Harian</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif
        </ul>
    </div>
</div>