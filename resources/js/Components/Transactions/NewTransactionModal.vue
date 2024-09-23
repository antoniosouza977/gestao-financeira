<template>
    <Button :icon="icon ? 'pi pi-plus' : ''" :label="icon ? '' : 'Nova'" @click="visible = true"/>
    <Dialog v-model:visible="visible" modal header="Nova Transação" :style="{ width: '25rem' }">
        <TransactionForm :categories="categories" :form="form" @close-modal="closeModal" :type/>
    </Dialog>
</template>

<script setup>
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";
import TransactionForm from "@/Components/Transactions/TransactionForm.vue";
import DateFormater from "@/Services/Types/DateFormater.js";

const visible = ref(false);
const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
    storeRoute: {
        type: String,
        required: true,
    },
    type: String,
    icon: Boolean
})

const form = useForm({
    method: "post",
    url: props.storeRoute,
    value: null,
    description: null,
    date: DateFormater.todayStringDate(),
    category_id: null,
})

const closeModal = () => {
    form.clearErrors()
    form.reset()
    visible.value = false
}


</script>
