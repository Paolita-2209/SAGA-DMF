<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Catégories</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4">

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            <a href="{{ route('categories.create') }}"
               class="inline-block mb-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                Nouvelle catégorie
            </a>

            <div class="bg-white shadow rounded overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-100 text-gray-600 text-sm">
                        <tr>
                            <th class="px-4 py-3">Nom</th>
                            <th class="px-4 py-3">Livres</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($categories as $category)
                        <tr>
                            <td class="px-4 py-3">{{ $category->name }}</td>
                            <td class="px-4 py-3">{{ $category->books_count }}</td>
                            <td class="px-4 py-3 flex gap-3">
                                <a href="{{ route('categories.edit', $category) }}" class="text-indigo-600 hover:underline">Modifier</a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                      onsubmit="return confirm('Supprimer ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>