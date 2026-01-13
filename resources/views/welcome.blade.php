<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Luxe - Premium Laundry Service</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('images/LuxeLogo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased text-gray-600 bg-gray-50">

    <nav x-data="{ open: false }" class="fixed z-50 w-full transition-all duration-300 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="px-6 mx-auto max-w-7xl lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <div class="flex-shrink-0">
                    <a href="/" class="flex items-center gap-2">
                        <h1 class="font-serif text-3xl italic font-bold text-primary">Luxe</h1>
                    </a>
                </div>

                <div class="hidden md:block">
                    <div class="flex items-baseline space-x-8">
                        <a href="#home" class="text-sm font-medium text-gray-900 hover:text-primary transition-colors">Home</a>
                        <a href="#about" class="text-sm font-medium text-gray-500 hover:text-primary transition-colors">About Us</a>
                        <a href="#services" class="text-sm font-medium text-gray-500 hover:text-primary transition-colors">Services</a>
                    </div>
                </div>

                <div class="hidden md:block">
                    @if (Route::has('login'))
                        <div class="flex items-center gap-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 text-sm font-bold text-white transition-all rounded-lg bg-primary hover:brightness-110 shadow-lg shadow-primary/30">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-primary">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-bold text-white transition-all rounded-lg bg-primary hover:brightness-110 shadow-lg shadow-primary/30">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>

                <div class="flex -mr-2 md:hidden">
                    <button @click="open = !open" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                        <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div :class="{'block': open, 'hidden': !open}" class="hidden bg-white border-b border-gray-100 md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="#home" class="block px-3 py-2 text-base font-medium text-gray-900 rounded-md hover:bg-gray-50 hover:text-primary">Home</a>
                <a href="#about" class="block px-3 py-2 text-base font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-primary">About Us</a>
                <a href="#services" class="block px-3 py-2 text-base font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-primary">Services</a>
                @if (Route::has('login'))
                    <div class="pt-4 mt-4 border-t border-gray-100">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="block px-3 py-2 text-base font-bold text-primary">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-gray-600">Log in</a>
                            <a href="{{ route('register') }}" class="block px-3 py-2 text-base font-bold text-primary">Register</a>
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <section id="home" class="relative pt-32 pb-20 overflow-hidden bg-white lg:pt-40 lg:pb-28">
        <div class="px-6 mx-auto max-w-7xl lg:px-8">
            <div class="grid items-center gap-12 lg:grid-cols-2">
                
                <div class="max-w-2xl">
                    <div class="inline-flex items-center px-3 py-1 mb-6 text-xs font-medium rounded-full bg-primary/10 text-primary">
                        <span class="flex w-2 h-2 mr-2 rounded-full bg-primary"></span>
                        #1 Premium Laundry Service
                    </div>
                    
                    <h1 class="mb-6 font-serif text-5xl italic font-bold leading-tight text-gray-900 lg:text-6xl">
                        Care for your clothes, <br>
                        <span class="text-primary">Luxe</span> for your life.
                    </h1>
                    
                    <div class="mb-8 text-lg leading-relaxed text-gray-600 min-h-[120px] sm:min-h-[100px] flex items-center overflow-hidden">
                        <p id="quote-text" class="transform transition-all duration-500 ease-in-out opacity-100 translate-y-0">
                            Fokus kuliah dan aktivitasmu, biar <span class="italic font-bold text-primary">Luxe</span> yang urus cucian kotormu.
                        </p>
                    </div>

                    <div class="flex flex-col gap-4 sm:flex-row">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-white transition-all rounded-xl bg-primary hover:brightness-110 shadow-xl shadow-primary/20 hover:-translate-y-1">
                            Get Started
                        </a>
                        
                        <a href="#about" class="inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-gray-700 transition-all bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:border-gray-300">
                            Learn More
                        </a>
                    </div>
                    
                    <div class="flex items-center gap-8 mt-12 text-gray-500">
                        <div>
                            <p class="text-3xl font-bold text-gray-900">5k+</p>
                            <p class="text-sm">Happy Clients</p>
                        </div>
                        <div class="w-px h-10 bg-gray-200"></div>
                        <div>
                            <p class="text-3xl font-bold text-gray-900">24h</p>
                            <p class="text-sm">Express Delivery</p>
                        </div>
                    </div>
                </div>

                <div class="relative lg:ml-auto">
                    <div class="absolute -top-24 -right-24 w-80 h-80 bg-primary/20 rounded-full blur-3xl opacity-50 animate-pulse"></div>
                    <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-blue-100 rounded-full blur-3xl opacity-50"></div>
                    <div class="relative overflow-hidden shadow-2xl rounded-2xl aspect-[4/3] rotate-2 hover:rotate-0 transition-all duration-500 group">
                        <img src="{{ asset('images/loginpageimage.jpeg') }}" alt="Luxe Laundry" class="object-cover w-full h-full transform group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute bottom-6 left-6 p-4 bg-white/90 backdrop-blur rounded-xl shadow-lg border border-white/50 max-w-xs">
                            <div class="flex items-center gap-3">
                                <div class="p-2 text-white rounded-lg bg-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800">Order Completed</p>
                                    <p class="text-xs text-gray-500">Just now</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="py-20 bg-white border-t border-gray-100 scroll-mt-10">
        <div class="px-6 mx-auto max-w-7xl lg:px-8">
            <div class="grid items-center gap-16 lg:grid-cols-2">
                
                <div class="relative order-2 lg:order-1">
                    <div class="relative overflow-hidden shadow-xl rounded-3xl bg-gray-100 aspect-square border border-gray-100">
                         <img src="{{ asset('images/mesincuci.png') }}" alt="Tentang Luxe Laundry" class="object-cover w-full h-full">
                    </div>
                    <div class="absolute -bottom-10 -right-10 w-40 h-40 rounded-full bg-primary/10 -z-10"></div>
                </div>

                <div class="order-1 lg:order-2">
                    <div class="inline-flex items-center px-3 py-1 mb-6 text-xs font-medium rounded-full bg-gray-100 text-gray-600">
                        Tentang Kami
                    </div>
                    <h2 class="mb-6 font-serif text-4xl italic font-bold text-gray-900">
                        Apa itu <span class="text-primary">Luxe?</span>
                    </h2>
                    
                    <div class="space-y-6 text-lg leading-relaxed text-gray-600">
                        <p>
                            <strong class="text-gray-900">Luxe</strong> adalah platform layanan laundry modern yang dirancang khusus untuk memudahkan hidup mahasiswa dan pekerja profesional. Kami paham betapa berharganya waktu Anda.
                        </p>
                        <p>
                            Memadukan teknologi pemesanan online yang praktis dan standar pencucian premium, Luxe hadir sebagai solusi agar Anda tidak perlu lagi pusing memikirkan tumpukan pakaian kotor.
                        </p>
                        <p>
                            Dengan memesan lewat aplikasi, anda bisa tahu status pakaian anda, kapan anda harus mengambil pakian anda
                        </p>
                    </div>

                    <div class="pt-8 mt-8 border-t border-gray-100">
                        <ul class="grid gap-4 sm:grid-cols-2">
                            <li class="flex items-center gap-3">
                                <span class="flex items-center justify-center w-6 h-6 text-white rounded-full bg-primary shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"></path></svg>
                                </span>
                                <span class="text-sm font-medium text-gray-700">Teknologi Modern</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="flex items-center justify-center w-6 h-6 text-white rounded-full bg-primary shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"></path></svg>
                                </span>
                                <span class="text-sm font-medium text-gray-700">Higienis & Wangi</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="flex items-center justify-center w-6 h-6 text-white rounded-full bg-primary shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"></path></svg>
                                </span>
                                <span class="text-sm font-medium text-gray-700">Pengerjaan Cepat</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="flex items-center justify-center w-6 h-6 text-white rounded-full bg-primary shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"></path></svg>
                                </span>
                                <span class="text-sm font-medium text-gray-700">Harga Terjangkau</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="py-20 bg-gray-50">
        <div class="px-6 mx-auto max-w-7xl lg:px-8">
            <div class="max-w-2xl mx-auto text-center mb-16">
                <h2 class="mb-4 font-serif text-3xl italic font-bold text-gray-900 md:text-4xl">Layanan Premium</h2>
                <p class="text-gray-600">Kami menyediakan layanan laundry berkualitas tinggi untuk kenyamanan Anda.</p>
            </div>

            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                
                <div class="p-8 transition-all bg-white border border-gray-100 shadow-xl rounded-2xl hover:shadow-2xl hover:-translate-y-1 group">
                    <div class="inline-flex items-center justify-center w-14 h-14 mb-6 text-white rounded-xl bg-primary group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                    </div>
                    <h3 class="mb-3 text-xl font-bold text-gray-900">Paket Bersih</h3>
                    <p class="text-gray-500 leading-relaxed">Paket anti ribet. Dicuci bersih, disetrika, dan dilipat rapi, siap masuk lemari!</p>
                </div>

                <div class="p-8 transition-all bg-white border border-gray-100 shadow-xl rounded-2xl hover:shadow-2xl hover:-translate-y-1 group">
                    <div class="inline-flex items-center justify-center w-14 h-14 mb-6 text-white rounded-xl bg-primary group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
                        </svg>
                    </div>
                    <h3 class="mb-3 text-xl font-bold text-gray-900">Setrika Baju</h3>
                    <p class="text-gray-500 leading-relaxed">Jasa setrika saja. Cocok untuk Anda yang mencuci sendiri tapi tak sempat menyetrika.</p>
                </div>

                <div class="p-8 transition-all bg-white border border-gray-100 shadow-xl rounded-2xl hover:shadow-2xl hover:-translate-y-1 group">
                    <div class="inline-flex items-center justify-center w-14 h-14 mb-6 text-white rounded-xl bg-primary group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z" />
                        </svg>
                    </div>
                    <h3 class="mb-3 text-xl font-bold text-gray-900">Dry Cleaning</h3>
                    <p class="text-gray-500 leading-relaxed">Perawatan khusus untuk jas, gaun, dan bahan halus.</p>
                </div>

                <div class="p-8 transition-all bg-white border border-gray-100 shadow-xl rounded-2xl hover:shadow-2xl hover:-translate-y-1 group">
                    <div class="inline-flex items-center justify-center w-14 h-14 mb-6 text-white rounded-xl bg-primary group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                        </svg>
                    </div>
                    <h3 class="mb-3 text-xl font-bold text-gray-900">Layanan Express</h3>
                    <p class="text-gray-500 leading-relaxed">Butuh cepat? Layanan kilat untuk pakaian sehari jadi.</p>
                </div>

            </div>
        </div>
    </section>

    <footer class="bg-white border-t border-gray-100">
        <div class="px-6 py-12 mx-auto max-w-7xl lg:px-8 md:flex md:items-center md:justify-between">
            <div class="flex justify-center space-x-6 md:order-2">
                <a href="#" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Instagram</span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.468 2.373c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                </a>
            </div>
            <div class="mt-8 md:mt-0 md:order-1">
                <p class="text-center text-xs leading-5 text-gray-500">&copy; 2026 Luxe Laundry. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const textElement = document.getElementById('quote-text');
        
        if (!textElement) return;

        const quotes = [
            `Fokus kuliah dan aktivitasmu, biar <span class="italic font-bold text-primary">Luxe</span> yang urus cucian kotormu.`,
            `Tugas numpuk dan nggak sempat nyuci? Tenang, <span class="italic font-bold text-primary">Luxe</span> siap bantu cuci pakaianmu.`,
            `Pakaian Kotor Jangan Ditumpuk, bisa jadi sumber penyakit, loh! Hubungi <span class="italic font-bold text-primary">Luxe</span> untuk cuci pakaian kotormu.`,
            `Serahkan urusan cuci-gosok pada ahlinya. Hubungi <span class="italic font-bold text-primary">Luxe</span> sekarang juga.`
        ];

        let currentIndex = 0;

        function changeQuote() {
            textElement.classList.remove('opacity-100', 'translate-y-0');
            textElement.classList.add('opacity-0', 'translate-y-4');

            setTimeout(() => {
                currentIndex = (currentIndex + 1) % quotes.length;
                textElement.innerHTML = quotes[currentIndex];

                textElement.classList.remove('opacity-0', 'translate-y-4');
                textElement.classList.add('opacity-100', 'translate-y-0');
            }, 700); 
        }

        setInterval(changeQuote, 6000);
    });
    </script>
</body>
</html>

```