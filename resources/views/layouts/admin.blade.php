<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dasbor Admin' }} - SeeCut</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/logo-admin.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Custom Fonts -->
    <style>
        @font-face {
            font-family: 'Kuunari';
            src: url('{{ asset('assets/fonts/Kuunari-Regular.woff2') }}') format('woff2'),
                url('{{ asset('assets/fonts/Kuunari-Regular.woff') }}') format('woff');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }
    </style>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Livewire Styles -->
    @livewireStyles

    <!-- Custom Admin Styles -->
    <style>
        :root {
            --color-ecru: #C4A962;
            --color-charcoal: #36454F;
            --color-cream: #F5F5DC;
            --color-sage: #9CAF88;
            --color-terracotta: #E2725B;
            --color-navy: #2C3E50;
        }

        .font-Kuunari {
            font-family: 'Kuunari', 'Inter', system-ui, -apple-system, sans-serif;
        }

        .text-Ecru {
            color: var(--color-ecru);
        }

        .bg-Ecru {
            background-color: var(--color-ecru);
        }

        .text-Charcoal {
            color: var(--color-charcoal);
        }

        .bg-Charcoal {
            background-color: var(--color-charcoal);
        }

        .text-Cream {
            color: var(--color-cream);
        }

        .bg-Cream {
            background-color: var(--color-cream);
        }

        .text-Sage {
            color: var(--color-sage);
        }

        .bg-Sage {
            background-color: var(--color-sage);
        }

        .text-Terracotta {
            color: var(--color-terracotta);
        }

        .bg-Terracotta {
            background-color: var(--color-terracotta);
        }

        .text-Navy {
            color: var(--color-navy);
        }

        .bg-Navy {
            background-color: var(--color-navy);
        }

        /* Admin-specific styles */
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }

        .admin-sidebar {
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
            background: #f3f4f6;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #bdbdbd;
        }

        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #d1d5db #f3f4f6;
        }

        /* Animation utilities */
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(-10px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Admin-specific body styling */
        .admin-body {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }
    </style>

    @stack('styles')
</head>

<body class="admin-body antialiased">
    <div id="admin-app" class="min-h-screen">
        <!-- Admin Content -->
        @isset($slot)
            {{ $slot }}
        @endisset
        @yield('content')
    </div>

    <!-- Livewire Scripts -->
    @livewireScripts

    <!-- Custom Scripts -->
    @stack('scripts')

    <!-- Global Admin Scripts -->
    <script>
        // Global admin utilities
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading states to buttons
            const buttons = document.querySelectorAll('button[type="submit"]');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    if (!this.disabled) {
                        const originalText = this.innerHTML;
                        this.innerHTML =
                            '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-current inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Memproses...';
                        this.disabled = true;

                        // Reset after 5 seconds if not handled by Livewire
                        setTimeout(() => {
                            if (this.disabled) {
                                this.innerHTML = originalText;
                                this.disabled = false;
                            }
                        }, 5000);
                    }
                });
            });

            // Auto-hide alerts
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });

            // Keyboard shortcuts for admin
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + K for search focus
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    const searchInput = document.querySelector('input[placeholder*="Cari"]');
                    if (searchInput) {
                        searchInput.focus();
                    }
                }

                // Escape to close modals
                if (e.key === 'Escape') {
                    const modals = document.querySelectorAll('.modal, [id*="modal"]');
                    modals.forEach(modal => {
                        if (modal.style.display !== 'none' && !modal.classList.contains('hidden')) {
                            const closeBtn = modal.querySelector(
                                '[onclick*="close"], [onclick*="Close"]');
                            if (closeBtn) closeBtn.click();
                        }
                    });
                }
            });
        });

        // Livewire loading states
        document.addEventListener('livewire:load', function() {
            Livewire.hook('message.sent', () => {
                document.body.classList.add('loading');
                // Show loading indicator
                const loadingIndicator = document.createElement('div');
                loadingIndicator.id = 'loading-indicator';
                loadingIndicator.className =
                    'fixed top-4 right-4 bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg z-50 flex items-center';
                loadingIndicator.innerHTML =
                    '<svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Memuat...';
                document.body.appendChild(loadingIndicator);
            });

            Livewire.hook('message.processed', () => {
                document.body.classList.remove('loading');
                // Remove loading indicator
                const loadingIndicator = document.getElementById('loading-indicator');
                if (loadingIndicator) {
                    loadingIndicator.remove();
                }
            });
        });

        // Success notification function
        window.showSuccessNotification = function(message) {
            const notification = document.createElement('div');
            notification.className =
                'fixed top-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
            notification.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    ${message}
                </div>
            `;
            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // Auto remove
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        };
    </script>
</body>

</html>
