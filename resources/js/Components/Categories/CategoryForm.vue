<script setup>
import InputError from "@/Components/InputError.vue";
import BaseModalForm from "@/Components/Crud/BaseModalForm.vue";

const props = defineProps({
    form: {
        type: Object,
        required: true,
    }
})

</script>

<template>
    <BaseModalForm :form="form" @saved="$emit('saved')" @close-modal="$emit('close-modal')">
        <template v-slot:form>
            <div class="flex flex-col gap-1 mb-4">
                <label for="name">Nome</label>
                <InputText
                    id="name"
                    class="flex-auto"
                    v-model="form.name"
                    :invalid="Boolean(form.errors.name)"
                    autocomplete="off"/>
                <InputError class="mt-2" :message="form.errors.name"/>
            </div>

        </template>
    </BaseModalForm>

</template>

