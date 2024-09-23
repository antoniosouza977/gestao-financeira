<template>
    <Button icon="pi pi-pen-to-square" title="Editar" severity="warn" @click="visible = true"/>
    <Dialog v-model:visible="visible" modal header="Editar Transação" :style="{ width: '25rem' }">
        <TransactionForm :form @close-modal="visible = false" @saved="refreshFormData" :categories/>
    </Dialog>
</template>

<script setup>
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";
import TransactionForm from "@/Components/Transactions/TransactionForm.vue";

const props = defineProps({
    transaction: {
        type: Object,
        required: true
    },
    categories: {
        type: Array,
        required: true,
    },
    updateRoute: {
        type: String,
        required: true,
    }
})

const refreshFormData = (item) => {
    form = useForm({...item})
}

let form = useForm({
    method: "patch",
    url: props.updateRoute,
    ...props.transaction
})

const visible = ref(false);

</script>
