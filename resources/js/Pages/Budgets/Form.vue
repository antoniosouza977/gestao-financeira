<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import BaseForm from "@/Components/Crud/BaseForm.vue";
import InputError from "@/Components/InputError.vue";
import {useForm} from "@inertiajs/vue3";
import {Link} from "@inertiajs/vue3";

import {onBeforeMount, ref} from "vue";

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
    budget: {
        type: Object,
        required: false,
    }
})

const action = ref('Cadastrar');

let budgetForm = useForm({
    method: "post",
    url: route('budgets.store'),
    value: null,
    category_id: null,
    name: null,
    payment_day: 5,
})

onBeforeMount(() => {
    if (props.budget) {
        action.value = 'Editar';
        const budget = {...props.budget};
        budget.value = Number(budget.value);

        budgetForm = useForm({
            method: "patch",
            url: route('budgets.update', budget.id),
            ...budget
        });
    }
})

</script>

<template>
    <AppLayout>
        <BaseForm :title="action + ' Orçamento'" :form="budgetForm" :back-url="route('budgets.index')">
            <div>
                    <div class="flex flex-col flex-wrap mb-3">

                        <div class="budget-form-group">
                            <label for="value">Valor</label>
                            <InputNumber inputId="value"
                                         v-model="budgetForm.value"
                                         :minFractionDigits="2"
                                         style="width: fit-content"
                                         :invalid="Boolean(budgetForm.errors.value)"
                                         class="w-full"/>
                            <InputError class="mt-2" :message="budgetForm.errors.value"/>
                        </div>

                        <div class="budget-form-group">

                            <label for="category">Categoria</label>
                            <div class="flex gap-3">
                                <Select v-model="budgetForm.category_id"
                                        :options="categories" optionLabel="name"
                                        optionValue="id"
                                        class="w-5/6"
                                        :invalid="Boolean(budgetForm.errors.category_id)"
                                        placeholder="Selecione...">
                                </Select>
                                <Link :href="route('expense-categories.create')">
                                    <Button icon="pi pi-plus" title="Adicionar categoria"
                                            />
                                </Link>
                            </div>
                            <InputError class="mt-2" :message="budgetForm.errors.category_id"/>

                        </div>

                        <div class="budget-form-group">
                            <label for="name">Nome</label>
                            <InputText inputId="name" v-model="budgetForm.name"
                                      :invalid="Boolean(budgetForm.errors.name)"/>
                            <InputError class="mt-2" :message="budgetForm.errors.name"/>
                        </div>

                    </div>

            </div>
        </BaseForm>
    </AppLayout>
</template>

<style>
.budget-form-group{
    @apply lg:w-1/3 md:w-1/2 w-full flex flex-col p-3 gap-3;
}
</style>

