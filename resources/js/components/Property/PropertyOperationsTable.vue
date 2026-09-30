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

import type { OperationType } from "@/types/operationType";
import type { PropertyStatus } from "@/types/propertyStatus";

const props = defineProps<{
    operations: Array<{
        operation_type_id: number;
        price: string | number;
        currency: string;
        status: string;
    }>;
    operationTypes: OperationType[];
    propertyStatuses: PropertyStatus[];
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
                <TableHead>Tipo</TableHead>
                <TableHead>Precio</TableHead>
                <TableHead>Moneda</TableHead>
                <TableHead>Estado</TableHead>
                <TableHead class="text-right">Acciones</TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow
                v-for="(operation, index) in operations"
                :key="index"
            >
                <TableCell class="capitalize">
                    {{ (props.operationTypes.find((t) => t.id === operation.operation_type_id) as any)?.name ?? (operation.operation_type_id ?? "-") }}
                </TableCell>
                <TableCell>{{ operation.price }}</TableCell>
                <TableCell>{{ operation.currency }}</TableCell>
                <TableCell>
                    {{ (props.propertyStatuses.find((s) => s.code === operation.status) as any)?.name ?? operation.status }}
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
