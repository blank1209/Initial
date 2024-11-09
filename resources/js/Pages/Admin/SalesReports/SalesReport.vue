<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import VueApexCharts from 'vue3-apexcharts';

const showModal = ref(false);

const props = defineProps({
    sales: {
        type: Array,
        default: () => [],
    },
    products: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    date: '2024',
    month: ''
});

// Create a computed property to extract unique years from salesDate
const saleYears = computed(() => {
    const years = props.sales.map(sale => new Date(sale.salesDate).getFullYear());
    return [...new Set(years)]; // Convert Set back to an array
});
const filteredSales = computed(() => {
    const selectedYear = parseInt(form.date); // Get the selected year from the form
    return props.sales.filter(sale => {
        const saleYear = new Date(sale.salesDate).getFullYear(); // Extract the year from salesDate
        return saleYear === selectedYear; // Filter sales that match the selected year
    });
});

const yearlyProductTotals = computed(() => {
    const totals = props.sales.reduce((acc, sale) => {
        const saleYear = new Date(sale.salesDate).getFullYear();
        const selectedYear = parseInt(form.date);

        // Only consider sales from the selected year
        if (saleYear === selectedYear) {
            sale.saleitems.forEach(saleitem => {
                const truckloaditem = saleitem.truckloaditems;
                const product = truckloaditem.products;
                const productName = product.productName;
                const quantity = saleitem.quantity || 0;

                // Accumulate the quantity for each product
                if (acc[productName]) {
                    acc[productName] += quantity;
                } else {
                    acc[productName] = quantity;
                }
            });
        }
        return acc;
    }, {});

    // Convert the totals object back into an array of objects
    return Object.keys(totals).map(productName => ({
        productName,
        quantity: totals[productName],
    }));
});

const highestSellingProduct = computed(() => {
    if (yearlyProductTotals.value.length === 0) {
        return []; // Return an empty array if there are no products
    }
    
    const maxQuantity = Math.max(...yearlyProductTotals.value.map(product => product.quantity));
    return yearlyProductTotals.value.filter(product => product.quantity === maxQuantity);
});

const lowestSellingProduct = computed(() => {
    if (yearlyProductTotals.value.length === 0) {
        return []; // Return an empty array if there are no products
    }
    
    const minQuantity = Math.min(...yearlyProductTotals.value.map(product => product.quantity));
    return yearlyProductTotals.value.filter(product => product.quantity === minQuantity);
});

const agentSalesTotals = computed(() => {
    const totals = props.sales.reduce((acc, sale) => {
        const saleYear = new Date(sale.salesDate).getFullYear();
        const selectedYear = parseInt(form.date);

        // Only consider sales from the selected year
        if (saleYear === selectedYear) {
            const agentName = sale.delivery.users.name;
            let saleTotal = 0;

            // Calculate total for this sale
            sale.saleitems.forEach(saleitem => {
                const truckloaditem = saleitem.truckloaditems;
                const product = truckloaditem.products;
                const price = product.productprices[0]?.price || 0;
                const quantity = saleitem.quantity || 0;

                // Accumulate the total for this sale
                saleTotal += price * quantity;
            });

            // Accumulate the total for the agent
            if (acc[agentName]) {
                acc[agentName] += saleTotal;
            } else {
                acc[agentName] = saleTotal;
            }
        }
        return acc;
    }, {});

    // Convert the totals object back into an array of objects
    return Object.keys(totals).map(agentName => ({
        agentName,
        totalSales: totals[agentName],
    }));
});

const monthlyTotalSales = computed(() => {
    // Initialize an array for each month to hold total sales amounts
    const monthlyTotals = Array.from({ length: 12 }, () => 0); // 12 months initialized to 0

    // Loop through each sale in filteredSales
    filteredSales.value.forEach(sale => {
        // Initialize total for the current sale
        let saleTotal = 0;

        // Loop through each saleitem in the sale
        sale.saleitems.forEach(saleitem => {
            const truckloaditem = saleitem.truckloaditems;
            const product = truckloaditem.products;

            // Get the price from productprices
            const price = product.productprices[0]?.price || 0;
            const quantity = saleitem.quantity || 0;

            // Calculate total for this product and add to saleTotal
            saleTotal += price * quantity;
        });

        // Get the sales date and determine the month
        const saleDate = new Date(sale.salesDate);
        const month = saleDate.getMonth(); // getMonth() returns 0 for January, 1 for February, etc.

        // Add the sale total to the corresponding month's total
        monthlyTotals[month] += saleTotal;
    });

    return monthlyTotals; // This will be an array of total sales amounts for each month
});

