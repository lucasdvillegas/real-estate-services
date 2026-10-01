<script setup lang="ts">
import { ref, watch } from "vue";
import { useForm } from "vee-validate";
import * as yup from "yup";

import { Button } from "@/components/ui/button";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from "@/components/ui/dialog";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import { Spinner } from "@/components/ui/spinner";
import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert";
import { Separator } from "@/components/ui/separator";
import { Info } from "@lucide/vue";

import PropertyOperationsTable from "@/components/Property/PropertyOperationsTable.vue";
import InputError from "@/components/InputError.vue";

import type { PropertyType } from "@/types/propertyType";
import type { PropertyStatus } from "@/types/propertyStatus";
import type { Currency } from "@/types/currency";
import type { OperationType } from "@/types/operationType";

const props = withDefaults(
    defineProps<{
        operations: Array<{
            operation_type_id: number;
            price: string | number;
            currency: string;
            status: string;
        }>;
        operationTypes: OperationType[];
        propertyStatuses: PropertyStatus[];
        currencies: Currency[];
        saving?: boolean;
    }>(),
    {
        saving: false,
    },
);

const emit = defineEmits<{
    (e: "update:operations", value: typeof props.operations): void;
}>();

const dialogOpen = ref(false);
const editingIndex = ref<number | null>(null);

const schema = yup.object({
    operation_type_id: yup.string().required().label("Tipo de Operación"),
    price: yup.string().required().label("Precio"),
    currency: yup.string().required().label("Moneda"),
    status: yup.string().required().label("Estado"),
});

const { handleSubmit, defineField, errors, resetForm, setValues } = useForm({
    validationSchema: schema,
    initialValues: {
        operation_type_id: props.operationTypes[0]?.id?.toString() ?? "",
        price: "",
        currency: "USD",
        status: "",
    },
});

const [operationTypeId] = defineField("operation_type_id");
const [price] = defineField("price");
const [currency] = defineField("currency");
const [status] = defineField("status");

function openCreate() {
    editingIndex.value = null;
    resetForm();
    dialogOpen.value = true;
}

function openEdit(index: number) {
    editingIndex.value = index;
    const operation = props.operations[index];
    const operationTypeId =
        operation.operation_type_id ?? props.operationTypes[0]?.id;

    setValues({
        operation_type_id: operationTypeId?.toString() ?? "",
        price: String(operation.price),
        currency: operation.currency,
        status: operation.status,
    });

    dialogOpen.value = true;
}

function remove(index: number) {
    const next = [...props.operations];
    next.splice(index, 1);
    emit("update:operations", next);
}

const onSubmit = handleSubmit((values) => {
    const operation = {
        operation_type_id: parseInt(values.operation_type_id),
        price: values.price,
        currency: values.currency,
        status: values.status,
    };

    if (editingIndex.value !== null) {
        const next = [...props.operations];
        next[editingIndex.value] = operation;
        emit("update:operations", next);
    } else {
        emit("update:operations", [...props.operations, operation]);
    }

    dialogOpen.value = false;
    editingIndex.value = null;
});
</script>

<template>
    <div class="grid gap-4">
        <div class="flex items-center justify-between">
            <Label>Operaciones</Label>

            <Button
                type="button"
                variant="outline"
                size="sm"
                class="cursor-pointer shadow-none"
                @click="openCreate"
            >
                Agregar operación
            </Button>
        </div>

        <Alert>
            <Info class="size-4" />
            <AlertTitle>Múltiples operaciones</AlertTitle>
            <AlertDescription>
                Una propiedad puede tener más de una operación, por ejemplo, se
                puede alquilar y vender al mismo tiempo.
            </AlertDescription>
        </Alert>

        <PropertyOperationsTable
            :operations="operations"
            :operation-types="operationTypes"
            :property-statuses="propertyStatuses"
            @edit="openEdit"
            @remove="remove"
        />

        <Dialog :open="dialogOpen" @update:open="dialogOpen = $event">
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>
                        {{
                            editingIndex !== null
                                ? "Editar Operación"
                                : "Agregar Operación"
                        }}
                    </DialogTitle>
                    <DialogDescription>
                        {{
                            editingIndex !== null
                                ? "Modificá los datos de la operación."
                                : "Completá los datos de la operación para esta propiedad."
                        }}
                    </DialogDescription>
                </DialogHeader>

                <form @submit.prevent="onSubmit" class="grid gap-4">
                    <div class="grid gap-2">
                        <Label for="operation-type">Tipo de Operación</Label>
                        <Select v-model="operationTypeId">
                            <SelectTrigger id="operation-type">
                                <SelectValue
                                    placeholder="Seleccionar operación"
                                />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem
                                    v-for="operationTypeItem in operationTypes"
                                    :key="operationTypeItem.id"
                                    :value="operationTypeItem.id.toString()"
                                >
                                    {{ operationTypeItem.name }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <InputError
                            :message="(errors as any).operation_type_id"
                        />
                    </div>

                    <div class="grid gap-2">
                        <Label for="operation-price">Precio</Label>
                        <Input id="operation-price" v-model="price" />
                        <InputError :message="(errors as any).price" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="operation-currency">Moneda</Label>
                        <Select v-model="currency">
                            <SelectTrigger id="operation-currency">
                                <SelectValue placeholder="Seleccionar moneda" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem
                                    v-for="currencyItem in currencies"
                                    :key="currencyItem.code"
                                    :value="currencyItem.code"
                                >
                                    {{ currencyItem.name }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <InputError :message="(errors as any).currency" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="operation-status">Estado</Label>
                        <Select v-model="status">
                            <SelectTrigger id="operation-status">
                                <SelectValue placeholder="Seleccionar estado" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem
                                    v-for="statusItem in propertyStatuses"
                                    :key="statusItem.code"
                                    :value="statusItem.code"
                                >
                                    {{ statusItem.name }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <InputError :message="(errors as any).status" />
                    </div>

                    <DialogFooter>
                        <Button
                            type="button"
                            variant="outline"
                            :disabled="saving"
                            @click="dialogOpen = false"
                        >
                            Cancelar
                        </Button>
                        <Button type="submit" :disabled="saving">
                            <Spinner v-if="saving" />
                            Guardar
                        </Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    </div>
</template>
