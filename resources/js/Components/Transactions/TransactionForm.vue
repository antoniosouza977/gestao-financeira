<script setup>
import InputError from "@/Components/InputError.vue";
import BaseModalForm from "@/Components/Crud/BaseModalForm.vue";
import NewCategoryModal from "@/Components/Categories/NewCategoryModal.vue";

const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
    type: String
})

function handleNewCategory(item) {
    const lastCat = props.categories[props.categories.length - 1];

    if (lastCat.name === item.name) {
        props.form.category_id = lastCat.id;
    }
}

</script>

<template>

    <BaseModalForm :form="form" @saved="$emit('saved', $event)" @close-modal="$emit('close-modal')">
        <template v-slot:form>
            <div class="flex flex-col gap-1 mb-4">
                <label for="value" class="font-semibold">Valor</label>
                <InputNumber
                    id="value"
                    class="w-fit"
                    v-model="form.value"
                    :invalid="Boolean(form.errors.value)"
                    :min-fraction-digits="2"
                    autocomplete="off"/>
                <InputError class="mt-2" :message="form.errors.value"/>
            </div>

            <div class="flex flex-col gap-1 mb-4">
                <label for="value" class="font-semibold">Data</label>
                <InputText type="date" inputId="payment_day" v-model="form.date"
                           :invalid="Boolean(form.errors.date)" style="width: fit-content"/>
                <InputError class="mt-2" :message="form.errors.date"/>
            </div>


            <div class="flex flex-col gap-1 mb-4">
                <label for="description" class="font-semibold">Descrição (Opcional)</label>
                <Textarea
                    id="description"
                    class="flex-auto"
                    v-model="form.description"
                    :invalid="Boolean(form.errors.description)"
                    autocomplete="off"/>
                <InputError class="mt-2" :message="form.errors.description"/>
            </div>

            <div class="flex flex-col gap-1 mb-8">
                <label for="budget" class="font-semibold">Categoria</label>
                <div class="flex gap-2">
                    <Select
                        id="budget"
                        :options="categories" optionLabel="name"
                        optionValue="id"
                        class="w-5/6"
                        v-model="form.category_id"
                        showClear
                        filter
                        :invalid="Boolean(form.errors.category_id)"
                        autocomplete="off">
                        <template #empty>
                            <p>Nenhuma categoria cadastrada</p>
                        </template>
                    </Select>
                    <NewCategoryModal @new-category="handleNewCategory" :icon="true" :type/>
                </div>
                <InputError class="mt-2" :message="form.errors.category_id"/>
            </div>
        </template>
    </BaseModalForm>


</template>

