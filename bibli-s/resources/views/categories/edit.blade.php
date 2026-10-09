<h1>Modifier la catégorie</h1>

<form action="{{ route('categories.update', $category) }}" method="POST">
    @csrf @method('PUT')
    <input type="text" name="name" value="{{ old('name', $category->name) }}">
    @error('name') <p>{{ $message }}</p> @enderror
    <button>Mettre à jour</button>
</form>