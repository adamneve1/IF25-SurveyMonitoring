<header class="bg-[#0E21A1] w-full h-[70px] text-white flex items-center justify-between p-4">
    {{-- button burger --}}
    <button id="burger" class="text-white focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>
    <div class="relative">
        <img id="profileImage" src="{{ asset('img/profil.png') }}" alt="profil" class="h-10 rounded-full cursor-pointer ">
        {{-- dropdown menu --}}
        <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-10 px-2">
            <a href="/" class="block px-4 py-2 text-sm text-black font-medium hover:bg-gray-400 rounded-md">Logout</a>
        </div>
    </div>
    <script src="{{ asset('js/profil.js') }}"></script>
</header>