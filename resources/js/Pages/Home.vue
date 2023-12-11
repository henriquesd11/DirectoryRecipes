<script setup>
import DefaultButton from '@/Components/DefaultButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import DangerButton from '@/Components/DangerButton.vue';
import { inject, ref } from 'vue';

const Toast = inject('Toast');

getListRecipes();
const list = ref([]);
const selectedRecipe = ref(null);
function getListRecipes() {
    axios.get('/recipes/list').then(response => {
        list.value = response.data.recipes.data;
    }).catch(error => {
        console.log(error);
    });
}

function openModal(recipe) {
    selectedRecipe.value = recipe;
}

function closeModal() {
    selectedRecipe.value = null;
}

function removeRecipe(id) {

    // print toask confirm delete

    axios.delete(`/recipes/${id}`).then(response => {
        Toast.success(response.data.message);
        getListRecipes();
    }).catch(error => {
        Toast.error(error.response.data.message);
    });
}

</script>

<template>
    <Head title="Home" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                PESQUISAR RECEITAS
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Título
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Descrição
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="recipe in list" :key="recipe.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ recipe.title }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ recipe.description }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="grid grid-cols-2 gap-1">
                                        <DefaultButton @click="openModal(recipe)">Visualizar</DefaultButton>
                                        <DangerButton @click="openModal(recipe)">Remover</DangerButton>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-if="selectedRecipe" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title"
                        role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true">
                            </div>
                            <div
                                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                {{ selectedRecipe.title }}
                                            </h3>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-500">
                                                    <h3>Ingredientes</h3>
                                                    <hr class="my-3"/>
                                                    <div v-html="selectedRecipe.ingredients"></div>
                                                </p>
                                                <p class="text-sm text-gray-500 my-8">
                                                    <h3>Modo de Preparo</h3>
                                                    <hr class="my-3"/>
                                                    <div v-html="selectedRecipe.preparation"></div>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="button" @click="closeModal"
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Fechar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout></template>
