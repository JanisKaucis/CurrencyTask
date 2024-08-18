<script>

import {defineComponent} from "vue";
import PageHeader from "@/Components/PageHeader.vue";
import PageFooter from "@/Components/PageFooter.vue";

export default defineComponent({
    components: {PageHeader, PageFooter}
})
</script>

<template>
        <PageHeader/>
    <body />
    <div class="w-full md:w-5/6 xl:w-3/5 h-full bg-blue-50 m-auto">
        <slot name="page_body"/>
    </div>
    <PageFooter/>
</template>

<style>

</style>
