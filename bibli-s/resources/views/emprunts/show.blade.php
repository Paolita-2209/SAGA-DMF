@php
    $rendu = $emprunt->status === 'retourné';
    $retard = !$rendu && $emprunt->due_date?->isPast();
@endphp

<x-osome-layout title="Emprunt #{{ $emprunt->id }}">
    <x-slot name="breadcrumb"><a href="{{ route('emprunts.index') }}">Emprunts</a> / #{{ $emprunt->id }}</x-slot>
    <x-slot name="actions">
             <form action="{{ route('emprunts.destroy', $emprunt) }}" method="POST"
               onsubmit="return confirm('Supprimer cet emprunt ?')">
               @csrf @method('DELETE')
               <button class="o-btn">Supprimer</button>
               </form>
            @unless ($rendu)
            <a href="{{ route('emprunts.edit', $emprunt) }}" class="o-btn">Modifier</a>
            <form action="{{ route('emprunts.retour', $emprunt) }}" method="POST">
                @csrf @method('PATCH')
                <button class="o-btn o-btn-primary">Marquer rendu</button>
            </form>
        @endunless
    </x-slot>

    <div class="o-sheet o-form">
        <h1 class="o-heading">{{ $emprunt->livre->title ?? 'Livre supprimé' }}</h1>
        @if ($rendu)
            <span class="o-badge o-badge-ok">Retourné</span>
        @elseif ($retard)
            <span class="o-badge o-badge-no">En retard</span>
        @else
            <span class="o-badge o-badge-warn">En cours</span>
        @endif

        <div class="o-group">
            <div class="o-col">
                <div class="o-field"><label>Emprunteur</label><span>{{ $emprunt->nom }}</span></div>
                <div class="o-field"><label>Téléphone</label><span>{{ $emprunt->telephone }}</span></div>
                <div class="o-field"><label>Email</label><span>{{ $emprunt->email ?: '—' }}</span></div>
                <div class="o-field"><label>Auteur</label><span>{{ $emprunt->livre->author ?? '—' }}</span></div>
            </div>
            <div class="o-col">
                <div class="o-field"><label>Emprunté le</label><span>{{ $emprunt->loaned_at?->format('d/m/Y') }}</span></div>
                <div class="o-field">
                    <label>À rendre le</label>
                    <span class="{{ $retard ? 'o-late' : '' }}">{{ $emprunt->due_date?->format('d/m/Y') }}</span>
                </div>
                <div class="o-field"><label>Rendu le</label><span>{{ $emprunt->returned_at?->format('d/m/Y') ?? '—' }}</span></div>
                <div class="o-field"><label>Enregistré par</label><span>{{ $emprunt->user->name ?? '—' }}</span></div>
            </div>
        </div>
    </div>
</x-osome-layout>