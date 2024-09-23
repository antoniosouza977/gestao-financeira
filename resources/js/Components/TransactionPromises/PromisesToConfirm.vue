<script setup>
import {ref} from "vue";
import InputError from "@/Components/InputError.vue";
import ConfirmTransactionButton from "@/Components/Transactions/ConfirmTransactionButton.vue";

const props = defineProps({
    promises: {
        required: false,
        type: Array,
    },
    type: {
        type: String,
        required: true,
    },
    confirmRoute: {
        type: String,
        required: true,
    }
})

const promises = ref([...props.promises])
const removePromiseConfirmed = (id) => {
    promises.value = promises.value.filter(item => item.id !== id);
}
</script>

<template>
    <div class="w-full mb-3">
        <Accordion value="0">
            <AccordionPanel value="1">
                <AccordionHeader class="w-full" >
                    <span class="flex gap-3">
                    Transações não confirmadas
                    <Badge severity="warn">{{promises.length}}</Badge>
                    </span>
                </AccordionHeader>
                <AccordionContent>
                    <div v-for="promise in promises" :key="promise.id"
                         class="flex flex-wrap items-center w-full rounded">
                        <Divider/>

                        <div class="xl:w-1/5 lg:w-1/3 w-1/2 flex flex-col justify-start flex-wrap gap-2 p-3 pl-0">
                            <label class="font-bold w-full" for="value">Valor: </label>
                            <InputNumber fluid inputId="value" :min-fraction-digits="2" v-model="promise.value"
                                         class="w-fit"
                                         :invalid="Boolean($page.props.errors.value)"/>

                            <InputError class="mt-2" :message="$page.props.errors.value"/>
                        </div>

                        <div class="xl:w-1/5 lg:w-1/3 w-1/2 flex flex-wrap flex-col gap-2 p-3 pl-0">
                            <label class="font-bold w-full" for="date">Data: </label>
                            <InputText :invalid="Boolean($page.props.errors.date)"
                                       inputId="date" type="date" v-model="promise.date"
                                       class="w-fit"
                            />
                            <InputError class="mt-2" :message="$page.props.errors.date"/>
                        </div>

                        <div class="xl:w-1/5 lg:w-1/3 md:w-1/2 w-full flex flex-col flex-wrap gap-2 p-3 pl-0">
                            <label class="font-bold w-full" for="">Categoria: </label>
                            <Badge class="w-fit" severity="secondary" size="large">
                                {{ promise.category_id ? promise.category.name : 'Sem Categoria' }}
                            </Badge>
                        </div>

                        <div class="xl:w-1/5 lg:w-1/3 md:w-1/2 w-full flex flex-col flex-wrap gap-2 p-3 pl-0">
                            <label class="font-bold" for="">Descrição: </label>
                            {{ promise.description || 'Sem descrição' }}
                        </div>


                        <div class="xl:w-1/5 w-full flex flex-wrap gap-2 p-3 pl-0">
                            <div class="w-full">
                                <ConfirmTransactionButton @transactionConfirmed="removePromiseConfirmed" :promise="promise" :confirmRoute/>
                            </div>
                        </div>


                    </div>
                </AccordionContent>
            </AccordionPanel>

        </Accordion>
    </div>

</template>
