<?php

namespace Tests\Feature;

use App\Models\Recipes;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class RecipesControllerTest extends TestCase
{
    use DatabaseTransactions;

    private function initialize()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
    }

    public function testShouldReturnListOfRecipes()
    {
        $recipes = Recipes::factory()->count(3)->create();
        $this->initialize();
        $this->withoutExceptionHandling();
        $response = $this->get('/recipes/list');
        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonStructure([
            'filters' => ['search', 'sort'],
            'recipes' => [
                'current_page',
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
                        'ingredients',
                        'preparation',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links' => [
                    '*' => [
                        'url',
                        'label',
                        'active',
                    ],
                ],
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total',
            ],
        ]);
        $response->assertJsonFragment([
            'id' => $recipes[0]->id,
            'title' => $recipes[0]->title,
            'description' => $recipes[0]->description,
            'ingredients' => $recipes[0]->ingredients,
            'preparation' => $recipes[0]->preparation,
            'created_at' => $recipes[0]->created_at->diffForHumans(),
            'updated_at' => $recipes[0]->updated_at->diffForHumans(),
        ]);

        $response->assertJsonFragment([
            'id' => $recipes[1]->id,
            'title' => $recipes[1]->title,
            'description' => $recipes[1]->description,
            'ingredients' => $recipes[1]->ingredients,
            'preparation' => $recipes[1]->preparation,
            'created_at' => $recipes[1]->created_at->diffForHumans(),
            'updated_at' => $recipes[1]->updated_at->diffForHumans(),
        ]);

        $response->assertJsonFragment([
            'id' => $recipes[2]->id,
            'title' => $recipes[2]->title,
            'description' => $recipes[2]->description,
            'ingredients' => $recipes[2]->ingredients,
            'preparation' => $recipes[2]->preparation,
            'created_at' => $recipes[2]->created_at->diffForHumans(),
            'updated_at' => $recipes[2]->updated_at->diffForHumans(),
        ]);
    }

    public function testShouldCreateRecipe()
    {
        $this->initialize();
        $this->withoutExceptionHandling();
        $response = $this->post('/recipes/store', [
            'title' => 'Receita de teste',
            'description' => 'Descrição de teste',
            'ingredients' => 'Ingredientes de teste',
            'preparation' => 'Preparo de teste',
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Receita criada com sucesso!',
        ]);
    }

    public function testShouldReturnErrorOfValidateWhenCreateRecipe()
    {
        $this->initialize();
        $response = $this->post('/recipes/store', [
            'title' => '',
            'description' => '',
            'ingredients' => '',
            'preparation' => '',
        ]);
        $response->assertSessionHasErrors(['title', 'description', 'ingredients', 'preparation']);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors([
            'title' => 'The title field is required.',
            'description' => 'The description field is required.',
            'ingredients' => 'The ingredients field is required.',
            'preparation' => 'The preparation field is required.',
        ]);

        $response = $this->post('/recipes/store', [
            'title' => 'Receita de teste',
            'description' => 'Descrição de teste',
            'ingredients' => 'Ingredientes de teste',
            'preparation' => 'Preparo de teste',
        ]);

        $response->assertSessionDoesntHaveErrors(['title', 'description', 'ingredients', 'preparation']);
    }

    public function testShouldDeleteRecipe()
    {
        $this->initialize();
        $this->withoutExceptionHandling();
        $recipe = Recipes::factory()->create();
        $response = $this->delete('/recipes/' . $recipe->id);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Receita deletada com sucesso!',
        ]);
    }

    public function testShouldUpdateRecipe()
    {
        $this->initialize();
        $this->withoutExceptionHandling();
        $recipe = Recipes::factory()->create();
        $response = $this->put('/recipes/' . $recipe->id, [
            'title' => 'Receita de teste',
            'description' => 'Descrição de teste',
            'ingredients' => 'Ingredientes de teste',
            'preparation' => 'Preparo de teste',
        ]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Receita atualizada com sucesso!',
        ]);
    }

    public function testShouldReturnItemListBySearchValue()
    {
        $this->initialize();
        $this->withoutExceptionHandling();
        $recipes = Recipes::factory()->count(3)->create();
        $response = $this->get('/recipes/list?search=' . $recipes[0]->title);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(2);
        $response->assertJsonStructure([
            'filters' => ['search', 'sort'],
            'recipes' => [
                'current_page',
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
                        'ingredients',
                        'preparation',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links' => [
                    '*' => [
                        'url',
                        'label',
                        'active',
                    ],
                ],
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total',
            ],
        ]);
        $response->assertJsonFragment([
            'id' => $recipes[0]->id,
            'title' => $recipes[0]->title,
            'description' => $recipes[0]->description,
            'ingredients' => $recipes[0]->ingredients,
            'preparation' => $recipes[0]->preparation,
            'created_at' => $recipes[0]->created_at->diffForHumans(),
            'updated_at' => $recipes[0]->updated_at->diffForHumans(),
        ]);
    }
}