<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import BaseForm from "@/Components/Crud/BaseForm.vue";
import InputError from "@/Components/InputError.vue";
import {useForm} from "@inertiajs/vue3";
import {Link} from "@inertiajs/vue3";

import {onBeforeMount} from "vue";

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
    income: {
        type: Object,
        required: false,
    }
})

let incomeForm = useForm({
    method: "post",
    url: route('incomes.store'),
    value: null,
    category_id: null,
    description: null,
    payment_day: 5,
})

onBeforeMount(() => {
    if (props.income) {
        const income = {...props.income};
        income.value = Number(income.value);

        incomeForm = useForm({
            method: "patch",
            url: route('incomes.update', income.id),
            ...income
        });
    }
})

</script>

<template>
    <AppLayout>
        <BaseForm :form="incomeForm" :back-url="route('incomes.index')">
            <div>
                <div class="font-semibold text-xl mb-3">Cadastrar nova renda</div>

                    <div class="flex flex-col flex-wrap mb-3">

                        <div class="lg:w-1/3 w-full flex flex-col p-3 gap-3">
                            <label for="value">Valor</label>
                            <InputNumber inputId="value"
                                         v-model="incomeForm.value"
                                         :minFractionDigits="2"
                                         style="width: fit-content"
                                         :invalid="Boolean(incomeForm.errors.value)"
                                         class="w-full"/>
                            <InputError class="mt-2" :message="incomeForm.errors.value"/>
                        </div>

                        <div class="lg:w-1/3 md:w-1/2 w-full flex flex-col p-3 gap-3">

                            <label for="category">Categoria</label>
                            <div class="flex gap-3">
                                <Select v-model="incomeForm.category_id"
                                        :options="categories" optionLabel="name"
                                        optionValue="id"
                                        class="w-5/6"
                                        :invalid="Boolean(incomeForm.errors.category_id)"
                                        placeholder="Selecione...">
                                </Select>
                                <Link :href="route('income-categories.create')">
                                    <Button icon="pi pi-plus" outlined title="Adicionar categoria"
                                            />
                                </Link>
                            </div>
                            <InputError class="mt-2" :message="incomeForm.errors.category_id"/>


                        </div>

                        <div class="xl:w-1/3 lg:w-1/2 w-full flex flex-col p-3 gap-3">
                            <label for="description">Descrição</label>
                            <Textarea inputId="description" v-model="incomeForm.description"
                                      :invalid="Boolean(incomeForm.errors.description)" cols="30"/>
                            <InputError class="mt-2" :message="incomeForm.errors.description"/>
                        </div>

                        <div class="xl:w-1/3 lg:w-1/2 w-full flex flex-col p-3 gap-3">
                            <label for="payment_day">Dia Pagamento</label>
                            <InputNumber :min="1" :max="31" inputId="payment_day" v-model="incomeForm.payment_day"
                                         showIcon
                                         :invalid="Boolean(incomeForm.errors.payment_day)" style="width: fit-content"/>
                            <InputError class="mt-2" :message="incomeForm.errors.payment_day"/>
                            <p class="text-sm font-light">Data mensal prevista para o pagamento</p>
                        </div>

                    </div>

            </div>
        </BaseForm>
    </AppLayout>
</template>

