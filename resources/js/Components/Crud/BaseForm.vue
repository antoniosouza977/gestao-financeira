<script setup>
import BackButton from "@/Components/Partials/BackButton.vue";
import {useToast} from "primevue/usetoast";

const toast = useToast();
const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
    backUrl: String
})

const submitForm = () => {
    props.form.submit(props.form.method, props.form.url, {
        onSuccess: () => {
            toast.add({
                severity: 'success',
                summary: 'Sucesso',
                detail: 'Registro salvo com sucesso',
                life: 3000
            });
        }
    })
}

</script>

<template>
    <Fluid>
        <div class="card flex flex-col w-full crud-container">
            <div class="w-full flex justify-end items-center mb-3">
                <BackButton :back-url="backUrl"/>
            </div>
            <form @submit.prevent="submitForm">
                <slot></slot>
            </form>
            <div class="mt-auto">
                <Button @click.prevent="submitForm" style="width: fit-content" label="Salvar" rounded/>
            </div>
        </div>
    </Fluid>
</template>

<style scoped lang="scss">
.crud-container {
    min-height: calc(100vh - 12rem);
}
</style>
