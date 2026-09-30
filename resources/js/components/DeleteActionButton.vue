<script setup lang="ts">
import { Trash2 } from '@lucide/vue';
import { ref } from 'vue';

import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/components/ui/alert-dialog';
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@/components/ui/tooltip';

const props = defineProps<{
    id: number;
    title?: string;
    description?: string;
}>();

const emit = defineEmits<{
    (e: 'confirm', id: number): void;
}>();

const open = ref(false);

function confirm() {
    emit('confirm', props.id);
    open.value = false;
}
</script>

<template>
    <AlertDialog v-model:open="open">
        <TooltipProvider :delay-duration="200">
            <Tooltip>
                <TooltipTrigger as-child>
                    <AlertDialogTrigger as-child>
                        <button
                            class="cursor-pointer text-red-500 transition hover:text-red-700"
                        >
                            <Trash2 class="h-5 w-5" />
                        </button>
                    </AlertDialogTrigger>
                </TooltipTrigger>

                <TooltipContent>Eliminar registro</TooltipContent>
            </Tooltip>
        </TooltipProvider>

        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>
                    {{ title ?? '¿Eliminar registro?' }}
                </AlertDialogTitle>

                <AlertDialogDescription>
                    {{ description ?? 'Esta acción no se puede deshacer.' }}
                </AlertDialogDescription>
            </AlertDialogHeader>

            <AlertDialogFooter>
                <AlertDialogCancel>Cancelar</AlertDialogCancel>

                <AlertDialogAction
                    class="bg-red-500 hover:bg-red-700"
                    @click="confirm"
                >
                    Eliminar
                </AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
