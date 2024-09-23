<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import BaseForm from "@/Components/Crud/BaseForm.vue";
import {useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import {onBeforeMount, ref} from 'vue'
import DateFormater from "@/Services/Types/DateFormater.js";

let paymentForm = useForm({
    method: "post",
    url: route('incomes.store'),
    value: null,
    income_id: null,
    description: null,
    date: DateFormater.todayStringDate(),
});

const action = ref('Cadastrar');

const props = defineProps({
    payment: {
        required: false,
        type: Object,
    },
    incomes: {
        required: true,
        type: Array,
    }
})

onBeforeMount(() => {
    if (props.payment) {
        action.value = 'Editar';
        paymentForm = useForm({
            method: "patch",
            url: route('incomes.update', props.payment.id),
            ...props.payment
        });
    }
})
</script>

<template>
    <AppLayout>
        <BaseForm :title="action + ' pagamento'" :form="paymentForm">
            <div>

                    <div class="flex flex-col flex-wrap mb-3">

                        <div class="lg:w-1/3 w-full flex flex-col p-3 gap-3">
                            <label for="value">Valor</label>
                            <InputNumber inputId="value"
                                         v-model="paymentForm.value"
                                         :minFractionDigits="2"
                                         style="width: fit-content"
                                         :invalid="Boolean(paymentForm.errors.value)"
                                         class="w-full"/>
                            <InputError class="mt-2" :message="paymentForm.errors.value"/>
                        </div>

                        <div class="xl:w-1/3 lg:w-1/2 w-full flex flex-col p-3 gap-3">
                            <label for="description">Descrição</label>
                            <Textarea inputId="description" v-model="paymentForm.description"
                                      :invalid="Boolean(paymentForm.errors.description)" cols="30"/>
                            <InputError class="mt-2" :message="paymentForm.errors.description"/>
                        </div>

                        <div class="xl:w-1/3 lg:w-1/2 w-full flex flex-col p-3 gap-3">
                            <label for="income">Renda</label>
                            <Select v-model="paymentForm.income_id"
                                    :options="incomes" optionLabel="description"
                                    showClear
                                    optionValue="id"
                                    :invalid="Boolean(paymentForm.errors.income_id)"
                                    placeholder="Selecione..."/>
                            <InputError class="mt-2" :message="paymentForm.errors.income_id"/>
                        </div>


                        <div class="xl:w-1/3 lg:w-1/2 w-full flex flex-col p-3 gap-3">
                            <label for="payment_date">Data</label>
                            <InputText type="date" inputId="payment_date" v-model="paymentForm.date"
                                       showIcon
                                       :invalid="Boolean(paymentForm.errors.date)" style="width: fit-content"/>
                            <InputError class="mt-2" :message="paymentForm.errors.date"/>
                        </div>

                    </div>

            </div>

        </BaseForm>
    </AppLayout>
</template>

