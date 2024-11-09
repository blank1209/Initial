<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';

const form = useForm({
    supplierName: '',
    address: '',
    contactNumber: '',
});

const submit = () => {
    form.post(route('suppliers.store'));
}
</script>

<template>
    <Head title="Supplier" />

    <AuthenticatedLayout>
        <article class="min-h-full p-5 bg-white rounded-lg flex flex-col">
            <!-- Top -->
            <div class="flex justify-between items-center">
                <h3 class="font-bold">Supplier</h3>
            </div>
            <div class="border-b border-gray-700 my-2 mb-5" />

            <!-- Bottom Table -->
            <!-- Form -->
            <form @submit.prevent="submit">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-5">
                        <div>
                            <Link href="/suppliers" class="btn btn-primary">
                                <PrimaryButton> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5"/>
                                    </svg>
                                </PrimaryButton>
                            </Link>
                        </div>
                        <div>
                            <h3> Create Supplier </h3>
                        </div>
                    </div>
                    <div class="space-x-5">

                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Create
                        </PrimaryButton>
                    </div>
                </div>

                <div class="border-b border-gray-700 my-5" />

                <!-- Form Fields -->

                <div>
                    <InputLabel for="supplierName" class="mb-2">Supplier Name</InputLabel>
                    <TextInput class="mt-1 block w-[50%]" id="supplierName" type="text" v-model="form.supplierName" required />
                    <InputError :message="form.errors.supplierName" />
                </div>

                <div>
                    <InputLabel for="address" class="mb-2">Address</InputLabel>
                    <TextInput class="mt-1 block w-[50%]" id="address" type="text" v-model="form.address" required />
                    <InputError :message="form.errors.address" />
                </div>

                <div>
                    <InputLabel for="contactNumber" class="mb-2">Contact Number</InputLabel>
                    <TextInput class="mt-1 block w-[50%]" id="contactNumber" type="text" v-model="form.contactNumber" required />
                    <InputError :message="form.errors.contactNumber" />
                </div>
            </form>
        </article>
    </AuthenticatedLayout>
</template>