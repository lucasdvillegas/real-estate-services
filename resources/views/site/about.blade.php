@extends('layouts.site')

@section('title', 'Nosotros')

@section('content')
    {{-- Hero --}}
    <section class="site-container pt-10 lg:pt-16">
        <div class="grid gap-8 lg:grid-cols-[1.6fr_1fr] lg:items-end lg:gap-16">
            <div>
                <p class="eyebrow">Nosotros</p>

                <h1 class="mt-4 text-[clamp(2.5rem,6.5vw,5.5rem)] leading-[0.95] font-semibold tracking-[-0.04em]">
                    Conocemos el mercado y también a quien lo habita.
                </h1>
            </div>

            <p class="max-w-md text-sm leading-relaxed text-ink-muted lg:pb-4 lg:text-base">
                Somos un equipo dedicado a conectar personas con espacios.
                Trabajamos con propietarios, compradores e inquilinos con
                información clara y sin sorpresas.
            </p>
        </div>

        <div class="mt-10 overflow-hidden rounded-4xl bg-surface-alt">
            <img
                src="{{ config('site.images.style_main') }}"
                alt="Living amplio con escalera de madera y ventanales"
                class="aspect-[16/10] w-full object-cover lg:aspect-[21/9]"
            >
        </div>
    </section>

    {{-- Story --}}
    <section class="site-container mt-20 lg:mt-28">
        <div class="grid items-center gap-10 lg:grid-cols-2 lg:gap-16">
            <div class="relative">
                <div class="overflow-hidden rounded-4xl">
                    <img
                        src="{{ config('site.images.intro_main') }}"
                        alt="Living luminoso con piso de madera"
                        class="aspect-[4/5] w-full object-cover"
                        loading="lazy"
                    >
                </div>

                <div class="absolute -right-3 bottom-8 hidden w-40 overflow-hidden rounded-3xl border-4 border-surface shadow-2xl shadow-ink/20 lg:block">
                    <img
                        src="{{ config('site.images.intro_card') }}"
                        alt="Ambiente integrado con sillones y plantas"
                        class="aspect-square w-full object-cover"
                        loading="lazy"
                    >
                </div>
            </div>

            <div class="lg:pl-8">
                <p class="eyebrow">Nuestra historia</p>

                <h2 class="mt-4 text-3xl leading-[1.05] font-semibold tracking-[-0.03em] sm:text-4xl lg:text-5xl">
                    15 años acompañando mudanzas
                </h2>

                <p class="mt-6 text-sm leading-relaxed text-ink-muted sm:text-base">
                    Empezamos como una oficina chica, con pocas propiedades y mucho
                    trato personal. Hoy seguimos trabajando igual: cada operación la
                    lleva una persona con nombre y apellido, que conoce la propiedad
                    y responde las consultas.
                </p>

                <p class="mt-4 text-sm leading-relaxed text-ink-muted sm:text-base">
                    Ese modo de trabajar nos permitió crecer de boca en boca, con
                    clientes que vuelven y recomiendan.
                </p>

                <ul class="mt-8 space-y-3">
                    @foreach ([
                        'Fotos reales y medidas verificadas de cada propiedad',
                        'Precios y estado de disponibilidad siempre actualizados',
                        'Un asesor asignado de principio a fin',
                    ] as $item)
                        <li class="flex items-start gap-3 text-sm">
                            <span class="mt-0.5 grid size-5 shrink-0 place-items-center rounded-full bg-ink text-surface" aria-hidden="true">
                                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" class="size-2.5">
                                    <path d="m3.5 8.5 3 3 6-6.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    {{-- Process --}}
    <section class="site-container mt-20 lg:mt-32">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="eyebrow">Cómo trabajamos</p>

                <h2 class="mt-3 max-w-2xl text-3xl leading-[1.05] font-semibold tracking-[-0.03em] sm:text-4xl lg:text-5xl">
                    Cuatro pasos, sin vueltas
                </h2>
            </div>

            <p class="max-w-xs text-sm leading-relaxed text-ink-muted md:pb-2 md:text-right">
                Buscar, alquilar o vender una propiedad debería ser simple.
                Nuestro trabajo es que así sea.
            </p>
        </div>

        <ol class="mt-10 grid gap-x-8 gap-y-10 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['Nos contás qué buscás', 'Zona, presupuesto y qué no podés negociar. Con eso armamos tu perfil de búsqueda.'],
                ['Seleccionamos opciones', 'Solo te mostramos propiedades que cumplen con lo que pediste y están disponibles.'],
                ['Visitamos juntos', 'Coordinamos las visitas y respondemos todas las dudas en el momento.'],
                ['Cerramos la operación', 'Revisamos documentación, condiciones y plazos para que la firma sea simple.'],
            ] as $index => $step)
                <li class="border-t border-line pt-5">
                    <span class="text-sm font-medium text-ink-muted">
                        {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}
                    </span>

                    <h3 class="mt-3 text-lg font-medium tracking-[-0.01em]">
                        {{ $step[0] }}
                    </h3>

                    <p class="mt-2 text-sm leading-relaxed text-ink-muted">
                        {{ $step[1] }}
                    </p>
                </li>
            @endforeach
        </ol>
    </section>

    {{-- Metrics --}}
    <section class="site-container mt-16 lg:mt-24">
        <dl class="grid grid-cols-2 gap-y-8 sm:grid-cols-4">
            <div>
                <dd class="text-4xl font-medium tracking-[-0.03em] lg:text-5xl">15+</dd>
                <dt class="mt-2 text-sm text-ink-muted">Años de experiencia</dt>
            </div>

            <div class="border-l border-line pl-5 sm:pl-6">
                <dd class="text-4xl font-medium tracking-[-0.03em] lg:text-5xl">320+</dd>
                <dt class="mt-2 text-sm text-ink-muted">Operaciones cerradas</dt>
            </div>

            <div class="border-l border-line pl-5 sm:pl-6">
                <dd class="text-4xl font-medium tracking-[-0.03em] lg:text-5xl">3</dd>
                <dt class="mt-2 text-sm text-ink-muted">Propiedades publicadas</dt>
            </div>

            <div class="border-l border-line pl-5 sm:pl-6">
                <dd class="text-4xl font-medium tracking-[-0.03em] lg:text-5xl">6</dd>
                <dt class="mt-2 text-sm text-ink-muted">Tipos de propiedad</dt>
            </div>
        </dl>
    </section>

    {{-- Manifesto + CTA --}}
    <section class="site-container mt-20 lg:mt-32">
        <div class="border-t border-line pt-10 lg:pt-14">
            <p class="max-w-4xl text-2xl leading-[1.25] font-medium tracking-[-0.02em] sm:text-3xl lg:text-4xl">
                Alquilamos y vendemos propiedades, pero sobre todo respondemos una
                pregunta: dónde querés estar.
            </p>

            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ url('/propiedades') }}" class="btn">
                    Ver propiedades
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="size-4" aria-hidden="true">
                        <path d="M7 17 17 7M9 7h8v8" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>

                <a
                    href="{{ url('/').'#contacto' }}"
                    class="inline-flex items-center gap-2 rounded-full border border-ink/20 px-5 py-2.5 text-sm font-medium transition duration-200 hover:border-ink/50 hover:bg-ink/5 focus-visible:ring-2 focus-visible:ring-ink/40 focus-visible:ring-offset-2 focus-visible:ring-offset-surface focus-visible:outline-none"
                >
                    Hablar con un asesor
                </a>
            </div>
        </div>
    </section>
@endsection
