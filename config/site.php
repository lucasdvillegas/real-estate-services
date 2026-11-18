<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Public site identity
    |--------------------------------------------------------------------------
    |
    | Used by the Blade views that make up the public website (layout, home,
    | properties listing...). Override any value from the .env file.
    |
    */

    'name' => env('SITE_NAME', 'Inmobiliaria Horizonte'),

    'tagline' => env('SITE_TAGLINE', 'Venta y alquiler de propiedades'),

    'description' => env(
        'SITE_DESCRIPTION',
        'Casas, departamentos y PH en venta y alquiler. Acompañamos cada operación con asesoramiento personalizado.'
    ),

    'contact' => [
        'phone' => env('SITE_PHONE', '+54 11 5555-5555'),
        'whatsapp' => env('SITE_WHATSAPP', '5491155555555'),
        'email' => env('SITE_EMAIL', 'hola@ejemplo.com'),
        'address' => env('SITE_ADDRESS', 'Av. Ejemplo 1234, Buenos Aires'),
        'hours' => env('SITE_HOURS', 'Lunes a viernes de 9 a 18 h'),
    ],

    'social' => [
        'instagram' => env('SITE_INSTAGRAM'),
        'facebook' => env('SITE_FACEBOOK'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Home metrics
    |--------------------------------------------------------------------------
    |
    | Static numbers shown next to the real amount of published properties.
    |
    */

    'metrics' => [
        'years' => env('SITE_YEARS', 15),
        'operations' => env('SITE_OPERATIONS', 320),
    ],

    /*
    |--------------------------------------------------------------------------
    | Editorial images
    |--------------------------------------------------------------------------
    |
    | Stock imagery for the marketing sections. Property cards use the photos
    | uploaded from the panel and fall back to one of these images.
    |
    */

    'images' => [
        'hero' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=2000&q=80',
        'intro_main' => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1400&q=80',
        'intro_card' => 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=900&q=80',
        'style_main' => 'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?auto=format&fit=crop&w=1400&q=80',
        'style_detail' => 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?auto=format&fit=crop&w=900&q=80',
        'contact' => 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?auto=format&fit=crop&w=1200&q=80',

        'fallbacks' => [
            'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?auto=format&fit=crop&w=1000&q=80',
            'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1000&q=80',
        ],
    ],

];
