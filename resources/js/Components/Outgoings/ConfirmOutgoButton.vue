<template>
    <Button @click="confirmOutgo()" label="Confirmar Gasto"></Button>
</template>

<script setup>
import {useConfirm} from "primevue/useconfirm";
import {useToast} from "primevue/usetoast";
import {router} from "@inertiajs/vue3";

const emit = defineEmits(['outgoConfirmed'])

const props = defineProps({
    expense: {
        required: true,
        type: Object,
    }
})

const confirm = useConfirm();
const toast = useToast();

const confirmOutgo = () => {
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
            return router.post(route('confirm-outgo'), {
                expense_id: props.expense.id,
                description: props.expense.description,
                value: props.expense.value,
                date: props.expense.date
            }, {
                onSuccess: () => {
                    toast.add({
                        severity: 'success',
                        summary: 'Confirmado',
                        detail: 'O pagamento foi confirmado',
                        life: 3000
                    });
                    emit('outgoConfirmed', props.expense.id);
                }
            })
        },
    });
};

</script>
