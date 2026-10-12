<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Bibliothèque' }}</title>
    @vite(['resources/css/osome.css'])
</head>
<body class="o-body">
    <nav class="o-navbar">
        <a href="{{ route('dashboard') }}" class="o-brand">📚 Bibli-S</a>

        @php
            $menu = [
                'livres.index'     => 'Livres',
                'categories.index' => 'Catégories',
                'membres.index'    => 'Membres',
                'emprunts.index'   => 'Emprunts',
            ];
        @endphp
        <div class="o-menu">
            @foreach($menu as $routeName => $label)
                @if(Route::has($routeName))
                    <a href="{{ route($routeName) }}" @class(['active' => request()->routeIs(Str::before($routeName, '.').'.*')])>{{ $label }}</a>
                @endif
            @endforeach
        </div>

        <div class="o-user">
            <span>{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Déconnexion</button>
            </form>
        </div>
    </nav>

    <div class="o-control">
        <div class="o-breadcrumb">{{ $breadcrumb ?? '' }}</div>
        <div class="o-actions">{{ $actions ?? '' }}</div>
    </div>

    <main class="o-main">
        @if(session('success'))
            <div class="o-alert">{{ session('success') }}</div>
        @endif

        {{ $slot }}
    </main>
</body>
</html>