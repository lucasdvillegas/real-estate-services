<script setup lang="ts">
import { Head, Link, router } from "@inertiajs/vue3";
import { useForm, useField } from "vee-validate";
import { ref } from "vue";
import { toast } from "vue-sonner";
import * as yup from "yup";

import InputError from "@/components/InputError.vue";
import { Button } from "@/components/ui/button";
import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent,
    CardFooter,
} from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Spinner } from "@/components/ui/spinner";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert";
import { Separator } from "@/components/ui/separator";
import { Info, Pencil, Trash2 } from "@lucide/vue";

import PropertyOperationsTable from "@/components/Property/PropertyOperationsTable.vue";
import PropertyOperationsModal from "@/components/Property/PropertyOperationsModal.vue";
import PropertyImageUpload from "@/components/Property/PropertyImageUpload.vue";

import propertyRoutes from "@/routes/properties";
import type { Property } from "@/types/property";
import type { PropertyType } from "@/types/propertyType";
import type { PropertyStatus } from "@/types/propertyStatus";
import type { Currency } from "@/types/currency";
import type { OperationType } from "@/types/operationType";

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: "Propiedades",
                href: propertyRoutes.index(),
            },
        ],
    },
});

const props = defineProps<{
    property: Property;
    propertyTypes: PropertyType[];
    propertyStatuses: PropertyStatus[];
    currencies: Currency[];
    operationTypes: OperationType[];
    operations: Array<{
        operation_type_id: number;
        price: number | string;
        currency: string;
        status: string;
    }>;
    images?: string;
    propertyTypeCode?: string;
}>();

const saving = ref(false);
const operationsDialogOpen = ref(false);
const operationsDialogSaving = ref(false);
const editingOperationIndex = ref<number | null>(null);

const addOperation = () => {
    editingOperationIndex.value = null;
    operationsDialogOpen.value = true;
};

const editOperation = (index: number) => {
    editingOperationIndex.value = index;
    operationsDialogOpen.value = true;
};

const handleOperationSave = (operation: {
    operation_type_id: number;
    price: string | number;
    currency: string;
    status: string;
}) => {
    if (editingOperationIndex.value !== null) {
        operations.value[editingOperationIndex.value] = {
            ...operation,
            price: String(operation.price),
        };
    } else {
        operations.value.push({
            ...operation,
            price: String(operation.price),
        });
    }
    operationsDialogOpen.value = false;
    editingOperationIndex.value = null;
};

const schema = yup.object({
    title: yup.string().required().label("Título"),
    description: yup.string().required().label("Descripción"),
    property_type_id: yup.string().nullable().label("Tipo de Propiedad"),
    operations: yup
        .array()
        .of(
            yup.object({
                operation_type_id: yup
                    .number()
                    .required()
                    .label("Tipo de Operación"),
                price: yup.number().required().label("Precio"),
                currency: yup.string().required().label("Moneda"),
                status: yup.string().required().label("Estado"),
            }),
        )
        .min(1)
        .required()
        .label("Operaciones"),
    images: yup.array().of(yup.string()).nullable().label("Imágenes"),
});

const { handleSubmit, defineField, errors, setErrors } = useForm({
    validationSchema: schema,
    initialValues: {
        title: props.property.title,
        description: props.property.description,
        property_type_id: props.propertyTypeCode ?? "",
        operations: props.operations?.length
            ? props.operations
            : [
                  {
                      operation_type_id: props.operationTypes[0]?.id ?? 0,
                      price: "",
                      currency: "USD",
                      status: "",
                  },
              ],
        images: props.images
            ? props.images
                  .split("\n")
                  .filter(Boolean)
                  .map((url) => url.trim())
            : [],
    },
});

const [title] = defineField("title");
const [description] = defineField("description");
const [propertyTypeId] = defineField("property_type_id");
const [operations] = defineField("operations");
const [images] = defineField("images");

const removeOperation = (index: number) => {
    operations.value.splice(index, 1);
};

