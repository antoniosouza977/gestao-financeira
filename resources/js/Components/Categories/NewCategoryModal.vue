<template>
    <Button :icon="icon ? 'pi pi-plus' : ''" :label title="Nova categoria" @click="visible = true"/>
    <Dialog v-model:visible="visible" modal header="Nova categoria" :style="{ width: '25rem' }">
        <CategoryForm :form="form" @saved="alertNewCategory" @close-modal="visible = false"/>
    </Dialog>
</template>

<script setup>
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";
import CategoryForm from "@/Components/Categories/CategoryForm.vue";

const props = defineProps({
    type: {
        type: String,
        required: true,
    },
    label: String,
    icon: Boolean,
})

const emit = defineEmits(['new-category']);

function alertNewCategory(ev) {
    emit('new-category', ev);
}

const form = useForm({
    method: "post",
    url: route('categories.store'),
    name: null,
    type: props.type
})

const visible = ref(false);

</script>
