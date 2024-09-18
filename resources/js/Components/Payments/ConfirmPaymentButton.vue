<template>
    <Button @click="confirmPayment()" label="Confirmar Pagamento" outlined></Button>
</template>

<script setup>
import {useConfirm} from "primevue/useconfirm";
import {useToast} from "primevue/usetoast";
import {router} from "@inertiajs/vue3";

const emit = defineEmits(['paymentConfirmed'])

const props = defineProps({
    income: {
        required: true,
        type: Object,
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
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Confirmar'
        },
        accept: () => {
            return router.post(route('confirm-payment'), {
                income_id: props.income.id,
                description: props.income.description,
                value: props.income.value,
                date: props.income.date
            }, {
                onSuccess: () => {
                    toast.add({
                        severity: 'success',
                        summary: 'Confirmado',
                        detail: 'O pagamento foi confirmado',
                        life: 3000
                    });
                    emit('paymentConfirmed', props.income.id);
                }
            })
        },
    });
};

</script>
