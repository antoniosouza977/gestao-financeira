<script>
import {router} from "@inertiajs/vue3";
import {useToast} from "vue-toastification";

export default {
    name: "DeleteButton",
    props: ['url'],
    data: () => {
        return {
            toast: useToast()
        }
    },
    methods: {
        deleteModel() {
            const app = this;
            this.$swal.fire({
                title: "Tem certeza?",
            }).then(result => {
                if (result.isConfirmed) {
                    router.delete(this.url, {
                        onSuccess: () => {
                            app.toast.success('Registro removido.')
                        }
                    })
                }
            })
        }
    }
}
</script>

<template>
    <Button label="Remover" severity="danger" outlined @click.prevent="deleteModel"/>
</template>

