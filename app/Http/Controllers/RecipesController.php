<?php

namespace App\Http\Controllers;

use App\Models\Recipes;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class RecipesController extends Controller
{
    public function create()
    {
        return Inertia::render('Recipes/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'ingredients' => 'required|string|max:255',
            'preparation' => 'required|string|max:255',
        ]);

        Recipes::create($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'Receita criada com sucesso!',
        ], Response::HTTP_CREATED);
    }

    public function list(Request $request)
    {
        $recipes = Recipes::query()
            ->filter($request->only('search'))
            ->sort($request->sort)
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($recipe) => [
                'id' => $recipe->id,
                'title' => $recipe->title,
                'description' => $recipe->description,
                'ingredients' => $recipe->ingredients,
                'preparation' => $recipe->preparation,
                'created_at' => $recipe->created_at->diffForHumans(),
                'updated_at' => $recipe->updated_at->diffForHumans(),
            ]);

        return response()->json([
            'filters' => $request->all('search', 'sort'),
            'recipes' => $recipes,
        ], Response::HTTP_OK);
    }
}
