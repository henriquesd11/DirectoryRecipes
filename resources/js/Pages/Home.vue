<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
</script>

<template>
    <Head title="Home" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">O que deseja realizar?

            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="grid grid-cols-4 gap-4">
                        <div>
                            <PrimaryButton class="ms-4" route>
                                Gerenciar Usuários
                            </PrimaryButton>
                        </div>
                        <div>2</div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
