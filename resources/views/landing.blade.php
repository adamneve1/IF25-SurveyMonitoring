<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LKS BATAM - Survey Monitoring</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="font-sans">
<main>
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-blue-900 to-indigo-800 text-[#FAB12F] overflow-hidden h-screen">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        
        <!-- Logo LKS di pojok kiri atas -->
        <div class="absolute -top-0 left-4 z-20">
            <img src="https://www.pt-lks.com/wp-content/uploads/2022/05/loggo.png" alt="LKS Logo" class="w-32 md:w-48" onerror="this.style.display='none'">
        </div>
        
        <div class="absolute inset-0 bg-cover bg-center opacity-55" style="background-image: url('https://images.unsplash.com/photo-1625722776951-39123efa4dc3?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');"></div>
        
        <!-- Centered Content -->
        <div class="container mx-auto px-4 py-24 md:py-32 relative z-10 flex items-center justify-center h-full">
            <div class="text-center">
                <!-- Company Info -->
                <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight text-white shadow-lg">
                    Safety.<br>Good Quality.<br>Competitive Cost.
                </h1>
                <p class="text-white text-lg mb-8">Aplikasi untuk manajemen Manpower dan Manhour proyek Anda.</p>
                
                <!-- Tombol Login -->
                <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <!-- Tombol Login Admin -->
                    <a href="/admin/login" class="bg-[#091057] border-2 border-[#FAB12F] text-white font-semibold px-8 py-3 rounded-xl hover:bg-[#FAB12F] hover:text-black group transition duration-300 text-center flex items-center justify-center space-x-2 w-full sm:w-auto">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.286Zm-3.14-1.168A11.953 11.953 0 0 1 6 3.598" />
                        </svg>
                        <span>Login Admin</span>
                    </a>
                    <!-- Tombol Login Operational -->
                    <a href="/operational/login" class="bg-[#FAB12F] border-2 border-white text-black font-semibold px-8 py-3 rounded-xl hover:bg-white hover:text-black group transition duration-300 text-center flex items-center justify-center space-x-2 w-full sm:w-auto">
                         <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m-7.5-2.962a3.752 3.752 0 0 1-4.238-4.238 3.752 3.752 0 0 1 4.238-4.238 3.752 3.752 0 0 1 4.238 4.238 3.752 3.752 0 0 1-4.238 4.238Zm0-9a4.5 4.5 0 0 0-4.5 4.5 4.5 4.5 0 0 0 4.5 4.5 4.5 4.5 0 0 0 4.5-4.5 4.5 4.5 0 0 0-4.5-4.5Zm12.741 8.796a4.5 4.5 0 0 1-5.656 5.656 4.5 4.5 0 0 1-5.656-5.656 4.5 4.5 0 0 1 5.656-5.656 4.5 4.5 0 0 1 5.656 5.656Z" />
                        </svg>
                        <span>Login Operasional</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Decorative Element -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white"/>
            </svg>
        </div>
    </section>
</main>

<div class="container mx-auto mt-16 p-8 rounded-lg shadow-lg max-w-7xl">
    <div class="grid md:grid-cols-2 gap-6 items-center">
        <!-- Kolom Gambar -->
        <div class="flex justify-center p-10">
            <img src="https://placehold.co/400x400/091057/FFFFFF?text=LKS" alt="Visi Misi LKS" class="rounded-md bg-white w-96 h-96 object-cover">
        </div>
        
        <!-- Kolom Teks -->
        <div class="space-y-8">
            <!-- Visi -->
            <div class="bg-[#091057] p-6 rounded-md shadow-md max-w-lg relative">
                <div class="absolute -top-6 left-1/2 transform -translate-x-1/2">
                    <div class="rounded-full bg-[#EB8317] p-2 shadow-lg">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                    </div>
                </div>
                <h1 class="text-center text-white pb-2 text-3xl font-semibold mt-4">VISI</h1>
                <p class="text-white text-justify">
                    Menjadi mitra bisnis yang paling dipercaya dan diandalkan oleh industri, menyediakan produk kelas dunia, keahlian luar biasa, serta semangat untuk kualitas dan kepuasan pelanggan.
                </p>
            </div>

            <!-- Misi -->
            <div class="bg-[#091057] p-6 rounded-md shadow-md max-w-lg relative">
                <div class="absolute -top-6 left-1/2 transform -translate-x-1/2">
                    <div class="rounded-full bg-[#EB8317] p-2 shadow-lg">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <h1 class="text-center text-white pb-2 text-3xl font-semibold mt-4">MISI</h1>
                <p class="text-white text-justify">
                    Berhasil melaksanakan berbagai proyek dengan keamanan, kualitas yang baik, biaya yang kompetitif, dan pengiriman tepat waktu.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="p-10 max-w-screen-lg mx-auto">
    <div class="text-center mb-4">
        <p class="mt-4 text-sm leading-7 text-gray-500 font-regular">
            THE TEAM
        </p>
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Ahli Terbaik<span class="text-indigo-600"> Kami</span>
        </h3>
    </div>
    <div class="sm:grid grid-cols-1 md:grid-cols-2 gap-10 my-10">

        <div class="max-w-sm w-full lg:max-w-full lg:flex mx-auto my-10">
            <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden"
                 style="background-image: url('https://www.pt-lks.com/wp-content/uploads/2019/01/01.jpg')"
                 title="Iswendra">
            </div>
            <div class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-[#EB8317] rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between">
                <div class="">
                    <a href="#" class="text-white font-bold text-xl mb-2 hover:text-indigo-600 transition duration-500 ease-in-out">ISWENDRA</a>
                    <p class="text-sm text-white">President</p>
                    <p class="text-white text-base mt-4">Bapak Iswendra adalah Direktur PT. Lancang Kuning Sukses.</p>
                </div>
            </div>
        </div>

        <div class="max-w-sm w-full lg:max-w-full lg:flex mx-auto my-10">
            <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden"
                 style="background-image: url('https://www.pt-lks.com/wp-content/uploads/2019/01/02.jpg')"
                 title="Prastiwo">
            </div>
            <div class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between">
                <div class="">
                    <a href="#" class="text-gray-900 font-bold text-xl mb-2 hover:text-indigo-600 transition duration-500 ease-in-out">PRASTIWO</a>
                    <p class="text-sm text-gray-600">Project Director</p>
                    <p class="text-black text-base mt-4">Seorang Manajer Proyek (bersertifikasi oleh Project Management Institute) dengan pengalaman lebih dari 16 tahun.</p>
                </div>
            </div>
        </div>

        <div class="max-w-sm w-full lg:max-w-full lg:flex mx-auto my-10">
            <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden"
                 style="background-image: url('https://www.pt-lks.com/wp-content/uploads/2022/11/lisa-scaled.jpg')"
                 title="Alysha">
            </div>
            <div class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-[#091057] rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between">
                <div class="">
                    <a href="#" class="text-white font-bold text-xl mb-2 hover:text-indigo-600 transition duration-500 ease-in-out">Alysha</a>
                    <p class="text-sm text-white">Finance Corporate</p>
                    <p class="text-white text-base mt-4">Alysha Ramadhani Syahwendra, S.Ak, menjabat sebagai Finance Corporate sejak Agustus 2022.</p>
                </div>
            </div>
        </div>
        
        <div class="max-w-sm w-full lg:max-w-full lg:flex mx-auto my-10">
            <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden"
                 style="background-image: url('https://www.pt-lks.com/wp-content/uploads/2019/01/04-1.jpg')"
                 title="Subandi">
            </div>
            <div class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between">
                <div class="">
                    <a href="#" class="text-gray-900 font-bold text-xl mb-2 hover:text-indigo-600 transition duration-500 ease-in-out">SUBANDI</a>
                    <p class="text-sm text-gray-600">Business Development Manager</p>
                    <p class="text-black text-base mt-4">Bapak Subandi adalah salah satu pionir di PT. Lancang Kuning Sukses.</p>
                </div>
            </div>
        </div>
        
    </div>
</div>

<!-- FOOTER -->
<footer class="bg-[#091057] text-white py-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center text-center lg:text-left justify-items-center">
            <div>
                <h4 class="text-lg font-bold mb-4">Lancang Kuning Sukses</h4>
                <p class="text-white text-md">We perform Engineering, Procurement,</p>
                <p class="text-white text-md">Construction Management, Manufacturing</p>
                <p class="text-white text-md">& Installation for various projects in Batam</p>
            </div>
            <div>
                <h4 class="text-lg font-bold mb-4">Contact Us</h4>
                <ul class="space-y-2">
                    <li class="flex flex-row items-center gap-2 justify-center lg:justify-start">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <a href="mailto:admin@pt-lks.com" class="hover:text-gray-300">admin@pt-lks.com</a>
                    </li>
                    <li class="flex flex-row items-center gap-2 justify-center lg:justify-start">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                        </svg>
                        <a href="tel:087784095176" class="hover:text-gray-300">087784095176</a>
                    </li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-bold mb-4">Follow Us</h4>
                <div class="flex justify-center lg:justify-start space-x-4">
                    <div class="bg-white rounded-xl p-1 flex items-center text-center justify-center">
                        <a href="#" class="hover:text-blue-400">
                            <svg class="h-5 w-5 text-black" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z"/><path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4" /></svg>
                        </a>
                    </div>
                    <div class="bg-white rounded-xl p-1 flex items-center text-center justify-center">
                        <a href="#" class="hover:text-blue-400">
                            <svg class="h-5 w-5 text-black" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z"/> <rect x="4" y="4" width="16" height="16" rx="4" /> <circle cx="12" cy="12" r="3" /> <line x1="16.5" y1="7.5" x2="16.5" y2="7.501" /></svg>
                        </a>
                    </div>
                    <div class="bg-white rounded-xl p-1 flex items-center text-center justify-center">
                        <a href="#" class="hover:text-pink-500">
                            <svg class="h-5 w-5 text-black" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z"/> <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" /></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-8 pt-8 border-t border-gray-700">
            <p>
                <span class="font-light text-[#EB8317]">© 2024 Lancang Kuning Sukses.</span> All rights reserved.
            </p>
        </div>
    </div>
</footer>
</body>
</html>
