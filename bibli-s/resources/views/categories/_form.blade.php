@php $categorie = $categorie ?? null; @endphp

<input type="text" name="name" class="o-title" placeholder="Nom de la catégorie"
       value="{{ old('name', $categorie?->name) }}" required>
@error('name') <div class="o-error" style="grid-column:auto">{{ $message }}</div> @enderror

<div class="o-notes">
    <label for="description">Description</label>
    <textarea id="description" name="description" required>{{ old('description', $categorie?->description) }}</textarea>
    @error('description') <div class="o-error" style="grid-column:auto">{{ $message }}</div> @enderror
</div>