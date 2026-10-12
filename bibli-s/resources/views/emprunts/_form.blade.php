<div class="o-group">
    <div class="o-col">
        <div class="o-field">
            <label for="book_id">Livre *</label>
            <select name="book_id" id="book_id" required>
                <option value="">— Choisir —</option>
                @foreach ($livres as $livre)
                    <option value="{{ $livre->id }}"
                        @selected(old('book_id', $emprunt->book_id ?? '') == $livre->id)>
                        {{ $livre->title }} ({{ $livre->available_quantity }} dispo)
                    </option>
                @endforeach
            </select>
            @error('book_id') <div class="o-error">{{ $message }}</div> @enderror
        </div>

        <div class="o-field">
            <label for="nom">Nom *</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom', $emprunt->nom ?? '') }}" required>
            @error('nom') <div class="o-error">{{ $message }}</div> @enderror
        </div>

        <div class="o-field">
            <label for="telephone">Téléphone *</label>
            <input type="text" name="telephone" id="telephone" value="{{ old('telephone', $emprunt->telephone ?? '') }}" required>
            @error('telephone') <div class="o-error">{{ $message }}</div> @enderror
        </div>

        <div class="o-field">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $emprunt->email ?? '') }}">
            @error('email') <div class="o-error">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="o-col">
        <div class="o-field">
            <label for="loaned_at">Emprunté le *</label>
            <input type="date" name="loaned_at" id="loaned_at"
                   value="{{ old('loaned_at', optional($emprunt->loaned_at ?? null)->format('Y-m-d') ?? now()->format('Y-m-d')) }}" required>
            @error('loaned_at') <div class="o-error">{{ $message }}</div> @enderror
        </div>

        <div class="o-field">
            <label for="due_date">À rendre le *</label>
            <input type="date" name="due_date" id="due_date"
                   value="{{ old('due_date', optional($emprunt->due_date ?? null)->format('Y-m-d') ?? now()->addDays(14)->format('Y-m-d')) }}" required>
            @error('due_date') <div class="o-error">{{ $message }}</div> @enderror
        </div>
    </div>
</div>