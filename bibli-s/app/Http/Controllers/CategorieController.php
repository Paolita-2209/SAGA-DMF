<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::latest()->paginate(10);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100|unique:categories,name',
            'description' => 'required|string|max:255',
        ]);

        Categorie::create($data);

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie créée avec succès.');
    }

    public function show(Categorie $categorie)
    {
        $categorie->load('livres');

        return view('categories.show', compact('categorie'));
    }

    public function edit(Categorie $categorie)
    {
        return view('categories.edit', compact('categorie'));
    }

    public function update(Request $request, Categorie $categorie)
    {
        $data = $request->validate([
            'name' => [
                'required', 'string', 'max:100',
                Rule::unique('categories', 'name')->ignore($categorie->getKey(), $categorie->getKeyName()),
            ],
            'description' => 'required|string|max:255',
        ]);

        $categorie->update($data);

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(Categorie $categorie)
    {
        if ($categorie->livres()->exists()) {
            return back()->withErrors([
                'categorie' => 'Impossible de supprimer une catégorie qui contient des livres.',
            ]);
        }

        $categorie->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }
}