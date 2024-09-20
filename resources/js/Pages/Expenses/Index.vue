<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import NumberFormater from "@/Services/Types/NumberFormater.js";
import DeleteButton from "@/Components/Partials/DeleteButton.vue";
import Index from "@/Components/Crud/Index.vue";
import CustomPaginator from "@/Components/Crud/CustomPaginator.vue";
import EditButton from "@/Components/Partials/EditButton.vue";

const props = defineProps({
    expenses: {
        type: Array,
        required: false,
    }
})
</script>

<template>
    <AppLayout>
        <Index title="Minhas Despesas Mensais" :create-route="route('expenses.create')" button-label="Nova Despesa">

            <div class="mt-3 font-light italic" v-if="expenses.data.length === 0">
                <h3>Nenhuma despesa mensal cadastrada ainda...</h3>
            </div>

            <div v-if="expenses.length" class="w-full">
                <Badge size="large">Rendas cadastradas</Badge>
                <Divider/>
            </div>

            <div v-for="expense in expenses.data" :key="expense.id" class="flex flex-wrap items-center w-full rounded">

                <div class="expense-field">
                    <label class="font-bold" for="">Valor: </label>
                    <Badge size="large" class="w-fit">
                        {{ NumberFormater.toLocalCurrency(expense.value) }}
                    </Badge>
                </div>

                <div class="expense-field">
                    <label class="font-bold" for="">Orçamento: </label>
                    {{ expense.budget.name }}
                </div>

                <div class="expense-field">
                    <label class="font-bold" for="">Descrição: </label>
                    {{ expense.description || 'Sem descrição' }}
                </div>

                <div class="expense-field">
                    <label class="font-bold" for="">Dia Pagamento: </label>
                        {{ expense.payment_day }}
                </div>

                <div class="expense-field">
                    <label class="font-bold" for="">Ações: </label>
                    <div class="flex gap-3">
                        <EditButton :href="route('expenses.edit', expense.id)"/>
                        <DeleteButton icon="true" :url="route('expenses.destroy', expense)"/>
                    </div>
                </div>

                <Divider/>
            </div>

            <CustomPaginator :index-route="route('expenses.index')" :laravel-paginator="expenses"/>
        </Index>
    </AppLayout>
</template>

<style scoped>
.expense-field {
    @apply xl:w-1/5 sm:w-1/2 w-full p-3 flex flex-col gap-1;
}
</style>
