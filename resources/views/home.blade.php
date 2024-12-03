<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
@include('welcome')

<body>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LKS BATAM</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
    </style>
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
            <img src="https://www.pt-lks.com/wp-content/uploads/2022/05/loggo.png" class="w-32 md:w-48">
        </div>
        
        <div class="absolute inset-0 bg-cover bg-center opacity-55" style="background-image: url('https://images.unsplash.com/photo-1625722776951-39123efa4dc3?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');"></div>
        
        <!-- Centered Content -->
        <div class="container mx-auto px-4 py-24 md:py-32 relative z-10 flex items-center justify-center h-full">
            <div class="text-center">
                <!-- Company Info -->
                <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                    Safety.<br>Good Quality.<br>Competitive Cost.
                </h1>
                <div class="flex justify-center items-center space-x-2">
                    <a href="#" class="bg-[#FAB12F] border-2 border-white text-white font-semibold px-8 py-3 rounded-xl hover:bg-white hover:text-black group transition duration-300 text-center flex items-center space-x-2">
                        <span>Login</span>
                        <svg class="h-6 w-6 text-white group-hover:text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
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


    <div class="container mx-auto mt-16 p-8  rounded-lg shadow-lg max-w-7xl  ">
    <div class="grid grid-cols-2 gap-6 items-center  ">
        <!-- Kolom Gambar -->
        <div class="flex justify-center p-10 shadow-x ">
            <img src="./asset/gambar 2.svg" alt="Deskripsi Gambar" class="rounded-md bg-white  w-96 h-96">
        </div>
        

        <!-- Kolom Teks -->
        <div class="space-y-8 ">
            <!-- Visi -->
            <div class="bg-[#091057] p-4 rounded-md shadow-md max-w-lg relative">
                <!-- Icon Love -->
                 <div class="absolute -top-6 left-1/2 transform -translate-x-1/2">
                    <div class="rounded-full bg-[#EB8317] p-2 shadow-lg">
                        <svg class="h-6 w-6 text-white"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                    </div>
                </div>
                <!-- Content -->
                 <h1 class="text-center  text-white pb-2 text-3xl font-semibold">VISI</h1>
                 <p class="text-white text-justify">
                 Menjadi mitra bisnis yang paling dipercaya dan diandalkan oleh industri, menyediakan produk kelas dunia, keahlian luar biasa, serta semangat untuk kualitas dan kepuasan pelanggan.                </p>
            </div>


            <!-- Misi -->
            <div class="bg-[#091057] p-4 rounded-md shadow-md max-w-lg relative">
                <!-- Icon Love -->
                 <div class="absolute -top-6 left-1/2 transform -translate-x-1/2">
                    <div class="rounded-full bg-[#EB8317] p-2 shadow-lg">
                        <svg class="h-6 w-6 text-white"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <!-- Content -->
                <h1 class="text-center text-white pb-2 text-3xl font-semibold">MISI</h1>
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
    <div class="sm:grid grid-cols-2 gap-6 my-10">

        <div class="max-w-sm w-full lg:max-w-full lg:flex mx-auto my-10">
            <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden"
                style="background-image: url('https://www.pt-lks.com/wp-content/uploads/2019/01/01.jpg')"
                title="Woman holding a mug">
            </div>
            <div
                class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-[#EB8317] rounded-b lg:rounded-b-none lg:rounded-r p-4">
                <div class="">
                    <a href="#"
                        class="text-white font-bold text-xl mb-2 hover:text-indigo-600 transition duration-500 ease-in-out">ISWENDRA
                    </a>
                    <p class="text-sm text-white">
                        President
                    </p>
                    <p class="text-white text-base mt-4">Bapak Iswendra adalah Direktur PT. Lancang Kuning Sukses. 
                    </p>
                    

                    <div class="my-4 flex gap-x-4 ">
                    <div class="bg-white rounded-2xl w-8 h-8 flex items-center justify-center shadow-lg">
                            <a href="#" class="flex items-center justify-center">
                                <svg class="h-5 w-5 text-slate-900 hover:text-blue-500 transition duration-300"viewBox="0 0 24 24"  fill="none"stroke="currentColor" stroke-width="2"stroke-linecap="round"stroke-linejoin="round">
                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                                </svg>
                            </a>
                        </div>
                        <div class="bg-white rounded-2xl w-8 h-8 flex items-center justify-center shadow-lg">
                            <a href="#" class="flex items-center justify-center">
                            <svg class="h-5 w-5 text-slate-900"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z"/>
                                <rect x="4" y="4" width="16" height="16" rx="4" />
                                <circle cx="12" cy="12" r="3" />
                                <line x1="16.5" y1="7.5" x2="16.5" y2="7.501" />
                            </svg>
                            </a>
                        </div>
                        <div class="bg-white rounded-2xl w-8 h-8 flex items-center justify-center shadow-lg">
                            <a href="#" class="flex items-center justify-center">
                            <svg class="h-5 w-5 text-slate-900"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">
                                <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z" />
                            </svg>
                            </a>
                        </div>


                    </div>

                </div>

            </div>

        </div>

        <div class="max-w-sm w-full lg:max-w-full lg:flex mx-auto my-10">
            <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden"
                style="background-image: url('https://www.pt-lks.com/wp-content/uploads/2019/01/02.jpg')"
                title="Woman holding a mug">
            </div>
            <div
                class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4">
                <div class="">
                    <a href="#"
                        class="text-gray-900 font-bold text-xl mb-2 hover:text-indigo-600 transition duration-500 ease-in-out">PRASTIWO
                        </a>
                    <p class="text-sm text-gray-600">
                        Project Director
                    </p>
                    <p class="text-black text-base mt-4">Seorang Manajer Proyek (bersertifikasi oleh Project Management Institute) dengan pengalaman lebih dari 16 tahun
                    </p>

                    <div class="my-4 flex gap-x-4">
                    <div class="bg-[#EB8317] rounded-2xl w-8 h-8 flex items-center justify-center shadow-lg">
                            <a href="#" class="flex items-center justify-center">
                                <svg class="h-5 w-5 text-white hover:text-blue-500 transition duration-300"viewBox="0 0 24 24"  fill="none"stroke="currentColor" stroke-width="2"stroke-linecap="round"stroke-linejoin="round">
                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                                </svg>
                            </a>
                        </div>
                        <div class="bg-[#EB8317] rounded-2xl w-8 h-8 flex items-center justify-center shadow-lg">
                            <a href="#" class="flex items-center justify-center">
                            <svg class="h-5 w-5 text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z"/>
                                <rect x="4" y="4" width="16" height="16" rx="4" />
                                <circle cx="12" cy="12" r="3" />
                                <line x1="16.5" y1="7.5" x2="16.5" y2="7.501" />
                            </svg>
                            </a>
                        </div>
                        <div class="bg-[#EB8317] rounded-2xl w-8 h-8 flex items-center justify-center shadow-lg">
                            <a href="#" class="flex items-center justify-center">
                            <svg class="h-5 w-5 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">
                                <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z" />
                            </svg>
                            </a>
                        </div>


                    </div>

                </div>

            </div>
        </div>
        <div class="max-w-sm w-full lg:max-w-full lg:flex mx-auto my-10">
            <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden"
                style="background-image: url('https://www.pt-lks.com/wp-content/uploads/2019/01/04-1.jpg')"
                title="Woman holding a mug">
            </div>
            <div
                class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4">
                <div class="">
                    <a href="#"
                        class="text-gray-900  font-bold text-xl mb-2 hover:text-indigo-600 transition duration-500 ease-in-out">SUBANDI
                    </a>
                    <p class="text-sm text-gray-600">
                    Business Development Manager
                    </p>
                    <p class="text-black text-base mt-4">Bapak Subandi adalah salah satu pionir di PT. Lancang Kuning Sukses
                    </p>

                    <div class="my-4 flex gap-x-4">
                    <div class="bg-[#EB8317] rounded-2xl w-8 h-8 flex items-center justify-center shadow-lg">
                            <a href="#" class="flex items-center justify-center ">
                                <svg class="h-5 w-5 text-white  transition duration-300"viewBox="0 0 24 24"  fill="none"stroke="currentColor" stroke-width="2"stroke-linecap="round"stroke-linejoin="round">
                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                                </svg>
                            </a>
                        </div>
                        <div class="bg-[#EB8317] rounded-2xl w-8 h-8 flex items-center justify-center shadow-lg">
                            <a href="#" class="flex items-center justify-center">
                            <svg class="h-5 w-5 text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z"/>
                                <rect x="4" y="4" width="16" height="16" rx="4" />
                                <circle cx="12" cy="12" r="3" />
                                <line x1="16.5" y1="7.5" x2="16.5" y2="7.501" />
                            </svg>
                            </a>
                        </div>
                        <div class="bg-[#EB8317] rounded-2xl w-8 h-8 flex items-center justify-center shadow-lg">
                            <a href="#" class="flex items-center justify-center">
                            <svg class="h-5 w-5 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">
                                <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z" />
                            </svg>
                            </a>
                        </div>


                    </div>

                </div>

            </div>
        </div>
        <div class="max-w-sm w-full lg:max-w-full lg:flex mx-auto my-10">
            <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden"
                style="background-image: url('https://www.pt-lks.com/wp-content/uploads/2022/11/lisa-scaled.jpg')">
            </div>
            <div
                class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-[#091057] rounded-b lg:rounded-b-none lg:rounded-r p-4">
                <div class="">
                    <a href="#"
                        class="text-white font-bold text-xl mb-2 hover:text-indigo-600 transition duration-500 ease-in-out">Alysha
                    </a>
                    <p class="text-sm text-white">
                    Finance Corporate
                    </p>
                    <p class="text-white text-base mt-4">Alysha Ramadhani Syahwendra, S.Ak, menjabat sebagai Finance Corporate sejak Agustus 2022
                    </p>

                    <div class="my-4 flex gap-x-4">
                        <div class="bg-white rounded-2xl w-8 h-8 flex items-center justify-center shadow-lg">
                            <a href="#" class="flex items-center justify-center">
                                <svg class="h-5 w-5 text-slate-900 hover:text-blue-500 transition duration-300"viewBox="0 0 24 24"  fill="none"stroke="currentColor" stroke-width="2"stroke-linecap="round"stroke-linejoin="round">
                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                                </svg>
                            </a>
                        </div>
                        <div class="bg-white rounded-2xl w-8 h-8 flex items-center justify-center shadow-lg">
                            <a href="#" class="flex items-center justify-center">
                            <svg class="h-5 w-5 text-slate-900"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z"/>
                                <rect x="4" y="4" width="16" height="16" rx="4" />
                                <circle cx="12" cy="12" r="3" />
                                <line x1="16.5" y1="7.5" x2="16.5" y2="7.501" />
                            </svg>
                            </a>
                        </div>
                        <div class="bg-white rounded-2xl w-8 h-8 flex items-center justify-center shadow-lg">
                            <a href="#" class="flex items-center justify-center">
                            <svg class="h-5 w-5 text-slate-900"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">
                                <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z" />
                            </svg>
                            </a>
                        </div>
                        
                        
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>




<!-- FOOTER -->
<footer class="bg-[#091057] text-white py-8">
    <div class="container mx-auto px-4">
        <!-- Footer Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center text-center lg:text-left justify-items-center">
            <!-- Column 1: Company Info -->
            <div>
                <h4 class="text-lg font-bold mb-4">Lancang Kuning Sukses</h4>
                <p class="text-white text-md">We perform Engineering, Procurement,</p>
                <p class="text-white text-md">Construction Management, Manufacturing</p>
                <p class="text-white text-md">& Installation for various projects in Batam</p>
            </div>

            <!-- Column 2: Contact Info -->
            <div>
                <h4 class="text-lg font-bold mb-4">Contact Us</h4>
                <ul class="space-y-2">
                    <li class="flex flex-row items-center gap-2 justify-center lg:justify-start">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <a href="#" class="hover:text-gray-300">admin@pt-lks.com</a>
                    </li>
                    <li class="flex flex-row items-center gap-2 justify-center lg:justify-start">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                            <line x1="15" y1="7" x2="15" y2="7.01" />
                            <line x1="18" y1="7" x2="18" y2="7.01" />
                            <line x1="21" y1="7" x2="21" y2="7.01" />
                        </svg>
                        <a href="#" class="hover:text-gray-300">087784095176</a>
                    </li>
                </ul>
            </div>

            <!-- Column 3: Follow Us -->
            <div>
                <h4 class="text-lg font-bold mb-4">Follow Us</h4>
                <div class="flex justify-center lg:justify-start space-x-4">
                    <div class="bg-white rounded-xl p-1 flex items-center text-center justify-center">
                        <a href="#" class="hover:text-blue-400">
                            <svg class="h-5 w-5 text-black"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/><path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4" /></svg>
                        </a>
                    </div>
                    
                    <div class="bg-white rounded-xl p-1 flex items-center text-center justify-center">
                        <a href="#" class="hover:text-blue-400">
                            <svg class="h-5 w-5 text-black"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <rect x="4" y="4" width="16" height="16" rx="4" />  <circle cx="12" cy="12" r="3" />  <line x1="16.5" y1="7.5" x2="16.5" y2="7.501" /></svg>
                        </a>
                    </div>
                    <div class="bg-white rounded-xl p-1 flex items-center text-center justify-center">
                        <a href="#" class="hover:text-pink-500">
                            <svg class="h-5 w-5 text-black"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" /></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="text-center mt-5 border-t border-white">
            <p class="mt-5">
                <span class="font-light text-[#EB8317]">© 2024 Lancang Kuning Sukses.</span> All rights reserved.
            </p>
        </div>
    </div>
</footer>
</body>
</html>
