<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import BaseForm from "@/Components/Crud/BaseForm.vue";
import {useForm} from "@inertiajs/vue3";
import {onBeforeMount, ref} from "vue";
import TransactionPromiseForm from "@/Components/TransactionPromises/TransactionPromiseForm.vue";

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
    promise: {
        type: Object,
        required: false,
    }
})

let form = useForm({
    method: "post",
    url: route('income-promises.store'),
    value: null,
    category_id: null,
    description: null,
    period_type: '3',
    period_value: null,
    payment_day: 10,
})

onBeforeMount(() => {
    if (props.promise) {
        const promise = {...props.promise};
        promise.value = Number(promise.value);

        form = useForm({
            method: "patch",
            url: route('income-promises.update', promise.id),
            ...promise
        });
    }
})

</script>

<template>
    <AppLayout>
        <BaseForm title="Agendamento de Receita" :form="form" :back-url="route('income-promises.index')">
            <TransactionPromiseForm type="1" :form :categories/>
        </BaseForm>
    </AppLayout>
</template>



