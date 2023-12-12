<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { inject, ref } from 'vue';
import { VueEditor } from "vue3-editor";
import axios from 'axios';
import WarningButton from '@/Components/WarningButton.vue';
import SuccessButton from '@/Components/SuccessButton.vue';

const Toast = inject('Toast');

const props = defineProps({
    recipe: Object,
});

const valueName = ref(props?.recipe?.title);
const valueDescription = ref(props?.recipe?.description);
const valueIngredients = ref(props?.recipe?.ingredients);
const valuePreparation = ref(props?.recipe?.preparation);
const ingredients = ref(false);
const preparation = ref(false);

function showIngredients() {
    ingredients.value = true;
    preparation.value = false;
}

function showPreparation() {
    ingredients.value = false;
    preparation.value = true;
}

function submit() {
    const axiosMethod = props?.recipe ? 'put' : 'post';
    const axiosUrl = props?.recipe ? `/recipes/${props.recipe.id}` : '/recipes/store';

    axios[axiosMethod](axiosUrl, {
        title: valueName.value,
        description: valueDescription.value,
        ingredients: valueIngredients.value,
        preparation: valuePreparation.value,
    }).then(response => {
        Toast.fire({
            title: 'Sucesso!',
            text: response.data.message,
            icon: 'success',
        });
        setTimeout(() => {
            window.location.href = '/home';
        }, 1000);
    }).catch(error => {
        Toast.fire({
            title: 'Erro!',
            text: "Ocorreu um erro ao salvar a receita, tente novamente!",
            icon: 'error',
        });
    });
}

function update() {

}
</script>
<template>
    <Head title="Criar" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ props?.recipe ? "ATUALIZAR" : "CRIAR" }} RECEITA
            </h2>
        </template>

        <div class="py-12">
            <div class="grid grid-cols-6 gap-4">
                <div class="col-start-2 col-span-4 ...">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="p-6 dark:text-gray-800 border col-span-12 border-gray-200 rounded-lg shadow">
                            <div class="grid grid-cols-3 gap-4 py-4">
                                <SuccessButton class="col-end-7 col-span-2" v-on:click="submit()">
                                    Salvar
                                </SuccessButton>
                            </div>
                            <div class="grid grid-cols-3 gap-4 py-4">
                                <label for="name"><strong>Nome</strong></label>
                                <input type="text" v-model="valueName"
                                    class="focus:border-[#60ac49] focus:ring-indigo-[#60ac49] rounded-md shadow-sm col-span-12"
                                    placeholder="Receita de bolo de cenoura">
                            </div>
                            <div class="grid grid-cols-3 gap-4 py-4">
                                <label for="name"><strong>Descrição</strong></label>
                                <input type="text" v-model="valueDescription"
                                    class="focus:border-[#60ac49] focus:ring-indigo-[#60ac49] rounded-md shadow-sm col-span-12"
                                    placeholder="Receita de bolo com cobertura de chocolate...">
                            </div>
                            <div class="grid grid-cols-2 gap-4 py-4">
                                <WarningButton @click="showIngredients()">
                                    <strong>Ingredientes</strong>
                                </WarningButton>
                                <WarningButton @click="showPreparation()">
                                    <strong>Forma de Preparo</strong>
                                </WarningButton>
                            </div>
                            <div v-if="ingredients" class="grid grid-cols-3 gap-4 py-4">
                                <label for="name"><strong>Ingredientes</strong></label>
                                <VueEditor v-model="valueIngredients" class="col-span-12" />
                            </div>
                            <div v-if="preparation" class="grid grid-cols-3 gap-4 py-4">
                                <label class="col-span-12" for="name"><strong>Modo de Preparo</strong></label>
                                <VueEditor v-model="valuePreparation" class="col-span-12" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
