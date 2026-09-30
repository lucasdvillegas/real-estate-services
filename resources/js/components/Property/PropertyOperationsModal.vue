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

import InputError from "@/components/InputError.vue";

import type { PropertyType } from "@/types/propertyType";
import type { PropertyStatus } from "@/types/propertyStatus";
import type { Currency } from "@/types/currency";
import type { OperationType } from "@/types/operationType";

const props = defineProps<{
    open: boolean;
    saving: boolean;
    mode: "create" | "edit";
    operation?: {
        operation_type_id: number | null;
        price: string | number;
        currency: string;
        status: string;
    };
    propertyTypes: PropertyType[];
    propertyStatuses: PropertyStatus[];
    currencies: Currency[];
    operationTypes: OperationType[];
}>();

const emit = defineEmits<{
    (e: "update:open", value: boolean): void;
    (e: "save", operation: {
        operation_type_id: number;
        price: string | number;
        currency: string;
        status: string;
    }): void;
}>();

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

const internalOpen = ref(props.open);

watch(
    () => props.open,
    (value) => {
        internalOpen.value = value;
        if (value) {
            if (props.mode === "edit" && props.operation) {
                const operationTypeId = props.operation.operation_type_id ?? props.operationTypes[0]?.id;

                setValues({
                    operation_type_id: operationTypeId?.toString() ?? "",
                    price: String(props.operation.price),
                    currency: props.operation.currency,
                    status: props.operation.status,
                });
            } else {
                resetForm();
            }
        }
    },
);

watch(internalOpen, (value) => {
    emit("update:open", value);
});

const onSubmit = handleSubmit((values) => {
    emit("save", {
        operation_type_id: parseInt(values.operation_type_id),
        price: values.price,
        currency: values.currency,
        status: values.status,
    });
});
</script>

<template>
    <Dialog :open="internalOpen" @update:open="internalOpen = $event">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>
                    {{ mode === "edit" ? "Editar Operación" : "Agregar Operación" }}
                </DialogTitle>
                <DialogDescription>
                    {{
                        mode === "edit"
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
                            <SelectValue placeholder="Seleccionar operación" />
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
                    <InputError :message="(errors as any).operation_type_id" />
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
                        @click="internalOpen = false"
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
</template>
