<script setup>
import Index from "@/Components/Crud/Index.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import CustomPaginator from "@/Components/Crud/CustomPaginator.vue";
import EditCategoryModal from "@/Components/Categories/EditCategoryModal.vue";
import DeleteCategoryButton from "@/Components/Categories/DeleteCategoryButton.vue";
import NewCategoryModal from "@/Components/Categories/NewCategoryModal.vue";
import {Head} from "@inertiajs/vue3";

const props = defineProps({
    categories: {
        type: Array,
        required: false,
    },
    type: {
        type: String,
        required: true,
    }
})
const labels = ['Receitas', 'Despesas'];

</script>

<template>
    <AppLayout>
        <Head title="Categorias"/>

        <Index :title="'Categorias de ' + labels[props.type - 1]" button-label="Nova Categoria">

            <template v-slot:new-btn>
                <NewCategoryModal :icon="false" label="Nova" :type="props.type"/>
            </template>

            <template v-slot:content>

                <div class="mt-3" v-if="categories.data.length === 0">
                    <Badge severity="secondary" size="large">Nenhuma categoria cadastrada</Badge>
                </div>

                <div v-for="category in categories.data" :key="category.id"
                     class="flex flex-wrap items-center justify-between w-full rounded">

                    <div class="xl:w-1/5 sm:w-1/2 w-full p-3 pl-0 flex flex-col gap-1">
                        <label class="font-bold" for="">Nome da Categoria: </label>
                        {{ category.name }}
                    </div>

                    <div class="xl:w-1/5 sm:w-1/2 w-full p-3 pl-0 flex flex-col gap-1">
                        <label class="font-bold" for="">Ações: </label>
                        <div class="flex gap-3">
                            <EditCategoryModal :category/>
                            <DeleteCategoryButton icon="true" :categories :category/>
                        </div>
                    </div>

                    <Divider/>

                </div>

                <CustomPaginator :laravel-paginator="categories"/>
            </template>
        </Index>
    </AppLayout>

</template>
