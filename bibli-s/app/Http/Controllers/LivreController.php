<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class LivreController extends Controller
{
    public function index()
    {
        $livres = Livre::latest()->paginate(10);
        return view('livres.index', compact('livres'));
    }

    public function create()
    {
        $categories = Categorie::all();
        return view('livres.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'              => 'required|string|max:255',
            'author'             => 'required|string|max:100',
            'isbn'               => 'required|string|max:100|unique:livres,isbn',
            'category_id'        => 'required|exists:categories,id',
            'quantity'           => 'required|integer|min:0',
            'available_quantity' => 'required|integer|min:0|lte:quantity',
            'image'              => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description'        => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('livres', 'public');
        }

        Livre::create($data);

        return redirect()->route('livres.index')
            ->with('success', 'Livre ajouté avec succès.');
    }

    public function show(Livre $livre)
    {
        return view('livres.show', compact('livre'));
    }

    public function edit(Livre $livre)
    {
        $categories = Categorie::all();
        return view('livres.edit', compact('livre', 'categories'));
    }

    public function update(Request $request, Livre $livre)
    {
        $data = $request->validate([
            'title'              => 'required|string|max:255',
            'author'             => 'required|string|max:100',
            'isbn'               => [
                'required', 'string', 'max:100',
                Rule::unique('livres', 'isbn')->ignore($livre->getKey(), $livre->getKeyName()),
            ],
            'category_id' => 'required|exists:categories,id',
            'quantity'           => 'required|integer|min:0',
            'available_quantity' => 'required|integer|min:0|lte:quantity',
            'image'              => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description'        => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            if ($livre->image) {
                Storage::disk('public')->delete($livre->image);
            }
            $data['image'] = $request->file('image')->store('livres', 'public');
        }

        $livre->update($data);

        return redirect()->route('livres.index')
            ->with('success', 'Livre mis à jour avec succès.');
    }

    public function destroy(Livre $livre)
    {
        if ($livre->image) {
            Storage::disk('public')->delete($livre->image);
        }

        $livre->delete();

        return redirect()->route('livres.index')
            ->with('success', 'Livre supprimé avec succès.');
    }
}