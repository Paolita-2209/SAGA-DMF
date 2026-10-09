<h1>Catégories</h1>

@if(session('success')) <p>{{ session('success') }}</p> @endif
@if(session('error')) <p>{{ session('error') }}</p> @endif

<a href="{{ route('categories.create') }}">Nouvelle catégorie</a>

<table>
    <tr><th>Nom</th><th>Livres</th><th>Actions</th></tr>
    @foreach($categories as $category)
    <tr>
        <td>{{ $category->name }}</td>
         <td>{{ $category->books_count }}</td>
        <td>
            <a href="{{ route('categories.edit', $category) }}">Modifier</a>
            <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline">
                @csrf @method('DELETE')
                <button onclick="return confirm('Supprimer ?')">Supprimer</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>