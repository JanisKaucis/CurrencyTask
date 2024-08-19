<script>
export default {
    name: "CurrenciesTable",
    data() {
        return {
            currencies: null,
            dateFrom: null,
            dateTo: null,
            minDate: new Date().toISOString().split('T')[0],
            maxDate: new Date().toJSON().slice(0, 10),
        }
    },
    methods: {
        getTodayCurrencyExchangeValues() {
            axios.get(route('currencies.today')).then((response) => {
                this.currencies = response.data.todayCurrencies;
            });
        },
        getDatesWithCurrencyExchangeData() {
            axios.get(route('currencies.today')).then((response) => {
                this.currencies = response.data.todayCurrencies;
            });
        }
    },
    mounted() {
        this.getTodayCurrencyExchangeValues()
    }
}
</script>

<template>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">Currencies</h1>
                <p class="mt-2 text-sm text-gray-700">The list of all exchange rates from EUR, which is compiled on the website of the Latvijas Banka.</p>
            </div>

            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <input type="date" v-model="dateFrom" :min="minDate" :max="maxDate">
                <input type="date" v-model="dateTo" :min="minDate" :max="maxDate">
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Country</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Rate</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white">
                        <tr v-for="currency in currencies" :key="currency.country_id" class="even:bg-gray-50">
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-3">{{ currency.country_id }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ currency.rate }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

</script>

<style scoped>

</style>
