<?php

namespace App\Http\Controllers;

use App\Models\Emprunt;
use App\Models\Livre;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EmpruntController extends Controller
{
    public function index()
    {
        $emprunts = Emprunt::with(['livre', 'user'])
            ->latest('loaned_at')
            ->paginate(10);

        return view('emprunts.index', compact('emprunts'));
    }

    public function create()
    {
        $livres = Livre::where('available_quantity', '>', 0)
            ->orderBy('title')
            ->get();

        return view('emprunts.create', compact('livres'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'book_id'        => 'required|exists:livres,id',
            'borrower_name'  => 'required|string|max:150',
            'borrower_phone' => 'nullable|string|max:30',
            'borrower_email' => 'nullable|email|max:150',
            'loaned_at'      => 'required|date',
            'due_date'       => 'required|date|after_or_equal:loaned_at',
        ]);

        try {
            DB::transaction(function () use ($data) {
                $livre = Livre::lockForUpdate()->findOrFail($data['book_id']);

                if (! $livre->isAvailable()) {
                    throw new \RuntimeException('Aucun exemplaire disponible pour ce livre.');
                }

                $livre->decrement('available_quantity');

               Emprunt::create($data + [
                   'user_id'     => Auth::id(),   // l'agent qui enregistre l'emprunt
                   'returned_at' => null,
                   'status'      => 'en_cours',
]);
            });
        } catch (\RuntimeException $e) {
            return back()->withInput()->withErrors(['book_id' => $e->getMessage()]);
        }

        return redirect()->route('emprunts.index')
            ->with('success', 'Emprunt enregistré avec succès.');
    }

    public function show(Emprunt $emprunt)
    {
        $emprunt->load(['livre', 'user']);

        return view('emprunts.show', compact('emprunt'));
    }

    public function edit(Emprunt $emprunt)
    {
        return view('emprunts.edit', compact('emprunt'));
    }

    // On ne modifie que la date d'échéance et les coordonnées de l'emprunteur
    // (pas le livre : cela fausserait le stock)
    public function update(Request $request, Emprunt $emprunt): RedirectResponse
    {
        $data = $request->validate([
            'borrower_name'  => 'required|string|max:150',
            'borrower_phone' => 'nullable|string|max:30',
            'borrower_email' => 'nullable|email|max:150',
            'due_date'       => 'required|date|after_or_equal:' . $emprunt->loaned_at->toDateString(),
        ]);

        $emprunt->update($data);

        return redirect()->route('emprunts.index')
            ->with('success', 'Emprunt mis à jour avec succès.');
    }

    // Retour d'un livre : PATCH /emprunts/{emprunt}/retour
    public function retour(Emprunt $emprunt): RedirectResponse
    {
        if ($emprunt->returned_at) {
            return back()->withErrors(['emprunt' => 'Ce livre a déjà été retourné.']);
        }

        // markAsReturned() enregistre la date de retour, le statut et remet l'exemplaire en stock
        DB::transaction(fn () => $emprunt->markAsReturned());

        return redirect()->route('emprunts.index')
            ->with('success', 'Livre retourné avec succès.');
    }

    public function destroy(Emprunt $emprunt): RedirectResponse
    {
        DB::transaction(function () use ($emprunt) {
            // Si l'emprunt est encore en cours, on remet l'exemplaire en stock
            if (! $emprunt->returned_at) {
                $emprunt->livre()->increment('available_quantity');
            }

            $emprunt->delete();
        });

        return redirect()->route('emprunts.index')
            ->with('success', 'Emprunt supprimé avec succès.');
    }
}