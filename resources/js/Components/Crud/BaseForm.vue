<script>
import BackButton from "@/Components/Partials/BackButton.vue";
import {useToast} from "vue-toastification";
import {useForm} from "@inertiajs/vue3";

export default {
    name: "BaseForm",
    props: ['form'],
    components: {BackButton},
    data: () => {
        return {
            toast: useToast()
        }
    },
    methods: {
        submitForm() {
            this.form.submit(this.form.method, this.form.url, {
                onSuccess: () => {
                    this.toast.success('Registro salvo com sucesso!')
                }
            })
        }
    }
}
</script>

<template>
    <Fluid>
        <div class="card flex flex-col w-full crud-container">
            <div class="w-full flex justify-end items-center mb-3">
                <BackButton/>
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
