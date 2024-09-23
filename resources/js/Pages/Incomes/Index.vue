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

                <div class="mt-3" v-if="transactions.data.length === 0">
                    <Badge severity="secondary" size="large">Nenhum lançamento cadastrado</Badge>
                </div>

                <div v-for="payment in transactions.data" :key="payment.id"
                     class="flex flex-wrap items-center w-full rounded">

                    <div class="xl:w-2/12 lg:w-1/3 w-1/2 flex flex-col gap-3 p-3 pl-0">
                        <span class="font-bold">Valor: </span>
                        <Badge size="large" class="w-fit">
                            {{ NumberFormater.toLocalCurrency(payment.value) }}
                        </Badge>
                    </div>

                    <div class="xl:w-2/12 lg:w-1/3 w-1/2 flex flex-col gap-3 p-3 pl-0">
                        <label class="font-bold" for="">Data: </label>
                        {{ DateFormater.toLocaleDateString(payment.date) }}
                    </div>

                    <div class="xl:w-2/12 lg:w-1/3 sm:w-1/2 w-full flex flex-col gap-3 p-3 pl-0">
                        <span class="font-bold">Categoria: </span>
                        <Badge class="w-fit" severity="secondary" size="large">
                            {{ payment.category_id ? payment.category.name : 'Sem Categoria' }}
                        </Badge>
                    </div>

                    <div class="xl:w-4/12 lg:w-1/3 sm:w-1/2 w-full flex flex-col flex-wrap gap-3 p-3 pl-0">
                        <label class="font-bold" for="">Descrição: </label>
                        {{ payment.description || 'Sem descrição' }}
                    </div>

                    <div class="xl:w-2/12 lg:w-1/3 sm:w-1/2 w-full flex flex-col flex-wrap gap-3 p-3 pl-0">
                        <label class="font-bold">Ações: </label>
                        <div class="flex gap-3">
                            <EditTransactionModal :update-route="route('incomes.update', payment)" :categories
                                                  :transaction="payment"/>
                            <DeleteButton icon="true" :url="route('incomes.destroy', payment)"/>
                        </div>
                    </div>

                    <Divider/>
                </div>
                <CustomPaginator :index-route="route('incomes.index')" :laravel-paginator="transactions"/>
            </template>
        </Index>
    </AppLayout>
</template>

