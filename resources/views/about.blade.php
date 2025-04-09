@extends('layouts.master')

@section('title', 'About CV XYZ')

@section('content')

<div class="app-content-header"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Tentang CV XYZ</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        About
                    </li>
                </ol>
            </div>
        </div> <!--end::Row-->
    </div> <!--end::Container-->
</div>

<div class="container mt-4"> <!--begin::Content-->
    <div class="row">
        <div class="col-lg-12">
            <h2>CV XYZ</h2>
            <p>CV XYZ adalah perusahaan yang bergerak di bidang reklame dan pengelolaan arsip digital. Kami berkomitmen
                untuk menyediakan solusi terbaik bagi pelanggan dalam mengelola dan mendokumentasikan berbagai jenis
                dokumen penting.</p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-6">
            <h3>Visi</h3>
            <p>Menjadi perusahaan terdepan dalam bidang pengarsipan digital dan periklanan, memberikan solusi inovatif
                dan terpercaya bagi pelanggan.</p>
        </div>
        <div class="col-lg-6">
            <h3>Misi</h3>
            <ul>
                <li>Menyediakan layanan pengarsipan yang efisien dan aman.</li>
                <li>Mengembangkan teknologi berbasis web untuk mendukung sistem pengelolaan arsip digital.</li>
                <li>Memberikan pelayanan terbaik kepada pelanggan dengan standar profesionalisme tinggi.</li>
            </ul>
        </div>
    </div>
</div> <!--end::Content-->
@endsection