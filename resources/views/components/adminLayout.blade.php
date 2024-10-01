@extends('components/layout')
@section('layout')

{{-- import navbar  --}}
@include('components/navbar')
<div class="min-h-screen flex flex-row">
    {{-- sidebar --}}
    <aside class="bg-[#EFF0F2] text-white w-96 h-screen">
        <script src="{{ asset('js/dropdown.js') }}"></script>
        <head class="flex flex-col">
            <img src="{{ asset('img/logo.png') }}" alt="" class="h-24 w-auto my-16 m-auto">
            <div class="flex items-center justify-between py-4 px-6 bg-[#6F78B2] hover:bg-[#4C5487] ">
                <a href="#" class="block text-black font-bold text-lg">Dashboard</a>
                <img src="{{ asset('img/home.png') }}" alt="icon" class="h-4 w-auto">
            </div>
        </head>
        {{-- list proyek --}}
        <nav>
            {{-- Contoh proyek 1 --}}
            <ul>
                <li class="relative">
                    <div class="dropdown-trigger flex items-center justify-between py-4 px-6 bg-[#6F78B2] hover:bg-[#4C5487] cursor-pointer">
                        <a href="#" class="block text-black font-bold text-lg">Batamindo</a>
                        <img src="{{ asset('img/arrow.png') }}" alt="icon" class="h-[9px] w-auto transform transition-transform duration-300">
                    </div>
                    <ul class="dropdown-menu transition-all duration-500 ease-in-out overflow-hidden bg-[#EFEFEF]">
                        <li class="py-2 px-6 hover:bg-[#D8D8D8] flex items-center justify-between">
                            <a href="#" class="block text-black font-bold text-lg">Menpower</a>
                            <img src="{{ asset('img/manpower.png') }}" alt="icon" class="h-[18px] w-auto">
                        </li>
                        <li class="py-2 px-6 hover:bg-[#D8D8D8] flex items-center justify-between">
                            <a href="#" class="block text-black font-bold text-lg">Manhour</a>
                            <img src="{{ asset('img/manhour.png') }}" alt="icon" class="h-[18px] w-auto">
                        </li>
                        <li class="py-2 px-6 hover:bg-[#D8D8D8] flex items-center justify-between">
                            <a href="#" class="block text-black font-bold text-lg">QR GCN</a>
                            <img src="{{ asset('img/qr.png') }}" alt="icon" class="h-[18px] w-auto">
                        </li>
                    </ul>
                </li>                
            </ul>
            {{-- Contoh proyek 2 --}}
            <ul>
                <li class="relative">
                    <div class="dropdown-trigger flex items-center justify-between py-4 px-6 bg-[#6F78B2] hover:bg-[#4C5487] cursor-pointer">
                        <a href="#" class="block text-black font-bold text-lg">Polibatam</a>
                        <img src="{{ asset('img/arrow.png') }}" alt="icon" class="h-[9px] w-auto transform transition-transform duration-300">
                    </div>
                    <ul class="dropdown-menu transition-all duration-500 ease-in-out overflow-hidden bg-[#EFEFEF]">
                        <li class="py-2 px-6 hover:bg-[#D8D8D8] flex items-center justify-between">
                            <a href="#" class="block text-black font-bold text-lg">Menpower</a>
                            <img src="{{ asset('img/manpower.png') }}" alt="icon" class="h-[18px] w-auto">
                        </li>
                        <li class="py-2 px-6 hover:bg-[#D8D8D8] flex items-center justify-between">
                            <a href="#" class="block text-black font-bold text-lg">Manhour</a>
                            <img src="{{ asset('img/manhour.png') }}" alt="icon" class="h-[18px] w-auto">
                        </li>
                        <li class="py-2 px-6 hover:bg-[#D8D8D8] flex items-center justify-between">
                            <a href="#" class="block text-black font-bold text-lg">QR GCN</a>
                            <img src="{{ asset('img/qr.png') }}" alt="icon" class="h-[18px] w-auto">
                        </li>
                    </ul>
                </li>                
            </ul>
            {{-- Contoh proyek 3 --}}
            <ul>
                <li class="relative">
                    <div class="dropdown-trigger flex items-center justify-between py-4 px-6 bg-[#6F78B2] hover:bg-[#4C5487] cursor-pointer">
                        <a href="#" class="block text-black font-bold text-lg">Kantin Polibatam</a>
                        <img src="{{ asset('img/arrow.png') }}" alt="icon" class="h-[9px] w-auto transform transition-transform duration-300">
                    </div>
                    <ul class="dropdown-menu transition-all duration-500 ease-in-out overflow-hidden bg-[#EFEFEF]">
                        <li class="py-2 px-6 hover:bg-[#D8D8D8] flex items-center justify-between">
                            <a href="#" class="block text-black font-bold text-lg">Menpower</a>
                            <img src="{{ asset('img/manpower.png') }}" alt="icon" class="h-[18px] w-auto">
                        </li>
                        <li class="py-2 px-6 hover:bg-[#D8D8D8] flex items-center justify-between">
                            <a href="#" class="block text-black font-bold text-lg">Manhour</a>
                            <img src="{{ asset('img/manhour.png') }}" alt="icon" class="h-[18px] w-auto">
                        </li>
                        <li class="py-2 px-6 hover:bg-[#D8D8D8] flex items-center justify-between">
                            <a href="#" class="block text-black font-bold text-lg">QR GCN</a>
                            <img src="{{ asset('img/qr.png') }}" alt="icon" class="h-[18px] w-auto">
                        </li>
                    </ul>
                </li>                
            </ul>
            {{-- Contoh proyek 4 --}}
            <ul>
                <li class="relative">
                    <div class="dropdown-trigger flex items-center justify-between py-4 px-6 bg-[#6F78B2] hover:bg-[#4C5487] cursor-pointer">
                        <a href="#" class="block text-black font-bold text-lg">Tanjung Uncang Sebe...</a>
                        <img src="{{ asset('img/arrow.png') }}" alt="icon" class="h-[9px] w-auto transform transition-transform duration-300">
                    </div>
                    <ul class="dropdown-menu transition-all duration-500 ease-in-out overflow-hidden bg-[#EFEFEF]">
                        <li class="py-2 px-6 hover:bg-[#D8D8D8] flex items-center justify-between">
                            <a href="#" class="block text-black font-bold text-lg">Menpower</a>
                            <img src="{{ asset('img/manpower.png') }}" alt="icon" class="h-[18px] w-auto">
                        </li>
                        <li class="py-2 px-6 hover:bg-[#D8D8D8] flex items-center justify-between">
                            <a href="#" class="block text-black font-bold text-lg">Manhour</a>
                            <img src="{{ asset('img/manhour.png') }}" alt="icon" class="h-[18px] w-auto">
                        </li>
                        <li class="py-2 px-6 hover:bg-[#D8D8D8] flex items-center justify-between">
                            <a href="#" class="block text-black font-bold text-lg">QR GCN</a>
                            <img src="{{ asset('img/qr.png') }}" alt="icon" class="h-[18px] w-auto">
                        </li>
                    </ul>
                </li>                
            </ul>                 
        </nav>
    </aside>
    {{-- isian yield --}}
    <main class="ml-0 p-6 w-full transition-all duration-300 bg-[#E2B820]">
        <h2 class="text-2xl font-semibold mb-4">Nama Proyek</h2>
        {{-- section akan terlempar kesini dengan nama section adminlayout --}}
        @yield('adminlayout')
    </main>
</div>
@include('components/footer')

@endsection
