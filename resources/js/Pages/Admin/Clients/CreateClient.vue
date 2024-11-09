<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';

const currentDate = () => {
    const current = new Date();
    return current.toISOString().split('T')[0];
};


const form = useForm({
    clientName: '',
    clientAddress: '',
    clientContact: '',
    clientDate: currentDate(),
});

const submit = () => {
    form.post(route('clients.store'));
}
</script>

<template>
    <Head title="Clients" />

    <AuthenticatedLayout>
        <article class="min-h-full p-5 bg-white rounded-lg flex flex-col">
            <!-- Top -->
            <div class="flex justify-between items-center">
                <h3 class="font-bold">Clients</h3>
            </div>
            <div class="border-b border-gray-700 my-2 mb-5" />

            <!-- Bottom Table -->
            <!-- Form -->
            <form @submit.prevent="submit">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-5">
                        <div>
                            <Link href="/clients" class="btn btn-primary">
                                <PrimaryButton> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5"/>
                                    </svg>
                                </PrimaryButton>
                            </Link>
                        </div>
                        <div>
                            <h3> Create Clients </h3>
                        </div>
                    </div>
                    <div class="space-x-5">
                        <!-- <Link href="/suppliers" class="btn btn-primary">
                            <PrimaryButton>
                                <span>
                                    Cancel
                                </span>
                            </PrimaryButton>
                        </Link> -->

                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            <span>
                                Create
                            </span>
                        </PrimaryButton>
                    </div>
                </div>

                <div class="border-b border-gray-700 my-5" />

                <!-- Form Fields -->

                <div>
                    <InputLabel for="clientName" class="mb-2">Client Name</InputLabel>
                    <TextInput class="mt-1 block w-[50%]" id="clientName" type="text" v-model="form.clientName" required />
                    <InputError :message="form.errors.clientName" />
                </div>

                <div>
                    <InputLabel for="clientAddress" class="mb-2">Address</InputLabel>
                    <TextInput class="mt-1 block w-[50%]" id="clientAddress" type="text" v-model="form.clientAddress" required />
                    <InputError :message="form.errors.clientAddress" />
                </div>

                <div>
                    <InputLabel for="clientContact" class="mb-2">Contact No.</InputLabel>
                    <TextInput class="mt-1 block w-[50%]" id="clientContact" type="text" v-model="form.clientContact" required />
                    <InputError :message="form.errors.clientContact" />
                </div>

                <!-- <div>
                    <InputLabel for="clientDate" class="mb-2">Client Date</InputLabel>
                    <TextInput class="mt-1 block w-[50%]" id="clientDate" type="text" :placeholder="formattedDate" v-model="form.clientDate" />
                    <InputError :message="form.errors.clientDate" />
                </div> -->
            </form>
        </article>
    </AuthenticatedLayout>
</template>