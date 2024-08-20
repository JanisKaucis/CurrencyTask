<script>
export default {
    name: "CurrenciesTable",
    data() {
        return {
        }
    },
    props: {
      currencies: {
          type: Array
      }
    },
    methods: {
    },
    mounted() {
    }
}
</script>

<template>

        <div class="mt-2 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Currency</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Currency unit for 1 euro</th>
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
</template>

<script setup>

import CurrenciesTabs from "@/Components/Currencies/CurrenciesTabs.vue";
</script>

<style scoped>

</style>
