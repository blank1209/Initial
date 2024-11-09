<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
</script>

<template>
    <Head title="Branches" />

    <AuthenticatedLayout>
        <article class="min-h-full p-5 bg-white rounded-lg flex flex-col">
            <!-- Top -->
            <div class="flex justify-between items-center">
                <h3 class="font-bold">Branches</h3>
            </div>
            <div class="border-b border-gray-700 my-2 mb-5" />

            <!-- Bottom Table -->
            <div class="overflow-x-auto">
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
                            <h3> Loakan </h3>
                            <p> Commissary </p>
                        </div>
                    </div>
                    <div class="space-x-5">
                        <PrimaryButton class="p-2">
                            Products
                        </PrimaryButton>
                        <PrimaryButton class="p-2">
                            Premixes
                        </PrimaryButton>
                        <PrimaryButton class="p-2">
                            Beverages
                        </PrimaryButton>
                        <PrimaryButton class="p-2">
                            Raw Materials
                        </PrimaryButton>
                    </div>
                </div>

                <div class="border-b border-gray-700 my-5" />

                <div class="flex m-5 space-x-5">
                    <div class="flex bg-[#D9D9D9] inline-flex items-center pl-5 py-4 pr-16 rounded-lg space-x-5">
                        <div class="bg-[#BFBFBF] p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#0108EE" class="bi bi-box" viewBox="0 0 16 16">
                                <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
                            </svg>
                        </div>
                        <div>
                            <p> Stocks </p>
                            <h2> 2,476 </h2>
                        </div>
                    </div>

                    <div class="flex bg-[#D9D9D9] inline-flex items-center pl-5 py-4 pr-16 rounded-lg space-x-5">
                        <div class="bg-[#BFBFBF] p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#0108EE" class="bi bi-box" viewBox="0 0 16 16">
                                <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
                            </svg>
                        </div>
                        <div>
                            <p> Sale </p>
                            <h2> ₱ 2,476 </h2>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs uppercase">
                            <tr>
                                <th scope="col" class="px-6 py-3">SL.</th>
                                <th scope="col" class="px-6 py-3">Date</th>
                                <th scope="col" class="px-6 py-3">Invoice</th>
                                <th scope="col" class="px-6 py-3">Items</th>
                                <th scope="col" class="px-6 py-3">Quantity</th>
                                <th scope="col" class="px-6 py-3">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-gray-700">
                                <td class="px-6 py-4">1</td>
                                <td class="px-6 py-4">10515 PCS</td>
                                <td class="px-6 py-4">26000.00</td>
                                <td class="px-6 py-4">26000.00</td>
                                <td class="px-6 py-4">Mabini</td>
                                <td class="px-6 py-4">10515 PCS</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </article>
    </AuthenticatedLayout>
</template>