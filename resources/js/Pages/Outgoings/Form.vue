<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import BaseForm from "@/Components/Crud/BaseForm.vue";
import {useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import {onBeforeMount, ref} from 'vue'
import DateFormater from "@/Services/Types/DateFormater.js";

let outgoForm = useForm({
    method: "post",
    url: route('outgoings.store'),
    value: null,
    budget_id: null,
    description: null,
    date: DateFormater.todayStringDate(),
});

const action = ref('Cadastrar');

const props = defineProps({
    outgo: {
        required: false,
        type: Object,
    },
    budgets: {
        required: true,
        type: Array,
    }
})

console.log(props.budgets)

onBeforeMount(() => {
    if (props.outgo) {
        action.value = 'Editar';
        outgoForm = useForm({
            method: "patch",
            url: route('outgoings.update', props.outgo.id),
            ...props.outgo
        });
    }
})
</script>

<template>
    <AppLayout>
        <BaseForm :title="action + ' gasto'" :form="outgoForm">
            <div>

                <div class="flex flex-col flex-wrap mb-3">

                    <div class="lg:w-1/3 w-full flex flex-col p-3 gap-3">
                        <label for="value">Valor</label>
                        <InputNumber inputId="value"
                                     v-model="outgoForm.value"
                                     :minFractionDigits="2"
                                     style="width: fit-content"
                                     :invalid="Boolean(outgoForm.errors.value)"
                                     class="w-full"/>
                        <InputError class="mt-2" :message="outgoForm.errors.value"/>
                    </div>

                    <div class="xl:w-1/3 lg:w-1/2 w-full flex flex-col p-3 gap-3">
                        <label for="description">Descrição</label>
                        <Textarea inputId="description" v-model="outgoForm.description"
                                  :invalid="Boolean(outgoForm.errors.description)" cols="30"/>
                        <InputError class="mt-2" :message="outgoForm.errors.description"/>
                    </div>

                    <div class="xl:w-1/3 lg:w-1/2 w-full flex flex-col p-3 gap-3">
                        <label for="budget">Orçamento</label>
                        <Select v-model="outgoForm.budget_id"
                                :options="budgets" optionLabel="name"
                                showClear
                                optionValue="id"
                                :invalid="Boolean(outgoForm.errors.budget_id)"
                                placeholder="Selecione..."/>
                        <InputError class="mt-2" :message="outgoForm.errors.budget_id"/>
                    </div>


                    <div class="xl:w-1/3 lg:w-1/2 w-full flex flex-col p-3 gap-3">
                        <label for="outgo_date">Data</label>
                        <InputText type="date" inputId="outgo_date" v-model="outgoForm.date"
                                   showIcon
                                   :invalid="Boolean(outgoForm.errors.date)" style="width: fit-content"/>
                        <InputError class="mt-2" :message="outgoForm.errors.date"/>
                    </div>

                </div>

            </div>

        </BaseForm>
    </AppLayout>
</template>

