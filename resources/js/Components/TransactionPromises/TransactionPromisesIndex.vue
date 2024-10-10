<script setup>

import NumberFormatter from "@/Services/Types/NumberFormatter.js";
import {Link} from "@inertiajs/vue3";
import DeleteButton from "@/Components/Partials/DeleteButton.vue";

const props = defineProps({
    promises: {
        type: Array,
        required: true,
    },
    valueSeverity: {
        type: String,
        required: true,
    },
    resource: {
        type: String,
        required: true,
    }
})

const types = [
    'Diária',
    'Semanal',
    'Mensal',
    'Anual',
    'Parcelas'
];

</script>

<template>
    <div v-for="promise in promises" :key="promise.id"
         class="flex flex-wrap items-center w-full rounded">

        <div class="xl:w-1/6 w-1/2 p-3 pl-0 flex flex-col gap-1">
            <label>Valor: </label>
            <Badge size="large" :severity="valueSeverity" class="w-fit">
                {{ NumberFormatter.toLocalCurrency(promise.value) }}
            </Badge>
        </div>

        <div class="xl:w-1/6 w-1/2 p-3 pl-0 flex flex-col gap-1">
            <label>Categoria: </label>
            <Chip class="w-fit" :label="promise.category_id ? promise.category.name : 'Sem Categoria'"></Chip>
        </div>

        <div class="xl:w-1/6 w-1/2 p-3 pl-0 flex flex-col gap-1">
            <label>Tipo: </label>
            {{ types[promise.period_type - 1] }}
        </div>

        <div class="xl:w-1/6 w-1/2 p-3 pl-0 flex flex-col gap-1">
            <label>Recorrência: </label>
            {{ promise.period_value_label }}
        </div>

        <div class="xl:w-1/6 w-full p-3 pl-0 flex flex-col gap-1">
            <label>Descrição: </label>
            {{ promise.description || 'Sem descrição' }}
        </div>

        <div class="xl:w-1/6 sm:w-1/2 w-full p-3 pl-0 flex flex-col gap-1">
            <label>Ações: </label>
            <div class="flex gap-3">
                <Link :href="route(resource + '.edit', promise)">
                    <Button icon="pi pi-pen-to-square" severity="warn"></Button>
                </Link>
                <DeleteButton icon="true" :url="route(resource + '.destroy', promise)"/>
            </div>
        </div>

        <Divider/>
    </div>
</template>

<style scoped>

</style>
