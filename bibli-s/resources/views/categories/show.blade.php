<x-osome-layout :title="$categorie->name">
    <x-slot name="breadcrumb"><a href="{{ route('categories.index') }}">Catégories</a> / {{ $categorie->name }}</x-slot>
    <x-slot name="actions">
        <a href="{{ route('categories.edit', $categorie) }}" class="o-btn o-btn-primary">Modifier</a>
        <a href="{{ route('categories.index') }}" class="o-btn">Retour</a>
    </x-slot>

    <div class="o-sheet o-form">
        <h1 class="o-heading">{{ $categorie->name }}</h1>
        <p>{{ $categorie->description }}</p>

        <div class="o-notes">
            <label>Livres de cette catégorie ({{ $categorie->livres->count() }})</label>
        </div>

        <table class="o-list">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categorie->livres as $livre)
                    <tr>
                        <td><a class="o-link" style="margin-left:0" href="{{ route('livres.show', $livre) }}">{{ $livre->title }}</a></td>
                        <td>{{ $livre->author }}</td>
                        <td>
                            <span class="o-badge {{ $livre->isAvailable() ? 'o-badge-ok' : 'o-badge-no' }}">
                                {{ $livre->available_quantity }} / {{ $livre->quantity }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="o-empty">Aucun livre dans cette catégorie.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-osome-layout>