<script setup lang="ts">
import { Head, Link, router } from "@inertiajs/vue3";
import { useForm } from "vee-validate";
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

import propertyStatusRoutes from "@/routes/propertystatuses";

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: "Estado de Propiedad",
                href: propertyStatusRoutes.index(),
            },
        ],
    },
});

const saving = ref(false);

const schema = yup.object({
    name: yup.string().required().label("Nombre"),
    code: yup.string().required().label("Código"),
});

const { handleSubmit, defineField, errors, setErrors } = useForm({
    validationSchema: schema,
    initialValues: {
        name: "",
        code: "",
    },
});

const [name] = defineField("name");
const [code] = defineField("code");

const submit = handleSubmit((values) => {
    saving.value = true;

    router.post(propertyStatusRoutes.store.url(), values, {
        preserveScroll: true,
        onSuccess: () => {
            toast.success("El Estado creado correctamente");
        },
        onError: (errors) => {
            setErrors(errors);
            toast.error("Error al intentar crear el Estado");
            console.log(errors);
        },
        onFinish: () => {
            saving.value = false;
        },
    });
});
</script>

<template>
    <Head title="Crear Estado" />

    <Card class="m-4 flex h-full flex-col shadow-none">
        <CardHeader>
            <CardTitle>Crear Estado</CardTitle>
            <CardDescription>
                Completa la información del nuevo registro.
            </CardDescription>
        </CardHeader>

        <CardContent class="flex-1">
            <form
                @submit.prevent="submit"
                id="create-propertyStatus-form"
                class="flex h-full flex-col"
            >
                <div class="grid grid-cols-1 gap-6">
                    <div class="grid gap-2">
                        <Label for="name">Nombre</Label>
                        <Input id="name" v-model="name" />
                        <InputError :message="errors.name" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="code">Código</Label>
                        <Input id="code" v-model="code" />
                        <InputError :message="errors.code" />
                    </div>
                </div>
            </form>
        </CardContent>

        <CardFooter class="flex justify-end gap-4 p-4">
            <Button
                type="submit"
                form="create-propertyStatus-form"
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
                <Link :href="propertyStatusRoutes.index()">Cancelar</Link>
            </Button>
        </CardFooter>
    </Card>
</template>
