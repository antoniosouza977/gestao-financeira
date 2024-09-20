<script setup>
import {useForm} from "@inertiajs/vue3";
import {onBeforeMount, ref} from "vue";
import BaseForm from "@/Components/Crud/BaseForm.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import InputError from "@/Components/InputError.vue";

let categoryForm = useForm({
    method: "post",
    url: route('expense-categories.store'),
    name: null
});

const props = defineProps({
    category: {
        required: false,
        type: Object,
    }
})

const action = ref('Cadastrar');

onBeforeMount(() => {
        if (props.category) {
        categoryForm = useForm({
            method: "patch",
            url: route('expense-categories.update', props.category.id),
            ...props.category
        });
        action.value = 'Editar';
    }
})

</script>

<template>
    <AppLayout>
        <BaseForm :form="categoryForm">
            <div>
                <div class="font-semibold text-xl mb-3">{{ action }} categoria de despesa</div>
                <div class="flex flex-col flex-wrap mb-3">

                    <div class="lg:w-1/3 w-full flex flex-col p-3 gap-3">
                        <label for="name">Nome</label>
                        <InputText inputId="name"
                                   v-model="categoryForm.name"
                                   style="width: fit-content"
                                   :invalid="Boolean(categoryForm.errors.name)"
                                   class="w-full"/>
                        <InputError class="mt-2" :message="categoryForm.errors.name"/>
                    </div>

                </div>
            </div>

        </BaseForm>
    </AppLayout>

</template>

