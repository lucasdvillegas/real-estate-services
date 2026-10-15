<script setup lang="ts">
import { ref } from "vue";

import { Button } from "@/components/ui/button";
import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert";
import { Separator } from "@/components/ui/separator";
import { Info } from "@lucide/vue";

import PropertyFeaturesTable from "@/components/Property/PropertyFeaturesTable.vue";
import PropertyFeaturesModal from "@/components/Property/PropertyFeaturesModal.vue";

import type { PropertyFeatureType } from "@/types/propertyFeature";

const props = withDefaults(
    defineProps<{
        features: Array<{
            id?: number;
            property_feature_id: number;
            quantity?: number;
        }>;
        propertyFeatures: PropertyFeatureType[];
        saving?: boolean;
    }>(),
    {
        saving: false,
    },
);

const emit = defineEmits<{
    (e: "update:features", value: typeof props.features): void;
}>();

const dialogOpen = ref(false);
const editingIndex = ref<number | null>(null);
const editingFeature = ref<{ property_feature_id: number } | undefined>(
    undefined,
);

function openCreate() {
    editingIndex.value = null;
    editingFeature.value = undefined;
    dialogOpen.value = true;
}

function openEdit(index: number) {
    editingIndex.value = index;
    editingFeature.value = props.features[index];
    dialogOpen.value = true;
}

function remove(index: number) {
    const next = [...props.features];
    next.splice(index, 1);
    emit("update:features", next);
}

function handleSave(feature: {
    property_feature_id: number;
    quantity?: number;
}) {
    if (editingIndex.value !== null) {
        const next = [...props.features];
        next[editingIndex.value] = feature;
        emit("update:features", next);
    } else {
        emit("update:features", [...props.features, feature]);
    }
    dialogOpen.value = false;
    editingIndex.value = null;
    editingFeature.value = undefined;
}
</script>

<template>
    <div class="grid gap-4">
        <div class="flex items-center justify-between">
            <p class="text-sm font-medium">Características</p>
            <Button
                type="button"
                variant="outline"
                size="sm"
                class="cursor-pointer shadow-none"
                @click="openCreate"
            >
                Agregar característica
            </Button>
        </div>

        <Alert>
            <Info class="size-4" />
            <AlertTitle>Múltiples características</AlertTitle>
            <AlertDescription>
                Podés agregar varias características como baños, dormitorios,
                superficie, etc.
            </AlertDescription>
        </Alert>

        <PropertyFeaturesTable
            :features="features"
            :property-features="propertyFeatures"
            @edit="openEdit"
            @remove="remove"
        />

        <PropertyFeaturesModal
            :open="dialogOpen"
            :saving="saving"
            :mode="editingIndex !== null ? 'edit' : 'create'"
            :feature="editingFeature"
            :property-features="propertyFeatures"
            @update:open="dialogOpen = $event"
            @save="handleSave"
        />
    </div>
</template>
