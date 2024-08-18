<script>
import DangerButton from "@/Components/DangerButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

export default {
    name: "Currencies",
    components: {PrimaryButton, DangerButton},
    // reactive state
    data() {
        return {
            buttonName: 'Poga',
            buttonState: true,
        }
    },
    methods: {
        change() {
            if (this.buttonState === true) {
                this.buttonName = 'OOps';
            }
            if (this.buttonState === false) {
                this.buttonName = 'Poga';
            }
            this.buttonState = !this.buttonState;
        },
        popAlert() {
            axios.get(route('currencies.popup')).then((response) => {
                alert(response.data.popupText)
            });
        },
    },
    mounted() {
    }
}
</script>

<template>
    <div class="bg-red-200 font-bold">hello world!</div>
    <div class="w-full flex flex-col items-center mt-8 justify-items-center">
        <DangerButton class="mb-4" @click="popAlert">XDFXD</DangerButton>
        <PrimaryButton @click="change">{{ buttonName }}</PrimaryButton>
    </div>
</template>

<style scoped>

</style>
