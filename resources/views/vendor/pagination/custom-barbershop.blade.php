@if ($paginator->hasPages())
    <div class="pagination flex items-center justify-center space-x-2 py-0">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="page-item disabled mx-1">
                <span
                    class="page-link text-gray-500/50 px-5 py-3 rounded-2xl cursor-not-allowed select-none backdrop-blur-sm bg-gray-800/20 border border-gray-700/30">
                    <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Previous
                </span>
            </span>
        @else
            <a class="page-item group mx-1 relative" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                aria-label="@lang('pagination.previous')">
                <span
                    class="page-link relative overflow-hidden text-gray-300 hover:text-white px-5 py-3 rounded-2xl border border-gray-600/40 hover:border-Ecru/80 transition-all duration-500 backdrop-blur-sm bg-gray-800/30 hover:bg-gray-700/40 shadow-lg hover:shadow-Ecru/20 hover:shadow-xl transform group-hover:scale-105 block">

                    <!-- Animated background gradient -->
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-Ecru/0 via-[#F5D994]/0 to-[#E6B871]/0 rounded-2xl transition-all duration-500 group-hover:from-Ecru/20 group-hover:via-[#F5D994]/30 group-hover:to-[#E6B871]/20">
                    </div>

                    <!-- Shimmer effect -->
                    <div
                        class="absolute inset-0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-out bg-gradient-to-r from-transparent via-white/10 to-transparent skew-x-12">
                    </div>

                    <span
                        class="relative z-10 font-medium transition-all duration-300 group-hover:font-semibold flex items-center">
                        <svg class="w-4 h-4 mr-2 transform transition-transform duration-300 group-hover:-translate-x-1"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                        Previous
                    </span>
                </span>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="page-item disabled mx-1">
                    <span class="page-link text-gray-400 px-3 py-3 flex items-center">
                        <span class="w-1 h-1 bg-gray-500 rounded-full mx-0.5 animate-pulse"></span>
                        <span class="w-1 h-1 bg-gray-500 rounded-full mx-0.5 animate-pulse"
                            style="animation-delay: 0.2s"></span>
                        <span class="w-1 h-1 bg-gray-500 rounded-full mx-0.5 animate-pulse"
                            style="animation-delay: 0.4s"></span>
                    </span>
                </span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-item active relative mx-1 transform transition-all duration-300"
                            aria-current="page">
                            <span
                                class="page-link relative overflow-hidden group px-4 py-3 min-w-[3rem] flex items-center justify-center rounded-2xl shadow-lg">
                                <!-- Active glowing background with animation -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-Ecru via-[#F5D994] to-[#E6B871] rounded-2xl animate-pulse">
                                </div>

                                <!-- Inner glow -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent rounded-2xl">
                                </div>

                                <!-- Rotating border effect -->
                                <div class="absolute inset-0 rounded-2xl"
                                    style="background: conic-gradient(from 0deg, transparent, rgba(255,255,255,0.3), transparent); animation: spin 3s linear infinite;">
                                </div>

                                <!-- Inner shadow for depth -->
                                <div class="absolute inset-0 rounded-2xl shadow-inner"
                                    style="box-shadow: inset 0 2px 4px rgba(0,0,0,0.2), inset 0 -1px 2px rgba(255,255,255,0.3);">
                                </div>

                                <!-- Text with glow -->
                                <span
                                    class="relative z-10 font-bold text-gray-900 drop-shadow-sm">{{ $page }}</span>
                            </span>
                        </span>
                    @else
                        <a class="page-item group mx-1 transform transition-all duration-300 hover:scale-110"
                            href="{{ $url }}">
                            <span
                                class="page-link relative overflow-hidden transition-all duration-500 px-4 py-3 min-w-[3rem] rounded-2xl border border-gray-600/40 hover:border-Ecru/80 backdrop-blur-sm bg-gray-800/30 hover:bg-gray-700/40 shadow-md hover:shadow-Ecru/20 hover:shadow-xl flex items-center justify-center">

                                <!-- Background pulse on hover -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-gray-700/60 via-gray-600/60 to-gray-500/60 rounded-2xl transition-all duration-500 group-hover:from-gray-600/40 group-hover:via-gray-500/40 group-hover:to-gray-400/40">
                                </div>

                                <!-- Hover golden background with scale animation -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-Ecru/0 via-[#F5D994]/0 to-[#E6B871]/0 rounded-2xl transition-all duration-500 scale-90 group-hover:scale-100 group-hover:from-Ecru/20 group-hover:via-[#F5D994]/30 group-hover:to-[#E6B871]/20">
                                </div>

                                <!-- Multi-layer shimmer effect -->
                                <div
                                    class="absolute inset-0 -translate-x-full group-hover:translate-x-full transition-transform duration-700 bg-gradient-to-r from-transparent via-white/20 to-transparent transform skew-x-12">
                                </div>

                                <!-- Secondary shimmer -->
                                <div
                                    class="absolute inset-0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000 delay-200 bg-gradient-to-r from-transparent via-Ecru/30 to-transparent transform -skew-x-12">
                                </div>

                                <!-- Glow effect -->
                                <div
                                    class="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 bg-Ecru/10 blur-md">
                                </div>

                                <!-- Text with enhanced transitions -->
                                <span
                                    class="relative z-10 text-gray-300 group-hover:text-white font-medium group-hover:font-bold transition-all duration-500 group-hover:drop-shadow-lg transform group-hover:scale-105">{{ $page }}</span>
                            </span>
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="page-item group mx-1 relative" href="{{ $paginator->nextPageUrl() }}" rel="next"
                aria-label="@lang('pagination.next')">
                <span
                    class="page-link relative overflow-hidden text-gray-300 hover:text-white px-5 py-3 rounded-2xl border border-gray-600/40 hover:border-Ecru/80 transition-all duration-500 backdrop-blur-sm bg-gray-800/30 hover:bg-gray-700/40 shadow-lg hover:shadow-Ecru/20 hover:shadow-xl transform group-hover:scale-105 block">

                    <!-- Animated background gradient -->
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-Ecru/0 via-[#F5D994]/0 to-[#E6B871]/0 rounded-2xl transition-all duration-500 group-hover:from-Ecru/20 group-hover:via-[#F5D994]/30 group-hover:to-[#E6B871]/20">
                    </div>

                    <!-- Shimmer effect -->
                    <div
                        class="absolute inset-0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-out bg-gradient-to-r from-transparent via-white/10 to-transparent skew-x-12">
                    </div>

                    <span
                        class="relative z-10 font-medium transition-all duration-300 group-hover:font-semibold flex items-center">
                        Next
                        <svg class="w-4 h-4 ml-2 transform transition-transform duration-300 group-hover:translate-x-1"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </span>
                </span>
            </a>
        @else
            <span class="page-item disabled mx-1">
                <span
                    class="page-link text-gray-500/50 px-5 py-3 rounded-2xl cursor-not-allowed select-none backdrop-blur-sm bg-gray-800/20 border border-gray-700/30">
                    Next
                    <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            </span>
        @endif
    </div>

    <style>
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .page-item:hover .page-link {
            filter: brightness(1.1);
        }

        .page-item.active .page-link {
            animation: activeGlow 2s ease-in-out infinite alternate;
        }

        @keyframes activeGlow {
            0% {
                box-shadow: 0 0 20px rgba(236, 201, 148, 0.3);
            }

            100% {
                box-shadow: 0 0 30px rgba(236, 201, 148, 0.5), 0 0 40px rgba(245, 217, 148, 0.3);
            }
        }
    </style>
@endif