const monthlyProductsData = computed(() => {
    const monthlyProducts = Array.from({ length: 12 }, () => ({})); // Array to hold products for each month

    // Loop through each sale in filteredSales
    filteredSales.value.forEach(sale => {
        const saleDate = new Date(sale.salesDate);
        const month = saleDate.getMonth(); // Get the month index

        sale.saleitems.forEach(saleitem => {
            const truckloaditem = saleitem.truckloaditems;
            const product = truckloaditem.products;
            const productName = product.productName;
            const quantity = saleitem.quantity || 0;

            // Accumulate quantities for each product in the corresponding month
            if (monthlyProducts[month][productName]) {
                monthlyProducts[month][productName] += quantity;
            } else {
                monthlyProducts[month][productName] = quantity;
            }
        });
    });

    // Determine the highest and lowest selling product for each month
    return monthlyProducts.map(products => {
        const entries = Object.entries(products);
        
        const highestSelling = [];
        const lowestSelling = [];
        let maxQuantity = -Infinity;
        let minQuantity = Infinity;

        entries.forEach(([productName, quantity]) => {
            // Check for highest selling products
            if (quantity > maxQuantity) {
                maxQuantity = quantity;
                highestSelling.length = 0; // Clear the array
                highestSelling.push({ productName, quantity });
            } else if (quantity === maxQuantity) {
                highestSelling.push({ productName, quantity });
            }

            // Check for lowest selling products
            if (quantity < minQuantity) {
                minQuantity = quantity;
                lowestSelling.length = 0; // Clear the array
                lowestSelling.push({ productName, quantity });
            } else if (quantity === minQuantity) {
                lowestSelling.push({ productName, quantity });
            }
        });

        return { highestSelling, lowestSelling };
    });
});

const agentSalesPerMonth = computed(() => {
    const monthlyAgentTotals = Array.from({ length: 12 }, () => ({})); // Array to hold agent totals for each month

    // Loop through each sale in filteredSales
    filteredSales.value.forEach(sale => {
        const saleDate = new Date(sale.salesDate);
        const month = saleDate.getMonth(); // Get the month index

        const agentName = sale.delivery.users.name;
        let saleTotal = 0;

        // Calculate total for this sale
        sale.saleitems.forEach(saleitem => {
            const truckloaditem = saleitem.truckloaditems;
            const product = truckloaditem.products;
            const price = product.productprices[0]?.price || 0;
            const quantity = saleitem.quantity || 0;

            // Accumulate the total for this sale
            saleTotal += price * quantity;
        });

        // Accumulate the total for the agent in the corresponding month
        if (monthlyAgentTotals[month][agentName]) {
            monthlyAgentTotals[month][agentName] += saleTotal;
        } else {
            monthlyAgentTotals[month][agentName] = saleTotal;
        }
    });

    // Convert the totals object back into an array of objects
    return monthlyAgentTotals.map(agentTotals => {
        return Object.entries(agentTotals).map(([agentName, totalSales]) => ({
            agentName,
            totalSales,
        }));
    });
});

const filteredSalesForModal = computed(() => {
    const selectedYear = parseInt(form.date); // Get the selected year from the form
    const selectedMonth = parseInt(form.month); // Get the selected month from the form
    return props.sales.filter(sale => {
        const saleDate = new Date(sale.salesDate);
        const saleYear = saleDate.getFullYear(); // Extract the year from salesDate
        const saleMonth = saleDate.getMonth(); // Extract the month from salesDate
        return saleYear === selectedYear && saleMonth === selectedMonth; // Filter sales that match the selected year and month
    });
});

