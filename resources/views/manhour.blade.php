{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.main')

@section('title', 'Manhour | PT. Lancang Kuning Sukses')

@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Manhour</h1>
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

@section('content')
{{-- col main --}}
<section class="w-full flex flex-row items-center justify-center px-10 py-4">
    {{-- table --}}
    <div class="w-full flex flex-col justify-center">
        {{-- Form --}}
        <form action="" method="POST" class="w-full grid grid-cols-5 gap-8 mb-2">

            {{-- input proyek/lk --}}
            <div class="flex flex-col col-span-2">
                <label for="">Proyek / LK</label>
                <input type="text" name="proyek" id="proyek" class="text-black w-full" placeholder="Proyek / LK">
            </div>
        
            {{-- input IDL --}}
            <div class="flex flex-col col-span-1">
                <label for="idl">IDL</label>
                <input type="number" name="idl" id="idl" class="text-black w-full" placeholder="IDL" oninput="calculateTotal()">
            </div>
        
            {{-- input DL --}}
            <div class="flex flex-col col-span-1">
                <label for="dl">DL</label>
                <input type="number" name="dl" id="dl" class="text-black w-full" placeholder="DL" oninput="calculateTotal()">
            </div>
        
            {{-- Total --}}
            <div class="flex flex-col col-span-1">
                <label for="total">Total</label>
                <input type="number" name="total" id="total" class="text-black bg-gray-200 w-full" placeholder="Total" readonly>
            </div>
        
            {{-- Input area --}}
            <div class="flex flex-col col-span-2">
                <label for="area">Area</label>
                <input type="text" name="area" id="area" class="text-black w-full" placeholder="Area">
            </div>
        
            <button type="submit" class="flex items-center justify-center text-white font-bold bg-[#7284FA] py-2 px-4 rounded hover:bg-[#6173D4] transition-colors duration-300 col-span-1 mt-4">
                <img src="{{ asset('img/refresh.png') }}" alt="" class="mr-2"> <!-- Icon with margin for spacing -->
                Submit
            </button>
        
            <script>
                function calculateTotal() {
                    const idl = parseFloat(document.getElementById('idl').value) || 0; // Get IDL value
                    const dl = parseFloat(document.getElementById('dl').value) || 0;   // Get DL value
                    const total = idl + dl; // Calculate total
                    document.getElementById('total').value = total; // Set total to the Total input
                }
            </script>
        </form>
        {{-- /. form  --}}
        <table class="w-full border border-gray-300">
            <thead class="border-b-2 border-gray-300 bg-blue-600">
                <tr>
                    <th class="border border-gray-300 py-2 px-1 text-center text-white">No</th>
                    <th class="border border-gray-300 py-2 px-4 text-center text-white">Proyek/LK</th>
                    <th class="border border-gray-300 py-2 px-4 text-center text-white">IDL</th>
                    <th class="border border-gray-300 py-2 px-4 text-center text-white">DL</th>
                    <th class="border border-gray-300 py-2 px-4 text-center text-white">Total</th>
                    <th class="border border-gray-300 py-2 px-4 text-center text-white">Proyek/Area</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @for ($i = 1; $i <= 7; $i++)
                    <tr>
                        <td class="border border-gray-300 py-2 px-2 text-center">{{ $i }}</td>
                        <td class="border border-gray-300 py-2 px-2 text-left">Proyek {{ $i }}</td>
                        <td class="border border-gray-300 py-2 px-2 text-left">IDL {{ $i }}</td>
                        <td class="border border-gray-300 py-2 px-2 text-left">DL {{ $i }}</td>
                        <td class="border border-gray-300 py-2 px-2 text-left">Total {{ $i }}</td>
                        <td class="border border-gray-300 py-2 px-2 text-left">Proyek Area {{ $i }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>                
    {{-- /. table --}}
</section>


@endsection
