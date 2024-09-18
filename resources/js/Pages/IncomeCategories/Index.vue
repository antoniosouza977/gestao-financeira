<script setup>
import Index from "@/Components/Crud/Index.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import NumberFormater from "@/Services/Types/NumberFormater.js";
import {Link} from "@inertiajs/vue3";
import DeleteButton from "@/Components/Partials/DeleteButton.vue";

const props = defineProps({
    categories: {
        type: Array,
        required: false,
    }
})
</script>

<template>
    <AppLayout>
        <Index :create-route="route('income-categories.create')" button-label="Nova Categoria">

            <div class="w-full">
                <Badge size="large">Minhas Categorias</Badge>
                <Divider/>
            </div>

            <div v-for="category in categories" :key="category.id" class="flex flex-wrap items-center w-full p-3 rounded">

                <div class="xl:w-1/5 sm:w-1/2 w-full p-3 flex flex-col gap-3">
                    <label class="font-bold" for="">Nome da Categoria: </label>
                    {{ category.name}}
                </div>

                <div class="xl:w-1/5 sm:w-1/2 w-full p-3 flex flex-col gap-3">
                    <label class="font-bold" for="">Ações: </label>
                    <div v-if="category.user_id" class="flex gap-3">
                        <Link :href="route('income-categories.edit', category.id)">
                            <Button icon="pi pi-pen-to-square" title="Editar" severity="warn" outlined/>
                        </Link>
                        <DeleteButton icon="true" :url="route('income-categories.destroy', category)"/>
                    </div>
                    <Badge v-else size="large" class="w-fit" severity="secondary">Categoria Padrão</Badge>
                </div>

                <Divider/>

            </div>

        </Index>
    </AppLayout>

</template>