const modalPieData = computed(() => {
    const data = [];
    
    // Iterate through each sale in filteredSalesForModal
    filteredSalesForModal.value.forEach(sale => {
        // Iterate through each saleitem in the sale
        sale.saleitems.forEach(saleitem => {
            // Access the truckloaditem and product
            const truckloaditem = saleitem.truckloaditems;
            const product = truckloaditem.products;

            // Extract productName and quantity
            const productName = product.productName;
            const quantity = saleitem.quantity || 0; // Default to 0 if quantity is not available

            // Push the data into the array
            data.push({ productName, quantity });
        });
    });

    return data; // This will be an array of objects containing productName and quantity
});

const modalPieDataTotals = computed(() => {
    const totals = modalPieData.value.reduce((acc, item) => {
        if (acc[item.productName]) {
            acc[item.productName] += item.quantity; // Sum quantities for the same product
        } else {
            acc[item.productName] = item.quantity; // Initialize with the first quantity
        }
        return acc;
    }, {});

    // Convert the totals object back into an array of objects
    return Object.keys(totals).map(productName => ({
        productName,
        quantity: totals[productName],
    }));
});

const modalPieChartOptions = computed(() => {
    const quantities = modalPieDataTotals.value.map(data => data.quantity);
    const productNames = modalPieDataTotals.value.map(data => data.productName);

    const colors = productNames.map((_, index) => {
        // You can customize this logic to generate different colors
        return `hsl(${index * 360 / productNames.length}, 100%, 50%)`; // Generates a hue for each product
    });


    return {
        chart: {
            type: 'pie',
        },
        dataLabels: {
            enabled: true,
        },
        series: quantities,
        labels: productNames,
        colors: colors,
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            offsetX: 0,
            offsetY: 0,
        },
    };
});

const pieChartOptions = computed(() => {
    const quantities = yearlyProductTotals.value.map(data => data.quantity);
    const productNames = yearlyProductTotals.value.map(data => data.productName);

    // Generate an array of colors based on the number of products
    const colors = productNames.map((_, index) => {
        // You can customize this logic to generate different colors
        return `hsl(${index * 360 / productNames.length}, 100%, 50%)`; // Generates a hue for each product
    });

    return {
        chart: {
            type: 'pie',
        },
        dataLabels: {
            enabled: true,
        },
        series: quantities,
        labels: productNames,
        colors: colors, // Use the generated colors array
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            offsetX: 0,
            offsetY: 0,
        },
    };
});

const barChartOptions = computed(() => ({
    plotOptions: {
        bar: {
            distributed: true
        }
    },
    chart: {
        type: 'bar',
    },
    series: [{
        data: monthlyTotalSales.value.map((total, index) => ({
            x: new Date(0, index).toLocaleString('default', { month: 'long' }), // Get month name
            y: total
        }))
    }]
}));


// Group products by category
const productsByCategory = computed(() => {
    return props.products.reduce((acc, product) => {
        const category = product.productCategory;
        if (!acc[category]) {
            acc[category] = [];
        }
        acc[category].push(product);
        return acc;
    }, {});
});

// Calculate total sales for each product by month
const monthlyProductSales = computed(() => {
    const monthlyTotals = {};
    const selectedYear = parseInt(form.date);

    // Initialize the monthly totals for each category
    Object.keys(productsByCategory.value).forEach(category => {
        monthlyTotals[category] = Array.from({ length: 12 }, () => ({})); // 12 months initialized to empty objects
    });

    // Loop through each sale
    props.sales.forEach(sale => {
        const saleDate = new Date(sale.salesDate);
        const saleYear = saleDate.getFullYear();
        const saleMonth = saleDate.getMonth(); // 0 for January, 1 for February, etc.

        // Only consider sales from the selected year
        if (saleYear === selectedYear) {
            sale.saleitems.forEach(saleitem => {
                const truckloaditem = saleitem.truckloaditems;
                const product = truckloaditem.products;
                const productName = product.productName;
                const productCategory = product.productCategory;
                const quantity = saleitem.quantity || 0;

                // Initialize the product in the monthly totals if not already done
                if (!monthlyTotals[productCategory][saleMonth][productName]) {
                    monthlyTotals[productCategory][saleMonth][productName] = 0;
                }

                // Accumulate the quantity for the product in the corresponding month
                monthlyTotals[productCategory][saleMonth][productName] += quantity;
            });
        }
    });

    // Ensure all products have a total for each month, even if it's zero
    Object.keys(productsByCategory.value).forEach(category => {
        productsByCategory.value[category].forEach(product => {
            const productName = product.productName;
            for (let month = 0; month < 12; month++) {
                if (!monthlyTotals[category][month][productName]) {
                    monthlyTotals[category][month][productName] = 0; // Set to 0 if no sales
                }
            }
        });
    });

    return monthlyTotals;
});

