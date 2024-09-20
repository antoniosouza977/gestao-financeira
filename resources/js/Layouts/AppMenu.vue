<script setup>
import {ref} from 'vue';

import AppMenuItem from './AppMenuItem.vue';

const model = ref([
    {
        label: 'Home',
        items: [{label: 'Dashboard', icon: 'pi pi-fw pi-home', to: route('dashboard')}],
    },
    {
        label: 'Minhas Finanças',
        items: [
            {
                label: 'Rendas',
                icon: 'pi pi-fw pi-money-bill',
                items: [
                    {label: "Minhas Rendas Mensais", to: route('incomes.index')},
                    {label: 'Categorias', to: route('income-categories.index')},
                    {label: 'Pagamentos', to: route('payments.index')}
                ]
            },
            {
                label: 'Despesas',
                icon: 'pi pi-receipt',
                items: [
                    {label: 'Minhas Despesas Mensais', to: route('expenses.index')},
                    {label: 'Orçamentos', to: route('budgets.index')},
                    {label: 'Categorias de Orçamento', to: route('expense-categories.index')},
                    {label: 'Gastos', to: route('outgoings.index')},
                ]
            }
        ]
    }
]);
</script>

<template>
    <ul class="layout-menu">
        <template v-for="(item, i) in model" :key="item">
            <app-menu-item v-if="!item.separator" :item="item" :index="i"></app-menu-item>
            <li v-if="item.separator" class="menu-separator"></li>
        </template>
    </ul>
</template>

<style lang="scss" scoped></style>
