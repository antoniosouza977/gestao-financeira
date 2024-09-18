<script setup>
import {router} from "@inertiajs/vue3";

const props = defineProps({
    links: Object
})

const changePage = (link) => {
    const params = {...route().params}
    const paramsSize = Object.keys(params).length

    if (paramsSize === 1 && route().params.page || paramsSize === 0) return router.get(link.url)

    params.page = getPage(link.url)

    return router.get(window.location.pathname, params)
}
const getPage = (url) => {
    return url.match(/page=\d+/g)[0].match(/page=(\d+)/)[1];
}

</script>

<template>

    <div class="w-full flex items-center justify-center p-3 gap-2">
        <template v-for="link in links">
            <template v-if="link.label.includes('Anterior')">
                <Button @click.prevent="changePage(link)"
                        :disabled="link.url === null" icon="pi pi-chevron-left"
                        :severity="link.active ? '' : 'secondary'" rounded outlined/>
            </template>
            <template v-else-if="link.label.includes('Próximo')">
                <Button @click.prevent="changePage(link)"
                        :disabled="link.url === null" icon="pi pi-chevron-right"
                        :severity="link.active ? '' : 'secondary'" rounded outlined/>
            </template>
            <template v-else>
                <Button @click.prevent="changePage(link)"
                        :disabled="link.url === null" :label="link.label"
                        :severity="link.active ? '' : 'secondary'" rounded outlined/>
            </template>
        </template>
    </div>

</template>
