<script setup lang="ts">
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import { Pencil, Plus, Search } from "@lucide/vue";
import { ref, watch } from "vue";

import DataTablePagination from "@/components/DataTablePagination.vue";
import DeleteActionButton from "@/components/DeleteActionButton.vue";
import { Input } from "@/components/ui/input";

import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table";

import propertyFeatureRoutes from "@/routes/propertyfeatures";
import type { PropertyFeature } from "@/types/propertyFeature";

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: "Características de Inmuebles",
                href: propertyFeatureRoutes.index(),
            },
        ],
    },
});

const props = defineProps<{
    propertyFeatures: {
        data: PropertyFeature[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
        from: number | null;
        to: number | null;
    };
}>();

const page = usePage();

const search = ref<string>((page.props.filters as any)?.search ?? "");

watch(
    () => page.props.filters,
    (filters: any) => {
        search.value = filters?.search ?? "";
    },
);

const applyFilters = () => {
    router.get(
        propertyFeatureRoutes.index.url(),
        {
            search: search.value || undefined,
            page: 1,
            per_page: props.propertyFeatures.per_page,
        },
        {
            preserveScroll: true,
            preserveState: false,
            replace: true,
        },
    );
};

const deleteItem = (id: number) => {
    router.delete(propertyFeatureRoutes.destroy(id));
};
</script>

<template>
    <Head title="Característica" />

    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
        <div class="rounded-xl border p-4">
            <div class="mb-4 flex items-center justify-between gap-2">
                <Link
                    :href="propertyFeatureRoutes.create()"
                    class="flex items-center gap-2 rounded-md bg-primary px-4 py-2 text-sm text-primary-foreground hover:bg-primary/90"
                >
                    <Plus class="h-4 w-4" />
                    Crear Característica
                </Link>

                <div class="relative w-[240px]">
                    <Search
                        class="absolute top-1/2 left-2 h-4 w-4 -translate-y-1/2 text-muted-foreground"
                    />
                    <Input
                        v-model="search"
                        placeholder="Buscar por Nombre"
                        class="pl-8"
                        @input="applyFilters()"
                    />
                </div>
            </div>

            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead class="px-4 py-2">Nombre</TableHead>
                        <TableHead class="px-4 py-2">Código</TableHead>
                        <TableHead class="pr-4 text-right">Acciones</TableHead>
                    </TableRow>
                </TableHeader>

                <TableBody>
                    <TableRow
                        v-for="item in props.propertyFeatures.data"
                        :key="item.id"
                    >
                        <TableCell class="px-4 py-2">{{ item.name }}</TableCell>
                        <TableCell class="px-4 py-2">{{ item.code }}</TableCell>
                        <TableCell>
                            <div class="flex justify-end gap-2 pr-2">
                                <Link
                                    :href="propertyFeatureRoutes.edit(item.id)"
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
                </TableBody>
            </Table>

            <DataTablePagination
                :pagination="props.propertyFeatures"
                :route="propertyFeatureRoutes.index.url()"
                :filters="{ search }"
            />
        </div>
    </div>
</template>
