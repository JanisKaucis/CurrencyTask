<script>
import CurrenciesTopText from "@/Components/Currencies/CurrenciesTopText.vue";
import CurrenciesTable from "@/Components/Currencies/CurrenciesTable.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

export default {
    name: "Currencies",
    components: {AppLayout, CurrenciesTable, CurrenciesTopText},
    // reactive state
    data() {
        return {}
    },
    methods: {},
    mounted() {
    }
}
</script>

<template>
    <app-layout>
        <template v-slot:page_body>
            <currencies-top-text/>
            <currencies-table/>
        </template>
    </app-layout>
</template>

<style scoped>

</style>
