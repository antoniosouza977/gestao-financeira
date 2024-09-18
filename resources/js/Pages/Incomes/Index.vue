<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import NumberFormater from "@/Services/Types/NumberFormater.js";
import {Link} from "@inertiajs/vue3";
import DeleteButton from "@/Components/Partials/DeleteButton.vue";
import Index from "@/Components/Crud/Index.vue";

const props = defineProps({
    incomes: {
        type: Array,
        required: false,
    }
})
</script>

<template>
    <AppLayout>
        <Index :create-route="route('incomes.create')" button-label="Nova Renda">

            <div class="mt-3 font-light italic" v-if="incomes.length === 0">
                <h3>Nenhuma renda cadastrada ainda...</h3>
            </div>

            <div v-if="incomes.length" class="w-full">
                <Badge size="large">Rendas cadastradas</Badge>
                <Divider/>
            </div>

            <div v-for="income in incomes" :key="income.id" class="flex flex-wrap items-center w-full p-3 rounded">

                <div class="xl:w-1/5 sm:w-1/2 w-full p-3 flex flex-col gap-3">
                    <label class="font-bold" for="">Valor: </label>
                    <Badge size="large" class="w-fit">
                        {{ NumberFormater.toLocalCurrency(income.value) }}
                    </Badge>
                </div>

                <div class="xl:w-1/5 sm:w-1/2 w-full p-3 flex flex-col gap-3">
                    <label class="font-bold" for="">Categoria: </label>
                    {{ income.category.name }}
                </div>

                <div class="xl:w-1/5 sm:w-1/2 w-full p-3 flex flex-col gap-3">
                    <label class="font-bold" for="">Descrição: </label>
                    {{ income.description || 'Sem descrição' }}
                </div>

                <div class="xl:w-1/5 sm:w-1/2 w-full p-3 flex flex-col gap-3">
                    <label class="font-bold" for="">Dia Pagamento: </label>
                        {{ income.payment_day }}
                </div>

                <div class="xl:w-1/5 sm:w-1/2 w-full p-3 flex flex-col gap-3">
                    <label class="font-bold" for="">Ações: </label>
                    <div class="flex gap-3">
                        <Link :href="route('incomes.edit', income.id)">
                            <Button icon="pi pi-pen-to-square" title="Editar" severity="warn" outlined/>
                        </Link>
                        <DeleteButton icon="true" :url="route('incomes.destroy', income)"/>
                    </div>
                </div>

                <Divider/>

            </div>
        </Index>
    </AppLayout>
</template>
