<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import NumberInput from '@/Components/NumberInput.vue';

const form = useForm({
    branchName: '',
    contactPerson: '',
    contact: '',
});

const submit = () => {
    form.post(route('branches.store'));
}
</script>

<template>
    <Head title="Branch" />

    <AuthenticatedLayout>
        <article class="min-h-full p-5 bg-white rounded-lg flex flex-col">
            <!-- Top -->
            <div class="flex justify-between items-center">
                <h3 class="font-bold">Branch</h3>
            </div>
            <div class="border-b border-gray-700 my-2 mb-5" />

            <!-- Bottom Table -->
            <!-- Form -->
            <form @submit.prevent="submit">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-5">
                        <div>
                            <Link :href="route('branches.index')" class="btn btn-primary">
                                <PrimaryButton> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5"/>
                                    </svg>
                                </PrimaryButton>
                            </Link>
                        </div>
                        <div>
                            <h3> Create Branch </h3>
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
                    <InputLabel for="branchName" class="mb-2">Branch Name</InputLabel>
                    <TextInput class="mt-1 block w-[50%]" id="branchName" type="text" v-model="form.branchName" required />
                    <InputError :message="form.errors.branchName" />
                </div>

                <div>
                    <InputLabel for="branchName" class="mb-2">Contact Person</InputLabel>
                    <TextInput class="mt-1 block w-[50%]" id="contactPerson" type="text" v-model="form.contactPerson" required />
                    <InputError :message="form.errors.branchName" />
                </div>
                
                <div class="mt-2">
                    <InputLabel for="contact" value="Contact Number" />
                    <NumberInput
                        maxlength="11"
                        id="contact"
                        type="text"
                        pattern="\d*"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, this.maxLength);"
                        class="mt-1 block w-[50%]"
                        v-model="form.contact"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.userContact" />
                </div>
            </form>


            <!-- CSV HERE -->
        </article>
    </AuthenticatedLayout>
</template>