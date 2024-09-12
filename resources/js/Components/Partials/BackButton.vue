<script>
import {Link, router} from "@inertiajs/vue3";

export default {
    name: "BackButton",
    components: {
        Link,
    },
    props: ['back_url'],
}
</script>

<template>
    <Link :href="back_url || route('dashboard')">
        <Button style="width: fit-content;" icon="pi pi-arrow-left" label="Voltar" outlined severity="secondary"/>
    </Link>
</template>

<style scoped lang="scss">

</style>
