<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import {onBeforeMount, ref} from "vue";
import NumberFormater from "../Services/Types/NumberFormater.js";
import DateFormater from "../Services/Types/DateFormater.js";
import LinkTag from "@/Components/Partials/LinkTag.vue";
import CustomLabel from "@/Components/Partials/CustomLabel.vue";

const props = defineProps({
    startPeriod: String,
    endPeriod: String,
    paymentsTotal: String,
    outgoingsTotal: String,
    incomesTotal: String,
    budgetsTotal: String,
    latestsOutgoings: Array
})

const chartData = ref(null)

onBeforeMount(() => {
    chartData.value = setChartData()
})

function setChartData() {
    return {
        labels: ['Pagamentos', 'Renda Prevista', 'Gastos', 'Orçamentos'],
        datasets: [
            {
                label: 'Total',
                type: 'bar',
                backgroundColor: ['#42A5F5', '#66BB6A', '#FFA726', '#FF7043'],
                data: [props.paymentsTotal, props.incomesTotal, props.outgoingsTotal, props.budgetsTotal],
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
                <div class="card mb-0">
                    <div class="flex justify-between mb-4">
                        <div>
                            <Link :href="route('payments.index')" class="block text-muted-color font-medium mb-4">
                                Pagamentos
                            </Link>
                            <div class="text-surface-900 dark:text-surface-0 font-medium text-xl">
                                {{ NumberFormater.toLocalCurrency(paymentsTotal) }}
                            </div>
                        </div>
                        <div class="flex items-center justify-center bg-blue-100 dark:bg-blue-400/10 rounded-border"
                             style="width: 2.5rem; height: 2.5rem">
                            <i class="pi pi-dollar text-green-500 !text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-6 xl:col-span-3">
                <div class="card mb-0">
                    <div class="flex justify-between mb-4">
                        <div>
                            <Link :href="route('outgoings.index')" class="block text-muted-color font-medium mb-4">
                                Gastos
                            </Link>
                            <div class="text-surface-900 dark:text-surface-0 font-medium text-xl">
                                {{ NumberFormater.toLocalCurrency(outgoingsTotal) }}
                            </div>
                        </div>
                        <div class="flex items-center justify-center bg-blue-100 dark:bg-blue-400/10 rounded-border"
                             style="width: 2.5rem; height: 2.5rem">
                            <i class="pi pi-dollar text-red-500 !text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-6 xl:col-span-3">
                <div class="card mb-0">
                    <div class="flex justify-between mb-4">
                        <div>
                            <Link :href="route('incomes.index')" class="block text-muted-color font-medium mb-4">Renda
                                Prevista
                            </Link>
                            <div class="text-surface-900 dark:text-surface-0 font-medium text-xl">
                                {{ NumberFormater.toLocalCurrency(incomesTotal) }}
                            </div>
                        </div>
                        <div class="flex items-center justify-center bg-blue-100 dark:bg-blue-400/10 rounded-border"
                             style="width: 2.5rem; height: 2.5rem">
                            <i class="pi pi-wallet text-orange-500 !text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-6 xl:col-span-3">
                <div class="card mb-0">
                    <div class="flex justify-between mb-4">
                        <div>
                            <Link :href="route('budgets.index')" class="block text-muted-color font-medium mb-4">Gastos
                                Orçados
                            </Link>
                            <div class="text-surface-900 dark:text-surface-0 font-medium text-xl">
                                {{ NumberFormater.toLocalCurrency(budgetsTotal) }}
                            </div>
                        </div>
                        <div class="flex items-center justify-center bg-blue-100 dark:bg-blue-400/10 rounded-border"
                             style="width: 2.5rem; height: 2.5rem">
                            <i class="pi pi-list-check text-orange-500 !text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 xl:col-span-6">
                <div class="card">
                    <div class="font-semibold text-xl mb-4">Visão geral</div>
                    <Chart type="bar" :data="chartData" class="h-80"/>
                </div>
            </div>

            <div class="col-span-12 xl:col-span-6">
                <div class="card">
                    <div class="flex justify-between">
                        <div class="font-semibold text-xl mb-4">Ultimos gastos</div>
                        <Link :href="route('outgoings.create')">
                            <Button icon="pi pi-plus" size="small"></Button>
                        </Link>
                    </div>
                    <div class="flex flex-col gap-1 min-h-80">
                        <div v-for="outgo in latestsOutgoings" class="flex flex-wrap w-full items-center justify-between bg-emphasis p-2 rounded">
                            <div class="sm:w-1/3 w-1/2">
                                <CustomLabel value="Valor: "/>
                                {{ NumberFormater.toLocalCurrency(outgo.value) }}
                            </div>
                            <div class="sm:w-1/3 w-1/2">
                                <CustomLabel value="Data: "/>
                                {{ DateFormater.toLocaleDateString(outgo.date) }}
                            </div>
                            <div class="sm:w-1/3 w-full">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
