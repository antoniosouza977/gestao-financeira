<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Index from "@/Components/Crud/Index.vue";
import {Link} from "@inertiajs/vue3";
import NumberFormater from "../../Services/Types/NumberFormater.js";
import DateFormater from "../../Services/Types/DateFormater.js";
import IncomesToConfirmList from "@/Components/Payments/IncomesToConfirmList.vue";
import DeleteButton from "@/Components/Partials/DeleteButton.vue";
import Paginator from '@/Components/Crud/Paginator.vue'

const props = defineProps({
    incomesWithNoPayment: {
        required: false,
        type: Array,
    },
    payments: {
        required: false,
        type: Object,
    }
})
</script>

<template>
    <AppLayout>
        <Index :create-route="route('payments.create')">

            <IncomesToConfirmList :incomesWithNoPayment=incomesWithNoPayment></IncomesToConfirmList>

            <div class="mt-3" v-if="payments.data.length === 0">
                <Badge severity="secondary" size="large">Nenhuma lançamento cadastrado</Badge>
            </div>


            <div v-if="payments.data.length" class="w-full mb-3">
                <Badge size="large">Lançamentos:</Badge>
            </div>

            <div v-for="payment in payments.data" :key="payment.id"
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
                    <span class="font-bold">Origem: </span>
                    <template v-if="payment.income_id">
                        <Link v-if="payment.income.active" class="underline text-blue-400"
                              :href="route('incomes.edit', payment.income_id)">
                            {{ payment.income.description }}
                            <i class="pi pi-link"></i>
                        </Link>
                        <span v-else>{{ payment.income.description }}</span>
                    </template>
                    <template v-else>
                        <Badge class="w-fit" severity="secondary" size="large">Pagamento Avulso</Badge>
                    </template>
                </div>

                <div class="xl:w-4/12 lg:w-1/3 sm:w-1/2 w-full flex flex-col flex-wrap gap-3 p-3 pl-0">
                    <label class="font-bold" for="">Descrição: </label>
                    <span v-if="payment.income_id && !payment.description">
                        {{ 'Confirmação de pagamento de ' + payment.income.description }}
                    </span>
                    <span v-else>
                        {{ payment.description || 'Sem descrição (Pagamento Avulso)' }}
                    </span>
                </div>

                <div class="xl:w-2/12 lg:w-1/3 sm:w-1/2 w-full flex flex-col flex-wrap gap-3 p-3 pl-0">
                    <label class="font-bold">Ações: </label>
                    <div class="flex gap-3">
                        <Link :href="route('payments.edit', payment.id)">
                            <Button icon="pi pi-pen-to-square" title="Editar" severity="warn" outlined/>
                        </Link>
                        <DeleteButton icon="true" :url="route('payments.destroy', payment.id)"/>
                    </div>
                </div>

                <Divider/>

            </div>
            <Paginator v-if="props.payments.total > props.payments.data.length" :links="props.payments.links"/>
        </Index>
    </AppLayout>
</template>

