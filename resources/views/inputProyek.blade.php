{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.main')

@section('title', 'Input Proyek | PT. Lancang Kuning Sukses')

{{-- section header --}}
@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Input Proyek</h1>
            </div>
            {{-- /.col --}}
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard v1</li>
                </ol>
            </div>
            {{-- /.col --}}
        </div>
        {{-- /.row --}}
    </div>
    {{-- /.container-fluid --}}
</div>
@endsection
{{-- /.section header --}}

{{-- section utama --}}
@section('content')
{{-- col main --}}
<section class="w-full flex flex-row items-center justify-center px-10 py-4">
    {{-- wrapper form  --}}
    <div class="max-w-full mx-auto p-4 bg-white rounded-md shadow-md">
        {{-- form post input proyek baru  --}}
        <form method="POST">
            @csrf
                {{-- table --}}
                <table class="w-full">
                    <tr>
                        <td class="w-40 text-gray-700 font-semibold text-right py-2 pr-2">Nama Proyek:</td>
                        {{-- input nama proyek --}}
                        <td class="py-2">
                            <input
                                type="text"
                                id="namaProyek"
                                class="w-full p-2 border border-gray-300 rounded-md"
                                placeholder="Masukkan nama proyek"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="w-40 text-gray-700 font-semibold text-right py-2 pr-2">Alamat Proyek:</td>
                        {{-- input alamat proyek --}}
                        <td class="py-2">
                            <input
                                type="text"
                                id="alamatProyek"
                                class="w-full p-2 border border-gray-300 rounded-md"
                                placeholder="Masukkan alamat proyek"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="w-40 text-gray-700 font-semibold text-right py-2 pr-2">Status:</td>
                        {{-- input status --}}
                        <td class="py-2">
                            <select
                                id="status"
                                class="w-full p-2 border border-gray-300 rounded-md"
                            >
                                <option value="belum_mulai" class="bg-yellow-400 bg-opacity-50">Belum Mulai</option>
                                <option value="berjalan" class="bg-orange-500 bg-opacity-50">Berjalan</option>
                                <option value="batal" class="bg-red-500 bg-opacity-50">Batal</option>
                                <option value="selesai" class="bg-green-600 bg-opacity-50">Selesai</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="w-40 text-gray-700 font-semibold text-right py-2 pr-2">Tanggal Mulai:</td>
                        {{-- tanggal mulai proyek --}}
                        <td class="py-2">
                            <input
                                type="date"
                                id="tanggalMulai"
                                class="w-full p-2 border border-gray-300 rounded-md"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="w-40 text-gray-700 font-semibold text-right py-2 pr-2">Estimasi Selesai:</td>
                        {{-- input estimasi selesai proyek --}}
                        <td class="py-2">
                            <input
                                type="date"
                                id="estimasiSelesai"
                                class="w-full p-2 border border-gray-300 rounded-md"
                            />
                        </td>
                    </tr>
                </table>
                {{-- /.table --}}
            <button 
            type="submit" 
            class="flex items-center ml-auto justify-center text-white font-bold bg-[#7284FA] py-2 px-4 rounded hover:bg-[#6173D4] transition-colors duration-300 col-span-1 mt-4"
            >
                Submit {{-- submit --}}
            </button>
        </form>
        {{-- /. form  --}}
    </div>
    {{-- /.wrapper form --}}
</section>
@endsection
{{-- /. section utama --}}