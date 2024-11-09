<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import { ref, computed } from 'vue';

const props = defineProps({
    users: {
        type: Array,
        default: () => [],
    },

    trucks: {
        type: Array,
        default: () => [],
    },

    saletypes: {
        type: Array,
        default: () => [],
    },

    drivers: {
        type: Array,
        default: () => [],
    },

    clients: {
        type: Array,
        default: () => [],
    },

    products: {
        type: Array,
        default: () => [],
    },
});

const currentDate = () => {
    const current = new Date();
    return current.toISOString().split('T')[0];
};

const form = useForm({
    salesDate: currentDate(),
    truck: '',
    saleType: '',
    truckDriver: '',
    agent: '',
    client: '',
    products: [],
    route: ''
});

const newProduct = ref({ productID:'', product:'', quantity:'', price:''});

const addProduct = () => {
    if (newProduct.value.quantity && newProduct.value.productID) {
        const existingProduct = props.products.find(p => p.productID === parseInt(newProduct.value.productID));
        if (existingProduct) {
            const availableQuantity = existingProduct.quantity;
            if (availableQuantity >= newProduct.value.quantity && newProduct.value.quantity > 0) {
                form.products.push({ ...newProduct.value });
                newProduct.value = { productID: '', product: '', quantity: '', price: '' };
                searchProducts.value = '';
                filterProducts();
            }else {
                alert("Insufficient Products.");
            }
        }
    }
};

const submit = () => {
    form.post(route('deliveries.store'));
}

const searchDrivers = ref('');
const filteredDrivers = ref(props.drivers);

function filterDrivers() {
    filteredDrivers.value = props.drivers.filter(driver =>
        driver.driverName.toString().toLowerCase().includes(searchDrivers.value.toLowerCase())
    );
}

function selectDriver(driver) {
    searchDrivers.value = driver.driverName;
    form.truckDriver = driver.driverID;
    filteredDrivers.value = [];
}

const searchAgents = ref('');
const filteredAgents = ref(props.users.filter(user => user.roles[0]?.name === 'agent'));

function filterAgents() {
    filteredAgents.value = props.users.filter(agent =>
        agent.name.toString().toLowerCase().includes(searchAgents.value.toLowerCase())
    );
}

function selectAgent(agent) {
    searchAgents.value = agent.name;
    form.agent = agent.id;
    filteredAgents.value = [];
}

const searchClients = ref('');
const filteredClients = ref(props.clients);

function filterClients() {
    filteredClients.value = props.clients.filter(client =>
    client.clientName.toString().toLowerCase().includes(searchClients.value.toLowerCase())
    );
}

function selectClient(client) {
    searchClients.value = client.clientName;
    form.client = client.clientID;
    filteredClients.value = [];
}

const searchProducts = ref('');
const filteredProducts = ref(props.products);

function filterProducts () {
    filteredProducts.value = props.products.filter(product =>
    product.productName.toString().toLowerCase().includes(searchProducts.value.toLowerCase())
    );
}

function selectProduct(products) {
    searchProducts.value = products.productName;
    newProduct.value.productID= products.productID;
    newProduct.value.product= products.productName;
    newProduct.value.price= products.productprices[0].price;
    filteredProducts.value = [];
}

const a = ref([
    {id:1,name:'dsf'},
    {id:2,name:'asd'}
])

</script>
<style>
    #selectdri, #selectcli, #selectpro, #selectage {
        visibility: hidden;
        position: absolute;
        z-index: 1;
    }

    #typedri:focus~#selectdri, #typecli:focus~#selectcli, #typepro:focus~#selectpro, #typeage:focus~#selectage{
        visibility: visible;
    }

    #selectdri:hover, #selectcli:hover, #selectpro:hover, #selectage:hover{
        visibility: visible;
    }
</style>

