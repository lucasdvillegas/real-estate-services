<div
    id="mobile-menu"
    hidden
    class="fixed inset-0 z-50 flex animate-menu-fade flex-col overflow-y-auto bg-surface md:hidden"
    role="dialog"
    aria-modal="true"
    aria-label="Menú principal"
>
    <div class="site-container flex h-16 shrink-0 items-center justify-between">
        <a href="{{ url('/') }}" class="truncate text-lg font-semibold tracking-tight">
            {{ config('site.name') }}
        </a>

        <button
            type="button"
            data-menu-close
            aria-label="Cerrar menú"
            class="-mr-2 grid size-11 place-items-center rounded-full transition-colors hover:bg-ink/5"
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="size-6" aria-hidden="true">
                <path d="m6 6 12 12M18 6 6 18" stroke-linecap="round" />
            </svg>
        </button>
    </div>

    <div class="site-container flex flex-1 flex-col justify-between pt-4 pb-10">
        <nav class="flex flex-col" aria-label="Navegación mobile">
            @foreach ($navItems as $item)
                <a
                    href="{{ $item['href'] }}"
                    data-menu-link
                    @if ($item['active']) aria-current="page" @endif
                    class="flex items-center justify-between border-b border-line py-4 text-3xl font-medium tracking-tight transition-colors {{ $item['active'] ? 'text-ink' : 'text-ink/60 hover:text-ink' }}"
                >
                    {{ $item['label'] }}
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" class="size-5 text-ink-muted" aria-hidden="true">
                        <path d="M7 17 17 7M9 7h8v8" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            @endforeach
        </nav>

        <div class="mt-10 space-y-4">
            <p class="eyebrow">Contacto</p>

            <a href="tel:{{ preg_replace('/\s+/', '', config('site.contact.phone')) }}" class="block text-lg transition-colors hover:text-ink-muted">
                {{ config('site.contact.phone') }}
            </a>

            <a href="mailto:{{ config('site.contact.email') }}" class="block text-lg transition-colors hover:text-ink-muted">
                {{ config('site.contact.email') }}
            </a>

            <p class="text-sm text-ink-muted">
                {{ config('site.contact.address') }}
            </p>
        </div>
    </div>
</div>
