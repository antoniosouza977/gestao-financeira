<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import BaseForm from "@/Components/Crud/BaseForm.vue";
import InputError from "@/Components/InputError.vue";
import {useForm} from "@inertiajs/vue3";
import {Link} from "@inertiajs/vue3";

import {onBeforeMount, ref} from "vue";

const props = defineProps({
    budgets: {
        type: Array,
        required: true,
    },
    expense: {
        type: Object,
        required: false,
    }
})

const action = ref('Cadastrar');

let expenseForm = useForm({
    method: "post",
    url: route('expenses.store'),
    value: null,
    budget_id: null,
    description: null,
    payment_day: 10,
})

onBeforeMount(() => {
    if (props.expense) {
        action.value = 'Editar';
        const expense = {...props.expense};
        expense.value = Number(expense.value);

        expenseForm = useForm({
            method: "patch",
            url: route('expenses.update', expense.id),
            ...expense
        });
    }
})

</script>

<template>
    <AppLayout>
        <BaseForm :title="action + ' Despesa Mensal'" :form="expenseForm" :back-url="route('expenses.index')">
            <div>
                    <div class="flex flex-col flex-wrap mb-3">

                        <div class="expense-form-group">
                            <label for="value">Valor</label>
                            <InputNumber inputId="value"
                                         v-model="expenseForm.value"
                                         :minFractionDigits="2"
                                         style="width: fit-content"
                                         :invalid="Boolean(expenseForm.errors.value)"
                                         class="w-full"/>
                            <InputError class="mt-2" :message="expenseForm.errors.value"/>
                        </div>

                        <div class="expense-form-group">

                            <label for="category">Orçamento</label>
                            <div class="flex gap-3">
                                <Select v-model="expenseForm.budget_id"
                                        :options="budgets" optionLabel="name"
                                        optionValue="id"
                                        class="w-5/6"
                                        :invalid="Boolean(expenseForm.errors.budget_id)"
                                        placeholder="Selecione...">
                                </Select>
                                <Link :href="route('budgets.create')">
                                    <Button icon="pi pi-plus" title="Adicionar categoria"/>
                                </Link>
                            </div>
                            <InputError class="mt-2" :message="expenseForm.errors.budget_id"/>

                        </div>

                        <div class="expense-form-group">
                            <label for="description">Descrição</label>
                            <Textarea inputId="description" v-model="expenseForm.description"
                                      :invalid="Boolean(expenseForm.errors.description)" cols="30"/>
                            <InputError class="mt-2" :message="expenseForm.errors.description"/>
                        </div>

                        <div class="expense-form-group">
                            <label for="payment_day">Dia Pagamento</label>
                            <InputNumber :min="1" :max="31" inputId="payment_day" v-model="expenseForm.payment_day"
                                         showIcon
                                         :invalid="Boolean(expenseForm.errors.payment_day)" style="width: fit-content"/>
                            <InputError class="mt-2" :message="expenseForm.errors.payment_day"/>
                            <p class="text-sm font-light">Data mensal prevista para o pagamento</p>
                        </div>

                    </div>

            </div>
        </BaseForm>
    </AppLayout>
</template>

<style>
.expense-form-group{
    @apply lg:w-1/3 md:w-1/2 w-full flex flex-col p-3 gap-3;
}
</style>

