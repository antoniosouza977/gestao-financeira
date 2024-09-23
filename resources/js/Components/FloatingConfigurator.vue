<script setup>
import AppConfigurator from '@/Layouts/AppConfigurator.vue';
import { useLayout } from '@/Layouts/composables/layout';
import {onMounted} from "vue";

const { toggleDarkMode, isDarkTheme } = useLayout();

onMounted(() => {
    const isDarkModeSetted = localStorage.getItem('darkTheme') === 'true';

    if (isDarkModeSetted && !document.documentElement.classList.contains('app-dark')) {
        document.documentElement.classList.add('app-dark');
    }

});
</script>

<template>
    <div class="fixed flex gap-4 top-8 right-8">
        <Button type="button" @click="toggleDarkMode" rounded :icon="{ 'pi pi-moon': isDarkTheme, 'pi pi-sun': !isDarkTheme }" severity="secondary" />
        <div class="relative">
            <Button
                icon="pi pi-palette"
                v-styleclass="{ selector: '@next', enterFromClass: 'hidden', enterActiveClass: 'animate-scalein', leaveToClass: 'hidden', leaveActiveClass: 'animate-fadeout', hideOnOutsideClick: true }"
                type="button"
                rounded
            />
            <AppConfigurator />
        </div>
    </div>
</template>
