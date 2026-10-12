<x-osome-layout title="Livres">
    <x-slot name="breadcrumb"><strong>Livres</strong></x-slot>
    <x-slot name="actions">
        <a href="{{ route('livres.create') }}" class="o-btn o-btn-primary">Nouveau</a>
    </x-slot>

    <div class="o-sheet">
        <table class="o-list">
            <thead>
                <tr>
                    <th></th>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Catégorie</th>
                    <th>Stock</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($livres as $livre)
                    <tr>
                        <td>
                            @if($livre->image)
                                <img class="o-thumb" src="{{ asset('storage/'.$livre->image) }}" alt="">
                            @endif
                        </td>
                        <td><strong>{{ $livre->title }}</strong></td>
                        <td>{{ $livre->author }}</td>
                        <td>{{ $livre->category?->name ?? '—' }}</td>
                        <td>
                            <span class="o-badge {{ $livre->isAvailable() ? 'o-badge-ok' : 'o-badge-no' }}">
                                {{ $livre->available_quantity }} / {{ $livre->quantity }}
                            </span>
                        </td>
                        <td class="o-right">
                            <a class="o-link" href="{{ route('livres.show', $livre) }}">Voir</a>
                            <a class="o-link" href="{{ route('livres.edit', $livre) }}">Modifier</a>                        
                                <form action="{{ route('livres.destroy', $livre) }}" method="POST" style="display:inline"
                                      onsubmit="return confirm('Supprimer ce livre ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="o-link danger">Supprimer</button>
                                </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="o-empty">Aucun livre enregistré.</td></tr>
                @endforelse
            </tbody>
        </table>

        @if($livres->hasPages())
            <div class="o-pager">{{ $livres->links('pagination::default') }}</div>
        @endif
    </div>
</x-osome-layout>