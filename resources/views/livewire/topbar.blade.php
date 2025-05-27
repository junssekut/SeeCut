<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 px-48 py-4 bg-Eerie-Black">
    <div class="col-span-1">
        <a href="{{ route('home') }}"><img class="w-24" src="{{ asset(path: 'assets/images/logo-text.png') }}"
                alt="SeeCut"></a>
    </div>
    <div class="col-span-1 flex flex-row gap-6 justify-center items-center">
        <a class="font-Kuunari text-Seasalt text-xl hover:text-Ecru transition-colors duration-300 ease-in-out"
            href="{{ 'BERANDA' }}">BERANDA</a>
        <a class="font-Kuunari text-Seasalt text-xl hover:text-Ecru transition-colors duration-300 ease-in-out"
            href="{{ 'CARI BARBERSHOP' }}">CARI BARBERSHOP</a>
        <a class="font-Kuunari text-Seasalt text-xl hover:text-Ecru transition-colors duration-300 ease-in-out"
            href="{{ 'CHAT LANGSUNG' }}">CHAT LANGSUNG</a>
    </div>
    <div class="col-span-1 flex justify-end items-center">
        <a class="font-Kuunari ring-1 ring-Seasalt text-Seasalt px-4 py-2 text-md hover:ring-Satin-Sheen-Yellow hover:bg-Satin-Sheen-Yellow transition-all duration-300 ease-in-out"
            href="{{ 'MULAI' }}">MULAI
            SEKARANG</a>
    </div>
</div>
