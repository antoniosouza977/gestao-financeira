<script setup>
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    buttonLabel: {
        type: String,
        required: false,
    },
    createRoute: {
        type: String,
        required: true,
    },
    title: {
        type: String,
        required: true,
    }
});

</script>

<template>
    <div class="card">
        <div class="flex flex-wrap items-center mb-3">
            <div class="w-full flex justify-between items-center mb-3">
                <h1 class="text-2xl">{{ props.title }}</h1>
                <Link :href="createRoute">
                    <Button :label="buttonLabel || 'Novo'"/>
                </Link>
            </div>
            <slot/>
        </div>
    </div>
</template>

<style scoped lang="scss">

</style>
