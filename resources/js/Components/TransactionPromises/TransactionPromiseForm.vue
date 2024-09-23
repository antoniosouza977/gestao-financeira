<script setup>
import InputError from "@/Components/InputError.vue";
import NewCategoryModal from "@/Components/Categories/NewCategoryModal.vue";

const period_types = [
    {label: 'Diária', value: '1'},
    {label: 'Semanal', value: '2'},
    {label: 'Mensal', value: '3'},
    {label: 'Anual', value: '4'},
    {label: 'Parcela', value: '5'}
];

const week = [
    {day: 'Domingo', value: '1'},
    {day: 'Segunda-Feira', value: '2'},
    {day: 'Terça-Feira', value: '3'},
    {day: 'Quarta-Feira', value: '4'},
    {day: 'Quinta-Feira', value: '5'},
    {day: 'Sexta-Feira', value: '6'},
    {day: 'Sábado', value: '7'}
];

const periodLabels = [
    'Dia da semana',
    'Dia do mês',
    'Mes do ano',
    'Quantidade de parcelas'
];

const months = [
    {name: "Janeiro", value: '1'},
    {name: "Fevereiro", value: '2'},
    {name: "Março", value: '3'},
    {name: "Abril", value: '4'},
    {name: "Maio", value: '5'},
    {name: "Junho", value: '6'},
    {name: "Julho", value: '7'},
    {name: "Agosto", value: '8'},
    {name: "Setembro", value: '9'},
    {name: "Outubro", value: '10'},
    {name: "Novembro", value: '11'},
    {name: "Dezembro", value: '12'}
];

const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
    type: {
        type: String,
        required: true,
    }
})

const handleNewCategory = () => {
    props.form.category_id = props.categories[props.categories.length - 1].id;
}
</script>

<template>
    <div>
        <div class="flex flex-wrap mb-3">

            <div class="promise-form-group">
                <label for="value">Valor</label>
                <InputNumber inputId="value"
                             v-model="form.value"
                             :minFractionDigits="2"
                             :invalid="Boolean(form.errors.value)"
                             class="w-full"/>
                <InputError class="mt-2" :message="form.errors.value"/>
            </div>

            <div class="promise-form-group">
                <label for="period_type">Recorrência</label>
                <div class="flex gap-3">
                    <Select v-model="form.period_type"
                            id="period_type"
                            :options="period_types"
                            optionLabel="label"
                            optionValue="value"
                            class="w-full"
                            @change="form.period_value = null"
                            :invalid="Boolean(form.errors.period_type)"
                            placeholder="Selecione...">
                    </Select>
                </div>
                <InputError class="mt-2" :message="form.errors.period_type"/>
            </div>

            <div v-if="form.period_type !== '1'" class="promise-form-group">

                <label for="period">
                    {{ periodLabels[form.period_type - 2] }}
                </label>

                <template v-if="form.period_type === '2'">
                    <Select inputId="period" v-model="form.period_value" :options="week"
                            optionLabel="day"
                            optionValue="value"
                            showClear
                            :invalid="Boolean(form.errors.period_value)" class="w-full"/>
                </template>

                <template v-if="form.period_type === '3'">
                    <InputNumber :min="1" :max="31" inputId="period" v-model="form.period_value"
                                 :invalid="Boolean(form.errors.period_value)" style="width: fit-content;"/>
                </template>

                <template v-if="form.period_type === '4'">
                    <Select inputId="period" v-model="form.period_value" :options="months" optionLabel="name"
                            optionValue="value" class="w-full"
                            :invalid="Boolean(form.errors.period_value)"/>
                </template>

                <template v-if="form.period_type === '5'">
                    <InputNumber :min="1" :max="999" inputId="period" v-model="form.period_value"
                                 :invalid="Boolean(form.errors.period_value)" style="width: fit-content;"/>
                </template>

                <InputError class="mt-2" :message="form.errors.period_value"/>

            </div>

        </div>
        <div class="flex flex-wrap">

            <div class="promise-form-group">

                <label for="category">Categoria</label>
                <div class="flex gap-3">
                    <Select v-model="form.category_id"
                            :options="categories" optionLabel="name"
                            optionValue="id"
                            class="w-5/6"
                            showClear
                            :invalid="Boolean(form.errors.category_id)"
                            placeholder="Selecione...">
                    </Select>
                    <NewCategoryModal :icon="true" @saved="handleNewCategory" :type="type" />
                </div>
                <InputError class="mt-2" :message="form.errors.category_id"/>

            </div>

            <div class="w-full flex flex-col p-3 gap-3">
                <label for="description">Descrição</label>
                <Textarea inputId="description" v-model="form.description"
                          :invalid="Boolean(form.errors.description)" cols="30"/>
                <InputError class="mt-2" :message="form.errors.description"/>
            </div>


        </div>

    </div>
</template>

<style>
.promise-form-group {
    @apply lg:w-1/3 md:w-1/2 w-full flex flex-col p-3 gap-3;
}
</style>
