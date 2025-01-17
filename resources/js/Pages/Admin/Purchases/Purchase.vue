<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    purchases: {
        type: Object,
        default: () => [],
    }
});

function calculateTotalQuantity(purchaseitems){
    return purchaseitems.reduce((total, item) => total + item.quantity, 0);
};

const completePurchaseForm = useForm({ purchaseID: null });

function completePurchase(purchase) {
    // Set the purchaseID to the selected purchase
    completePurchaseForm.purchaseID = purchase.purchaseID;
    
    // Send the request to complete the purchase
    completePurchaseForm.post(route('purchases.complete'), {
        onSuccess: () => {
            alert('Purchase completed successfully, and items have been added to raw materials.');
        },
        onError: () => {
            alert('There was an error completing the purchase.');
        }
    });
}
</script>

<template>
    <Head title="Purchases" />

    <AuthenticatedLayout>
        <article class="min-h-full p-5 bg-white rounded-lg flex flex-col">
            <!-- Top -->
            <div class="flex justify-between items-center">
                <h3 class="font-bold">Purchases</h3>
                <Link :href="route('purchases.create')" class="btn btn-primary">
                    <PrimaryButton class="p-2">
                        Create
                    </PrimaryButton>
                </Link>
            </div>
            <div class="border-b border-gray-700 my-2 mb-5" />

            <!-- Bottom Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs uppercase">
                        <tr>
                            <th scope="col" class="px-6 py-3">#</th>
                            <th scope="col" class="px-6 py-3">Date</th>
                            <th scope="col" class="px-6 py-3">Supplier</th>
                            <th scope="col" class="px-6 py-3">Quantity</th>
                            <th scope="col" class="px-6 py-3">Action</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="purchase in purchases" :key="purchase.id" class="border-t border-gray-700">
                            <td class="px-6 py-4">{{ purchase.purchaseID }}</td>
                            <td class="px-6 py-4">{{ purchase.purchaseDate }}</td>
                            <td class="px-6 py-4">{{ purchase.suppliers.supplierName }}</td>
                            <td class="px-6 py-4">{{ calculateTotalQuantity(purchase.purchaseitems) }}</td>
                            <td class="px-6 py-4 flex items-center space-x-3">
                                <Link :href="route('purchases.show', purchase.purchaseID)" class="text-blue-400 hover:text-blue-600">
                                    <PrimaryButton>
                                        View More
                                    </PrimaryButton>
                                </Link>
                                <button v-show="purchase.status === 'Pending'" @click="completePurchase(purchase)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z"/>
                                    </svg>
                                </button>
                                
                                <!-- <button @click="destroy(product.id)" class="text-red-400 hover:text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                    </svg>
                                </button> -->
                            </td>
                            <td class="px-6 py-4">{{ purchase.status }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </article>
    </AuthenticatedLayout>
</template>