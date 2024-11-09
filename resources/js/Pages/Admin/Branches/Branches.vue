<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Multiselect from 'vue-multiselect';
import { ref } from 'vue';

const props = defineProps({
    branches: {
        type: Object,
        default: () => ({}),
    },
});

// Create a reactive property to hold the selected branches
const selectedBranches = ref([]);

// Create an options array from the branches prop for the multiselect
const options = props.branches.map(branch => ({
    id: branch.id,
    name: branch.branchName,
}));
</script>

<template>
    <Head title="Branches" />

    <AuthenticatedLayout>
        <article class="min-h-full p-5 bg-white rounded-lg flex flex-col">
            <!-- Top -->
            <div class="flex justify-between items-center">
                <h3 class="font-bold"> Branch </h3>
                <Link :href="route('branches.create')" class="btn btn-primary">
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
                            <th scope="col" class="px-6 py-3">Branch</th>
                            <th scope="col" class="px-6 py-3">Available Products</th>
                            <th scope="col" class="px-6 py-3">Today Sold</th>
                            <th scope="col" class="px-6 py-3">Contact Person</th>
                            <th scope="col" class="px-6 py-3">View Branch</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="branch in branches" :key="branch.id">
                            <td class="px-6 py-4"> {{ branch.branchName }}</td>
                            <td class="px-6 py-4"></td>
                            <td class="px-6 py-4"></td>

                            <td class="px-6 py-4" v-if="branch.users">{{ branch.users.name }} ({{ branch.contact }})</td>
                            <td class="px-6 py-4" v-else> </td>
                            <td class="px-6 py-4 flex items-center space-x-3">
                                <Link :href="route('branches.show', branch.branchID)" class="text-[#0109F4] hover:text-blue-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </article>
    </AuthenticatedLayout>
</template>
