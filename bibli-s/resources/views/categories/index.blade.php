<x-osome-layout title="Catégories">
    <x-slot name="breadcrumb"><strong>Catégories</strong></x-slot>
    <x-slot name="actions">
        <a href="{{ route('categories.create') }}" class="o-btn o-btn-primary">Nouveau</a>
    </x-slot>

    @error('categorie')
        <div class="o-alert o-alert-danger">{{ $message }}</div>
    @enderror

    <div class="o-sheet">
        <table class="o-list">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Livres</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $categorie)
                    <tr>
                        <td><strong>{{ $categorie->name }}</strong></td>
                        <td>{{ $categorie->description }}</td>
                        <td><span class="o-badge o-badge-ok">{{ $categorie->livres_count }}</span></td>
                        <td class="o-right">
                            <a class="o-link" href="{{ route('categories.show', $categorie) }}">Voir</a>
                            <a class="o-link" href="{{ route('categories.edit', $categorie) }}">Modifier</a>
                          
                                <form action="{{ route('categories.destroy', $categorie) }}" method="POST" style="display:inline"
                                      onsubmit="return confirm('Supprimer cette catégorie ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="o-link danger">Supprimer</button>
                                </form>
                         
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="o-empty">Aucune catégorie enregistrée.</td></tr>
                @endforelse
            </tbody>
        </table>

        @if($categories->hasPages())
            <div class="o-pager">{{ $categories->links('pagination::default') }}</div>
        @endif
    </div>
</x-osome-layout>