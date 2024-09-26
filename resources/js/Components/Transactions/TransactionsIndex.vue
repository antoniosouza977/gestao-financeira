<script setup>
import NumberFormater from "@/Services/Types/NumberFormater.js";
import DateFormater from "@/Services/Types/DateFormater.js";
import EditTransactionModal from "@/Components/Transactions/EditTransactionModal.vue";
import DeleteButton from "@/Components/Partials/DeleteButton.vue";
import CustomPaginator from "@/Components/Crud/CustomPaginator.vue";

const props = defineProps({
    transactions: {
        type: Object,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
    updateRoute: {
        type: String,
        required: true,
    },
    destroyRoute: {
        type: String,
        required: true,
    },
    valueSeverity: {
        type: String,
        required: true,
    }
})

</script>

<template>
    <div class="mt-3" v-if="transactions.data.length === 0">
        <Badge severity="secondary" size="large">Nenhum lançamento cadastrado</Badge>
    </div>

    <div v-for="transaction in transactions.data" :key="transaction.id"
         class="flex flex-wrap items-center w-full rounded">

        <div class="xl:w-4/12 lg:w-2/3 sm:w-1/2 w-full flex flex-col flex-wrap gap-3 p-3 pl-0">
            <label class="font-bold" for="">Descrição: </label>
            {{ transaction.description || 'Sem descrição' }}
        </div>

        <div class="xl:w-2/12 lg:w-1/3 sm:w-1/2 w-full flex flex-col gap-3 p-3 pl-0">
            <span class="font-bold">Categoria: </span>
            <Badge class="w-fit" severity="secondary" size="large">
                {{ transaction.category_id ? transaction.category.name : 'Sem Categoria' }}
            </Badge>
        </div>

        <div class="xl:w-2/12 lg:w-1/3 w-1/2 flex flex-col gap-3 p-3 pl-0">
            <span class="font-bold">Valor: </span>
            <Badge size="large" :severity="valueSeverity" class="w-fit">
                {{ NumberFormater.toLocalCurrency(transaction.value) }}
            </Badge>
        </div>

        <div class="xl:w-2/12 lg:w-1/3 w-1/2 flex flex-col gap-3 p-3 pl-0">
            <label class="font-bold" for="">Data: </label>
            {{ DateFormater.toLocaleDateString(transaction.date) }}
        </div>

        <div class="xl:w-2/12 lg:w-1/3 sm:w-1/2 w-full flex flex-col flex-wrap gap-3 p-3 pl-0">
            <label class="font-bold">Ações: </label>
            <div class="flex gap-3">
                <EditTransactionModal :update-route="route(updateRoute, transaction)" :categories
                                      :transaction="transaction"/>
                <DeleteButton icon="true" :url="route(destroyRoute, transaction)"/>
            </div>
        </div>

        <Divider/>
    </div>

    <CustomPaginator :laravel-paginator="transactions"/>
</template>

<style scoped>

</style>
