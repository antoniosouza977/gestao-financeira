<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import {onBeforeMount, ref} from "vue";
import NumberFormatter from "../Services/Types/NumberFormatter.js";
import DateFormater from "../Services/Types/DateFormater.js";
import NewTransactionModal from "@/Components/Transactions/NewTransactionModal.vue";
import EditTransactionModal from "@/Components/Transactions/EditTransactionModal.vue";

const props = defineProps({
    startPeriod: String,
    endPeriod: String,
    incomesTotal: String,
    expensesTotal: String,
    wallet: String,
    expensePromisesTotal: String,
    latestsExpenses: Array,
    categories: Array
})

const chartData = ref(null)

onBeforeMount(() => {
    chartData.value = setChartData()
})

function setChartData() {
    return {
        labels: ['Entradas', 'Saídas', 'Despesas Agendadas'],
        datasets: [
            {
                label: 'Total',
                type: 'bar',
                backgroundColor: ['#42A5F5', '#66BB6A', '#FFA726', '#FF7043'],
                data: [props.incomesTotal, props.expensesTotal, props.expensePromisesTotal],
                borderRadius: {
                    topLeft: 8,
                    topRight: 8
                },
                borderSkipped: true,
                barThickness: 32
            }
        ]
    };
}

</script>

<template>
    <Head title="Dashboard"/>

    <AppLayout>
        <div class="grid grid-cols-12 gap-8">
            <div class="col-span-12">
                <div class="card mb-0 text-center text-xl text-muted-color-emphasis">
                    Balanço do perido de {{ startPeriod }} até {{ endPeriod }}
                </div>
            </div>

            <div class="col-span-12 lg:col-span-6 xl:col-span-3">
                <Link :href="route('incomes.index')">
                    <div class="card mb-0">
                        <div class="flex justify-between mb-4">
                            <div>
                            <span class="block text-muted-color font-medium mb-4">
                                Entradas
                            </span>
                                <div class="text-surface-900 dark:text-surface-0 font-medium text-xl">
                                    {{ NumberFormatter.toLocalCurrency(incomesTotal) }}
                                </div>
                            </div>
                            <div class="flex items-center justify-center bg-blue-100 dark:bg-blue-400/10 rounded-border"
                                 style="width: 2.5rem; height: 2.5rem">
                                <i class="pi pi-dollar text-green-500 !text-xl"></i>
                            </div>
                        </div>
                    </div>
                </Link>
            </div>

            <div class="col-span-12 lg:col-span-6 xl:col-span-3">
                <div class="card mb-0">
                    <Link :href="route('expenses.index')">
                        <div class="flex justify-between mb-4">
                            <div>
                                <span class="block text-muted-color font-medium mb-4">
                                    Saídas
                                </span>
                                <div class="text-surface-900 dark:text-surface-0 font-medium text-xl">
                                    {{ NumberFormatter.toLocalCurrency(expensesTotal) }}
                                </div>
                            </div>
                            <div class="flex items-center justify-center bg-blue-100 dark:bg-blue-400/10 rounded-border"
                                 style="width: 2.5rem; height: 2.5rem">
                                <i class="pi pi-dollar text-red-500 !text-xl"></i>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-6 xl:col-span-3">
                <Link :href="route('income-promises.index')">
                    <div class="card mb-0">
                        <div class="flex justify-between mb-4">
                            <div>
                            <span class="block text-muted-color font-medium mb-4">Carteira
                            </span>
                                <div class="text-surface-900 dark:text-surface-0 font-medium text-xl">
                                    {{ NumberFormatter.toLocalCurrency(wallet) }}
                                </div>
                            </div>
                            <div class="flex items-center justify-center bg-blue-100 dark:bg-blue-400/10 rounded-border"
                                 style="width: 2.5rem; height: 2.5rem">
                                <i class="pi pi-wallet text-orange-500 !text-xl"></i>
                            </div>
                        </div>
                    </div>
                </Link>
            </div>

            <div class="col-span-12 lg:col-span-6 xl:col-span-3">
                <Link :href="route('expense-promises.index')">
                    <div class="card mb-0">
                        <div class="flex justify-between mb-4">
                            <div>
                            <span class="block text-muted-color font-medium mb-4">Despesas
                                Agendadas
                            </span>
                                <div class="text-surface-900 dark:text-surface-0 font-medium text-xl">
                                    {{ NumberFormatter.toLocalCurrency(expensePromisesTotal) }}
                                </div>
                            </div>
                            <div class="flex items-center justify-center bg-blue-100 dark:bg-blue-400/10 rounded-border"
                                 style="width: 2.5rem; height: 2.5rem">
                                <i class="pi pi-list-check text-orange-500 !text-xl"></i>
                            </div>
                        </div>
                    </div>
                </Link>
            </div>

            <div class="col-span-12 xl:col-span-6">
                <div class="card min-h-[432px]">
                    <div class="font-semibold text-xl mb-4">Visão geral</div>
                    <Chart type="bar" class="" :data="chartData"/>
                </div>
            </div>

            <div class="col-span-12 xl:col-span-6">
                <div class="card min-h-[432px]">
                    <div class="flex justify-between">
                        <div class="font-semibold text-xl mb-4">Ultimas despesas</div>
                        <NewTransactionModal :store-route="route('add-expense')" :categories :icon="true" type="2"/>
                    </div>
                    <div class="flex flex-col gap-1 mt-3">
                        <div v-for="transaction in latestsExpenses"
                             class="flex flex-wrap w-full items-center justify-between bg-emphasis p-2 rounded text-sm">
                            <div class="sm:w-2/12 w-1/2">
                                <label>Valor:</label>
                                {{ NumberFormatter.toLocalCurrency(transaction.value) }}
                            </div>
                            <div class="sm:w-2/12 w-1/2">
                                <label for="">Data: </label>
                                {{ DateFormater.toLocaleDateString(transaction.date) }}
                            </div>
                            <div class="sm:w-7/12 w-1/2">
                                <label for="">Descrição</label>
                                {{ transaction.description || 'Sem descrição' }}
                            </div>
                            <div class="sm:w-1/12 w-1/2">
                                <EditTransactionModal :update-route="route('update-expense', transaction)" :categories :transaction/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </AppLayout>
</template>
