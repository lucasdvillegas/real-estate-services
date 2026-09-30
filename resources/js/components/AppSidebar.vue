<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import {
    BookOpen,
    FolderGit2,
    LayoutGrid,
    Home,
    HousePlus,
    Houses,
    Tag,
    Type,
} from "@lucide/vue";
import AppLogo from "@/components/AppLogo.vue";
import NavMain from "@/components/NavMain.vue";
import NavUser from "@/components/NavUser.vue";
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from "@/components/ui/sidebar";
import { dashboard } from "@/routes";
import propertyTypeRoutes from "@/routes/propertytypes";
import propertyFeatureRoutes from "@/routes/propertyfeatures";
import operationTypeRoutes from "@/routes/operationTypes";
import propertyRoutes from "@/routes/properties";
import propertyStatusRoutes from "@/routes/propertyStatuses";
import type { NavItem } from "@/types";

const mainNavItems: NavItem[] = [
    {
        title: "Dashboard",
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: "Tipos de Propiedades",
        href: propertyTypeRoutes.index(),
        icon: Houses,
    },
    {
        title: "Características",
        href: propertyFeatureRoutes.index(),
        icon: HousePlus,
    },
    {
        title: "Tipos de Operación",
        href: operationTypeRoutes.index(),
        icon: Type,
    },
    {
        title: "Propiedades",
        href: propertyRoutes.index(),
        icon: Home,
    },
    {
        title: "Estados de Propiedad",
        href: propertyStatusRoutes.index(),
        icon: Tag,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: "Repository",
        href: "https://github.com/laravel/vue-starter-kit",
        icon: FolderGit2,
    },
    {
        title: "Documentation",
        href: "https://laravel.com/docs/starter-kits#vue",
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
