<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Index from "@/Components/Crud/Index.vue";
import {Head} from "@inertiajs/vue3";
import NumberFormater from "../../Services/Types/NumberFormater.js";
import DateFormater from "../../Services/Types/DateFormater.js";
import CustomPaginator from '@/Components/Crud/CustomPaginator.vue'
import PromisesToConfirm from "@/Components/TransactionPromises/PromisesToConfirm.vue";
import NewTransactionModal from "@/Components/Transactions/NewTransactionModal.vue";
import EditTransactionModal from "@/Components/Transactions/EditTransactionModal.vue";
import DeleteButton from "@/Components/Partials/DeleteButton.vue";
import TransactionsIndex from "@/Components/Transactions/TransactionsIndex.vue";

const props = defineProps({
    promisesMissingConfirmation: Array,
    categories: Array,
    transactions: Object,
    type: String
})

</script>

<template>
    <AppLayout>
        <Head title="Pagamentos"/>

        <Index title="Receitas">

            <template v-slot:new-btn>
                <NewTransactionModal :type="type" :store-route="route('incomes.store')" :categories/>
            </template>

            <template v-slot:content>
                <PromisesToConfirm v-if="promisesMissingConfirmation.length" :type
                                   :confirm-route="route('incomes.store')"
                                   :promises=promisesMissingConfirmation></PromisesToConfirm>

                <TransactionsIndex destroy-route="incomes.update" update-route="incomes.update" :transactions value-severity="success"/>

            </template>
        </Index>
    </AppLayout>
</template>

