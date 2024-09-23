<script setup>
import {ref} from "vue";
import {router, useForm} from "@inertiajs/vue3";
import {useToast} from "primevue/usetoast";
import {useConfirm} from "primevue/useconfirm";

const visible = ref(false)
const toast = useToast()
const props = defineProps({
    icon: String,
    category: {
        type: Object,
        required: true
    },
    categories: {
        type: Array,
        required: true,
    }
})

const availableCategories = ref(null)
const confirm = useConfirm();
const loading = ref(false);

const deleteBudget = async () => {
    loading.value = true;
    if (await isUsed()) {
        await getAvailableBudgets()
        visible.value = true
        loading.value = false
        return;
    }
    loading.value = false
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
            return router.delete(route('categories.destroy', props.category), {
                onSuccess: () => {
                    toast.add({
                        severity: 'success',
                        summary: 'Sucesso',
                        detail: 'Registro removido',
                        life: 3000
                    });
                }
            })
        },
    });
}

const form = useForm({
    id: null
})

const deleteUsedBudget = () => {
    const url = route('categories.migrateToDestroy', props.category);
    form.post(url, {
        onSuccess: () => {
            toast.add({
                severity: 'success',
                summary: 'Sucesso',
                detail: 'Registro removido',
                life: 3000
            });
        }
    })
}

const getAvailableBudgets = async () => {
    const resp = await axios.get(route('categories.listToMigrate', props.category));
    availableCategories.value = resp.data.categories;
}

const isUsed = async () => {
    const resp = await axios.get(route('categories.checkToDelete', props.category))
    return resp.data.isUsed;
}

</script>

<template>

    <Dialog v-model:visible="visible" modal header="Categoria em uso!" :style="{ width: '25rem' }">
        <p class="font-semibold bg-emphasis w-fit p-1 px-2 rounded mb-4">Deseja mover as movimentações pertencentes a
            esta categoria para outra?</p>
        <Select
            id="category"
            :options="availableCategories" optionLabel="name"
            optionValue="id"
            class="w-full mb-8"
            v-model="form.id"
            placeholder="Selecione"
            showClear
            autocomplete="off"/>
        <div class="flex justify-end gap-2">
            <Button type="button" label="Cancelar" severity="secondary" @click="visible = false"></Button>
            <Button type="button" label="Confirmar" :loading="form.processing" @click="deleteUsedBudget"></Button>
        </div>
    </Dialog>

    <Button
        :icon="icon ? 'pi pi-trash' : null"
        :label="icon ? null : 'Remover'"
        severity="danger"
        :loading="loading"
        @click="deleteBudget"
        title="Remover"
    />
</template>

<style scoped>

</style>
