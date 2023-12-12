<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen grid grid-cols-12 gap-4 sm:justify-center items-center pt-6 sm:pt-0 px-6 py-3 bg-gray-200">
        <div class="col-start-3 col-span-5 text-center">
            <ApplicationLogo class="w-30 h-50 fill-current"/>
        </div>

        <div
            class="w-full sm:max-w-md col-span-4 mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg "
        >
            <slot />
        </div>
    </div>
</template>
