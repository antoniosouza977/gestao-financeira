<script>

import AppLayout from "@/Layouts/AppLayout.vue";
export default {
    props: ['incomes'],
    components: {
        AppLayout,
    }
}
</script>

<template>
    <AppLayout>
        <div v-for="income in incomes" :key="income.id">
            {{ income }}
        </div>
    </AppLayout>
</template>

<style scoped lang="scss">

</style>