<template>
    <Head title="Delivery" />

    <AuthenticatedLayout>
        <article class="min-h-full p-5 bg-white rounded-lg flex flex-col">
            <!-- Top -->
            <div class="flex justify-between items-center">
                <h3 class="font-bold">Delivery</h3>
            </div>
            <div class="border-b border-gray-700 my-2 mb-5" />

            <!-- Bottom Table -->
            <!-- Form -->
            <form @submit.prevent="submit">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-5">
                        <div>
                            <Link :href="route('deliveries.index')" class="btn btn-primary">
                                <PrimaryButton> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5"/>
                                    </svg>
                                </PrimaryButton>
                            </Link>
                        </div>
                        <div>
                            <h3> Delivery Load </h3>
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
                        <InputLabel for="salesDate" class="mb-2">Delivery Date</InputLabel>
                        <TextInput class="mt-1 block w-[50%]" id="salesDate" type="text" v-model="form.salesDate" />
                    </div>

                    <div class="relative">
                        <InputLabel for="driver" class="mb-2">Driver</InputLabel>
                        <TextInput id="typedri"
                            type="text"
                            v-model="searchDrivers" 
                            @input="filterDrivers" 
                            class="mt-1 block w-[50%]" 
                            placeholder="Search for driver" 
                        />
                        <InputError :message="form.errors.supplierID" />

                        <ul id="selectdri" v-if="filteredDrivers.length > 0" class="w-[50%] bg-white" >
                            <li 
                                v-for="driver in filteredDrivers" 
                                :key="driver.driverID" 
                                @click="selectDriver(driver)" 
                                class="cursor-pointer hover:text-white hover:bg-[#0108EE] w-[50%] pl-5 rounded-lg mt-1"
                            >
                                {{ driver.driverName }}
                            </li>
                        </ul>
                    </div>

                    <div class="relative">
                        <InputLabel for="agent" class="mb-2">Agent</InputLabel>
                        <TextInput id="typeage"
                            type="text"
                            v-model="searchAgents" 
                            @input="filterAgents" 
                            class="mt-1 block w-[50%]" 
                            placeholder="Search for agent" 
                        />
                        <InputError :message="form.errors.supplierID" />

                        <ul id="selectage" v-if="filteredAgents.length > 0" class="w-[50%] bg-white" >
                            <li 
                                v-for="agent in filteredAgents" 
                                :key="agent.id" 
                                @click="selectAgent(agent)" 
                                class="cursor-pointer hover:text-white hover:bg-[#0108EE] w-[50%] pl-5 rounded-lg mt-1"
                            >
                                {{ agent.name }}
                            </li>
                        </ul>
                    </div>

                    <!-- <div>
                        <InputLabel for="truckDriver" class="mb-2">TruckDriver</InputLabel>
                        <select class="mt-1 w-[50%] border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" id="truckDriver" v-model="form.truckDriver" required>
                            <option disabled value="">Select Truck</option>
                            <option v-for="driver in drivers" :key="driver.id" :value="driver.driverID">{{ driver.driverID }}</option>
                        </select>
                    </div> -->

                    <div>
                        <InputLabel for="truckID" class="mb-2">Truck</InputLabel>
                        <select class="mt-1 w-[50%] border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" id="truckID" v-model="form.truck" required>
                            <option disabled value="">Select Truck</option>
                            <option v-for="truck in trucks" :key="truck.id" :value="truck.truckID">Truck {{ truck.truckID }} ({{ truck.plateNumber }})</option>
                        </select>
                    </div>

                    <div>
                        <InputLabel for="saleType" class="mb-2">Delivery Type</InputLabel>
                        <select v-model="form.saleType" name="state" id="deliveryType" class="mt-1 w-[50%] border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option disabled value="">Select Delivery Type</option>
                            <option v-for="type in saletypes" :key="type.id" :value="type">{{ type.saleTypeName }}</option>
                        </select>
                    </div>

                    <!-- <div>
                        <InputLabel for="saleType" class="mb-2">saleType</InputLabel>
                        <TextInput class="mt-1 block w-[50%]" id="saleType" type="text" v-model="form.saleType"  />
                        <InputError :message="form.errors.saleType" />
                    </div> -->
                    
                    <!-- <div>
                        <InputLabel for="client" class="mb-2">Client</InputLabel>
                        <Multiselect
                        v-model="form.client"
                        :options="props.clients"
                        label="clientName"
                        track-by="clientID"
                        placeholder="Search for client"
                        class="mt-1 w-1/2"
                        />
                        <InputError :message="form.errors.supplierID" />
                    </div> -->

                    <div class="relative" v-if="form.saleType.saleTypeName=='Wholesale'">
                        <InputLabel for="client" class="mb-2">Client</InputLabel>
                        <TextInput id="typecli"
                            type="text" 
                            v-model="searchClients" 
                            @input="filterClients" 
                            class="mt-1 block w-[50%]" 
                            placeholder="Search for client" 
                        />
                        <InputError :message="form.errors.supplierID" />

                        <ul id="selectcli" v-if="filteredClients.length > 0" class="w-[50%] bg-white" >
                            <li 
                                v-for="client in filteredClients" 
                                :key="client.clientID" 
                                @click="selectClient(client)" 
                                class="cursor-pointer hover:text-white hover:bg-[#0108EE] w-[50%] pl-5 rounded-lg mt-1"
                            >
                                {{ client.clientName }}
                            </li>
                        </ul>
                    </div>

                    <div class="mt-4" v-if="form.saleType.saleTypeName=='Extract'">
                        <InputLabel for="route" class="mb-2">Route</InputLabel>
                        <TextInput class="mt-1 block w-[50%]" id="route" v-model="form.route" />
                        <InputError :message="form.errors.route" />
                    </div>

                    <!-- <div class="mt-2">
                        <Link :href="route('saleitems.index')" class="btn btn-primary"
                        :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            <PrimaryButton class="px-5">
                                Add Product
                            </PrimaryButton>
                        </Link>
                    </div> -->

                    <div class="relative">
                        <InputLabel for="product" class="mb-2">Product</InputLabel>
                        <TextInput id="typepro"
                            type="text" 
                            v-model="searchProducts" 
                            @input="filterProducts" 
                            class="mt-1 block w-[50%]" 
                            placeholder="Search for product" 
                        />
                        <InputError :message="form.errors.supplierID" />

                        <ul id="selectpro" v-if="filteredProducts.length > 0" class="w-[50%] bg-white" >
                            <li 
                                v-for="product in filteredProducts" 
                                :key="product.productID" 
                                @click="selectProduct(product)" 
                                class="cursor-pointer hover:text-white hover:bg-[#0108EE] w-[50%] pl-5 rounded-lg mt-1"
                            >
                                {{ product.productName }}
                            </li>
                        </ul>
                    </div>

                    <div class="mt-4">
                        <InputLabel for="quantity" class="mb-2">Quantity</InputLabel>
                        <TextInput class="mt-1 block w-[50%]" id="quantity" v-model="newProduct.quantity" />
                        <InputError :message="form.errors.quantity" />
                    </div>

                    <PrimaryButton @click.prevent="addProduct" class="mt-2">
                        Add Product
                    </PrimaryButton>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs uppercase">
                            <tr>
                                <th scope="col" class="px-6 py-3">SL.</th>
                                <th scope="col" class="px-6 py-3">Product Name</th>
                                <th scope="col" class="px-6 py-3">Quantity</th>
                                <th scope="col" class="px-6 py-3">Unit Price</th>
                                <th scope="col" class="px-6 py-3">Action</th>
                            </tr>
                        </thead>


                        <!-- Table -->
                        <tbody>
                            <tr v-for="(product, index) in form.products" :key="index">
                                <td class="px-6 py-4">{{ index + 1 }}</td>
                                <td class="px-6 py-4">{{ product.product }}</td>
                                <td class="px-6 py-4">{{ product.quantity }}</td>
                                <td class="px-6 py-4">{{ product.price }}</td>
                                <td class="px-6 py-4 flex items-center space-x-3">
                                    <button class="text-red-700 hover:text-red-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>
        </article>
    </AuthenticatedLayout>
</template>