<template>
    <Button icon="pi pi-pen-to-square" title="Editar" severity="warn" @click="visible = true"/>
    <Dialog v-model:visible="visible" modal header="Editar Categoria" :style="{ width: '25rem' }">
        <CategoryForm :form="form" @close-modal="visible = false" @saved="refreshFormData"/>
    </Dialog>
</template>

<script setup>
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";
import CategoryForm from "@/Components/Categories/CategoryForm.vue";

const props = defineProps({
    category: {
        type: Object,
        required: true
    }
})



const refreshFormData = (item) => {
    form = useForm({...item})
}

let form = useForm({
    method: "patch",
    url: route('categories.update', props.category),
    ...props.category
})

const visible = ref(false);

</script>
