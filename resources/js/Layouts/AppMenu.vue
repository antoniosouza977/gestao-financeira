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
                label: 'Receitas',
                icon: 'pi pi-fw pi-money-bill',
                items: [
                    {
                        label: 'Rendas Mensais',
                        items: [
                            {
                                label: "Minhas Rendas",
                                to: route('incomes.index')
                            },
                            {
                                label: 'Categorias',
                                to: route('income-categories.index'),
                            },
                        ],
                    },
                    {
                        label: 'Pagamentos',
                        to: route('payments.index'),
                    }
                ]
            },
            {
                label: 'Submenu 2',
                icon: 'pi pi-fw pi-bookmark',
                items: [
                    {
                        label: 'Submenu 2.1',
                        icon: 'pi pi-fw pi-bookmark',
                        items: [
                            {label: 'Submenu 2.1.1', icon: 'pi pi-fw pi-bookmark'},
                            {label: 'Submenu 2.1.2', icon: 'pi pi-fw pi-bookmark'}
                        ]
                    },
                    {
                        label: 'Submenu 2.2',
                        icon: 'pi pi-fw pi-bookmark',
                        items: [{label: 'Submenu 2.2.1', icon: 'pi pi-fw pi-bookmark'}]
                    }
                ]
            }
        ]
    },
    {
        label: 'Menu 1',
        items: [
            {label: 'Example 1', icon: 'pi pi-fw pi-id-card'},
            {label: 'Example 2', icon: 'pi pi-fw pi-check-square'},
            {label: 'Example 3', icon: 'pi pi-fw pi-mobile', class: 'rotated-icon'},
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
