<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import NumberFormater from "@/Services/Types/NumberFormater.js";
import DateFormater from "@/Services/Types/DateFormater.js";
import {Link, router} from "@inertiajs/vue3";
import DeleteButton from "@/Components/Partials/DeleteButton.vue";
import Index from "@/Components/Crud/Index.vue";

export default {
    methods: {
        router() {
            return router
        }
    },
    data: () => {
        return {
            NumberFormater: NumberFormater,
            DateFormater: DateFormater,
        }
    },
    props: ['incomes'],
    components: {
        Index,
        DeleteButton,
        AppLayout,
        Link
    }
}
</script>

<template>
    <AppLayout>
        <Index :create_route="route('incomes.create')" button_label="Nova Renda">

            <div class="mt-3 font-light italic" v-if="incomes.length === 0">
                <h3>Nenhuma renda cadastrada ainda...</h3>
            </div>

            <div v-if="incomes.length" class="w-full">
                <h3>Rendas cadastradas:</h3>
                <Divider/>
            </div>

            <div v-for="income in incomes" :key="income.id" class="flex flex-wrap items-center w-full p-3 rounded">

                <div class="xl:w-1/5 lg:1/2 w-full p-3 flex gap-3">
                    <label class="font-bold" for="">Valor: </label>
                    {{ NumberFormater.toLocalCurrency(income.value) }}
                </div>

                <div class="xl:w-1/5 lg:1/2 w-full p-3 flex gap-3">
                    <label class="font-bold" for="">Categoria: </label>
                    {{ income.category.name}}
                </div>

                <div class="xl:w-1/5 lg:1/2 w-full p-3 flex gap-3">
                    <label class="font-bold" for="">Descrição: </label>
                    {{ income.description || 'Sem descrição' }}
                </div>

                <div class="xl:w-1/5 lg:1/2 w-full p-3 flex gap-3">
                    <label class="font-bold" for="">Dia Pagamento: </label>
                    {{ income.payment_day }}
                </div>

                <div class="xl:w-1/5 lg:1/2 w-full p-3 flex gap-3">
                    <Link :href="route('incomes.edit', income.id)">
                        <Button label="Editar" severity="secondary" outlined/>
                    </Link>
                    <DeleteButton :url="route('incomes.destroy', income)"/>
                </div>

                <Divider/>

            </div>
        </Index>
    </AppLayout>
</template>
