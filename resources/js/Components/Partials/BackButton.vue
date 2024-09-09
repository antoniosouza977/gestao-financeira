<script>
import {router} from "@inertiajs/vue3";

export default {
    name: "BackButton",
    methods: {
        back: function() {
            router.get("/dashboard");
        }
    }
}
</script>

<template>
    <Button @click.prevent="back" style="width: fit-content;" icon="pi pi-arrow-left" label="Voltar" rounded />
</template>

<style scoped lang="scss">

</style>
