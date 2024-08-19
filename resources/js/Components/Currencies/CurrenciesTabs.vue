<script>
export default {
    name: "CurrenciesTabs",

    data() {
        return {
            allCurrencies: [],
            dateFrom: null,
            dateTo: null,
            minDate: (new Date()).toISOString().split('T')[0],
            maxDate: (new Date()).toISOString().split('T')[0],
            currentTab: 0,
            countryFilter: null,
        }
    },
    methods: {
        getTodayCurrencyExchangeValues() {
            axios.get(route('currencies.today')).then((response) => {
                this.allCurrencies.push(response.data.todayCurrencies);
            });
        },
        getDatesWithCurrencyExchangeData() {
            axios.get(route('currencies.dates')).then((response) => {
                this.minDate = this.dateFrom = response.data.firstDate;
                this.maxDate = this.dateTo = response.data.lastDate;
            });
            console.log(this.dateFrom)
            console.log(this.dateTo)
        },
        filterCurrencies() {

            axios.get(route('currencies.filter',
                {
                    countryFilter: this.countryFilter,
                    dateFrom: this.dateFrom,
                    dateTo: this.dateTo,
                })).then((response) => {
                this.allCurrencies = response.data.filteredCurrencies;
                this.currentTab = this.dateFrom;
                this.minDate = this.dateFrom;
                this.maxDate = this.dateTo;
            });
            console.log(this.minDate)
            console.log(this.maxDate)
        },
        changeTable(index) {
            this.currentTab = index;
        }
    },
    mounted() {
        this.getTodayCurrencyExchangeValues();
        this.getDatesWithCurrencyExchangeData();
    }
}
</script>

<template>
    <div>
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:justify-center mb-4">
                <div>
                    <h1 class="sm:items-center text-center text-base font-semibold leading-6 text-gray-900">
                        Currencies</h1>
                    <p class="mt-2 text-sm text-gray-700">The list of all exchange rates from EUR, which is compiled on
                        the website of the Latvijas Banka.</p>
                </div>
            </div>
            <div class="sm:flex sm:items-center sm:justify-center mb-4">
                <div>
                    <div class="sm:ml-2 sm:flex-none">
                        <input type="text" v-model="countryFilter" v-on:input="filterCurrencies"
                               placeholder="Country code...">
                        <input type="date" @change="filterCurrencies" v-model="dateFrom" :min="minDate" :max="maxDate">
                        <input type="date" @change="filterCurrencies" v-model="dateTo" :min="minDate" :max="maxDate">
                    </div>
                </div>
            </div>
            <div class="sm:hidden">
                <label for="tabs" class="sr-only">Select a tab</label>
                <template v-for="(currencies, index) in allCurrencies" :key="index">
                    <button @click="changeTable(index)"
                            :class="[index === currentTab ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700', 'whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium']"
                            :aria-current="index === currentTab ? 'page' : undefined">Tab
                    </button>
                </template>
                <template v-for="(currencies, index) in allCurrencies" :key="index">

                    <currencies-table :currencies="currencies" :id="'table'+index"
                                      :class="[index !== currentTab ? 'hidden' : '']"/>
                </template>
            </div>
            <div class="hidden sm:block">
                <div class="border-b border-gray-200">
                    <nav class="" aria-label="Tabs">
                        <div class="px-4 sm:px-6 lg:px-8">
                            <template v-for="(currencies, index) in allCurrencies" :key="index">
                                <button @click="changeTable(index)"
                                        :class="[index === currentTab ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700', 'whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium']"
                                        :aria-current="index === currentTab ? 'page' : undefined">{{ index }}
                                </button>
                            </template>
                            <template v-for="(currencies, index) in allCurrencies" :key="index">
                                <currencies-table :currencies="currencies" :id="'table'+index"
                                                  :class="[index !== currentTab ? 'hidden' : '']"/>
                            </template>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import CurrenciesTable from "@/Components/Currencies/CurrenciesTable.vue";

</script>

<style scoped>

</style>
