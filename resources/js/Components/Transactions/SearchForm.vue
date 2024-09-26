<script setup>
import SearchSideBar from "@/Components/Crud/SearchSideBar.vue";
import SearchButton from "@/Components/Crud/SearchButton.vue";
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    }
})

const params = new URLSearchParams(window.location.search)
const form = useForm({
    start_date: params.get('start_date'),
    end_date: params.get('end_date'),
    category_id: Number(params.get('category_id')),
})

</script>
<template>
    <SearchSideBar>
        <div class="flex flex-col gap-3">

            <div class="flex flex-col gap-1">
                <label for="start_date">Período (início)</label>
                <div class="flex gap-1">
                    <InputText type="date" id="start_date" v-model="form.start_date"/>
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <label for="end_date">Período (Fim)</label>
                <div class="flex gap-1">
                    <InputText type="date" id="end_date" v-model="form.end_date"/>
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <label for="category_id">Categoria</label>
                <div class="flex gap-1">
                    <Select v-model="form.category_id"
                            :options="categories" optionLabel="name"
                            optionValue="id"
                            class="w-full"
                            showClear
                            :invalid="Boolean(form.errors.category_id)"
                            placeholder="Selecione...">
                        <template #empty>
                            <p>Nenhuma categoria cadastrada</p>
                        </template>
                    </Select>
                </div>
            </div>

        </div>

        <Divider/>
        <SearchButton :form/>
    </SearchSideBar>
</template>

<style scoped>

</style>
