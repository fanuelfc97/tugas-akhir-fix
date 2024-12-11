    @extends('layouts.master')

    @section('title', 'Dashboard CV XYZ')

    @section('content')

            <div class="app-content-header"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Aplikasi Pengarsipan CV XYZ</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Aplikasi Pengarsipan CV XYZ
                                </li>
                            </ol>
                        </div>
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div>
            <div class="row"> <!--begin::Col-->

                        <h1></h1>
                        <h1></h1>
                        <h1></h1>
                        <h1></h1>

            </div> <!--end::Col-->

            <div class="info-box-container"> <!-- New container for info boxes -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                    @php
                        $twoMonthsFromNow = \Carbon\Carbon::now()->addMonths(2); 
                        $skpdCount = \App\Models\Skpd::where('periode_akhirskpd', '>', $twoMonthsFromNow)->count();
                        $iprCount = \App\Models\Ipr::where('periode_akhiripr', '>', $twoMonthsFromNow)->count();
                        $sewaLahanCount = \App\Models\SewaLahan::where('periode_akhirsl', '>', $twoMonthsFromNow)->count();
                    @endphp
                    <div class="inner">
                        <h3>Di Atas 2 Bulan</h3>
                        <p>
                            SKPD: {{ $skpdCount }} dokumen<br>
                            IPR: {{ $iprCount }} dokumen<br>
                            Sewa Lahan: {{ $sewaLahanCount }} dokumen
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                    @php
                        $oneMonthFromNow = \Carbon\Carbon::now()->addMonth();
                        $twoMonthsFromNow = \Carbon\Carbon::now()->addMonths(2);

                        $skpdCount = \App\Models\Skpd::whereBetween('periode_akhirskpd', [$oneMonthFromNow, $twoMonthsFromNow])->count();
                        $iprCount = \App\Models\Ipr::whereBetween('periode_akhiripr', [$oneMonthFromNow, $twoMonthsFromNow])->count();
                        $sewaLahanCount = \App\Models\SewaLahan::whereBetween('periode_akhirsl', [$oneMonthFromNow, $twoMonthsFromNow])->count();
                    @endphp
                    <div class="inner">
                        <h3>Di Atas 1 Bulan</h3>
                        <p>
                            SKPD: {{ $skpdCount }} dokumen<br>
                            IPR: {{ $iprCount }} dokumen<br>
                            Sewa Lahan: {{ $sewaLahanCount }} dokumen
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                    @php
                        $oneMonthFromNow = \Carbon\Carbon::now()->addMonth();

                        $skpdCount = \App\Models\Skpd::where('periode_akhirskpd', '<', $oneMonthFromNow)->count();
                        $iprCount = \App\Models\Ipr::where('periode_akhiripr', '<', $oneMonthFromNow)->count();
                        $sewaLahanCount = \App\Models\SewaLahan::where('periode_akhirsl', '<', $oneMonthFromNow)->count();
                    @endphp
                    <div class="inner">
                        <h3>Di Bawah 1 Bulan</h3>
                        <p>
                            SKPD: {{ $skpdCount }} dokumen<br>
                            IPR: {{ $iprCount }} dokumen<br>
                            Sewa Lahan: {{ $sewaLahanCount }} dokumen
                        </p>
                    </div>
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div> <!-- End of info box container -->


        <style>
            .row {
                display: flex;
                justify-content: center; /* Center horizontally */
                align-items: flex-start; /* Align items at the start */
            }

            .info-box-container {
                display: flex;
                justify-content: space-around; /* Space out the info boxes evenly */
                width: 100%; /* Make sure it takes full width */
            }

            .info-box {
                margin: 20px; /* Space between info boxes */
                flex: 1; /* Allow boxes to grow equally */
            }
        </style>
        @endsection
