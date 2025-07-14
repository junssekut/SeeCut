<div class="flex flex-col lg:flex-row justify-between items-center gap-4 px-8 md:px-16 lg:px-48 py-4 bg-Eerie-Black z-[1000]">
    <div>
        <a href="{{ route('home') }}"><img class="w-24" src="{{ asset(path: 'assets/images/logo-text.png') }}"
                alt="SeeCut"></a>
    </div>
    <div class="flex flex-col sm:flex-row gap-7 justify-center items-center">
        <a class="font-Kuunari text-Seasalt text-xl hover:text-Ecru transition-colors duration-300 ease-in-out"
            href="{{ route('home') }}">BERANDA</a>
        <a class="font-Kuunari text-Seasalt text-xl hover:text-Ecru transition-colors duration-300 ease-in-out"
            href="{{ 'CARI BARBERSHOP' }}">CARI BARBERSHOP</a>
        <a class="font-Kuunari text-Seasalt text-xl hover:text-Ecru transition-colors duration-300 ease-in-out"
            href="{{ route('recomendation') }}">REKOMENDASI GAYA</a>
    </div>
    <div class="">
        <a class="font-Kuunari ring-1 ring-Seasalt text-Seasalt px-4 py-2 text-md hover:ring-Satin-Sheen-Yellow hover:bg-Satin-Sheen-Yellow transition-all duration-300 ease-in-out"
            href="{{ route('masuksekarang') }}">MULAI
            SEKARANG</a>
    </div>
</div>
