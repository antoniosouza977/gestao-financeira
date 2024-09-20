<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import NumberFormater from "@/Services/Types/NumberFormater.js";
import DeleteButton from "@/Components/Partials/DeleteButton.vue";
import Index from "@/Components/Crud/Index.vue";
import CustomPaginator from "@/Components/Crud/CustomPaginator.vue";
import EditButton from "@/Components/Partials/EditButton.vue";

const props = defineProps({
    budgets: {
        type: Array,
        required: false,
    }
})
</script>

<template>
    <AppLayout>
        <Index title="Meus Orçamentos" :create-route="route('budgets.create')" button-label="Novo Orçamento">

            <div class="mt-3 font-light italic" v-if="budgets.data.length === 0">
                <h3>Nenhum orçamento cadastrado ainda...</h3>
            </div>

            <div v-if="budgets.length" class="w-full">
                <Badge size="large">Orçamentos cadastrados</Badge>
                <Divider/>
            </div>

            <div v-for="budget in budgets.data" :key="budget.id" class="flex flex-wrap items-center w-full rounded">

                <div class="budget-field">
                    <label class="font-bold" for="">Valor: </label>
                    <Badge size="large" class="w-fit">
                        {{ NumberFormater.toLocalCurrency(budget.value) }}
                    </Badge>
                </div>

                <div class="budget-field">
                    <label class="font-bold" for="">Categoria: </label>
                    {{ budget.category.name }}
                </div>

                <div class="budget-field">
                    <label class="font-bold" for="">Nome: </label>
                    {{ budget.name || 'Sem descrição' }}
                </div>

                <div class="budget-field">
                    <label class="font-bold" for="">Ações: </label>
                    <div class="flex gap-3">
                        <EditButton :href="route('budgets.edit', budget.id)"/>
                        <DeleteButton icon="true" :url="route('budgets.destroy', budget)"/>
                    </div>
                </div>

                <Divider/>
            </div>

            <CustomPaginator :index-route="route('budgets.index')" :laravel-paginator="budgets"/>
        </Index>
    </AppLayout>
</template>

<style scoped>
.budget-field {
    @apply xl:w-1/5 sm:w-1/2 w-full p-3 flex flex-col gap-1;
}
</style>
