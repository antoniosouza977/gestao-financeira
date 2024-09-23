<template>
    <Button @click="confirmPayment()" label="Confirmar Pagamento"></Button>
</template>

<script setup>
import {useConfirm} from "primevue/useconfirm";
import {useToast} from "primevue/usetoast";
import {router} from "@inertiajs/vue3";

const emit = defineEmits(['transactionConfirmed'])

const props = defineProps({
    promise: {
        required: true,
        type: Object,
    },
    confirmRoute: {
        type: String,
        required: true,
    }
})

const confirm = useConfirm();
const toast = useToast();

const confirmPayment = () => {
    confirm.require({
        message: 'Tem certeza que deseja proceder?',
        header: 'Confirmação',
        rejectProps: {
            label: 'Cancelar',
            severity: 'secondary'
        },
        acceptProps: {
            label: 'Confirmar'
        },
        accept: () => {
            return router.post(props.confirmRoute, {
                transaction_promise_id: props.promise.id,
                description: props.promise.description,
                value: props.promise.value,
                date: props.promise.date,
                category_id: props.promise.category_id,
            }, {
                onSuccess: () => {
                    toast.add({
                        severity: 'success',
                        summary: 'Transação',
                        detail: 'Confirmada',
                        life: 3000
                    });
                    emit('transactionConfirmed', props.promise.id);
                }
            })
        },
    });
};

</script>
