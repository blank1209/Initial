<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    rawmaterials: {
        type: Array,
        default: () => [],
    },

    suppliers: {
        type: Array,
        default: () => [],
    },

    // amount: Object
});

const form = useForm({});

function destroy(id) {
    if (confirm("Are you sure you want to delete this? This action cannot be undone.")) {
        form.delete(route('rawmaterials.destroy', id));
    }
}

function totalAmount(supplierID) {
    // Ensure to check for valid supplierID
    if (!supplierID) return 0;

    return props.rawmaterials
        .filter(rawMaterial => rawMaterial.supplierID === supplierID) // Filter by supplier
        .reduce((total, rawMaterial) => {
            return total + rawMaterial.rawmaterialunits.reduce((unitTotal, unit) => {
                return unitTotal + (unit.price * unit.stock);
            }, 0);
        }, 0);
}

// var last = props.rawmaterials.length;
// var highest = 0;
// for (let i = 0;  i < props.rawmaterials.length; i++) {
//     if (props.rawmaterials[i].supplierID > highest){
//         highest = props.rawmaterials[i].supplierID
//     }
// }
// for (let i = 0;  i < props.rawmaterials.length; i++) {
//     for(let id = 0; id <= highest; id++) {

//     }
//     if (props.rawmaterials[i].supplierID == id) {
//         total += props.rawmaterials[i].price * props.rawmaterials[i].quantity
//     }
// }
</script>

<template>
    <Head title="Raw Materials" />

    <AuthenticatedLayout>
        <article class="min-h-full p-5 bg-white rounded-lg flex flex-col">
            <!-- Top -->
            <div class="flex justify-between items-center">
                <h3 class="font-bold">Raw Materials</h3>
                <div class="flex gap-5">
                    <Link :href="route('rawmaterials.create')" class="btn btn-primary">
                        <PrimaryButton class="p-2">
                            Create
                        </PrimaryButton>
                    </Link>
                    <!-- <Link :href="route('rawmaterials.show')" class="btn btn-primary">
                        <PrimaryButton class="p-2">
                            Produce
                        </PrimaryButton>
                    </Link> -->
                </div>
            </div>
            <div class="border-b border-gray-700 my-2 mb-5" />

            <div v-for="supplier in suppliers" :key="supplier.id">{{ supplier.supplierName }}

            <!-- Bottom Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs uppercase">
                        <tr>
                            <th scope="col" class="px-6 py-3">Raw Material Name</th>
                            <th scope="col" class="px-6 py-3">Type</th>
                            <th scope="col" class="px-6 py-3">Unit</th>
                            <th scope="col" class="px-6 py-3">Price</th>
                            <!-- <th scope="col" class="px-6 py-3">Exp Date</th> -->
                            <th scope="col" class="px-6 py-3">Stocks</th>
                            <th scope="col" class="px-6 py-3">Amount</th>
                            <th scope="col" class="px-6 py-3">Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="rawMaterial in rawmaterials" :key="rawMaterial.id">
                            <td v-show="rawMaterial.supplierID===supplier.supplierID" class="px-6 py-4 w-[25%] align-top"><span v-show="rawMaterial.supplierID===supplier.supplierID">{{ rawMaterial.rawMaterialName }}</span></td>
                            <td v-show="rawMaterial.supplierID===supplier.supplierID" class="px-6 py-4  align-top"><span v-show="rawMaterial.supplierID===supplier.supplierID">{{ rawMaterial.type }} {{ rawMaterial.typeQuantity }}</span></td>
                            <td v-show="rawMaterial.supplierID===supplier.supplierID" class="px-6 py-4 flex flex-col  align-top"><div v-for="unit in rawMaterial.rawmaterialunits">{{ unit.unit }}</div></td>
                            <td v-show="rawMaterial.supplierID===supplier.supplierID" class="px-6 py-4 align-top  align-top"><span v-show="rawMaterial.supplierID===supplier.supplierID"><div v-for="unit in rawMaterial.rawmaterialunits">{{ unit.price }}</div></span></td>
                            <!-- <td v-show="rawMaterial.supplierID===supplier.supplierID" class="px-6 py-4"><span v-show="rawMaterial.supplierID===supplier.supplierID">--</span></td> -->
                            <td v-show="rawMaterial.supplierID===supplier.supplierID" class="px-6 py-4  align-top"><span v-show="rawMaterial.supplierID===supplier.supplierID"><div v-for="unit in rawMaterial.rawmaterialunits">{{ unit.stock }}</div></span></td>
                            <td v-show="rawMaterial.supplierID===supplier.supplierID" class="px-6 py-4  align-top"><span v-show="rawMaterial.supplierID===supplier.supplierID"><div v-for="unit in rawMaterial.rawmaterialunits">{{ unit.price*unit.stock }}</div></span></td>
                            <td v-show="rawMaterial.supplierID===supplier.supplierID" class="px-6 py-4 flex items-center space-x-3">
                                <Link :href="route('rawmaterials.edit', rawMaterial.rawMaterialID)" class="text-blue-400 hover:text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </Link>
                                <button @click="destroy(rawMaterial.rawMaterialID)" class="text-red-700 hover:text-red-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td class="px-6 py-4">Total</td>
                            <td class="px-6 py-4">{{ totalAmount(supplier.supplierID) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            </div>
        </article>
    </AuthenticatedLayout>
</template>