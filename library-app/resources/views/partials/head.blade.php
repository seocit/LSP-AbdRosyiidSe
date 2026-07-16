<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    {{ filled($title ?? null) ? $title . ' - ' . config('app.name', 'Laravel') : config('app.name', 'Laravel') }}
</title>

<link rel="icon" href="/icon-library-noiree.svg" sizes="any">
<link rel="icon" href="/icon-library-noiree.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

@fonts

{{-- Google Fonts for Vintage Library Theme --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,500;1,600&family=EB+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Courier+Prime:wght@400;700&display=swap"
    rel="stylesheet">

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance