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

import PropertyOperations from "@/components/Property/PropertyOperations.vue";
import PropertyImageUpload from "@/components/Property/PropertyImageUpload.vue";

import propertyRoutes from "@/routes/properties";
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
    propertyTypes: PropertyType[];
    propertyStatuses: PropertyStatus[];
    currencies: Currency[];
    operationTypes: OperationType[];
}>();

const saving = ref(false);

const schema = yup.object({
    title: yup.string().required().label("Título"),
    description: yup.string().required().label("Descripción"),
    property_type_id: yup.string().required().label("Tipo de Propiedad"),
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
    images: yup.array().of(yup.string()).min(1).label("Imágenes"),
});

const { handleSubmit, defineField, errors, setErrors } = useForm({
    validationSchema: schema,
    initialValues: {
        title: "",
        description: "",
        property_type_id: "",
        operations: [],
        images: [],
    },
});

const [title] = defineField("title");
const [description] = defineField("description");
const [propertyTypeId] = defineField("property_type_id");
const [operations] = defineField("operations");
const [images] = defineField("images");

const submit = handleSubmit((values) => {
    saving.value = true;

    const payload = {
        ...values,
        images: Array.isArray(values.images)
            ? values.images.join("\n")
            : values.images || "",
    };

    console.log(payload);

    router.post(propertyRoutes.store.url(), payload, {
        preserveScroll: true,
        onSuccess: () => {
            toast.success("Propiedad creada correctamente");
        },
        onError: (errors) => {
            setErrors(errors);
            toast.error("Error al intentar crear la Propiedad");
            console.log(errors);
        },
        onFinish: () => {
            saving.value = false;
        },
    });
});
</script>

<template>
    <Head title="Crear Propiedad" />

    <Card class="m-4 flex h-full flex-col shadow-none">
        <CardHeader>
            <CardTitle>Crear Propiedad</CardTitle>
            <CardDescription>
                Completa la información del nuevo registro.
            </CardDescription>
        </CardHeader>

        <CardContent class="flex-1">
            <form
                @submit.prevent="submit"
                id="create-property-form"
                class="flex h-full flex-col"
            >
                <div class="grid grid-cols-1 gap-6">
                    <Separator />

                    <div class="grid gap-4">
                        <Label>Información básica</Label>
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
                            <InputError :message="errors.slug" />
                        </div>
                    </div>

                    <Separator />

                    <PropertyImageUpload
                        v-model="images"
                        label="Imágenes"
                        :error="errors.images"
                    />

                    <Separator />

                    <PropertyOperations
                        v-model:operations="operations"
                        :operation-types="props.operationTypes"
                        :property-statuses="props.propertyStatuses"
                        :currencies="props.currencies"
                        :saving="saving"
                    />

                    <InputError :message="errors.operations" />
                </div>
            </form>
        </CardContent>

        <CardFooter class="flex justify-end gap-4 p-4">
            <Button
                type="submit"
                form="create-property-form"
                :disabled="saving"
                class="cursor-pointer shadow-none"
            >
                <Spinner v-if="saving" />
                Guardar
            </Button>

            <Button
                as-child
                variant="outline"
                :disabled="saving"
                class="shadow-none"
            >
                <Link :href="propertyRoutes.index()">Cancelar</Link>
            </Button>
        </CardFooter>
    </Card>
</template>
