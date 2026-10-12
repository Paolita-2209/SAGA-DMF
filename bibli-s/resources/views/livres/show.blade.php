<x-osome-layout :title="$livre->title">
    <x-slot name="breadcrumb"><a href="{{ route('livres.index') }}">Livres</a> / {{ $livre->title }}</x-slot>
    <x-slot name="actions">
        <a href="{{ route('livres.edit', $livre) }}" class="o-btn o-btn-primary">Modifier</a>
        <a href="{{ route('livres.index') }}" class="o-btn">Retour</a>
    </x-slot>

    <div class="o-sheet o-form">
        <h1 class="o-heading">{{ $livre->title }}</h1>
        <span class="o-badge {{ $livre->isAvailable() ? 'o-badge-ok' : 'o-badge-no' }}">
            {{ $livre->isAvailable() ? 'Disponible' : 'Indisponible' }}
        </span>

        <div class="o-group">
            <div class="o-col">
                <div class="o-field"><label>Auteur</label><span>{{ $livre->author }}</span></div>
                <div class="o-field"><label>ISBN</label><span>{{ $livre->isbn }}</span></div>
                <div class="o-field"><label>Catégorie</label><span>{{ $livre->category?->name ?? '—' }}</span></div>
                <div class="o-field"><label>Stock</label><span>{{ $livre->available_quantity }} / {{ $livre->quantity }}</span></div>
            </div>
            <div class="o-col">
                @if($livre->image)
                    <img class="o-cover" src="{{ asset('storage/'.$livre->image) }}" alt="">
                @endif
            </div>
        </div>

        @if($livre->description)
            <div class="o-notes">
                <label>Description</label>
                <p>{{ $livre->description }}</p>
            </div>
        @endif
    </div>
</x-osome-layout>