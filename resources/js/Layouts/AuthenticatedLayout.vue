<script setup>
import { ref } from 'vue';
import Dropdown2nd from '@/Components/Dropdown2nd.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { usePermission } from '@/composables/permission';

const { hasRole } = usePermission();
</script>

<template>
    <div class="h-screen p-5 bg-[#D9D9D9]">
        <div class="flex h-full gap-5">
            <aside class="w-[20%] bg-white p-5 flex flex-col justify-between rounded-lg">
                <!-- Top -->
                <div class="overflow-auto">
                    <div class="my-5 h-[0.1px] " />
                
                    <!-- Dashboard -->
                    <ResponsiveNavLink 
                        :href="route('dashboard')"
                        :active="route().current('dashboard')"
                        class="flex items-center mb-1 text-sm"
                    >
                        <svg fill="currentColor" viewBox="0 0 8 8" width="15" height="15" xmlns="http://www.w3.org/2000/svg" class="mr-2">
                            <path d="M3.5 0c-.97 0-1.84.4-2.47 1.03l2.97 2.97v-3.97c-.16-.02-.33-.03-.5-.03zm1.5 1.06v3.41l-2.72 2.72c.61.5 1.37.81 2.22.81 1.93 0 3.5-1.57 3.5-3.5 0-1.76-1.31-3.19-3-3.44zm-4.09 1.31c-.56.54-.91 1.29-.91 2.13 0 .96.46 1.79 1.16 2.34l2.13-2.13-2.38-2.34z"></path>
                        </svg>
                        
                        Dashboard
                    </ResponsiveNavLink>

                    <!-- User -->
                    <ResponsiveNavLink 
                        v-if="hasRole('admin')"
                        :href="route('users.index')"
                        :active="route().current('users.index') || route().current('users.create') || route().current('users.edit')"
                        class="flex items-center mb-1 text-sm"
                    >
                        User List
                    </ResponsiveNavLink>

                    <!-- Branches -->
                    <ResponsiveNavLink 
                        v-if="hasRole('admin') || hasRole('branch')"
                        :href="route('branches.index')"
                        :active="route().current('branches.index') || route().current('branches.create')"
                        class="flex items-center mb-1 text-sm"
                    >
                        Branches
                    </ResponsiveNavLink>

                    <!-- Sales -->
                    <ResponsiveNavLink
                        v-if="hasRole('admin') || hasRole('agent')"
                        :href="route('sales.index')"
                        :active="route().current('sales.index')"
                        class="flex items-center mb-1 text-sm"
                    >
                        Sales
                    </ResponsiveNavLink>

                    <!-- Delivery -->
                    <ResponsiveNavLink
                        v-if="hasRole('admin') || hasRole('agent')"
                        :href="route('deliveries.index')"
                        :active="route().current('deliveries.index') || route().current('deliveries.create')"
                        class="flex items-center mb-1 text-sm"
                    >
                        Delivery
                    </ResponsiveNavLink>

                    <!-- Inventory -->
                    <Dropdown2nd v-if="hasRole('admin')">
                        <template #trigger>
                            <button
                            type="button"
                            class="w-full my-2 flex justify-between items-center text-sm px-6 py-1">
                                <div class="flex items-center">
                                    Inventory
                                </div>

                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                </svg>
                            </button>
                        </template>

                        <template #content>
                            <div class="px-6">
                                <!-- Products -->
                                <ResponsiveNavLink
                                    v-if="hasRole('admin') || hasRole('agent')"
                                    :href="route('products.index')"
                                    :active="route().current('products.index') || route().current('products.create') || route().current('products.edit')"
                                    class="flex items-center mb-1 text-sm"
                                >
                                    Products
                                </ResponsiveNavLink>

                                <!-- Premixes -->
                                <ResponsiveNavLink
                                    v-if="hasRole('admin')"
                                    :href="route('premixes.index')"
                                    :active="route().current('premixes.index') || route().current('premixes.create') || route().current('premixes.edit')"
                                    class="flex items-center mb-1 text-sm"
                                >
                                    Premixes
                                </ResponsiveNavLink>

                                <!-- Beverages -->
                                <!-- <ResponsiveNavLink 
                                    :href="route('beverage.index')"
                                    :active="route().current('beverage.index')"
                                    class="flex items-center mb-1 text-sm"
                                >
                                    Beverages
                                </ResponsiveNavLink> -->

                                <!-- Raw Materials -->
                                <ResponsiveNavLink
                                    v-if="hasRole('admin')"
                                    :href="route('rawmaterials.index')"
                                    :active="route().current('rawmaterials.index') || route().current('rawmaterials.create')"
                                    class="flex items-center mb-1 text-sm"
                                >
                                    Raw Materials
                                </ResponsiveNavLink>

                                <!-- Transfer Products -->
                                <ResponsiveNavLink
                                    v-if="hasRole('admin')"
                                    :href="route('transfers.index')"
                                    :active="route().current('transfers.index') || route().current('transfers.create')"
                                    class="flex items-center mb-1 text-sm"
                                >
                                    Transfer Items
                                </ResponsiveNavLink>
                            </div>
                        </template>
                    </Dropdown2nd>

                    <!-- Contacts -->
                    <Dropdown2nd v-if="hasRole('admin')">
                        <template #trigger>
                            <button
                            type="button"
                            class="w-full my-2 flex justify-between items-center text-sm px-6 py-1">
                                <div class="flex items-center">
                                    Contacts
                                </div>

                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                </svg>
                            </button>
                        </template>

                        <template #content>
                            <div class="px-6">
                                <!-- Clients -->
                                <ResponsiveNavLink
                                    v-if="hasRole('admin')"
                                    :href="route('clients.index')"
                                    :active="route().current('clients.index') || route().current('clients.create') || route().current('clients.edit')"
                                    class="flex items-center mb-1 text-sm"
                                >
                                    Clients
                                </ResponsiveNavLink>

                                <!-- Suppliers -->
                                <ResponsiveNavLink
                                    v-if="hasRole('admin')"
                                    :href="route('suppliers.index')"
                                    :active="route().current('suppliers.index') || route().current('suppliers.create') || route().current('suppliers.edit')"
                                    class="flex items-center mb-1 text-sm"
                                >
                                    Suppliers
                                </ResponsiveNavLink>
                            </div>
                        </template>
                    </Dropdown2nd>

                    <!-- Purchases -->
                    <Dropdown2nd v-if="hasRole('admin')">
                        <template #trigger>
                            <button
                            type="button"
                            class="w-full my-2 flex justify-between items-center text-sm px-6 py-1">
                                <div class="flex items-center">
                                    Purchases
                                </div>

                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                </svg>
                            </button>
                        </template>

                        <template #content>
                            <div class="px-6">
                                <!-- View Purchases -->
                                <ResponsiveNavLink
                                    v-if="hasRole('admin')"
                                    :href="route('purchases.index')"
                                    :active="route().current('purchases.index')"
                                    class="flex items-center mb-1 text-sm"
                                >
                                    View Purchases
                                </ResponsiveNavLink>

                                <!-- Purchase Return -->
                            </div>
                        </template>
                    </Dropdown2nd>

                    <!-- Reports -->
                    <Dropdown2nd v-if="hasRole('admin')">
                        <template #trigger>
                            <button
                            type="button"
                            class="w-full my-2 flex justify-between items-center text-sm px-6 py-1">
                                <div class="flex items-center">
                                    Reports
                                </div>

                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                </svg>
                            </button>
                        </template>

                        <template #content>
                            <div class="px-6">
                                <!-- Sales Reports -->
                                <ResponsiveNavLink
                                    v-if="hasRole('admin')"
                                    :href="route('salesreports.index')"
                                    :active="route().current('salesreports.index')"
                                    class="flex items-center mb-1 text-sm"
                                >
                                    Sales Reports
                                </ResponsiveNavLink>

                                <!-- Inventory Reports -->
                                <ResponsiveNavLink
                                    v-if="hasRole('admin')"
                                    :href="route('inventoryreports.index')"
                                    :active="route().current('inventoryreports.index')"
                                    class="flex items-center mb-1 text-sm"
                                >
                                    Inventory Reports
                                </ResponsiveNavLink>
                            </div>
                        </template>
                    </Dropdown2nd>
                </div>

                <!-- Bottom -->
                <div>
                    <ResponsiveNavLink :href="route('logout')" method="post" as="button" class="text-[#B91C1C] hover:bg-[#B91C1C] flex items-center text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" class="bi bi-box-arrow-left mr-3" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"/>
                            <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z"/>
                        </svg>
                        Signout
                    </ResponsiveNavLink>
                </div>
            </aside>

            <main class="flex-1">
                <div class="h-full gap-2 flex flex-col">
                    <nav class="bg-white rounded-lg py-2 px-4 flex justify-between items-center gap-5">
                        <!-- Burger -->
                        <button class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="black" class="bi bi-list" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
                            </svg>
                        </button>

                        <!-- Search -->
                        <form class="flex-grow">
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input type="search" class="block w-full ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg" placeholder="Search" required />
                            </div>
                        </form>

                        <!-- Bell Icon -->
                        <div class="flex items-center relative">
                            <button class="border border-gray-300 rounded-full p-2 transition-all duration-200 hover:bg-gray-100 hover:border-black focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                                    <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
                                </svg>
                                <!-- Notification Badge -->
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center w-4 h-4 text-xs font-medium text-white bg-[#F7C849] border-2 border-white rounded-full" />
                            </button>
                        </div>

                        <div class="flex items-center relative">
                            <button class="border border-gray-300 rounded-full p-2 transition-all duration-200 hover:bg-gray-100 hover:border-black focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                                    <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
                                </svg>
                            </button>
                        </div>
                    </nav>

                    <div class="h-full overflow-y-auto">
                        <slot />
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>