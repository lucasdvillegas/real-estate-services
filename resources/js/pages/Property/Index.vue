<script setup lang="ts">
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import { ChevronDown, Pencil, Plus, Search } from "@lucide/vue";
import { ref, watch } from "vue";

import DataTablePagination from "@/components/DataTablePagination.vue";
import DeleteActionButton from "@/components/DeleteActionButton.vue";
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";

import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table";

import propertyRoutes from "@/routes/properties";
import type { Property } from "@/types/property";

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
    properties: {
        data: Property[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
        from: number | null;
        to: number | null;
    };
}>();

console.log(props.properties);

const page = usePage();

const search = ref<string>((page.props.filters as any)?.search ?? "");

const expandedId = ref<number | null>(null);

watch(
    () => page.props.filters,
    (filters: any) => {
        search.value = filters?.search ?? "";
    },
);

const applyFilters = () => {
    router.get(
        propertyRoutes.index.url(),
        {
            search: search.value || undefined,
            page: 1,
            per_page: props.properties.per_page,
        },
        {
            preserveScroll: true,
            preserveState: false,
            replace: true,
        },
    );
};

const deleteItem = (id: number) => {
    router.delete(propertyRoutes.destroy(id));
};

const formatPrice = (value: number | string | undefined | null): string => {
    if (value === undefined || value === null || value === "") {
        return "-";
    }
    const numericValue = typeof value === "string" ? parseFloat(value) : value;
    if (isNaN(numericValue)) {
        return "-";
    }
    return "$" + numericValue.toLocaleString("es-AR");
};

const getStatusLabel = (
    status: string | { name?: string } | undefined | null,
): string => {
    return typeof status === "string" ? status : (status?.name ?? "-");
};
</script>

<template>
    <Head title="Propiedades" />

    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
        <div class="rounded-xl border p-4">
            <div class="mb-4 flex items-center justify-between gap-2">
                <Link
                    :href="propertyRoutes.create()"
                    class="flex items-center gap-2 rounded-md bg-primary px-4 py-2 text-sm text-primary-foreground hover:bg-primary/90"
                >
                    <Plus class="h-4 w-4" />
                    Crear Propiedad
                </Link>

                <div class="relative w-[240px]">
                    <Search
                        class="absolute top-1/2 left-2 h-4 w-4 -translate-y-1/2 text-muted-foreground"
                    />
                    <Input
                        v-model="search"
                        placeholder="Buscar por Título"
                        class="pl-8"
                        @input="applyFilters()"
                    />
                </div>
            </div>

            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead class="px-4 py-2">Título</TableHead>
                        <TableHead class="px-4 py-2"
                            >Tipo de Propiedad</TableHead
                        >
                        <TableHead class="px-4 py-2">Operaciones</TableHead>
                        <TableHead class="pr-4 text-right">Acciones</TableHead>
                    </TableRow>
                </TableHeader>

                <TableBody>
                    <template
                        v-for="item in props.properties.data"
                        :key="item.id"
                    >
                        <TableRow>
                            <TableCell class="px-4 py-2">{{
                                item.title
                            }}</TableCell>
                            <TableCell class="px-4 py-2">{{
                                item.property_type?.name ?? "-"
                            }}</TableCell>
                            <TableCell class="px-4 py-2">
                                <Button
                                    v-if="item.operations?.length"
                                    variant="ghost"
                                    size="sm"
                                    class="h-auto p-1 font-normal"
                                    @click="
                                        expandedId =
                                            expandedId === item.id
                                                ? null
                                                : item.id
                                    "
                                >
                                    <span class="mr-1">{{
                                        item.operations.length
                                    }}</span>

                                    {{
                                        item.operations.length === 1
                                            ? "Operación"
                                            : "Operaciones"
                                    }}
                                    <ChevronDown
                                        :class="[
                                            'ml-1 size-4 transition-transform',
                                            expandedId === item.id
                                                ? 'rotate-180'
                                                : '',
                                        ]"
                                    />
                                </Button>
                                <span v-else class="text-muted-foreground">
                                    Sin operaciones
                                </span>
                            </TableCell>
                            <TableCell>
                                <div class="flex justify-end gap-2 pr-2">
                                    <Link
                                        :href="propertyRoutes.edit(item.id)"
                                        class="text-blue-500 transition hover:text-blue-700"
                                    >
                                        <Pencil class="h-5 w-5" />
                                    </Link>

                                    <DeleteActionButton
                                        :id="item.id"
                                        @confirm="deleteItem"
                                    />
                                </div>
                            </TableCell>
                        </TableRow>
                        <TableRow
                            v-if="
                                expandedId === item.id &&
                                item.operations?.length
                            "
                        >
                            <TableCell colspan="4" class="bg-muted/30 p-0">
                                <div class="grid grid-cols-4 gap-4 p-4">
                                    <div>
                                        <p
                                            class="mb-2 text-xs font-medium uppercase text-muted-foreground"
                                        >
                                            Tipo de Operación
                                        </p>
                                        <ul class="space-y-1 text-sm">
                                            <li
                                                v-for="operation in item.operations"
                                                :key="operation.id"
                                            >
                                                {{
                                                    operation.operation_type
                                                        ?.name ?? "-"
                                                }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <p
                                            class="mb-2 text-xs font-medium uppercase text-muted-foreground"
                                        >
                                            Precio
                                        </p>
                                        <ul class="space-y-1 text-sm">
                                            <li
                                                v-for="operation in item.operations"
                                                :key="operation.id"
                                            >
                                                {{
                                                    formatPrice(operation.price)
                                                }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <p
                                            class="mb-2 text-xs font-medium uppercase text-muted-foreground"
                                        >
                                            Moneda
                                        </p>
                                        <ul class="space-y-1 text-sm">
                                            <li
                                                v-for="operation in item.operations"
                                                :key="operation.id"
                                            >
                                                {{ operation.currency }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <p
                                            class="mb-2 text-xs font-medium uppercase text-muted-foreground"
                                        >
                                            Estado
                                        </p>
                                        <ul
                                            class="space-y-1 text-sm capitalize"
                                        >
                                            <li
                                                v-for="operation in item.operations"
                                                :key="operation.id"
                                            >
                                                {{
                                                    getStatusLabel(
                                                        operation.status,
                                                    )
                                                }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </TableCell>
                        </TableRow>
                    </template>
                </TableBody>
            </Table>

            <DataTablePagination
                :pagination="props.properties"
                :route="propertyRoutes.index.url()"
                :filters="{ search }"
            />
        </div>
    </div>
</template>
