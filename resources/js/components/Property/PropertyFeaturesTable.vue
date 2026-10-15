<script setup lang="ts">
import { Pencil, Trash2 } from "@lucide/vue";
import { Button } from "@/components/ui/button";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table";

import type { PropertyFeatureType } from "@/types/propertyFeature";

const props = defineProps<{
    features: Array<{ id?: number; property_feature_id: number; quantity?: number }>;
    propertyFeatures: PropertyFeatureType[];
}>();

const emit = defineEmits<{
    (e: "edit", index: number): void;
    (e: "remove", index: number): void;
}>();
</script>

<template>
    <Table>
        <TableHeader>
            <TableRow>
                <TableHead>Característica</TableHead>
                <TableHead class="text-right">Cantidad</TableHead>
                <TableHead class="text-right">Acciones</TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="(feature, index) in features" :key="feature.id ?? feature.property_feature_id">
                <TableCell>
                    {{ (props.propertyFeatures.find((f) => f.id === feature.property_feature_id) as any)?.name ?? feature.property_feature_id }}
                </TableCell>
                <TableCell class="text-right">
                    {{ feature.quantity ?? '-' }}
                </TableCell>
                <TableCell class="text-right">
                    <Button
                        type="button"
                        variant="ghost"
                        size="icon"
                        @click="emit('edit', index)"
                    >
                        <Pencil class="size-4" />
                    </Button>
                    <Button
                        type="button"
                        variant="ghost"
                        size="icon"
                        @click="emit('remove', index)"
                    >
                        <Trash2 class="size-4 text-destructive" />
                    </Button>
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>
