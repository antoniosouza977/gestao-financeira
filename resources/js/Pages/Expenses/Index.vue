<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Index from "@/Components/Crud/Index.vue";
import {Head} from "@inertiajs/vue3";
import PromisesToConfirm from "@/Components/TransactionPromises/PromisesToConfirm.vue";
import NewTransactionModal from "@/Components/Transactions/NewTransactionModal.vue";
import TransactionsIndex from "@/Components/Transactions/TransactionsIndex.vue";
import SearchForm from "@/Components/Transactions/SearchForm.vue";

const props = defineProps({
    promisesMissingConfirmation: Array,
    categories: Array,
    transactions: Object,
    type: String
})

</script>

<template>
    <AppLayout>
        <Head title="Despesas"/>

        <Index title="Despesas">
            <template v-slot:search-form>
                <SearchForm :categories/>
            </template>
            <template v-slot:new-btn>
                <NewTransactionModal :type="type" :store-route="route('expenses.store')" :categories/>
            </template>

            <template v-slot:content>
                <PromisesToConfirm v-if="promisesMissingConfirmation.length" :type
                                   :confirm-route="route('expenses.store')"
                                   :promises=promisesMissingConfirmation></PromisesToConfirm>

                <TransactionsIndex destroy-route="expenses.update" update-route="expenses.update" :transactions
                                   value-severity="danger" :categories/>

            </template>
        </Index>
    </AppLayout>
</template>

