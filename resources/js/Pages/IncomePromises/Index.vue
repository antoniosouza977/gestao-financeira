<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Index from "@/Components/Crud/Index.vue";
import CustomPaginator from "@/Components/Crud/CustomPaginator.vue";
import EmptyListAlert from "@/Components/Partials/EmptyListAlert.vue";
import {Head, Link} from "@inertiajs/vue3";
import Help from "@/Components/Partials/Help.vue";
import TransactionPromisesIndex from "@/Components/TransactionPromises/TransactionPromisesIndex.vue";

const props = defineProps({
    promises: Object
})

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

                <EmptyListAlert v-if="promises.data.length === 0"/>

                <TransactionPromisesIndex resource="income-promises" value-severity="success"
                                          :promises="promises.data"/>

                <CustomPaginator :index-route="route('income-promises.index')" :laravel-paginator="promises"/>
            </template>
        </Index>
    </AppLayout>
</template>

