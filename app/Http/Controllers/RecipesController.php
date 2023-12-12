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
        return Inertia::render('Recipes/CreateOrUpdate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'ingredients' => 'required|string',
            'preparation' => 'required|string',
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

    public function destroy(int $id)
    {
        $recipe = Recipes::find($id);
        $recipe->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Receita deletada com sucesso!',
        ], Response::HTTP_OK);
    }

    public function edit(int $id)
    {
        $recipe = Recipes::find($id);

        return Inertia::render('Recipes/CreateOrUpdate', [
            'recipe' => [
                'id' => $recipe->id,
                'title' => $recipe->title,
                'description' => $recipe->description,
                'ingredients' => $recipe->ingredients,
                'preparation' => $recipe->preparation,
            ],
        ]);
    }

    public function update(Request $request, int $id)
    {
        $recipe = Recipes::find($id);

        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'ingredients' => 'required|string',
            'preparation' => 'required|string',
        ]);

        $recipe->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Receita atualizada com sucesso!',
        ], Response::HTTP_OK);
    }
}
