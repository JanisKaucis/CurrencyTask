<script>
export default {
    name: "CurrenciesTabs",

    data() {
        return {
            allCurrencies: [],
            dateFrom: null,
            dateTo: null,
            minDate1: null,
            maxDate1: null,
            minDate2: null,
            maxDate2: null,
            currentTab: null,
            countryFilter: null,
            formattedMonth: {
                0 : 'Jan',
                1 : 'Feb',
                2:  'Mar',
                3: 'Apr',
                4 : 'May',
                5 : 'Jun',
                6 : 'Jul',
                7 : 'Aug',
                8 : 'Sep',
                9 : 'Oct',
                10 : 'Nov',
                11 : 'Dec',
            },
        }
    },
    methods: {
        getTodayCurrencyExchangeValues() {
            axios.get(route('currencies.today')).then((response) => {
                this.allCurrencies = response.data.todayCurrencies;
                this.dateFrom = response.data.todayDate;
                this.dateTo = response.data.todayDate;
                this.currentTab = response.data.todayDate;
                console.log(response.data.todayDate)
                console.log(this.dateFrom)
                console.log(this.dateTo)
            });

        },
        getDatesWithCurrencyExchangeData() {
            axios.get(route('currencies.dates')).then((response) => {
                this.minDate1 = response.data.firstDate;
                this.maxDate1 = this.dateFrom = this.dateTo = response.data.lastDate;
                this.minDate2 = response.data.firstDate;
                this.maxDate2 = response.data.lastDate;
            });
        },
        filterCurrencies() {
            axios.get(route('currencies.filter',
                {
                    countryFilter: this.countryFilter,
                    dateFrom: this.dateFrom,
                    dateTo: this.dateTo,
                })).then((response) => {
                this.allCurrencies = response.data.filteredCurrencies;
                this.currentTab = Object.keys(this.allCurrencies)[0];
                this.maxDate1 = this.dateTo;
                this.minDate2 = this.dateFrom;
            });
        },
        changeTable(index) {
            this.currentTab = index;
        }
    },
    computed: {

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
                    <div class="border-2 border-gray-200 rounded p-2">
                        <h1 class="sm:items-center text-center text-base font-semibold leading-6 text-gray-900">
                            Filter</h1>
                        <div class="sm:ml-2 sm:flex gap-3">
                            <input type="text"
                                   class="flex-1 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                   v-model="countryFilter" v-on:input="filterCurrencies"
                                   placeholder="Country code...">
                            <input type="date"
                                   class="flex-1 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                   @change="filterCurrencies" v-model="dateFrom" :min="minDate1" :max="maxDate1">
                            <input type="date"
                                   class="flex-1 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                   @change="filterCurrencies" v-model="dateTo" :min="minDate2" :max="maxDate2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="sm:hidden">
                <label for="tabs" class="sr-only">Select a tab</label>
                <template v-for="(currencies, index) in allCurrencies" :key="index">
                    <button @click="changeTable(index)"
                            :class="[index === currentTab ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700', 'whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium']"
                            :aria-current="index === currentTab ? 'page' : undefined">{{ new Date(index).getDate() + '.' + (new Date(index).getMonth() + 1)  }}
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
                                        :aria-current="index === currentTab ? 'page' : undefined">{{ new Date(index).getDate() + '. ' + formattedMonth[(new Date(index).getMonth())]  }}
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
