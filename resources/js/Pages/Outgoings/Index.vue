<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Index from "@/Components/Crud/Index.vue";
import {Link} from "@inertiajs/vue3";
import NumberFormater from "../../Services/Types/NumberFormater.js";
import DateFormater from "../../Services/Types/DateFormater.js";
import DeleteButton from "@/Components/Partials/DeleteButton.vue";
import CustomPaginator from '@/Components/Crud/CustomPaginator.vue'
import EditButton from "@/Components/Partials/EditButton.vue";
import ExpensesToConfirmList from "@/Components/Outgoings/ExpensesToConfirmList.vue";
import LinkTag from "@/Components/Partials/LinkTag.vue";

const props = defineProps({
    expensesWithNoOutgo: {
        required: false,
        type: Array,
    },
    outgoings: {
        required: false,
        type: Object,
    }
})
</script>

<template>
    <AppLayout>
        <Index title="Meus gastos" :create-route="route('outgoings.create')" button-label="Novo Gasto">

            <ExpensesToConfirmList v-if="expensesWithNoOutgo.length" :expensesWithNoOutgo=expensesWithNoOutgo></ExpensesToConfirmList>

            <div class="mt-3" v-if="outgoings.data.length === 0">
                <Badge severity="secondary" size="large">Nenhum lançamento de gastos foi cadastrado</Badge>
            </div>

            <div v-for="outgo in outgoings.data" :key="outgo.id"
                 class="flex flex-wrap items-center w-full rounded">

                <div class="xl:w-2/12 lg:w-1/3 w-1/2 flex flex-col gap-3 p-3 pl-0">
                    <span class="font-bold">Valor: </span>
                    <Badge severity="danger" size="large" class="w-fit">
                        {{ NumberFormater.toLocalCurrency(outgo.value) }}
                    </Badge>
                </div>

                <div class="xl:w-2/12 lg:w-1/3 w-1/2 flex flex-col gap-3 p-3 pl-0">
                    <label class="font-bold" for="">Data: </label>
                    {{ DateFormater.toLocaleDateString(outgo.date) }}
                </div>

                <div class="xl:w-2/12 lg:w-1/3 sm:w-1/2 w-full flex flex-col gap-3 p-3 pl-0">
                    <span class="font-bold">Origem: </span>
                    <template v-if="outgo.budget_id">
                        <LinkTag :label="outgo.budget.name" :url="route('budgets.edit', outgo.budget_id)"/>
                    </template>
                    <template v-else-if="outgo.expense_id">
                        <LinkTag :label="outgo.expense.description" :url="route('expenses.edit', outgo.expense_id)"/>
                    </template>
                    <template v-else>
                        <Badge class="w-fit" severity="secondary" size="large">Gasto Avulso</Badge>
                    </template>
                </div>

                <div class="xl:w-4/12 lg:w-1/3 sm:w-1/2 w-full flex flex-col flex-wrap gap-3 p-3 pl-0">
                    <label class="font-bold" for="">Descrição: </label>
                    <span v-if="outgo.expense_id && !outgo.description">
                        {{ 'Confirmação de pagamento de ' + outgo.expense.description }}
                    </span>
                    <span v-else>
                        {{ outgo.description || 'Sem descrição (Pagamento Avulso)' }}
                    </span>
                </div>

                <div class="xl:w-2/12 lg:w-1/3 sm:w-1/2 w-full flex flex-col flex-wrap gap-3 p-3 pl-0">
                    <label class="font-bold">Ações: </label>
                    <div class="flex gap-3">
                        <EditButton :href="route('outgoings.edit', outgo.id)"/>
                        <DeleteButton icon="true" :url="route('outgoings.destroy', outgo.id)"/>
                    </div>
                </div>

                <Divider/>
            </div>
                <CustomPaginator :index-route="route('outgoings.index')" :laravel-paginator="outgoings"/>
        </Index>
    </AppLayout>
</template>

