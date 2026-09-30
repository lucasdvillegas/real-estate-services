<script setup lang="ts">
import type { HTMLAttributes } from "vue"
import { cn } from "@/lib/utils"

const props = withDefaults(
    defineProps<{
        class?: HTMLAttributes["class"]
        variant?: "default" | "image"
    }>(),
    {
        variant: "default",
    },
)
</script>

<template>
    <div
        :class="
            cn(
                'flex size-9 shrink-0 items-center justify-center rounded-md border bg-muted',
                variant === 'image' && 'relative size-32 rounded-lg border-0 bg-transparent',
                props.class,
            )
        "
    >
        <slot />
    </div>
</template>
