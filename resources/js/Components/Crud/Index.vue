<script>
import {Link} from "@inertiajs/vue3";

export default {
    name: "Index",
    components: {Link},
    props: ['button_label', 'create_route']
}
</script>

<template>
    <div class="card">
        <div class="flex flex-wrap items-center mb-3">
            <div class="w-full flex justify-end items-center mb-3">
                <Link :href="create_route">
                    <Button outlined :label="button_label || 'Novo'"/>
                </Link>
            </div>
            <slot/>
        </div>
    </div>
</template>

<style scoped lang="scss">

</style>
