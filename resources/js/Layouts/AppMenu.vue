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
                    {
                        label: 'Agendar Receitas',
                        icon: 'pi pi-calendar-clock',
                        to: route('income-promises.index')
                    },
                    {
                        label: 'Entradas',
                        icon: 'pi pi-wallet',
                        to: route('incomes.index')
                    },
                    {
                        label: 'Categorias',
                        icon: 'pi pi-hashtag',
                        to: route('income-categories.index')
                    }
                ]
            },
            {
                label: 'Despesas',
                icon: 'pi pi-receipt',
                items: [
                    {
                        label: 'Agendar Despesas',
                        icon: 'pi pi-calendar-clock',
                        to: route('expense-promises.index')
                    },
                    {
                        label: 'Saidas',
                        icon: 'pi pi-dollar',
                        to: route('expenses.index')
                    },
                    {
                        label: 'Categorias',
                        icon: 'pi pi-hashtag',
                        to: route('expense-categories.index')
                    }
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
