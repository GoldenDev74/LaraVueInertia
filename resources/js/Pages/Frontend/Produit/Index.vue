<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const showFlash = ref(true);
const deleteModal = ref(false);
const productToDelete = ref(null);

defineProps({
    produits: {
        type: Array,
        default: () => []
    }
});

onMounted(() => {
    if (showFlash.value) {
        setTimeout(() => {
            showFlash.value = false;
        }, 3000);
    }
});

const form = useForm({});

const showDeleteModal = (produit) => {
    productToDelete.value = produit;
    deleteModal.value = true;
};

const deleteProduit = () => {
    if (productToDelete.value) {
        form.delete(route('produits.destroy', productToDelete.value.id), {
            onSuccess: () => {
                deleteModal.value = false;
                productToDelete.value = null;
            }
        });
    }
};

const cancelDelete = () => {
    deleteModal.value = false;
    productToDelete.value = null;
};
</script>

<template>
    <Head title="Produits" />
    <FrontendLayout>
        <div class="max-w-7xl mx-auto mt-8 px-4">
            <Transition name="fade">
                <div v-if="$page.props.flash.message && showFlash" 
                    class="bg-green-500 text-white p-4 rounded-lg mb-6 flex items-center justify-between">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        {{ $page.props.flash.message }}
                    </div>
                </div>
            </Transition>

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-800">Liste des Produits</h1>
                <Link :href="route('produits.create')" 
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors duration-200 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Ajouter un produit
                </Link>
            </div>

            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Id</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix Unitaire</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="produit in produits" :key="produit.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ produit.id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ produit.name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ produit.prix_unitaire }} F CFA</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <Link :href="route('produits.show', produit.id)" 
                                    class="text-blue-600 hover:text-blue-900 bg-blue-50 px-3 py-1.5 rounded-md inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                    Voir
                                </Link>
                                <Link :href="route('produits.edit', produit.id)" 
                                    class="text-green-600 hover:text-green-900 bg-green-50 px-3 py-1.5 rounded-md inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                    Modifier
                                </Link>
                                <button @click="showDeleteModal(produit)" 
                                    class="text-red-600 hover:text-red-900 bg-red-50 px-3 py-1.5 rounded-md inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    Supprimer
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Modal de confirmation de suppression -->
            <div v-if="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
                <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full">
                    <div class="flex items-center justify-center mb-4 text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-center mb-4">Confirmer la suppression</h3>
                    <p class="text-gray-600 text-center mb-6">
                        Êtes-vous sûr de vouloir supprimer le produit "{{ productToDelete?.name }}" ?
                        <br>Cette action est irréversible.
                    </p>
                    <div class="flex justify-end gap-3">
                        <button @click="cancelDelete"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                            Annuler
                        </button>
                        <button @click="deleteProduit"
                            :disabled="form.processing"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 disabled:opacity-50 flex items-center gap-2">
                            <svg v-if="form.processing" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span v-if="form.processing">Suppression...</span>
                            <span v-else>Supprimer</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </FrontendLayout>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>