<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import IncrementButton from '@/Components/IncrementButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { ref, computed } from 'vue'
import Modal from '@/Components/Modal.vue';

const showModal = ref(false);

const props = defineProps({
    products: {
        type: Object,
        default: () => ({}),
    },

    productcategories: {
        type: Object,
        default: () => ({}),
    },
});

const currentDate = () => {
    const current = new Date();
    return current.toISOString().split('T')[0];
};

const form = useForm({
    customerName: '',
    customerAddress: '',
    customerContact: '',
    orderDate: currentDate(),
    products: [],
});

const cart = ref([]);

const increment = (product) => {
    const existingProduct = cart.value.find(item => item.productID === product.productID);
    if (existingProduct) {
        existingProduct.quantity++;
    } else {
        cart.value.push({ productID: product.productID, productName:  product.productName, productPrice: product.productprices[0]?.price, quantity: 1 });
    }
};

const decrement = (productID) => {
    const existingProduct = cart.value.find(item => item.productID === productID);
    if (existingProduct && existingProduct.quantity > 1) {
        existingProduct.quantity--;
    } else if (existingProduct) {
        cart.value = cart.value.filter(item => item.productID !== productID);
    }
};

const subtotal = computed(() => {
    return cart.value.reduce((total, product) => {
        return total + (product.productPrice * product.quantity);
    }, 0);
});

const updateQuantity = (productID, newQuantity) => {
    const quantity = Number(newQuantity);
    const productInCart = cart.value.find(item => item.productID === productID);

    if (productInCart) {
        if (quantity <= 0) {
            // If quantity is 0 or negative, remove the product from the cart.
            removeProduct(productID);
        } else {
            // Update the quantity in the cart.
            productInCart.quantity = quantity;
        }
    }
};

const removeProduct = (productID) => {
    cart.value = cart.value.filter(item => item.productID !== productID);
};

const selectedDiscount = ref(null);
// const discounts = {
//     OSCA: 0.3,
//     PWD: 0.2,
// };

const total = computed(() => {
    let discountAmount = 0;
    if (selectedDiscount.value === '20%') {
        discountAmount = subtotal.value * 0.2; // 20% discount
    }
    return subtotal.value - discountAmount;
});

const submit = () => {
    form.products = cart.value;
    form.post(route('orderform.store'));
}
</script>

