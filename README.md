## DirectoryRecipes
Sistema CRUD de receitas, com sistema de filtro por opções de ingredientes, receitas, modo de preparo etc...

## Descrição build
Desenvolvido usando Laravel 10, Vue 3, Inertia, TailwindCSS e MYSQL
Realização de testes unitários, requests e integração da classe RecipesController

## Necessário
Composer v2, NODE v16/+, PHP v8

## Iniciar
composer install

npm install

ajustar DB no arquivo .env

DB_CONNECTION=mysql

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=db-name

DB_USERNAME=db-username

DB_PASSWORD=db-password

php artisan migrate

php artisan db:seed

php artisan key:generate

php artisan serve

npm run dev

## Usuário Teste
email: admin@admin.com senha: password
