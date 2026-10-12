@php $livre = $livre ?? null; @endphp
<form method="POST" action="{{ route('livres.store') }}" enctype="multipart/form-data">
    @csrf

<input type="text" name="title" class="o-title" placeholder="Titre du livre"
       value="{{ old('title', $livre?->title) }}" required>
@error('title') <div class="o-error" style="grid-column:auto">{{ $message }}</div> @enderror

<div class="o-group">
    <div class="o-col">
        <div class="o-field">
            <label for="author">Auteur</label>
            <input type="text" id="author" name="author" value="{{ old('author', $livre?->author) }}" required>
            @error('author') <div class="o-error">{{ $message }}</div> @enderror
        </div>
        <div class="o-field">
            <label for="isbn">ISBN</label>
            <input type="text" id="isbn" name="isbn" value="{{ old('isbn', $livre?->isbn) }}" required>
            @error('isbn') <div class="o-error">{{ $message }}</div> @enderror
        </div>
        <div class="input-box">
    <select name="category_id" id="category_id" required>
        <option value="">-- Choisir une catégorie --</option>
        @foreach ($categories as $categorie)
            <option value="{{ $categorie->id }}"
                {{ old('category_id') == $categorie->id ? 'selected' : '' }}>
                {{ $categorie->name }}
            </option>
        @endforeach
    </select>
</div>
    </div>

    <div class="o-col">
        <div class="o-field">
            <label for="quantity">Quantité</label>
            <input type="number" min="0" id="quantity" name="quantity" value="{{ old('quantity', $livre?->quantity) }}" required>
            @error('quantity') <div class="o-error">{{ $message }}</div> @enderror
        </div>
        <div class="o-field">
            <label for="available_quantity">Disponible</label>
            <input type="number" min="0" id="available_quantity" name="available_quantity" value="{{ old('available_quantity', $livre?->available_quantity) }}" required>
            @error('available_quantity') <div class="o-error">{{ $message }}</div> @enderror
        </div>
        <div class="o-field">
            <label for="image">Image</label>
            <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png">
            @error('image') <div class="o-error">{{ $message }}</div> @enderror
        </div>
        @if($livre?->image)
            <img class="o-cover" src="{{ asset('storage/'.$livre->image) }}" alt="">
        @endif
    </div>
</div>

<div class="o-notes">
    <label for="description">Description</label>
    <textarea id="description" name="description">{{ old('description', $livre?->description) }}</textarea>
    @error('description') <div class="o-error" style="grid-column:auto">{{ $message }}</div> @enderror
</div>
</form>