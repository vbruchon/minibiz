<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MiniBiz — ERP Freelance</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-background text-foreground antialiased relative overflow-hidden">
    <div class="absolute top-0 left-0 pointer-events-none">
        <div class="w-[500px] h-[500px] bg-primary/15 dark:bg-primary/25 
                    blur-[140px] rounded-full -translate-x-1/3 -translate-y-1/3">
        </div>
    </div>

    <div class="absolute bottom-0 right-0 pointer-events-none">
        <div class="w-[600px] h-[600px] bg-primary/15 dark:bg-primary/25 
                    blur-[160px] rounded-full translate-x-1/3 translate-y-1/3">
        </div>
    </div>

    <div class="min-h-screen flex flex-col items-center justify-center px-6 relative z-10">
        <div class="flex flex-col items-center mb-10 select-none">
            <img src="{{ asset('logo.png') }}"
                alt="MiniBiz Logo"
                class="w-24 h-24 object-contain drop-shadow-sm" />

            <h1 class="mt-6 text-4xl md:text-5xl font-bold text-foreground">
                MiniBiz
            </h1>

            <p class="mt-2 text-lg text-center max-w-lg leading-relaxed text-muted-foreground">
                <span class="block">
                    Votre mini ERP <span class="font-medium text-primary">local-first</span> conçu pour les freelances.
                </span>
                <span class="block">
                    Simple, rapide, et auto-hébergé.
                </span>
            </p>
        </div>

        <x-button href="{{ route('dashboard.index') }}" variant="primary">
            Accéder au Dashboard
        </x-button>

        <div class="mt-16 grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-4xl w-full">
            <div class="p-8 rounded-2xl shadow-lg border border-border bg-card">
                <h3 class="text-xl font-semibold mb-3 text-card-foreground">
                    Gestion de vos clients
                </h3>
                <p class="text-sm text-muted-foreground leading-relaxed">
                    Stockez les informations essentielles, suivez l’activité du client, accédez
                    rapidement aux devis et factures liés.
                </p>
            </div>

            <div class="p-8 rounded-2xl shadow-lg border border-border bg-card">
                <h3 class="text-xl font-semibold mb-3 text-card-foreground">
                    Produits & Options
                </h3>
                <p class="text-sm text-muted-foreground leading-relaxed">
                    Créez vos services, forfaits et packs personnalisés. Gérez les options
                    et leurs prix associés.
                </p>
            </div>

            <div class="p-8 rounded-2xl shadow-lg border border-border bg-card">
                <h3 class="text-xl font-semibold mb-3 text-card-foreground">
                    Devis & Factures
                </h3>
                <p class="text-sm text-muted-foreground leading-relaxed">
                    Génération rapide de devis et factures, conversion automatique,
                    statuts, TVA et export PDF propre.
                </p>
            </div>
        </div>

        <div class="mt-16 text-xs text-muted-foreground">
            MiniBiz — Local-first · Open Source 2025.
        </div>
    </div>
</body>

</html>