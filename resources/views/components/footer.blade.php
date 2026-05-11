<footer class="bg-white text-[#4B5563] pt-16 pb-6 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <!-- TOP SECTION -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 pb-10 border-b border-gray-200">

            <!-- LEFT -->
            <div>
                <!-- Logo -->
                <a href="{{ route('home') }}"
                   class="font-heading font-bold text-xl text-logo tracking-tight">
                    BetterEat
                </a>

                <!-- Description -->
                <p class="mt-5 text-sm leading-7 text-gray-500 max-w-md">
                    Kami hadir untuk menemani perjalanan kesehatanmu dengan nutrisi yang tepat dan cita rasa yang tak terlupakan.
                </p>

                <!-- Social Media -->
                <div class="flex items-center gap-3 mt-6">

                    <a href="#"
                       class="w-10 h-10 rounded-full bg-gray-100 hover:bg-[#556B2F] hover:text-white transition flex items-center justify-center">
                        <i class='bx bxl-twitter text-lg'></i>
                    </a>

                    <a href="#"
                       class="w-10 h-10 rounded-full bg-gray-100 hover:bg-[#556B2F] hover:text-white transition flex items-center justify-center">
                        <i class='bx bx-envelope text-lg'></i>
                    </a>

                    <a href="#"
                       class="w-10 h-10 rounded-full bg-gray-100 hover:bg-[#556B2F] hover:text-white transition flex items-center justify-center">
                        <i class='bx bxl-instagram text-lg'></i>
                    </a>

                </div>
            </div>

            <!-- RIGHT -->
            <div class="grid grid-cols-3 gap-8">

                <!-- Navigasi -->
                <div>
                    <h4 class="text-sm font-semibold text-[#556B2F] mb-4">
                        Navigasi
                    </h4>

                    <ul class="space-y-3 text-sm text-gray-500">
                        <li>
                            <a href="{{ route('home') }}"
                               class="hover:text-be-button transition font-bold">
                                Home
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('resep') }}"
                               class="hover:text-be-button transition">
                                Resep Sehat
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('kalkulator') }}"
                               class="hover:text-[be-button transition">
                                Kalkulator Gizi
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('community') }}"
                               class="hover:text-be-button transition">
                                Community Hub
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Bantuan -->
                <div>
                    <h4 class="text-sm font-semibold text-[#556B2F] mb-4">
                        Bantuan
                    </h4>

                    <ul class="space-y-3 text-sm text-gray-500">
                        <li>
                            <a href="#"
                               class="hover:text-be-button transition">
                                Tentang Kami
                            </a>
                        </li>

                        <li>
                            <a href="#"
                               class="hover:text-be-button transition">
                                Kontak
                            </a>
                        </li>

                        <li>
                            <a href="#"
                               class="hover:text-be-button transition">
                                FAQ
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h4 class="text-sm font-semibold text-be-button mb-4">
                        Legal
                    </h4>

                    <ul class="space-y-3 text-sm text-gray-500">
                        <li>
                            <a href="#"
                               class="hover:text-be-button transition">
                                Privacy Policy
                            </a>
                        </li>

                        <li>
                            <a href="#"
                               class="hover:text-be-button transition">
                                Terms of Service
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

        <!-- BOTTOM -->
        <div class="pt-6">
            <p class="text-sm text-gray-400">
                &copy 2026 BetterEat Indonesia. Nurturing your health journey.
            </p>
        </div>

    </div>
</footer>   