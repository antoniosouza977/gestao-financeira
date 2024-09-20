<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import NumberFormater from "@/Services/Types/NumberFormater.js";
import DeleteButton from "@/Components/Partials/DeleteButton.vue";
import Index from "@/Components/Crud/Index.vue";
import CustomPaginator from "@/Components/Crud/CustomPaginator.vue";
import EditButton from "@/Components/Partials/EditButton.vue";

const props = defineProps({
    incomes: {
        type: Array,
        required: false,
    }
})
</script>

<template>
    <AppLayout>
        <Index title="Rendas Mensais" :create-route="route('incomes.create')" button-label="Nova Renda">

            <div class="mt-3" v-if="incomes.data.length === 0">
                <Badge severity="secondary" size="large">Nenhuma renda cadastrada</Badge>
            </div>

            <div v-if="incomes.length" class="w-full">
                <Badge size="large">Rendas cadastradas</Badge>
                <Divider/>
            </div>

            <div v-for="income in incomes.data" :key="income.id" class="flex flex-wrap items-center w-full rounded">

                <div class="income-field">
                    <label class="font-bold" for="">Valor: </label>
                    <Badge size="large" class="w-fit">
                        {{ NumberFormater.toLocalCurrency(income.value) }}
                    </Badge>
                </div>

                <div class="income-field">
                    <label class="font-bold" for="">Categoria: </label>
                    {{ income.category.name }}
                </div>

                <div class="income-field">
                    <label class="font-bold" for="">Descrição: </label>
                    {{ income.description || 'Sem descrição' }}
                </div>

                <div class="income-field">
                    <label class="font-bold" for="">Dia Pagamento: </label>
                        {{ income.payment_day }}
                </div>

                <div class="income-field">
                    <label class="font-bold" for="">Ações: </label>
                    <div class="flex gap-3">
                        <EditButton :href="route('incomes.edit', income.id)"/>
                        <DeleteButton icon="true" :url="route('incomes.destroy', income)"/>
                    </div>
                </div>

                <Divider/>
            </div>

            <CustomPaginator :index-route="route('incomes.index')" :laravel-paginator="incomes"/>
        </Index>
    </AppLayout>
</template>

<style scoped>
.income-field {
    @apply xl:w-1/5 sm:w-1/2 w-full p-3 flex flex-col gap-1;
}
</style>
