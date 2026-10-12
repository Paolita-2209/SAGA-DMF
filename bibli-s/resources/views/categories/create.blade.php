<x-osome-layout title="Nouvelle catégorie">
    <x-slot name="breadcrumb"><a href="{{ route('categories.index') }}">Catégories</a> / Nouvelle</x-slot>
    <x-slot name="actions">
        <a href="{{ route('categories.index') }}" class="o-btn">Annuler</a>
        <button type="submit" form="categorie-form" class="o-btn o-btn-primary">Enregistrer</button>
    </x-slot>

    <form id="categorie-form" method="POST" action="{{ route('categories.store') }}" class="o-sheet o-form">
        @csrf
        @include('categories._form')
    </form>
</x-osome-layout>