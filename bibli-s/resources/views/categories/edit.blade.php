<x-osome-layout :title="$categorie->name">
    <x-slot name="breadcrumb"><a href="{{ route('categories.index') }}">Catégories</a> / {{ $categorie->name }}</x-slot>
    <x-slot name="actions">
        <a href="{{ route('categories.index') }}" class="o-btn">Annuler</a>
        <button type="submit" form="categorie-form" class="o-btn o-btn-primary">Enregistrer</button>
    </x-slot>

    <form id="categorie-form" method="POST" action="{{ route('categories.update', $categorie) }}" class="o-sheet o-form">
        @csrf
        @method('PUT')
        @include('categories._form', ['categorie' => $categorie])
    </form>
</x-osome-layout>