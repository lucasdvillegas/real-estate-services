<header id="site-header" class="sticky top-0 z-40 bg-surface/85 backdrop-blur-md transition-shadow duration-300">
    <div class="site-container flex h-16 items-center justify-between gap-6 lg:h-20">
        <a href="{{ url('/') }}" class="truncate text-lg font-semibold tracking-tight lg:text-xl">
            {{ config('site.name') }}
        </a>

        <nav class="hidden items-center gap-8 md:flex" aria-label="Navegación principal">
            @foreach ($navItems as $item)
                <a
                    href="{{ $item['href'] }}"
                    @if ($item['active']) aria-current="page" @endif
                    class="text-sm transition-colors hover:text-ink {{ $item['active'] ? 'text-ink' : 'text-ink-muted' }}"
                >
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <button
            type="button"
            data-menu-open
            aria-controls="mobile-menu"
            aria-label="Abrir menú"
            class="-mr-2 grid size-11 place-items-center rounded-full transition-colors hover:bg-ink/5 md:hidden"
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="size-6" aria-hidden="true">
                <path d="M4 8h16M4 16h16" stroke-linecap="round" />
            </svg>
        </button>
    </div>
</header>
