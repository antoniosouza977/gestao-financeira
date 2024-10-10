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
    <Head title="Despesas Agendas"/>

    <AppLayout>
        <Index title="Despesas Agendas">

            <template v-slot:new-btn>
                <Link :href="route('expense-promises.create')">
                    <Button label="Agendar"/>
                </Link>
            </template>

            <template v-slot:content>

                <Help
                    text="Agende suas Despesas Recorrentes como contas mensais, parcelas anuais e gastos diários. Confirme o pagamentos na aba de pagamentos."/>

                <EmptyListAlert v-if="promises.data.length === 0"/>

                <TransactionPromisesIndex resource="expense-promises" value-severity="danger"
                                          :promises="promises.data"/>

                <CustomPaginator :index-route="route('expense-promises.index')" :laravel-paginator="promises"/>
            </template>
        </Index>
    </AppLayout>
</template>

