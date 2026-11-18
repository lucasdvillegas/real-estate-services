<footer id="contacto" class="mt-20 scroll-mt-24 bg-ink text-surface lg:mt-32">
    <div class="site-container pt-16 pb-10 lg:pt-24">
        <div class="grid gap-10 lg:grid-cols-[1.35fr_1fr] lg:items-start lg:gap-16">
            <div>
                <p class="eyebrow text-surface/50">Contacto</p>

                <h2 class="mt-4 text-4xl leading-[1.05] font-semibold tracking-[-0.03em] sm:text-5xl lg:text-6xl">
                    Hablemos de tu<br class="hidden sm:block"> próxima propiedad.
                </h2>

                <p class="mt-6 max-w-md text-sm leading-relaxed text-surface/60 sm:text-base">
                    Contanos qué estás buscando y te armamos una selección a medida.
                    Respondemos consultas en el día.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a
                        href="https://wa.me/{{ config('site.contact.whatsapp') }}"
                        target="_blank"
                        rel="noopener"
                        class="btn-light"
                    >
                        Escribinos por WhatsApp
                    </a>

                    <a
                        href="mailto:{{ config('site.contact.email') }}"
                        class="inline-flex items-center gap-2 rounded-full border border-surface/25 px-5 py-2.5 text-sm font-medium text-surface transition duration-200 hover:border-surface/60 hover:bg-surface/10 focus-visible:ring-2 focus-visible:ring-surface/40 focus-visible:ring-offset-2 focus-visible:ring-offset-ink focus-visible:outline-none"
                    >
                        Enviar un mail
                    </a>
                </div>
            </div>

            <div class="overflow-hidden rounded-4xl">
                <img
                    src="{{ config('site.images.contact') }}"
                    alt="Interior de una propiedad en venta"
                    class="h-60 w-full object-cover lg:h-80"
                    loading="lazy"
                >
            </div>
        </div>

        <div class="mt-14 grid gap-10 border-t border-surface/10 pt-10 sm:grid-cols-2 lg:mt-20 lg:grid-cols-4">
            <div>
                <p class="eyebrow text-surface/40">Oficina</p>
                <p class="mt-3 text-sm text-surface/70">{{ config('site.contact.address') }}</p>
                <p class="mt-1 text-sm text-surface/70">{{ config('site.contact.hours') }}</p>
            </div>

            <div>
                <p class="eyebrow text-surface/40">Contacto</p>
                <a href="tel:{{ preg_replace('/\s+/', '', config('site.contact.phone')) }}" class="mt-3 block text-sm text-surface/70 transition-colors hover:text-surface">
                    {{ config('site.contact.phone') }}
                </a>
                <a href="mailto:{{ config('site.contact.email') }}" class="mt-1 block text-sm text-surface/70 transition-colors hover:text-surface">
                    {{ config('site.contact.email') }}
                </a>
            </div>

            <div>
                <p class="eyebrow text-surface/40">Navegación</p>
                <ul class="mt-3 space-y-1">
                    @foreach ($navItems as $item)
                        <li>
                            <a href="{{ $item['href'] }}" class="text-sm text-surface/70 transition-colors hover:text-surface">
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <p class="eyebrow text-surface/40">Seguinos</p>
                <ul class="mt-3 space-y-1">
                    <li>
                        <a
                            href="https://wa.me/{{ config('site.contact.whatsapp') }}"
                            target="_blank"
                            rel="noopener"
                            class="text-sm text-surface/70 transition-colors hover:text-surface"
                        >
                            WhatsApp
                        </a>
                    </li>

                    @if (config('site.social.instagram'))
                        <li>
                            <a href="{{ config('site.social.instagram') }}" target="_blank" rel="noopener" class="text-sm text-surface/70 transition-colors hover:text-surface">
                                Instagram
                            </a>
                        </li>
                    @endif

                    @if (config('site.social.facebook'))
                        <li>
                            <a href="{{ config('site.social.facebook') }}" target="_blank" rel="noopener" class="text-sm text-surface/70 transition-colors hover:text-surface">
                                Facebook
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="mt-14 border-t border-surface/10 pt-8">
            <p class="text-[clamp(1.75rem,8.5vw,8rem)] leading-[0.85] font-semibold tracking-[-0.05em]">
                {{ config('site.name') }}
            </p>

            <div class="mt-8 flex flex-col gap-2 text-xs text-surface/35 sm:flex-row sm:items-center sm:justify-between">
                <p>&copy; {{ date('Y') }} {{ config('site.name') }}. Todos los derechos reservados.</p>

                <a href="{{ url('/') }}" class="transition-colors hover:text-surface/70">
                    Volver al inicio
                </a>
            </div>
        </div>
    </div>
</footer>
