<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { useForm } from 'vee-validate';
import { ref } from 'vue';
import { toast } from 'vue-sonner';
import * as yup from 'yup';

import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent,
    CardFooter,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';

import propertyFeatureRoutes from '@/routes/propertyfeatures';
import type { PropertyFeature } from '@/types/propertyFeature';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Editar Característica',
                href: propertyFeatureRoutes.index(),
            },
        ],
    },
});

const props = defineProps<{
    propertyFeature: PropertyFeature;
}>();

const saving = ref(false);

const schema = yup.object({
    name: yup.string().required().label('Nombre'),
    code: yup.string().required().label('Código'),
});

const { handleSubmit, defineField, errors, setErrors } = useForm({
    validationSchema: schema,
    initialValues: {
        name: props.propertyFeature.name,
        code: props.propertyFeature.code,
    },
});

const [name] = defineField('name');
const [code] = defineField('code');

const submit = handleSubmit((values) => {
    saving.value = true;

    router.put(
        propertyFeatureRoutes.update.url(props.propertyFeature.id),
        values,
        {
            preserveScroll: true,
            onSuccess: () => {
                toast.success('PropertyFeature actualizado correctamente');
            },
            onError: (errors) => {
                setErrors(errors);
                toast.error('Error al intentar actualizar el PropertyFeature');
                console.log(errors);
            },
            onFinish: () => {
                saving.value = false;
            },
        },
    );
});
</script>

<template>
    <Head title="Editar Característica" />

    <Card class="m-4 flex h-full flex-col shadow-none">
        <CardHeader>
            <CardTitle>Editar Característica</CardTitle>
            <CardDescription>
                Modifica la información del registro.
            </CardDescription>
        </CardHeader>

        <CardContent class="flex-1">
            <form
                @submit.prevent="submit"
                id="edit-propertyFeature-form"
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
                form="edit-propertyFeature-form"
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
                <Link :href="propertyFeatureRoutes.index()"> Cancelar </Link>
            </Button>
        </CardFooter>
    </Card>
</template>
