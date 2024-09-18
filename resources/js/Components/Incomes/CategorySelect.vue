<script setup>
import InputError from "@/Components/InputError.vue";
import {router, useForm} from "@inertiajs/vue3";
import {useToast} from "primevue/usetoast";
import {ref} from "vue";
import 'vue-sweetalert2';


const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
    incomeForm: {
        type: Object,
        required: true,
    }
})

let categoryFormVisibility = ref(false)
let categoryForm = ref({})

const toast = useToast()

const editCategory = (category) => {
    categoryForm = useForm({
        method: "patch",
        url: route('income-categories.update', category.id),
        ...category
    })
    categoryFormVisibility = true
}

const saveCategory = () => {
    categoryForm.submit(categoryForm.method, categoryForm.url, {
        onSuccess: () => {
            toast.add({
                severity: 'success',
                summary: 'Sucesso',
                detail: 'Categoria salva!',
                life: 3000
            });
            categoryForm.name = null
            categoryForm.id = null
            categoryFormVisibility.value = false
        }
    });
}

const removeCategory = (category) => {
    swal({
        title: "Tem certeza?",
    }).then((result) => {
        if (result.isConfirmed) {
            const url = route('income-categories.destroy', category.id);
            router.delete(url, {
                onSuccess: () => {
                    toast.add({
                        severity: 'success',
                        summary: 'Sucesso',
                        detail: 'Categoria Removida!',
                        life: 3000
                    });
                }
            })
        }
    });
}

const clearCategoryForm = () => {
    console.log(categoryFormVisibility.value)
    categoryFormVisibility.value = !categoryFormVisibility.value
    console.log(categoryFormVisibility.value)
    categoryForm = useForm({
        method: "post",
        url: route('income-categories.store'),
        name: null
    });
}

</script>

<template>
    <div class="lg:w-1/3 md:w-1/2 w-full flex flex-col p-3 gap-3">

        <label for="category">Categoria</label>
        <div class="flex gap-3">
            <Select v-if="!categoryFormVisibility" v-model="incomeForm.category_id"
                    :options="categories" optionLabel="name"
                    optionValue="id"
                    class="w-5/6"
                    :invalid="Boolean(incomeForm.errors.category_id)"
                    placeholder="Selecione...">

                <template #option="slotProps">
                    <div class="flex items-center justify-between w-full gap-3">
                        <div>{{ slotProps.option.name }}</div>
                        <div v-if="slotProps.option.user_id" class="flex gap-2">
                            <Button icon="pi pi-pencil" outlined severity="warn" size="small" title="Editar categoria"
                                    @click.prevent="editCategory(slotProps.option)"/>
<!--                            <DeleteButton :icon="true" :url="route('income-categories.destroy', slotProps.option.id)"/>-->
                            <Button icon="pi pi-trash" outlined severity="danger" size="small" title="Remover categoria"
                                    @click.prevent="removeCategory(slotProps.option)"/>
                        </div>
                    </div>
                </template>

            </Select>
            <Button v-if="!categoryFormVisibility" icon="pi pi-plus" outlined title="Adicionar categoria"
                    @click.prevent="clearCategoryForm"/>
        </div>
        <InputError class="mt-2" :message="incomeForm.errors.category_id"/>

        <div v-if="categoryFormVisibility" class="flex flex-col">
            <InputGroup>
                <Button icon="pi pi-check" severity="success" outlined title="Salvar"
                        @click.prevent="saveCategory"/>
                <InputText v-model="categoryForm.name" :invalid="Boolean(categoryForm.errors.name)"
                           placeholder="Nome da Categoria"/>
                <Button icon="pi pi-times" severity="danger" outlined title="Cancelar"
                        @click.prevent="clearCategoryForm"/>
            </InputGroup>
            <InputError class="mt-2" :message="categoryForm.errors.name"/>
        </div>

    </div>
</template>

<style scoped lang="scss">

</style>