<template>
    <Head title="Order Form" />

    <GuestLayout>
        <div class="flex h-screen p-4 gap-4">
            <main class="flex-1 bg-white overflow-auto rounded-lg p-4">
                <!-- Top -->
                <div class="flex justify-between items-center">
                    <h3>Transaction</h3>
                </div>
                <div class="border-b border-gray-700 my-2" />

                <!-- Category -->
                <h3>Categories</h3>
                <div class="bg-[#BFBFBF] rounded-lg">
                    <div class="p-5">
                        <div class="flex h-10 overflow-auto space-x-5">
                            <PrimaryButton>
                                <h4>All</h4>
                            </PrimaryButton>
                            <PrimaryButton v-for="category in productcategories" :key="category.id">
                                <h4>{{ category.categoryName }}</h4>
                            </PrimaryButton>
                        </div>
                    </div>
                </div>

                <div v-for="category in productcategories" :key="category.id">
                    <h3>{{ category.categoryName }}</h3>
                    <div class="flex overflow-x-scroll">
                        <div v-for="product in products" :key="product.id">
                            <div v-if="product.productCategory === category.categoryID">
                                <div class="mr-5 bg-[#BFBFBF] rounded-lg p-3">
                                    <div>
                                        <h4> {{ product.productName }} </h4>
                                        <h4>P {{ product.productprices[0]?.price }}</h4>
                                        <div class="flex space-x-4 items-center">
                                            <IncrementButton @click="decrement(product.productID)">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-lg" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8"/>
                                                </svg>
                                            </IncrementButton>
                                            
                                            <TextInput :id="product.productID" class="w-10 text-center h-8 px-1 bg-[#bfbfbf] border-0" type="text" :value="cart.find(item => item.productID === product.productID)?.quantity || 0" readonly/>

                                            <IncrementButton @click="increment(product)">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                                                </svg>
                                            </IncrementButton>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <aside class="w-[25%] flex flex-col justify-between rounded-xl h-full">
                <!-- Top -->
                <div class="bg-white pt-4 px-4 rounded-t-lg">
                    <div class="flex justify-between items-center">
                        <h3>Cart</h3>
                    </div>
                    <div class="border-b border-gray-700 my-2" />
                </div>

                <!-- Cart -->
                <div class="bg-white pb-4 px-4 rounded-b-lg flex-1 overflow-y-auto">
                    <table>
                        <tr class="space-x-5 space-y-3 p-2" v-for="(product, index) in cart" :key="index">
                            <td>
                                <h5> {{ product.productName }} </h5>
                                <h5>P {{ product.productPrice }}</h5>
                            </td>
                            <td class="flex gap-5">
                                <div class="flex space-x-1 items-center">
                                    <IncrementButton @click="decrement(product.productID)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-lg" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8"/>
                                        </svg>
                                    </IncrementButton>
                                    
                                    <TextInput 
                                        :id="product.productID" 
                                        class="w-10 text-center h-8 px-1 border-0" 
                                        type="text" 
                                        v-model.number="product.quantity"
                                        @input="updateQuantity(product.productID, $event.target.value)"
                                    />

                                    <IncrementButton @click="increment(product)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                                        </svg>
                                    </IncrementButton>
                                </div>

                                <div>
                                    <button @click.prevent="removeProduct(product.productID)" class="bg-red-700 hover:bg-red-400 text-white p-1 rounded-bl-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Discount -->
                <div class="flex flex-col gap-2 mt-2">
                    <div class="bg-white p-4 rounded-lg">
                        <InputLabel> Apply Discounts </InputLabel>
                        <div class="border-b border-gray-700 my-2 opacity-[50%]" />
                        <div class="flex justify-between gap-5">
                            <select v-model="selectedDiscount" class="text-gray-700 w-full rounded-lg">
                                <option selected value=""> None </option>
                                <option class="text-black" value="20%"> OSCA </option>
                                <option class="text-black" value="20%"> PWD </option>
                            </select>

                            <PrimaryButton>
                                Apply
                            </PrimaryButton>
                        </div>
                    </div>
                    
                    <!-- Check out -->
                    <div class="bg-white p-4 rounded-lg">
                        <InputLabel> Check out</InputLabel>
                        <div class="border-b border-gray-700 my-2 opacity-[50%]" />

                        <div class="flex flex-col gap-2">
                            <div class="flex items-center justify-between">
                                <InputLabel> Subtotal: </InputLabel>
                                <span>P {{ subtotal.toFixed(2) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <InputLabel> Discount through applied:  </InputLabel>
                                <span> {{ selectedDiscount ? selectedDiscount : 'None' }} </span>
                            </div>

                            <div class="border-b border-gray-700 opacity-[50%]" />

                            <div class="flex items-center justify-between">
                                <InputLabel> Total: {{ total.toFixed(2) }} </InputLabel>
                                <!-- <PrimaryButton @click="submit">
                                    <span> Checkout </span>
                                </PrimaryButton> -->
                                <PrimaryButton @click="showModal = true">
                                    <span> Checkout </span>
                                </PrimaryButton>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <Modal
                :show="showModal" 
                @close="showModal = false" 
                :closeable="true"
                >
                
                <div class="p-6">
                    <h2 class="text-lg font-bold">Secure Order</h2>
                    <div class="flex gap-4">
                        <main class="flex-1 w-[500px]">
                            <form @submit.prevent="submit">
                                <div class="bg-white p-5 rounded-lg">
                                    <h4> Details </h4>
                                    <div>
                                        <InputLabel for="customerName" class="mb-2">Customer Name</InputLabel>
                                        <TextInput class="mt-1 block" id="customerName" type="text" v-model="form.customerName" required />
                                        <InputError :message="form.errors.customerName" />
                                    </div>
                                    <div>
                                        <InputLabel for="customerAddress" class="mb-2"> Address </InputLabel>
                                        <TextInput class="mt-1 block" id="customerAddress" type="text" v-model="form.customerAddress" required />
                                        <InputError :message="form.errors.customerAddress" />
                                    </div>
                                    <div>
                                        <InputLabel for="customerContact" class="mb-2"> Customer Contact </InputLabel>
                                        <TextInput class="mt-1 block" id="customerContact" type="text" v-model="form.customerContact" required />
                                        <InputError :message="form.errors.customerContact" />
                                    </div>
                                </div>
                            </form>

                            <div>
                                <h4 class="mt-2"> Your Orders </h4>
                            </div>

                            <!-- Modal -->
                            <div class="bg-white pb-4 px-4 rounded-b-lg" style="max-height: 300px; overflow-y: auto;">
                                <table>
                                    <tr class="space-x-5 space-y-3 p-2" v-for="(product, index) in cart" :key="index">
                                        <td>
                                            <h5> {{ product.productName }} </h5>
                                            <h5>P {{ product.productPrice }}</h5>
                                        </td>
                                        <td class="flex gap-5">
                                            <div class="flex space-x-1 items-center">
                                                <IncrementButton @click="decrement(product.productID)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-lg" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8"/>
                                                    </svg>
                                                </IncrementButton>
                                                
                                                <TextInput 
                                                    :id="product.productID" 
                                                    class="w-10 text-center h-8 px-1 border-0" 
                                                    type="text" 
                                                    v-model.number="product.quantity"
                                                    @input="updateQuantity(product.productID, $event.target.value)"
                                                />

                                                <IncrementButton @click="increment(product)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                                                    </svg>
                                                </IncrementButton>
                                            </div>

                                            <div>
                                                <button @click.prevent="removeProduct(product.productID)" class="bg-red-700 hover:bg-red-400 text-white p-1 rounded-bl-lg">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </main>

                        <aside class="bg-white w-[400px] p-5 rounded-lg flex flex-col justify-between">
                            <h2 class="text-lg font-bold">Order Summary</h2>

                            <div class="bg-white flex-1 pb-4 px-4 rounded-b-lg" style="max-height: 300px; overflow-y: auto;">
                                <table>
                                    <tr class="space-x-5 space-y-3 p-2" v-for="(product, index) in cart" :key="index">
                                        <td>
                                            <h5>{{ product.productName }}</h5>
                                        </td>
                                        <td>
                                            <h5>P {{ product.productPrice }}</h5>
                                        </td>
                                    </tr>
                                </table>
                                <div class="flex justify-between mt-2">
                                    <h2 class="text-lg font-bold">Total</h2>
                                    {{ total.toFixed(2) }}
                                </div>
                                <div class="border-b border-gray-700 my-2"></div>

                                <InputLabel> Payment Method </InputLabel>
                                <select class="text-gray-700 w-full rounded-lg">
                                    <option disabled selected value="">Select Payment</option>
                                    <option class="text-black" value="Cash">Cash</option>
                                    <option class="text-black" value="Check">Check</option>
                                    <option class="text-black" value="EWallet">EWallet</option>
                                </select>
                            </div>

                            <PrimaryButton class="w-full mt-2" @click="submit">
                                <span>Place Order</span>
                            </PrimaryButton>
                        </aside>
                    </div>
                    <!-- <button @click="showModal = false" class="mt-4">Close</button> -->
                </div>
            </Modal>
        </div>
    </GuestLayout>
</template>
