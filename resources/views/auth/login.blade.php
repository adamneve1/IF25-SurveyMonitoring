<x-guest-layout>
    {{-- Session Status --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="bg-cover bg-center bg-fixed" style="background-image: url('{{ asset('img/LKS.jpg') }}');">
            <div class="h-screen flex justify-center items-center">
                <div class="bg-white mx-4 p-8 rounded-2xl shadow-md w-full md:w-1/2 lg:w-1/3">
                    <div class="flex justify-center items-center mb-8">
                        <img src="{{ asset('img/logo.png') }}" class="w-20 h-20">
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold text-gray-700 mb-2" for="email">
                            Email Address
                        </label>
                        <input
                            class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-1 focus:ring-[#011638]"
                            id="email" name="email" type="email" placeholder="Masukkan Email Anda" required />
                    </div>
                    
                    <div class="mb-4">
                        <label class="block font-semibold text-gray-700 mb-2" for="password">
                            Password
                        </label>
                        <input
                            class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-1 focus:ring-[#011638]"
                            id="password" name="password" type="password" placeholder="Masukkan Password Anda" required />
                    </div>
                    
                    <div class="mb-6 mt-10">
                        <button
                            class="bg-[#EEC643] hover:bg-white hover:text-[#EEC643] w-full text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out"
                            type="submit">
                            Login
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-guest-layout>
