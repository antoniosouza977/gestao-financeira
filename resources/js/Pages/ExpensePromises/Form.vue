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


const action = ref('Nova');

let form = useForm({
    method: "post",
    url: route('expense-promises.store'),
    value: null,
    category_id: null,
    description: null,
    period_type: '3',
    period_value: null,
    payment_day: 10,
})

onBeforeMount(() => {
    if (props.promise) {
        action.value = 'Editar';
        const promise = {...props.promise};
        promise.value = Number(promise.value);

        form = useForm({
            method: "patch",
            url: route('expense-promises.update', promise.id),
            ...promise
        });
    }
})

</script>

<template>
    <AppLayout>
        <BaseForm :title="action + ' Despesa Recorrente'" :form="form">
            <TransactionPromiseForm :form :categories type="2"/>
        </BaseForm>
    </AppLayout>
</template>



