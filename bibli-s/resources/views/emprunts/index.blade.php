<x-osome-layout title="Emprunts">
    <x-slot name="breadcrumb">Emprunts</x-slot>
    <x-slot name="actions">
        <a href="{{ route('emprunts.create') }}" class="o-btn o-btn-primary">Nouveau</a>
    </x-slot>

    <div class="o-sheet">
        <form method="GET" class="o-filters">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Emprunteur ou livre…">
            <select name="status">
                <option value="">Tous les statuts</option>
                <option value="en cours" @selected(request('status') === 'en cours')>En cours</option>
                <option value="retourné" @selected(request('status') === 'retourné')>Retournés</option>
            </select>
            <button class="o-btn">Filtrer</button>
            @if (request()->hasAny(['search', 'status']))
                <a href="{{ route('emprunts.index') }}" class="o-btn">Réinitialiser</a>
            @endif
        </form>

        <table class="o-list">
            <thead>
                <tr>
                    <th>Livre</th>
                    <th>Emprunteur</th>
                    <th>Téléphone</th>
                    <th>Emprunté le</th>
                    <th>À rendre le</th>
                    <th>Statut</th>
                    <th class="o-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($emprunts as $emprunt)
                    @php
                        $rendu = $emprunt->status === 'retourné';
                        $retard = !$rendu && $emprunt->due_date?->isPast();
                    @endphp
                    <tr>
                        <td><strong>{{ $emprunt->livre->title ?? '—' }}</strong></td>
                        <td>{{ $emprunt->nom }}</td>
                        <td>{{ $emprunt->telephone }}</td>
                        <td>{{ $emprunt->loaned_at?->format('d/m/Y') }}</td>
                        <td class="{{ $retard ? 'o-late' : '' }}">{{ $emprunt->due_date?->format('d/m/Y') }}</td>
                        <td>
                            @if ($rendu)
                                <span class="o-badge o-badge-ok">Retourné</span>
                            @elseif ($retard)
                                <span class="o-badge o-badge-no">En retard</span>
                            @else
                                <span class="o-badge o-badge-warn">En cours</span>
                            @endif
                        </td>
                        <td class="o-right">
                            <a href="{{ route('emprunts.show', $emprunt) }}" class="o-link">Voir</a>
                            @unless ($rendu)
                                <a href="{{ route('emprunts.edit', $emprunt) }}" class="o-link">Modifier</a>
                                <form action="{{ route('emprunts.retour', $emprunt) }}" method="POST" style="display:inline">
                                    @csrf @method('PATCH')
                                    <button class="o-link">Marquer rendu</button>
                                </form>
                            @endunless
                                <form action="{{ route('emprunts.destroy', $emprunt) }}" method="POST" style="display:inline"
                                      onsubmit="return confirm('Supprimer cet emprunt ?')">
                                    @csrf @method('DELETE')
                                    <button class="o-link danger">Supprimer</button>
                                </form>
                        
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="o-empty">Aucun emprunt trouvé.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="o-pager">{{ $emprunts->withQueryString()->links() }}</div>
    </div>
</x-osome-layout>