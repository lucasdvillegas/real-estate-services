@extends('layouts.site')

@section('title', 'Inicio')

@section('content')
    {{-- Hero --}}
    <section class="site-container pt-4 lg:pt-6">
        <div class="relative overflow-hidden rounded-4xl bg-surface-alt">
            <img
                src="{{ config('site.images.hero') }}"
                alt="Casa moderna con grandes ventanales y jardín"
                class="h-[70vh] max-h-[760px] min-h-[520px] w-full object-cover"
            >

            <div class="absolute inset-0 bg-gradient-to-t from-ink/85 via-ink/25 to-ink/5"></div>

            <div class="absolute inset-x-0 bottom-0 p-6 pb-16 sm:p-10 sm:pb-20 lg:p-12 lg:pb-24">
                <p class="eyebrow text-white/60">{{ config('site.tagline') }}</p>

                <h1 class="mt-3 max-w-4xl text-[clamp(2.75rem,8vw,7rem)] leading-[0.9] font-semibold tracking-[-0.04em] text-white">
                    Encontrá tu lugar
                </h1>
            </div>

            {{-- Rotating badge --}}
            <div class="absolute right-6 bottom-6 hidden size-32 items-center justify-center text-white/80 sm:flex lg:right-10 lg:bottom-10">
                <div class="animate-slow-spin absolute inset-0">
                    <svg viewBox="0 0 100 100" class="size-full" aria-hidden="true">
                        <defs>
                            <path id="hero-badge-circle" d="M 50 50 m -37 0 a 37 37 0 1 1 74 0 a 37 37 0 1 1 -74 0" fill="none" />
                        </defs>
                        <text fill="currentColor" class="text-[7.5px] uppercase" style="letter-spacing: 0.22em;">
                            <textPath href="#hero-badge-circle">Asesoramiento · Confianza · Resultados ·</textPath>
                        </text>
                    </svg>
                </div>

                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" class="size-6" aria-hidden="true">
                    <path d="M7 17 17 7M9 7h8v8" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
        </div>

        {{-- Card overlapping the hero --}}
        <div class="relative z-10 -mt-10 sm:-mt-14 lg:-mt-16">
            <div class="max-w-sm rounded-4xl border border-white/50 bg-white/80 p-5 shadow-xl shadow-ink/5 backdrop-blur-xl sm:p-6">
                <p class="eyebrow">{{ config('site.metrics.years') }} años acompañando familias</p>

                <p class="mt-3 text-sm leading-relaxed text-ink-muted">
                    Casas, departamentos y PH en venta y alquiler, con asesoramiento
                    de principio a fin.
                </p>

                <a href="{{ url('/propiedades') }}" class="btn mt-5">
                    Ver propiedades
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="size-4" aria-hidden="true">
                        <path d="M7 17 17 7M9 7h8v8" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- Intro: gallery of spaces --}}
    <section class="site-container mt-20 lg:mt-28">
        <div class="grid gap-5 lg:grid-cols-3">
            <div class="relative overflow-hidden rounded-4xl lg:col-span-2">
                <img
                    src="{{ config('site.images.intro_main') }}"
                    alt="Living luminoso con piso de madera"
                    class="h-[420px] w-full object-cover lg:h-[540px]"
                    loading="lazy"
                >

                <div class="absolute inset-0 bg-gradient-to-t from-ink/50 to-transparent"></div>

                <span class="pill absolute top-5 left-5 border-white/40 bg-white/85 backdrop-blur">
                    Interiores pensados
                </span>

                <h2 class="absolute bottom-6 left-6 max-w-sm text-3xl leading-[1.05] font-semibold tracking-[-0.02em] text-white sm:text-4xl lg:bottom-8 lg:left-8">
                    Espacios pensados<br>para vivirlos
                </h2>
            </div>

            <div class="grid gap-5">
                <div class="rounded-4xl border border-line bg-white p-6 lg:p-7">
                    <span class="pill">Diferencial</span>

                    <h3 class="mt-4 text-2xl leading-tight font-semibold tracking-[-0.02em]">
                        Una galería de espacios que se sienten propios
                    </h3>

                    <p class="mt-3 text-sm leading-relaxed text-ink-muted">
                        Cada propiedad se selecciona y se documenta en detalle:
                        fotos reales, medidas y estado de cada ambiente.
                    </p>
                </div>

                <div class="relative overflow-hidden rounded-4xl">
                    <img
                        src="{{ config('site.images.intro_card') }}"
                        alt="Living con sillones de cuero y ventanales"
                        class="h-56 w-full object-cover sm:h-64"
                        loading="lazy"
                    >

                    <div class="absolute inset-x-4 bottom-4 flex items-end justify-between gap-3">
                        <p class="rounded-full bg-ink/70 px-3 py-1.5 text-[11px] tracking-[0.16em] text-white uppercase backdrop-blur">
                            Venta · Alquiler
                        </p>

                        <span class="grid size-10 place-items-center rounded-full bg-surface text-ink" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="size-4">
                                <path d="M7 17 17 7M9 7h8v8" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Metrics --}}
    <section class="site-container mt-16 lg:mt-20">
        <dl class="grid grid-cols-2 gap-y-8 sm:grid-cols-4">
            @foreach ($stats as $stat)
                <div class="border-l border-line pl-5 sm:pl-6 {{ $loop->first ? 'border-l-0 pl-0 sm:pl-0' : '' }}">
                    <dd class="text-4xl font-medium tracking-[-0.03em] lg:text-5xl">{{ $stat['value'] }}</dd>
                    <dt class="mt-2 text-sm text-ink-muted">{{ $stat['label'] }}</dt>
                </div>
            @endforeach
        </dl>
    </section>

    {{-- Style section --}}
    <section class="site-container mt-20 lg:mt-32">
        <div class="grid items-center gap-10 lg:grid-cols-2 lg:gap-16">
            <div class="relative">
                <div class="overflow-hidden rounded-4xl">
                    <img
                        src="{{ config('site.images.style_main') }}"
                        alt="Living amplio con escalera de madera y grandes ventanales"
                        class="aspect-[4/5] w-full object-cover lg:aspect-[5/6]"
                        loading="lazy"
                    >
                </div>

                <div class="absolute -right-3 bottom-8 hidden w-44 overflow-hidden rounded-3xl border-4 border-surface shadow-2xl shadow-ink/20 lg:block">
                    <img
                        src="{{ config('site.images.style_detail') }}"
                        alt="Casa con pileta y galería"
                        class="aspect-square w-full object-cover"
                        loading="lazy"
                    >
                </div>
            </div>

            <div class="lg:pl-8">
                <p class="eyebrow">Diseño · Calidez</p>

                <h2 class="mt-4 text-4xl leading-[1.02] font-semibold tracking-[-0.03em] sm:text-5xl lg:text-6xl">
                    Estilo atemporal,<br>encanto real
                </h2>

                <p class="mt-6 max-w-md text-sm leading-relaxed text-ink-muted sm:text-base">
                    Trabajamos con propietarios que cuidan cada detalle: buenas
                    terminaciones, luz natural y espacios que se adaptan a distintas
                    formas de vivir.
                </p>

                <a href="{{ url('/nosotros') }}" class="btn mt-8">
                    Conocenos
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="size-4" aria-hidden="true">
                        <path d="M7 17 17 7M9 7h8v8" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- Properties collection --}}
    <section class="site-container mt-20 lg:mt-32">
        <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="eyebrow">Colección</p>

                <h2 class="mt-3 max-w-3xl text-4xl leading-[1.02] font-semibold tracking-[-0.03em] sm:text-5xl lg:text-6xl">
                    Explorá las propiedades que tenemos para vos
                </h2>
            </div>

            <div class="md:max-w-xs md:pb-2 md:text-right">
                <p class="text-sm leading-relaxed text-ink-muted">
                    Una selección actualizada de lo que está disponible hoy para
                    comprar o alquilar.
                </p>

                <a href="{{ url('/propiedades') }}" class="btn mt-4">Ver todas</a>
            </div>
        </div>

        @if ($properties->isEmpty())
            <div class="mt-10 rounded-4xl border border-dashed border-line px-6 py-14 text-center">
                <p class="font-medium">Todavía no hay propiedades publicadas</p>
                <p class="mt-1 text-sm text-ink-muted">
                    Cuando cargues propiedades desde el panel van a aparecer acá.
                </p>
            </div>
        @else
            <div class="mt-10 [&>*]:mb-5 sm:columns-2 lg:columns-3">
                @foreach ($properties as $property)
                    <x-site.property-card
                        :property="$property"
                        :ratio="match (true) {
                            $loop->index % 6 === 1 => 'aspect-[3/4]',
                            $loop->index % 6 === 2 => 'aspect-square',
                            $loop->index % 6 === 3 => 'aspect-square',
                            $loop->index % 6 === 5 => 'aspect-[3/4]',
                            default => 'aspect-[4/5]',
                        }"
                        class="break-inside-avoid"
                    />
                @endforeach
            </div>
        @endif
    </section>
@endsection
