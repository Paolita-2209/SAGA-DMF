<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Modifier la catégorie</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto px-4">
            <form action="{{ route('categories.update', $category) }}" method="POST" class="bg-white shadow rounded p-6">
                @csrf
                @method('PUT')
                <input type="text" name="name" value="{{ old('name', $category->name) }}"
                       class="w-full border-gray-300 rounded shadow-sm">
                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                <button class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded">Mettre à jour</button>
            </form>
        </div>
    </div>
</x-app-layout>