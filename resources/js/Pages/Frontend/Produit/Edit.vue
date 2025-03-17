<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({ 
    errors: Object,
    produit: Object
});

const originalData = {
    name: props.produit.name,
    prix_unitaire: props.produit.prix_unitaire
};

const hasChanges = ref(false);

const form = useForm({
    name: props.produit.name,
    prix_unitaire: props.produit.prix_unitaire,
});

const checkChanges = () => {
    hasChanges.value = form.name !== originalData.name || 
                      form.prix_unitaire !== originalData.prix_unitaire;
};

const submit = () => {
    form.put(route('produits.update', props.produit.id));
}
</script>

<template>
    <Head title="Modification Produit"/>
    <FrontendLayout>
        <div class="max-w-4xl mx-auto mt-8 px-4">
            <!-- En-tête -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-800">
                    Modification du produit
                    <span class="text-gray-500 text-lg">#{{ produit.id }}</span>
                </h1>
                <Link :href="route('produits.index')" 
                    class="bg-gray-100 text-gray-600 hover:bg-gray-200 px-4 py-2 rounded-lg transition duration-150 ease-in-out flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.707 3.293a1 1 0 010 1.414L6.414 9H17a1 1 0 110 2H6.414l4.293 4.293a1 1 0 01-1.414 1.414l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Retour
                </Link>
            </div>

            <!-- Carte principale -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- État des modifications -->
                    <div v-if="hasChanges" 
                        class="bg-yellow-50 p-4 rounded-lg mb-6 transition-all duration-300 ease-in-out">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <h3 class="ml-2 text-sm font-medium text-yellow-800">Modifications non enregistrées</h3>
                        </div>
                    </div>

                    <!-- Champ Nom -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Nom du produit
                        </label>
                        <input type="text" 
                            id="name" 
                            v-model="form.name" 
                            @input="checkChanges"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            :class="{ 'border-red-300': errors.name }"
                            placeholder="Ex: Banane"
                            required>
                        <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name }}</p>
                    </div>

                    <!-- Champ Prix -->
                    <div class="space-y-2">
                        <label for="prix_unitaire" class="block text-sm font-medium text-gray-700">
                            Prix Unitaire (F CFA)
                        </label>
                        <div class="relative rounded-lg shadow-sm">
                            <input type="number" 
                                id="prix_unitaire" 
                                v-model="form.prix_unitaire"
                                @input="checkChanges"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 pl-3 pr-12"
                                :class="{ 'border-red-300': errors.prix_unitaire }"
                                placeholder="Ex: 1000"
                                required>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <span class="text-gray-500 sm:text-sm">F CFA</span>
                            </div>
                        </div>
                        <p v-if="errors.prix_unitaire" class="mt-1 text-sm text-red-600">{{ errors.prix_unitaire }}</p>
                    </div>

                    <!-- Comparaison des changements -->
                    <div v-if="hasChanges" class="bg-gray-50 p-4 rounded-lg space-y-3">
                        <h4 class="text-sm font-medium text-gray-700">Résumé des modifications</h4>
                        <div v-if="form.name !== originalData.name" class="flex items-center gap-2 text-sm">
                            <span class="text-gray-500">Nom:</span>
                            <span class="line-through text-red-500">{{ originalData.name }}</span>
                            <span class="text-green-500">{{ form.name }}</span>
                        </div>
                        <div v-if="form.prix_unitaire !== originalData.prix_unitaire" class="flex items-center gap-2 text-sm">
                            <span class="text-gray-500">Prix:</span>
                            <span class="line-through text-red-500">{{ originalData.prix_unitaire }} F CFA</span>
                            <span class="text-green-500">{{ form.prix_unitaire }} F CFA</span>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex items-center justify-end space-x-3 pt-4">
                        <Link :href="route('produits.index')"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Annuler
                        </Link>
                        <button type="submit"
                            :disabled="form.processing || !hasChanges"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                            <svg v-if="form.processing" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span v-if="form.processing">Mise à jour...</span>
                            <span v-else>Enregistrer les modifications</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </FrontendLayout>
</template>