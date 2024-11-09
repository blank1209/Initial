<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';

const props = defineProps({
    suppliers: {
        type: Object,
        default: () => [],
    },
});

const form = useForm({
    rawMaterialName: '',
    unit: '',
    container: '',
    type: '',
    typeQuantity: '',
    price: '',
    quantity: '',
    supplierID: '',
});

const submit = () => {
    form.post(route('rawmaterials.store'));
}

const search = ref('');
const filteredSuppliers = ref(props.suppliers);

function filterSuppliers() {
    filteredSuppliers.value = props.suppliers.filter(supplier =>
        supplier.supplierName.toString().toLowerCase().includes(search.value.toLowerCase())
    );
}

function selectSupplier(supplier) {
    search.value = supplier.supplierName;
    form.supplierID = supplier.supplierID;
    filteredSuppliers.value = [];
}
</script>

<style>
    #selectsup {
        visibility: hidden;
    }
    #typesup:focus~#selectsup {
        visibility: visible;
    }
    #selectsup:hover {
        visibility: visible;
    }
</style>
<template>
    <Head title="Raw Materials" />

    <AuthenticatedLayout>
        <article class="min-h-full p-5 bg-white rounded-lg flex flex-col">
            <!-- Top -->
            <div class="flex justify-between items-center">
                <h3 class="font-bold">Raw Materials</h3>
            </div>
            <div class="border-b border-gray-700 my-2 mb-5" />

            <!-- Bottom Table -->
            <!-- Form -->
            <form @submit.prevent="submit">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-5">
                        <div>
                            <Link :href="route('rawmaterials.index')" class="btn btn-primary">
                                <PrimaryButton> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5"/>
                                    </svg>
                                </PrimaryButton>
                            </Link>
                        </div>
                        <div>
                            <h3> Create Raw Material </h3>
                        </div>
                    </div>
                    <div class="space-x-5">
                        <PrimaryButton class="p-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Create
                        </PrimaryButton>
                    </div>
                </div>

                <div class="border-b border-gray-700 my-5" />

                <!-- Form Fields -->
                <div>
                    <div>
                        <InputLabel for="rawMaterialName" class="mb-2">Ingredients Name</InputLabel>
                        <TextInput class="mt-1 block w-[50%]" id="rawMaterialName" type="text" v-model="form.rawMaterialName" required />
                        <InputError :message="form.errors.rawMaterialName" />
                    </div>

                    <div class="mt-2 w-[50%]">
                        <InputLabel class="mb-2">Container</InputLabel>
                        <div class="border-b border-gray-600" />
                        <div class="flex mt-2 gap-2">
                            <div>
                                <InputLabel for="unit" class="mb-2">Unit</InputLabel>
                                <TextInput class="mt-1" id="unit" type="text" v-model="form.unit" required />
                                <InputError :message="form.errors.unit" />
                            </div>

                            <div>
                                <InputLabel for="type" class="mb-2">Type</InputLabel>
                                <TextInput class="mt-1" id="type" type="text" v-model="form.type" required />
                                <InputError :message="form.errors.type" />
                            </div>

                            <div>
                                <InputLabel for="typeQuantity" class="mb-2">Quantity</InputLabel>
                                <TextInput class="mt-1" id="typeQuantity" type="text" v-model="form.typeQuantity" required />
                                <InputError :message="form.errors.typeQuantity" />
                            </div>
                        </div>
                    </div>

                    <div>
                        <InputLabel for="price" class="mb-2">Price </InputLabel>
                        <TextInput class="mt-1 block w-[50%]" id="price" type="text" v-model="form.price" required />
                        <InputError :message="form.errors.price" />
                    </div>

                    <div>
                        <InputLabel for="quantity" class="mb-2">Quantity</InputLabel>
                        <TextInput class="mt-1 block w-[50%]" id="quantity" type="text" v-model="form.quantity" required />
                        <InputError :message="form.errors.quantity" />
                    </div>

                    <!-- <div>
                        <InputLabel for="supplierID" class="mb-2">Supplier</InputLabel>
                        <TextInput class="mt-1 block w-[50%]" id="supplierID" type="text" v-model="form.supplierID" required />
                        <InputError :message="form.errors.supplierID" />
                    </div> -->

                    <div>
                        <InputLabel for="supplier" class="mb-2">Supplier</InputLabel>
                        <TextInput id="typesup"
                            type="text" 
                            v-model="search" 
                            @input="filterSuppliers" 
                            class="mt-1 block w-[50%]" 
                            placeholder="Search for supplier" 
                        />
                        <InputError :message="form.errors.supplierID" />

                        <ul id="selectsup" v-if="filteredSuppliers.length > 0" class="w-[50%]">
                            <li 
                                v-for="supplier in filteredSuppliers" 
                                :key="supplier.supplierID" 
                                @click="selectSupplier(supplier)" 
                                class="cursor-pointer hover:text-white hover:bg-[#0108EE] w-[50%] pl-5 rounded-lg mt-1"
                            >
                                {{ supplier.supplierName }}
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </article>
    </AuthenticatedLayout>
</template>
