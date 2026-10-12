<x-osome-layout title="Modifier le livre">
    <x-slot name="breadcrumb"><a href="{{ route('livres.index') }}">Livres</a> / {{ $livre->title }}</x-slot>
    <x-slot name="actions">
        <a href="{{ route('livres.index') }}" class="o-btn">Annuler</a>
        <button type="submit" form="livre-form" class="o-btn o-btn-primary">Enregistrer</button>
    </x-slot>

    <form id="livre-form" method="POST" action="{{ route('livres.update', $livre) }}"
          enctype="multipart/form-data" class="o-sheet o-form">
        @csrf
        @method('PUT')
        @include('livres._form')
    </form>
</x-osome-layout>