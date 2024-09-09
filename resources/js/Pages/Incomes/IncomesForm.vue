<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import BaseForm from "@/Components/Crud/BaseForm.vue";
import InputError from "@/Components/InputError.vue";
import {useForm} from "@inertiajs/vue3";

export default {
    name: "IncomesForm",
    components: {InputError, BaseForm, AppLayout},
    props: ['categories'],
    data: () => {
        return {
            form: useForm({
                method: "post",
                url: route('incomes.store'),
                amount: null,
                category_id: null,
                description: null,
                date: null,
                monthly_income: null
            })
        }
    }
}
</script>

<template>
    <AppLayout>
        <BaseForm :form="form">
            <div>
                <div class="font-semibold text-xl mb-3">Cadastrar nova renda</div>
                <form>
                    <div class="flex flex-col flex-wrap mb-3 gap-3">

                        <div class="xl:w-1/3 lg:w-1/2 w-full flex flex-col gap-3">
                            <label for="amount">Valor</label>
                            <InputNumber inputId="amount"
                                         v-model="form.amount"
                                         :minFractionDigits="2"
                                         fluid
                                         :invalid="Boolean(form.errors.amount)"
                                         class="w-full"/>
                            <InputError class="mt-2" :message="form.errors.amount"/>
                        </div>

                        <div class="xl:w-1/3 lg:w-1/2 w-full flex flex-col gap-3">
                            <label for="category">Categoria</label>
                            <Select inputId="category" v-model="form.category_id" :options="categories"
                                    optionLabel="name"
                                    optionValue="id"
                                    :invalid="Boolean(form.errors.category_id)"
                                    placeholder="Selecione uma categoria" class="w-full"/>
                            <InputError class="mt-2" :message="form.errors.category_id"/>
                        </div>

                        <div class="xl:w-1/3 lg:w-1/2 w-full flex flex-col gap-3">
                            <label for="date">Data</label>
                            <DatePicker inputId="date" v-model="form.date" showIcon :invalid="Boolean(form.errors.date)"
                                        dateFormat="dd/mm/yy" fluid :showOnFocus="false"/>
                            <InputError class="mt-2" :message="form.errors.date"/>
                        </div>


                        <div class="xl:w-1/2 flex flex-col gap-3">
                            <label for="description">Descrição</label>
                            <Textarea inputId="description" v-model="form.description"
                                      :invalid="Boolean(form.errors.description)" cols="30"/>
                            <InputError class="mt-2" :message="form.errors.description"/>
                        </div>

                    </div>

                    <div class="font-semibold text-lg mb-3">Informaçoes Adicionais:</div>
                    <div class="flex items-center gap-3">
                        <Checkbox inputId="monthly" v-model="form.monthly_income" :binary="true"/>
                        <label for="monthly">Renda mensal</label>
                    </div>

                </form>
            </div>
        </BaseForm>
    </AppLayout>
</template>

