<script setup lang="ts">
import type { HTMLAttributes } from "vue";
import { cn } from "@/lib/utils";

const props = withDefaults(
    defineProps<{
        class?: HTMLAttributes["class"];
        state?: "idle" | "uploading" | "processing" | "error" | "done";
        orientation?: "vertical" | "horizontal";
        variant?: "default" | "image";
    }>(),
    {
        orientation: "horizontal",
        variant: "default",
    },
);
</script>

<template>
    <div
        :class="
            cn(
                'flex gap-3 rounded-lg border p-2 transition-colors',
                orientation === 'vertical' && 'flex-col',
                state === 'error' && 'border-destructive',
                state === 'done' && 'border-grey-600',
                props.class,
            )
        "
    >
        <slot />
    </div>
</template>
