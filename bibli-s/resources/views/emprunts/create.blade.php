<x-osome-layout title="Nouvel emprunt">
    <x-slot name="breadcrumb"><a href="{{ route('emprunts.index') }}">Emprunts</a> / Nouveau</x-slot>
    <x-slot name="actions">
        <a href="{{ route('emprunts.index') }}" class="o-btn">Annuler</a>
        <button type="submit" form="emprunt-form" class="o-btn o-btn-primary">Enregistrer</button>
    </x-slot>

    <form id="emprunt-form" method="POST" action="{{ route('emprunts.store') }}" class="o-sheet o-form">
        @csrf
        @include('emprunts._form')
    </form>
</x-osome-layout>