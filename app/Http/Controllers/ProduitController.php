<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Frontend/Produit/Index', [
            'produits' => Produit::orderBy('id')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Frontend/Produit/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'prix_unitaire' => 'required|integer|min:0'
        ]);

        Produit::create([
            'name' => $request->name,
            'prix_unitaire' => $request->prix_unitaire
        ]);

        return redirect()->route('produits.index')->with('message', 'Produit ajouté avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produit $produit)
    {
        return Inertia::render('Frontend/Produit/Show', [
            'produit' => $produit
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produit $produit)
    {
        return Inertia::render('Frontend/Produit/Edit', [
            'produit' => $produit
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produit $produit)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'prix_unitaire' => 'required|integer|min:0'
        ]);

        $produit->update($validated);

        return redirect()->route('produits.index')->with('message', 'Produit modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produit $produit)
    {
        $produit->delete();
        return redirect()->route('produits.index')->with('message', 'Produit supprimé avec succès');
    }
}
