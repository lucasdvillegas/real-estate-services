@props([
    'property',
    'ratio' => 'aspect-[4/5]',
])

@php
    $operation = $property->operations->first();

    $image = $property->images->first()?->path
        ?? collect(config('site.images.fallbacks'))->get($property->id % count(config('site.images.fallbacks')));

    $price = $operation
        ? $operation->currency.' '.number_format((float) $operation->price, 0, ',', '.')
        : 'Consultar precio';
@endphp

{{-- TODO: link to the property detail page once it exists. --}}
<a
    href="{{ url('/propiedades') }}"
    {{ $attributes->merge(['class' => 'group relative block overflow-hidden rounded-4xl bg-surface-alt ' . $ratio]) }}
>
    <img
        src="{{ $image }}"
        alt="{{ $property->title }}"
        class="absolute inset-0 size-full object-cover transition duration-700 ease-out group-hover:scale-[1.04]"
        loading="lazy"
    >

    <div class="absolute inset-0 bg-gradient-to-t from-ink/80 via-ink/10 to-transparent"></div>

    <div class="absolute inset-x-0 bottom-0 flex items-end justify-between gap-4 p-5 sm:p-6">
        <div class="min-w-0">
            <p class="text-[11px] font-medium tracking-[0.18em] text-white/70 uppercase">
                {{ $property->propertyType?->name }}
                @if ($operation?->propertyStatus)
                    <span class="mx-1 text-white/40">·</span>{{ $operation->propertyStatus->name }}
                @endif
            </p>

            <h3 class="mt-1.5 truncate text-lg font-medium text-white">
                {{ $property->title }}
            </h3>

            <p class="mt-1 text-sm text-white/75">{{ $price }}</p>
        </div>

        <span class="grid size-11 shrink-0 place-items-center rounded-full bg-surface text-ink transition duration-300 group-hover:bg-white" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="size-4">
                <path d="M7 17 17 7M9 7h8v8" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </span>
    </div>
</a>
