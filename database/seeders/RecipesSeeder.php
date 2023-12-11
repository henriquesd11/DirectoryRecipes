<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RecipesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recipes = [
            [
                'title' => 'Bolo de Cenoura',
                'description' => 'Bolo de cenoura com cobertura de chocolate',
                'ingredients' => '<h2><strong>Massa</strong></h2><ul><li><span style="color: rgb(60, 60, 60); background-color: rgb(255, 255, 255);">1/2 xícara (chá) de óleo</span></li><li><span style="color: rgb(60, 60, 60); background-color: rgb(255, 255, 255);">4 ovos</span></li><li><span style="color: rgb(60, 60, 60); background-color: rgb(255, 255, 255);">2 e 1/2 xícaras (chá) de farinha de trigo</span></li><li><span style="color: rgb(60, 60, 60); background-color: rgb(255, 255, 255);">3 cenouras médias raladas</span></li><li><span style="color: rgb(60, 60, 60); background-color: rgb(255, 255, 255);">2 xícaras (chá) de açúcar</span></li><li><span style="color: rgb(60, 60, 60); background-color: rgb(255, 255, 255);">1 colher (sopa) de fermento em pó</span></li></ul><p><br></p><h2><strong>Cobertura</strong></h2><ul><li><span style="color: rgb(60, 60, 60); background-color: rgb(255, 255, 255);">1 colher (sopa) de manteiga</span></li><li><span style="color: rgb(60, 60, 60); background-color: rgb(255, 255, 255);">1 xícara (chá) de açúcar</span></li><li><span style="color: rgb(60, 60, 60); background-color: rgb(255, 255, 255);">3 colheres (sopa) de chocolate em pó</span></li><li><span style="color: rgb(60, 60, 60); background-color: rgb(255, 255, 255);">1 xícara (chá) de leite</span></li></ul><p><br></p>',
                'preparation' => 'Em um liquidificador, adicione as cenouras, os ovos e o óleo, depois misture. Acrescente o açúcar e bata novamente por 5 minutos. Em uma tigela ou na batedeira, adicione a farinha de trigo e depois misture novamente. Acrescente o fermento e misture lentamente com uma colher. Asse em um forno preaquecido a 180° C por aproximadamente 40 minutos.'
            ],
            [
                'title' => 'Pudim de Leite',
                'description' => 'Pudim de leite condensado tradicional',
                'ingredients' => '1 lata de leite condensado, 1 lata de leite (use a lata de leite condensado vazia para medir), 3 ovos inteiros, 1 xícara de chá de açúcar para a calda',
                'preparation' => 'Primeiro, bata bem os ovos no liquidificador. Acrescente o leite condensado e o leite, e bata novamente. Reserve. Depois, coloque o açúcar na forma e leve ao fogo baixo até derreter. Quando derreter, caramelize toda a forma, unindo o líquido com o sólido. Despeje a massa do pudim na forma caramelizada. Asse em banho-maria, com a água já quente. Para saber se o pudim está pronto, espete um palito. Se sair limpo, está pronto. Desenforme o pudim ainda morno e leve para gelar por cerca de 3 horas.'
            ],
        ];

        foreach ($recipes as $recipe) {
            \App\Models\Recipes::create($recipe);
        }
    }
}