const submit = handleSubmit((values) => {
    saving.value = true;

    const payload = {
        ...values,
        images: Array.isArray(values.images)
            ? values.images.join("\n")
            : values.images || "",
    };

    router.put(propertyRoutes.update.url(props.property.id), payload, {
        preserveScroll: true,
        onSuccess: () => {
            toast.success("Propiedad actualizada correctamente");
        },
        onError: (errors) => {
            setErrors(errors);
            toast.error("Error al intentar actualizar la Propiedad");
            console.log(errors);
        },
        onFinish: () => {
            saving.value = false;
        },
    });
});
</script>

<template>
    <Head title="Editar Propiedad" />

    <Card class="m-4 flex h-full flex-col shadow-none">
        <CardHeader>
            <CardTitle>Editar Propiedad</CardTitle>
            <CardDescription>
                Modifica la información del registro.
            </CardDescription>
        </CardHeader>

        <CardContent class="flex-1">
            <form
                @submit.prevent="submit"
                id="edit-property-form"
                class="flex h-full flex-col"
            >
                <div class="grid grid-cols-1 gap-6">
                    <div class="grid gap-4">
                        <p class="text-sm font-medium text-muted-foreground">
                            Información básica
                        </p>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="grid gap-2">
                                <Label for="title">Título</Label>
                                <Input id="title" v-model="title" />
                                <InputError :message="errors.title" />
                            </div>
                            <div class="grid gap-2">
                                <Label for="description">Descripción</Label>
                                <Input id="description" v-model="description" />
                                <InputError :message="errors.description" />
                            </div>
                            <div class="grid gap-2">
                                <Label for="property_type_id"
                                    >Tipo de Propiedad</Label
                                >
                                <Select v-model="propertyTypeId">
                                    <SelectTrigger>
                                        <SelectValue
                                            placeholder="Seleccionar tipo"
                                        />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem
                                            v-for="type in props.propertyTypes as any[]"
                                            :key="type.code"
                                            :value="type.code"
                                        >
                                            {{ type.name }}
                                        </SelectItem>
                                    </SelectContent>
                                </Select>
                                <InputError
                                    :message="errors.property_type_id"
                                />
                            </div>
                        </div>
                    </div>

                    <Separator />

                    <div class="grid gap-4">
                        <div class="flex items-center justify-between">
                            <p
                                class="text-sm font-medium text-muted-foreground"
                            >
                                Operaciones
                            </p>
                            <Button
                                type="button"
                                variant="outline"
                                size="sm"
                                class="cursor-pointer shadow-none"
                                @click="addOperation"
                            >
                                Agregar operación
                            </Button>
                        </div>

                        <Alert>
                            <Info class="size-4" />
                            <AlertTitle>Múltiples operaciones</AlertTitle>
                            <AlertDescription>
                                Una propiedad puede tener más de una operación,
                                por ejemplo, se puede alquilar y vender al mismo
                                tiempo.
                            </AlertDescription>
                        </Alert>

                        <PropertyOperationsTable
                            :operations="operations as any[]"
                            :operation-types="props.operationTypes"
                            :property-statuses="props.propertyStatuses"
                            @edit="editOperation"
                            @remove="removeOperation"
                        />

                        <InputError :message="errors.operations" />
                    </div>

                    <PropertyOperationsModal
                        :open="operationsDialogOpen"
                        :saving="operationsDialogSaving"
                        :mode="
                            editingOperationIndex !== null ? 'edit' : 'create'
                        "
                        :operation="
                            editingOperationIndex !== null
                                ? operations[editingOperationIndex]
                                : undefined
                        "
                        :property-types="props.propertyTypes"
                        :property-statuses="props.propertyStatuses"
                        :currencies="props.currencies"
                        :operation-types="props.operationTypes"
                        @update:open="operationsDialogOpen = $event"
                        @save="handleOperationSave"
                    />

                    <Separator />

                    <PropertyImageUpload
                        v-model="images"
                        label="Imágenes"
                        :error="errors.images"
                    />
                </div>
            </form>
        </CardContent>

        <CardFooter class="flex justify-end gap-4 p-4">
            <Button
                type="submit"
                form="edit-property-form"
                :disabled="saving"
                class="cursor-pointer shadow-none"
            >
                <Spinner v-if="saving" />
                Actualizar
            </Button>

            <Button
                as-child
                variant="outline"
                :disabled="saving"
                class="shadow-none"
            >
                <Link :href="propertyRoutes.index()"> Cancelar </Link>
            </Button>
        </CardFooter>
    </Card>
</template>
