<script setup>
import {ref} from "vue";
import InputError from "@/Components/InputError.vue";
import ConfirmPaymentButton from "@/Components/Payments/ConfirmPaymentButton.vue";

const props = defineProps({
    incomesWithNoPayment: {
        required: false,
        type: Array,
    }
})

const incomes = ref([...props.incomesWithNoPayment])
const removeIncomeConfirmed = (id) => {
    incomes.value = incomes.value.filter(item => item.id !== id);
}
</script>

<template>

    <div v-for="income in incomes" :key="income.id"
         class="flex flex-wrap items-center w-full rounded">

        <div class="w-full pb-3">
            <Badge size="large" severity="warn">
                Renda mensal não confirmada
            </Badge>
        </div>

        <div class="xl:w-1/5 lg:w-1/3 w-1/2 flex flex-col justify-start flex-wrap gap-2 p-3 pl-0">
            <label class="font-bold w-full" for="value">Valor: </label>
            <InputNumber fluid inputId="value" :min-fraction-digits="2" v-model="income.value" class="w-fit"
                         :invalid="Boolean($page.props.errors.value)"/>

            <InputError class="mt-2" :message="$page.props.errors.value"/>
        </div>

        <div class="xl:w-1/5 lg:w-1/3 w-1/2 flex flex-wrap flex-col gap-2 p-3 pl-0">
            <label class="font-bold w-full" for="date">Data: </label>
            <InputText :invalid="Boolean($page.props.errors.date)"
                       inputId="date" type="date" v-model="income.date"
                       class="w-fit"
            />
            <InputError class="mt-2" :message="$page.props.errors.date"/>
        </div>

        <div class="xl:w-1/5 lg:w-1/3 md:w-1/2 w-full flex flex-col flex-wrap gap-2 p-3 pl-0">
            <label class="font-bold w-full" for="">Categoria: </label>
            {{ income.category.name }}
        </div>

        <div class="xl:w-1/5 lg:w-1/3 md:w-1/2 w-full flex flex-col flex-wrap gap-2 p-3 pl-0">
            <label class="font-bold" for="">Descrição: </label>
            {{ income.description || 'Sem descrição' }}
        </div>


        <div class="xl:w-1/5 w-full flex flex-wrap gap-2 p-3 pl-0">
            <div class="w-full">
                <ConfirmPaymentButton @payment-confirmed="removeIncomeConfirmed" :income="income"/>
            </div>
        </div>

        <Divider/>

    </div>
</template>

<style scoped lang="scss">

</style>
