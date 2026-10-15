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
import { Label } from "@/components/ui/label";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import { Spinner } from "@/components/ui/spinner";
import { Input } from "@/components/ui/input";

import InputError from "@/components/InputError.vue";

import type { PropertyFeatureType } from "@/types/propertyFeature";

const props = withDefaults(
    defineProps<{
        open: boolean;
        saving: boolean;
        mode: "create" | "edit";
        feature?: {
            property_feature_id: number;
            quantity?: number;
        };
        propertyFeatures: PropertyFeatureType[];
    }>(),
    {
        feature: undefined,
    },
);

const emit = defineEmits<{
    (e: "update:open", value: boolean): void;
    (e: "save", feature: { property_feature_id: number; quantity?: number }): void;
}>();

const schema = yup.object({
    property_feature_id: yup.string().required().label("Característica"),
    quantity: yup.number().nullable().transform(value => value === "" ? null : value).label("Cantidad"),
});

const { handleSubmit, defineField, errors, resetForm, setValues } = useForm({
    validationSchema: schema,
    initialValues: {
        property_feature_id: "",
        quantity: null,
    },
});

const [propertyFeatureId] = defineField("property_feature_id");
const [quantity] = defineField("quantity");

const internalOpen = ref(props.open);

watch(
    () => props.open,
    (value) => {
        internalOpen.value = value;
        if (value) {
            if (props.mode === "edit" && props.feature) {
                setValues({
                    property_feature_id: String(props.feature.property_feature_id),
                    quantity: props.feature.quantity ?? null,
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
        property_feature_id: parseInt(values.property_feature_id),
        quantity: values.quantity ? parseInt(values.quantity) : null,
    });
});
</script>

<template>
    <Dialog :open="internalOpen" @update:open="internalOpen = $event">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>
                    {{ mode === "edit" ? "Editar Característica" : "Agregar Característica" }}
                </DialogTitle>
                <DialogDescription>
                    {{
                        mode === "edit"
                            ? "Modificá la característica de la propiedad."
                            : "Completá la característica para esta propiedad."
                    }}
                </DialogDescription>
            </DialogHeader>

            <form @submit.prevent="onSubmit" class="grid gap-4">
                <div class="grid gap-2">
                    <Label for="feature">Característica</Label>
                    <Select v-model="propertyFeatureId">
                        <SelectTrigger id="feature">
                            <SelectValue placeholder="Seleccionar característica" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem
                                v-for="propertyFeatureItem in propertyFeatures"
                                :key="propertyFeatureItem.id"
                                :value="propertyFeatureItem.id.toString()"
                            >
                                {{ propertyFeatureItem.name }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                    <InputError :message="(errors as any).property_feature_id" />
                </div>

                <div class="grid gap-2">
                    <Label for="quantity">Cantidad</Label>
                    <Input id="quantity" type="number" v-model="quantity" />
                    <InputError :message="(errors as any).quantity" />
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
