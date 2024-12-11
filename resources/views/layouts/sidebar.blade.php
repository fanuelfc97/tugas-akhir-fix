<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="/" class="brand-link">
            <img src="/dist/assets/img/cv_xyz_l.png" alt="XYZ Logo" class="brand-image opacity-75 shadow">
            <span class="brand-text fw-light">CV XYZ</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2" role="navigation" aria-label="Main Menu">>
                        <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                            <li class="nav-item" role="none">
                                <href="#" class="nav-link active" role="menuitem">
                                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                                        <div class="image">
                                            <img src="/dist/assets/img/cv_xyz.png" class="img-circle elevation-2" alt="User Image">
                                        </div>
                                        <div class="info">
                                            <a href="#" class="d-block">{{ Auth::user()->username }} </a>
                                        </div>
                                    </div>
                            <!-- Menu Utama -->
                            <li class="nav-item" role="none">
                                <a href="#" class="nav-link" role="menuitem">
                                    <i class="nav-icon bi bi-clipboard-fill"></i>
                                    <p>Documents</p>
                                    <span class="nav-badge badge text-bg-secondary me-3"></span>
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </a>

                                <!-- Sub-menu Documents -->
                                <ul class="nav nav-treeview" role="group">
                                    <!-- Perizinan -->
                                    <li class="nav-item" role="none">
                                        <a href="#" class="nav-link" role="menuitem">
                                            <i class="nav-icon bi bi-pen"></i>
                                            <p>Perizinan</p>
                                            <i class="nav-arrow bi bi-chevron-right"></i>
                                        </a>
                                        <ul class="nav nav-treeview" role="group">
                                            <li class="nav-item" role="none"><a href="{{ route('iprs.index') }}" class="nav-link" role="menuitem"><i class="nav-icon bi bi-record-circle-fill"></i><p>IPR</p></a></li>
                                            <li class="nav-item" role="none"><a href="{{ route('skpds.index') }}" class="nav-link" role="menuitem"><i class="nav-icon bi bi-record-circle-fill"></i><p>SKPD</p></a></li>
                                            <li class="nav-item" role="none"><a href="{{ route('imbs.index') }}" class="nav-link" role="menuitem"><i class="nav-icon bi bi-record-circle-fill"></i><p>IMB</p></a></li>
                                        </ul>
                                    </li>   
                                    <!-- Sewa Lahan -->
                                    <li class="nav-item" role="none">
                                        <a href="{{ route('sewalahans.index') }}" class="nav-link" role="menuitem">
                                            <i class="nav-icon bi-file-earmark-check-fill"></i>
                                            <p>Sewa Lahan</p>
                                        </a>
                                    </li>

                                    <!-- Asuransi -->
                                    <li class='nav-item' role="none" title="Asuransi"><a href='#'class="nav-link" role="menuitem"><i class='bi nav-icon bi-file-earmark-lock'></i><p>Asuransi</p><i class='nav-arrow bi-chevron-right'></i></a>
                                        <!-- Sub-menu Asuransi -->
                                        <ul class='nav nav-treeview' role="group">
                                             <li class='nav-item' role="none"><a href="{{ route('bankgaransis.index') }}"class="nav-link" role="menuitem"><i class='bi nav-icon bi-record-circle-fill'></i><p>Bank Garansi</p></a></li>
                                             <li class='nav-item' role="none"><a href="{{ route('asuransis.index') }}"class="nav-link" role="menuitem"><i class='bi nav-icon bi-record-circle-fill'></i><p>Polis Asuransi</p></a></li>
                                         </ul>
                                     </li>
                                 </ul>
                             </li>
                             @if (in_array(Auth::user()->jabatan, ['Manager EMS', 'Manager Operasional', 'Manager Administasi']))
                             <li class="nav-item" role="none">
                                <a href="#" class="nav-link" role="menuitem">
                                    <i class="nav-icon bi bi-people-fill"></i>
                                    <p>Kepegawaian</p>
                                    <span class="nav-badge badge text-bg-secondary me-3"></span>
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </a>

                                    <ul class='nav nav-treeview' role="group">
                                         @if (Auth::user()->jabatan == 'Manager EMS')
                                            <li class='nav-item' role="none"><a href="{{ route('pegawais.index') }}"class="nav-link" role="menuitem"><i class='bi nav-icon bi-person   -fill'></i><p>Pegawai</p></a></li>
                                         @endif
                                         <li class='nav-item' role="none"><a href="{{ route('laporankegiatans.index') }}"class="nav-link" role="menuitem"><i class='bi nav-icon bi-tools'></i><p>Laporan kegiatan</p></a></li>
                                     </ul>
                                 </li>
                             </li>
                             @endif
                             <li class='nav-item' role="none">
                                <a href="{{ route('titikreklames.index') }}"class="nav-link" role="menuitem">
                                    <i class="nav-icon bi bi-pin-map-fill"></i>
                                    <p>Titik Reklame</p>
                                </a>
                            </li>



                             <!-- Tentang Program -->
                             <li class='nav-item' role="none">
                                <a href='./docs/faq.html'class="nav-link" role="menuitem">
                                    <i class='bi nav-icon bi-question-circle-fill'></i>
                                    <p>Tentang Program</p>
                                </a>
                            </li>

                             <!-- Header Akun -->
                             @if (Auth::user()->jabatan == 'Manager EMS')
                             <li class='nav-header'>ACCOUNT</li>

                             <!-- Login -->
                             <li class='nav-item' role="none"><a href="{{ route('users.index')  }}"class="nav-link" role="menuitem"><i class='bi nav-icon bi-pencil-square'></i><p>Daftar User</p></a></li>

                             <!-- Register -->
                             <li class='nav-item' role="none"><a href="{{ route('users.create')  }}"class="nav-link" role="menuitem"><i class='bi nav-icon bi-plus-square'></i><p>Create User</p></a></li>

                             @endif
                        </ul>
        </nav>
    </div> <!--end::Sidebar Wrapper-->
</aside> <!--end::Sidebar-->


  <script src="//code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="//stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
