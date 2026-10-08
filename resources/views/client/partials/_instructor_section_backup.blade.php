
<section id="instructor" class="pt-6 pb-6 lg:pt-8 lg:pb-8 bg-gray-50 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="text-center mb-6" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-gray-900">Instruktur & Pengajar Terbaik</h2>
            <p class="text-gray-600 mt-1.5 max-w-2xl mx-auto">
                Belajar langsung dari para pendidik profesional yang berpengalaman.
            </p>
        </div>

        <div class="relative">
            <div class="swiper instructorSwiper py-1 px-4">
                <div class="swiper-wrapper">
                    @foreach ($instructors as $instructor)
                        
                        <div class="swiper-slide h-auto">
                            <div
                                class="group bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 text-center h-full flex flex-col">
                                <div class="relative w-28 h-28 mx-auto mb-4">
                                    <div
                                        class="absolute inset-0 bg-blue-100 rounded-full scale-110 group-hover:scale-125 transition-transform duration-300">
                                    </div>
                                    <img src="{{ $instructor->foto }}"
                                        alt="{{ $instructor->nama }}"
                                        class="relative w-full h-full rounded-full object-cover border-4 border-white shadow-md">
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-1">
                                    {{ $instructor->nama }}
                                </h3>
                                <p
                                    class="text-blue-600 font-medium text-sm mb-2">
                                    {{ $instructor->jabatan }}
                                </p>
                                <p class="text-gray-500 text-sm leading-relaxed flex-grow line-clamp-3">
                                    {{ $instructor->deskripsi }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            
            <button
                class="instr-prev absolute top-1/2 -left-4 lg:-left-6 z-30 w-10 h-10 lg:w-12 lg:h-12 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-700 hover:bg-blue-600 hover:text-white transition-all duration-300 focus:outline-none transform -translate-y-1/2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button
                class="instr-next absolute top-1/2 -right-4 lg:-right-6 z-30 w-10 h-10 lg:w-12 lg:h-12 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-700 hover:bg-blue-600 hover:text-white transition-all duration-300 focus:outline-none transform -translate-y-1/2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>

        <div class="mt-4 text-center">
            <a href="{{ url('/instruktur') }}"
                class="inline-flex items-center gap-2 text-blue-600 font-bold hover:text-blue-700 transition-colors">
                Lihat Semua Instruktur
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                    </path>
                </svg>
            </a>
        </div>
    </div>
</section>
