<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    produit: Object
});
</script>

<template>
    <Head title="Show produit"/>
    <FrontendLayout>
        <div v-if="$page.props.flash.message" class="bg-green-500 text-white p-4 rounded-lg mb-4">
            {{ $page.props.flash.message }}
        </div>
        <div class="mt-4 mx-4">
            <div class="flex justify-between">
                <h4>Détails du produit</h4>
                <Link :href="route('produits.index')" class="bg-gray-400 text-white p-3 rounded mb-4 inline-block">Retour</Link>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom du produit</label>
                    <p class="text-lg">{{ produit.name }}</p>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prix Unitaire</label>
                    <p class="text-lg">{{ produit.prix_unitaire }} F CFA</p>
                </div>
                <div class="flex gap-2">
                    <Link :href="route('produits.edit', produit.id)" class="bg-blue-600 text-white py-2 px-4 rounded">
                        Modifier
                    </Link>
                    <Link :href="route('produits.index')" class="bg-gray-400 text-white py-2 px-4 rounded">
                        Retour à la liste
                    </Link>
                </div>
            </div>
        </div>
    </FrontendLayout>
</template>