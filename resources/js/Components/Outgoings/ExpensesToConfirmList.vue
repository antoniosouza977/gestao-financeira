<script setup>
import {ref} from "vue";
import InputError from "@/Components/InputError.vue";
import ConfirmOutgoButton from "@/Components/Outgoings/ConfirmOutgoButton.vue";

const props = defineProps({
    expensesWithNoOutgo: {
        required: false,
        type: Array,
    }
})

const expenses = ref([...props.expensesWithNoOutgo])
const removeExpenseConfirmed = (id) => {
    expenses.value = expenses.value.filter(item => item.id !== id);
}
</script>

<template>
    <div class="w-full mb-3">
        <Accordion value="0">
            <AccordionPanel value="1">
                <AccordionHeader class="w-full" >
                    <span class="flex gap-3">
                    Gastos de Despesas Mensais não confirmadas
                    <Badge severity="warn">{{expenses.length}}</Badge>
                    </span>
                </AccordionHeader>
                <AccordionContent>
                    <div v-for="expense in expenses" :key="expense.id"
                         class="flex flex-wrap items-center w-full rounded">
                        <Divider/>
                        <div class="w-full pb-3">
                            <Badge size="large" severity="warn">
                                Despesa mensal não confirmada
                            </Badge>
                        </div>

                        <div class="xl:w-1/5 lg:w-1/3 w-1/2 flex flex-col justify-start flex-wrap gap-2 p-3 pl-0">
                            <label class="font-bold w-full" for="value">Valor: </label>
                            <InputNumber fluid inputId="value" :min-fraction-digits="2" v-model="expense.value"
                                         class="w-fit"
                                         :invalid="Boolean($page.props.errors.value)"/>

                            <InputError class="mt-2" :message="$page.props.errors.value"/>
                        </div>

                        <div class="xl:w-1/5 lg:w-1/3 w-1/2 flex flex-wrap flex-col gap-2 p-3 pl-0">
                            <label class="font-bold w-full" for="date">Data: </label>
                            <InputText :invalid="Boolean($page.props.errors.date)"
                                       inputId="date" type="date" v-model="expense.date"
                                       class="w-fit"
                            />
                            <InputError class="mt-2" :message="$page.props.errors.date"/>
                        </div>

                        <div class="xl:w-1/5 lg:w-1/3 md:w-1/2 w-full flex flex-col flex-wrap gap-2 p-3 pl-0">
                            <label class="font-bold w-full" for="">Orçamento: </label>
                            {{ expense.budget.name }}
                        </div>

                        <div class="xl:w-1/5 lg:w-1/3 md:w-1/2 w-full flex flex-col flex-wrap gap-2 p-3 pl-0">
                            <label class="font-bold" for="">Descrição: </label>
                            {{ expense.description || 'Sem descrição' }}
                        </div>


                        <div class="xl:w-1/5 w-full flex flex-wrap gap-2 p-3 pl-0">
                            <div class="w-full">
                                <ConfirmOutgoButton @outgo-confirmed="removeExpenseConfirmed" :expense="expense"/>
                            </div>
                        </div>


                    </div>
                </AccordionContent>
            </AccordionPanel>

        </Accordion>
    </div>

</template>

<style scoped lang="scss">

</style>
