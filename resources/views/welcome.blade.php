<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-surface text-gray-600 font-sans antialiased">

    <nav class="w-full bg-white/80 backdrop-blur-md border-b border-line fixed top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="text-3xl font-luxe italic font-bold text-primary tracking-wide">
                        Luxe
                    </a>
                </div>
                
                <div class="hidden md:flex space-x-4 items-center">
                    <a href="{{ url('/register') }}" class="px-5 py-2.5 text-gray-600 hover:text-primary font-medium transition duration-150">
                        Register
                    </a>
                    <a href="{{ url('/login') }}" class="px-5 py-2.5 bg-primary text-white font-semibold rounded-md shadow-md hover:bg-primary-dark transition duration-150 ease-in-out">
                        Login
                    </a>
                </div>

                <div class="md:hidden flex items-center">
                    <button class="text-gray-500 hover:text-primary focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden">
        
        <div class="absolute inset-y-0 left-0 w-full lg:w-7/12 z-0 pointer-events-none overflow-hidden">
            <img 
                src="{{ asset('images/setrika.webp') }}" 
                alt="Background Watermark" 
                class="w-full h-full object-cover object-left-bottom opacity-10 grayscale"
            >
            <div class="absolute inset-y-0 right-0 w-32 bg-gradient-to-l from-surface to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <div class="text-center lg:text-left">
                    <span class="inline-block py-1 px-3 rounded-full bg-teal-50 text-primary text-sm font-semibold mb-4 border border-teal-100">
                         Solusi Terbaik Untuk Mahasiswa Sibuk
                    </span>
                    
                    <h1 class="text-5xl lg:text-6xl font-luxe font-bold text-gray-900 leading-tight mb-6">
                        Pakaian Bersih Gapake <span class="italic text-primary">Ribet.</span>
                    </h1>
                    
                    <div class="relative min-h-[100px] flex items-center justify-center lg:justify-start mb-6">
                        <p id="quote-text" class="text-lg text-gray-500 leading-relaxed transition-all duration-700 ease-in-out opacity-100 translate-y-0">
                        Fokus kuliah dan aktivitasmu, biar <span class="italic font-bold text-primary">Luxe</span> yang urus cucian kotormu. Layanan antar-jemput gratis khusus area Kampus Jimbaran.
                        </p>
                    </div>
                    
                    <div class="mt-8 flex items-center justify-center lg:justify-start space-x-8 text-gray-400 text-sm font-medium">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>1 Hari Selesai</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Higienis & Wangi</span>
                        </div>
                    </div>
                </div>

                <div class="relative lg:h-full flex justify-center lg:justify-end">
                    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-primary/10 rounded-full blur-3xl opacity-70"></div>
                    <div class="absolute bottom-0 left-10 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl opacity-70"></div>
                    
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl border-4 border-white rotate-2 hover:rotate-0 transition-all duration-500 max-w-md">
                        <img 
                            src="{{ asset('images/laundrytumpuk.png') }}" 
                            alt="Laundry Tumpukan Baju Rapi" 
                            class="object-cover h-full w-full"
                        >
                        <div class="absolute bottom-6 left-6 bg-white/95 backdrop-blur px-4 py-3 rounded-lg shadow-lg flex items-center gap-3 animate-bounce">
                            <div class="bg-green-100 p-2 rounded-full">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Status Pesanan</p>
                                <p class="text-sm font-bold text-gray-800">Siap Diantar!</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const textElement = document.getElementById('quote-text');
        
        if (!textElement) return; // Silent fail if not found

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