// Prepare data for line charts based on categories
const lineChartData = computed(() => {
    const data = {};

    Object.keys(monthlyProductSales.value).forEach(category => {
        data[category] = {
            series: [],
            categories: Array.from({ length: 12 }, (_, index) => new Date(0, index).toLocaleString('default', { month: 'long' })),
        };

        Object.keys(monthlyProductSales.value[category]).forEach(month => {
            const monthData = monthlyProductSales.value[category][month];
            Object.keys(monthData).forEach(productName => {
                const productSales = monthData[productName];

                // Find or create the series for this product
                const seriesIndex = data[category].series.findIndex(series => series.name === productName);
                if (seriesIndex === -1) {
                    data[category].series.push({ name: productName, data: Array(12).fill(0) });
                }

                // Add the sales quantity to the corresponding month
                data[category].series.find(series => series.name === productName).data[month] += productSales;
            });
        });
    });

    return data;
});
</script>

<style>
.striped {
    border: 1px solid #ddd;
}

.striped > tr:nth-child(odd) {
    background: rgb(234, 235, 234);
}

.striped td > tr {
    background: transparent; /* Ensure nested <tr> do not get the striped background */
}

</style>

<template>
    <Head title="Sales Reports" />

    <AuthenticatedLayout>
        <article class="min-h-full p-5 bg-white rounded-lg flex flex-col">
            <!-- Top -->
            <div class="flex justify-between items-center">
                <h3 class="font-bold">Sales Reports</h3>
            </div>
            <div class="border-b border-gray-700 my-2 mb-5" />

            <div>
                <InputLabel for="saleType" class="mb-2">Year: </InputLabel>
                <select v-model="form.date" name="year" id="year" class="mt-1 w-[8%] border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <option v-for="year in saleYears" :value="year">{{ year }}</option>
                </select>
            </div>
            
            <h4>{{ form.date }} Sales Performance</h4>

            <div class="flex">
                <VueApexCharts
                    :options="pieChartOptions" 
                    :series="pieChartOptions.series" 
                    type="pie" 
                    height="400"
                />

                <VueApexCharts
                    :options="barChartOptions" 
                    :series="barChartOptions.series"
                    height="400"
                    width="800"
                />
            </div>

            <table>
                <tr>
                    <td>Highest Selling Products</td>
                    <td>Lowest Selling Products</td>
                </tr>
                <tr>
                    <td class="align-top">
                        <ul>
                            <li v-for="product in highestSellingProduct" :key="product.productName">
                                {{ product.productName }}: {{ product.quantity }}
                            </li>
                        </ul>
                    </td>
                    <td class="align-top">
                        <ul>
                            <li v-for="product in lowestSellingProduct" :key="product.productName">
                                {{ product.productName }}: {{ product.quantity }}
                            </li>
                        </ul>
                    </td>
                </tr>
            </table>

            <h4 class="pt-6">Sales Agent Perfomance</h4>
            <table class="striped">
                <tr>
                    <td>Agent Name</td>
                    <td>Total Sales</td>
                </tr>
                <tr v-for="agent in agentSalesTotals">
                    <td>{{ agent.agentName }}</td>
                    <td>{{ agent.totalSales }}</td>
                </tr>
            </table>

            <h4 class="pt-6">Total Monthly Sales</h4>
            <table class="striped">
                <tr>
                    <td>Month</td>
                    <td>Total</td>
                    <td>Action</td>
                </tr>
                <tr v-for="total,index in monthlyTotalSales">
                    <td>{{ new Date(0, index).toLocaleString('default', { month: 'long' }) }}</td>
                    <td>{{ total }}</td>
                    <td><PrimaryButton class="w-[20%] h-[32%] text-sm" @click.prevent="showModal = true; form.month=index" >View</PrimaryButton></td>
                </tr>
            </table>

            <div>
                <h4>Sales by Product Category</h4>
                <div v-for="(chartData, category) in lineChartData" :key="category">
                    <h5>{{ category }}</h5>
                    <VueApexCharts
                        :options="{
                            chart: { type: 'line' },
                            xaxis: { categories: chartData.categories },
                            stroke: { curve: 'smooth' },
                        }"
                        :series="chartData.series"
                        type="line"
                        height="400"
                    />
                </div>
            </div>


            <Modal
                :show="showModal" 
                @close="showModal = false" 
                :closeable="true"
                class="p-8"
                >

                <VueApexCharts
                    :options="modalPieChartOptions" 
                    :series="modalPieChartOptions.series" 
                    type="pie" 
                    height="200"
                />

                <table class="w-full">
                    <tr>
                        <td>Highest Selling Products</td>
                        <td>Lowest Selling Products</td>
                    </tr>
                    <tr>
                        <td class="align-top">
                            <ul>
                                <li v-for="product in monthlyProductsData[form.month].highestSelling" :key="product.productName">
                                    {{ product.productName }}: {{ product.quantity }}
                                </li>
                            </ul>
                        </td>
                        <td class="align-top">
                            <ul>
                                <li v-for="product in monthlyProductsData[form.month]   .lowestSelling" :key="product.productName">
                                    {{ product.productName }}: {{ product.quantity }}
                                </li>
                            </ul>
                        </td>
                    </tr>
                </table>

                <h4 class="pt-6">Sales Agent Perfomance</h4>
                <table class="w-full striped">
                    <tr>
                        <td>Agent Name</td>
                        <td>Total Sales</td>
                    </tr>
                    <tr v-for="agent in agentSalesPerMonth[form.month]">
                        <td>{{ agent.agentName }}</td>
                        <td>{{ agent.totalSales }}</td>
                    </tr>
                </table>

                <h4 class="pt-6">Sales</h4>
                <table class="w-full text-sm text-left striped">
                    <tr>
                        <th scope="col" class="px-6 py-3">Transaction No.</th>
                        <th scope="col" class="px-6 py-3">Sale Type</th>
                        <th scope="col" class="px-6 py-3">Date/Time</th>
                        <!-- <th scope="col" class="px-6 py-3">Invoice</th> -->
                        <th scope="col" class="px-6 py-3">Product Items</th>
                        <th scope="col" class="px-6 py-3">Quantity</th>
                        <th scope="col" class="px-6 py-3">Price</th>
                        <th scope="col" class="px-6 py-3">Amount</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                    </tr>
                    <tr v-for="sale in filteredSalesForModal" :key="sale.id">
                        <td class="px-6 py-4 align-top"> {{ sale.salesID }} </td>
                        <td class="px-6 py-4 align-top"> {{ sale.delivery.saletypes.saleTypeName }} </td>
                        <td class="px-6 py-4 align-top"> {{ sale.salesDate }} </td>
                        <td class="px-6 py-4 align-top">
                            <tr v-for="item in sale.saleitems">{{ item.truckloaditems.products.productName }}</tr>
                        </td>
                        <td class="px-6 py-4 align-top">
                            <tr v-for="item in sale.saleitems">{{ item.quantity }}</tr>
                        </td>
                        <td class="px-6 py-4 align-top">
                            <tr v-for="item in sale.saleitems">{{ item.truckloaditems.products.productprices[0].price }}</tr>
                        </td>
                        <td class="px-6 py-4 align-top">
                            <tr v-for="item in sale.saleitems">{{ item.quantity*item.truckloaditems.products.productprices[0].price }}</tr>
                        </td>
                        <td class="px-6 py-4 align-top">{{ sale.salesStatus }} </td>
                    </tr>
                </table>
            </Modal>

        </article>
    </AuthenticatedLayout>
</template>
