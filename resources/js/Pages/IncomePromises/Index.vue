<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import NumberFormater from "@/Services/Types/NumberFormater.js";
import Index from "@/Components/Crud/Index.vue";
import CustomPaginator from "@/Components/Crud/CustomPaginator.vue";
import EmptyListAlert from "@/Components/Partials/EmptyListAlert.vue";
import {Head, Link} from "@inertiajs/vue3";
import Help from "@/Components/Partials/Help.vue";
import DeleteButton from "@/Components/Partials/DeleteButton.vue";

const props = defineProps({
    promisses: Array
})

const types = [
    'Diária',
    'Semanal',
    'Mensal',
    'Anual',
    'Parcelas'
];
</script>

<template>
    <Head title="Agendar Receitas"/>

    <AppLayout>
        <Index title="Receitas Agendadas">

            <template v-slot:new-btn>
                <Link :href="route('income-promises.create')">
                    <Button label="Agendar"/>
                </Link>
            </template>

            <template v-slot:content>

                <Help
                    text="Agende suas Receitas recorrentes como salário, beneficios e parcelas. Confirme o pagamentos na aba de entradas."/>

                <EmptyListAlert v-if="promisses.data.length === 0"/>

                <div v-for="promise in promisses.data" :key="promise.id"
                     class="flex flex-wrap items-center w-full rounded">

                    <div class="xl:w-1/6 w-1/2 p-3 pl-0 flex flex-col gap-1">
                        <label>Valor: </label>
                        <Badge size="large" class="w-fit">
                            {{ NumberFormater.toLocalCurrency(promise.value) }}
                        </Badge>
                    </div>

                    <div class="xl:w-1/6 w-1/2 p-3 pl-0 flex flex-col gap-1">
                        <label>Categoria: </label>
                        <Badge
                            class="w-fit"
                            size="large"
                            severity="secondary">
                            {{ promise.category_id ? promise.category.name : 'Sem Categoria' }}
                        </Badge>
                    </div>

                    <div class="xl:w-1/6 w-1/2 p-3 pl-0 flex flex-col gap-1">
                        <label>Tipo: </label>
                        {{ types[promise.period_type - 1] }}
                    </div>

                    <div class="xl:w-1/6 w-1/2 p-3 pl-0 flex flex-col gap-1">
                        <label>Recorrência: </label>
                        {{ promise.period_value_label }}
                    </div>

                    <div class="xl:w-1/6 w-full p-3 pl-0 flex flex-col gap-1">
                        <label>Descrição: </label>
                        {{ promise.description || 'Sem descrição' }}
                    </div>

                    <div class="xl:w-1/6 sm:w-1/2 w-full p-3 pl-0 flex flex-col gap-1">
                        <label>Ações: </label>
                        <div class="flex gap-3">
                            <Link :href="route('income-promises.edit', promise)">
                                <Button icon="pi pi-pen-to-square" severity="warn"></Button>
                            </Link>
                            <DeleteButton icon="true" :url="route('income-promises.destroy', promise)"/>
                        </div>
                    </div>

                    <Divider/>
                </div>

                <CustomPaginator :index-route="route('income-promises.index')" :laravel-paginator="promisses"/>
            </template>
        </Index>
    </AppLayout>
</template>

