<h1>Nouvelle catégorie</h1>

<form action="{{ route('categories.store') }}" method="POST">
    @csrf
    <input type="text" name="name" value="{{ old('name') }}">
    @error('name') <p>{{ $message }}</p> @enderror
    <button>Enregistrer</button>
</form>