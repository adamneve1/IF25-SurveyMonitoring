<!-- resources/views/dashboard.blade.php -->
@extends('layouts.main')

@section('title', 'Dashboard | PT.Lancang Kuning Sukses')

@section('content-header')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard v1</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
@endsection

@section('content')
<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <!-- Box 1 -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>150</h3>
            <p>Semua Projek</p>
          </div>
          <div class="icon">
            <i class="ion-compass ion-icon-small"></i>
          </div>
          <a href="#" class="small-box-footer text-xs">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      
      <!-- Box 2 -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>53<sup style="font-size: 20px">%</sup></h3>
            <p>Berjalan</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="#" class="small-box-footer text-xs">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->

      <!-- Box 3 -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>44</h3>
            <p>Terhambat</p>
          </div>
          <div class="icon">
            <i class="ion-close-round"></i>
          </div>
          <a href="#" class="small-box-footer text-xs">More info <i class="fas fa-arrow-circle-right"></i></a>
          
        </div>
      </div>
      <!-- ./col -->

      <!-- Box 4 -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>65</h3>
            <p>Selesai</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
         
          <a href="#" class="small-box-footer text-xs">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>
    <!-- /.row -->

    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-7 connectedSortable">
        <!-- Anda bisa menambahkan konten di sini -->
      </section>
      <!-- /.Left col -->

      <!-- Right col -->
      <section class="col-lg-5 connectedSortable">
        <!-- Anda bisa menambahkan konten di sini -->
      </section>
      <!-- /.Right col -->
    </div>
    <!-- /.row (main row) -->
  </div><!-- /.container-fluid -->
</section>
@endsection
