<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import NumberFormater from "@/Services/Types/NumberFormater.js";
import DateFormater from "@/Services/Types/DateFormater.js";
import {Link} from "@inertiajs/vue3";
import DeleteButton from "@/Components/Partials/DeleteButton.vue";

export default {
    data: () => {
        return {
            NumberFormater: NumberFormater,
            DateFormater: DateFormater,
        }
    },
    props: ['incomes'],
    components: {
        DeleteButton,
        AppLayout,
        Link
    }
}
</script>

<template>
    <AppLayout>

        <div class="card">
            <div class="flex flex-wrap items-center mb-3">
                <div v-for="income in incomes" :key="income.id" class="flex flex-wrap items-center w-full p-3 rounded">

                    <div class="xl:w-1/5 lg:1/3 md:w-1/2 w-full p-3 flex gap-3">
                        <label class="font-bold" for="">Valor: </label>
                        {{ NumberFormater.toLocalCurrency(income.amount) }}
                    </div>

                    <div class="xl:w-1/5 lg:1/3 md:w-1/2 w-full p-3 flex gap-3">
                        <label class="font-bold" for="">Descrição: </label>
                        {{ income.description || 'Sem descrição' }}
                    </div>

                    <div class="xl:w-1/5 lg:1/3 md:w-1/2 w-full p-3 flex gap-3">
                        <label class="font-bold" for="">Data: </label>
                        {{ DateFormater.toLocaleDateString(income.date) }}
                    </div>

                    <div class="xl:w-1/5 lg:1/3 md:w-1/2 w-full p-3 flex gap-3">
                        <label class="font-bold" for="">Mensal: </label>
                        {{ income.monthly_income ? "Sim" : "Não" }}
                    </div>

                    <div class="xl:w-1/5 lg:1/3 md:w-1/2 w-full p-3 flex gap-3">
                        <Link :href="route('incomes.edit', income.id)">
                            <Button label="Editar" severity="secondary" outlined/>
                        </Link>
                        <DeleteButton :url="route('incomes.destroy', income)"/>
                    </div>
                    <Divider/>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
