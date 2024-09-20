<script setup>
import Index from "@/Components/Crud/Index.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import DeleteButton from "@/Components/Partials/DeleteButton.vue";
import CustomPaginator from "@/Components/Crud/CustomPaginator.vue";
import EditButton from "@/Components/Partials/EditButton.vue";

const props = defineProps({
    categories: {
        type: Array,
        required: false,
    }
})
</script>

<template>
    <AppLayout>
        <Index title="Categorias de Rendas" :create-route="route('income-categories.create')" button-label="Nova Categoria">

            <div v-for="category in categories.data" :key="category.id"
                 class="flex flex-wrap items-center w-full p-3 rounded">

                <div class="xl:w-1/5 sm:w-1/2 w-full p-3 flex flex-col gap-3">
                    <label class="font-bold" for="">Nome da Categoria: </label>
                    {{ category.name }}
                </div>

                <div class="xl:w-1/5 sm:w-1/2 w-full p-3 flex flex-col gap-3">
                    <label class="font-bold" for="">Ações: </label>
                    <div v-if="category.user_id" class="flex gap-3">
                        <EditButton :href="route('income-categories.edit', category.id)"/>
                        <DeleteButton icon="true" :url="route('income-categories.destroy', category)"/>
                    </div>
                    <Badge v-else size="large" class="w-fit" severity="secondary">Categoria Padrão</Badge>
                </div>

                <Divider/>

            </div>

            <CustomPaginator :laravel-paginator="categories" :index-route="route('income-categories.index')"/>

        </Index>
    </AppLayout>

</template>
