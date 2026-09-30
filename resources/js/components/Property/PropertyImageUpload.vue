<script setup lang="ts">
import { ref, watch, onUnmounted } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
import { Label } from "@/components/ui/label";
import {
    Attachment,
    AttachmentAction,
    AttachmentActions,
    AttachmentContent,
    AttachmentDescription,
    AttachmentMedia,
    AttachmentTitle,
    AttachmentGroup,
} from "@/components/ui/attachment";
import { Spinner } from "@/components/ui/spinner";
import {
    UploadIcon,
    FileImageIcon,
    RefreshCwIcon,
    XIcon,
    FileWarningIcon,
    CheckIcon,
} from "@lucide/vue";
import InputError from "@/components/InputError.vue";

const props = withDefaults(
    defineProps<{
        modelValue: string[];
        label?: string;
        accept?: string;
        maxFiles?: number;
        maxSize?: number;
        error?: string;
    }>(),
    {
        accept: "image/*",
        maxFiles: Infinity,
        maxSize: 5 * 1024 * 1024,
    },
);

const emit = defineEmits<{
    (e: "update:modelValue", value: string[]): void;
}>();

const { post, processing } = useForm();

const fileInput = ref<HTMLInputElement | null>(null);
const intervals = ref<Map<string, number>>(new Map());

interface ImageItem {
    id: string;
    url: string;
    name: string;
    size: number;
    type: string;
    status: "uploading" | "error" | "done";
    isNew: boolean;
    progress: number;
    file?: File;
}

const imageItems = ref<ImageItem[]>([]);

watch(
    () => props.modelValue,
    (newValue) => {
        if (!newValue) {
            imageItems.value = [];
            return;
        }

        const currentUrls = new Set(newValue);

        imageItems.value = imageItems.value.filter((item) => {
            if (item.status === "uploading") {
                return true;
            }
            if (!currentUrls.has(item.url)) {
                if (item.url.startsWith("blob:")) {
                    URL.revokeObjectURL(item.url);
                }
                return false;
            }
            return true;
        });

        newValue.forEach((url) => {
            let existingItem = imageItems.value.find(
                (item) => item.url === url,
            );

            if (!existingItem) {
                const filename = url.split("/").pop() || "";
                existingItem = imageItems.value.find(
                    (item) =>
                        item.status === "uploading" && item.name === filename,
                );
                if (existingItem) {
                    existingItem.url = url;
                    existingItem.status = "done";
                    existingItem.progress = 100;
                }
            }

            if (!existingItem) {
                imageItems.value.push({
                    id: crypto.randomUUID(),
                    url,
                    name: url.split("/").pop() || "image",
                    size: 0,
                    type: "image/*",
                    status: "done",
                    isNew: false,
                    progress: 100,
                });
            }
        });
    },
    { immediate: true },
);

function formatFileSize(bytes: number): string {
    if (bytes === 0) return "0 Bytes";
    const k = 1024;
    const sizes = ["Bytes", "KB", "MB", "GB"];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i];
}

function getFileExtension(filename: string): string {
    return filename.split(".").pop()?.toUpperCase() || "";
}

function getFileTypeLabel(type: string): string {
    if (!type) return "Imagen";
    return type.split("/")[1]?.toUpperCase() || type;
}

function triggerFileSelect() {
    fileInput.value?.click();
}

function handleFileChange(event: Event) {
    const input = event.target as HTMLInputElement;
    if (!input.files) return;

    const files = Array.from(input.files);
    const maxSize = props.maxSize;
    const maxFiles = props.maxFiles;

    const currentCount = imageItems.value.filter(
        (item) => item.status !== "error",
    ).length;
    if (currentCount + files.length > maxFiles) {
        alert(`Máximo ${maxFiles} archivos permitidos`);
        input.value = "";
        return;
    }

    files.forEach((file) => {
        if (!file.type.startsWith("image/")) {
            alert(`El archivo ${file.name} no es una imagen`);
            return;
        }

        if (file.size > maxSize) {
            alert(
                `El archivo ${file.name} excede el tamaño máximo de ${formatFileSize(maxSize)}`,
            );
            return;
        }

        const url = URL.createObjectURL(file);
        const id = crypto.randomUUID();
        const item: ImageItem = {
            id,
            url,
            name: file.name,
            size: file.size,
            type: file.type,
            status: "uploading",
            isNew: true,
            progress: 0,
            file,
        };
        imageItems.value.push(item);
        simulateUpload(item);
    });

    input.value = "";
}

function simulateUpload(item: ImageItem) {
    const id = item.id;
    if (intervals.value.has(id)) {
        clearInterval(intervals.value.get(id)!);
    }

    const duration = 1500 + Math.random() * 1000;
    const startTime = Date.now();

    const intervalId = setInterval(async () => {
        const elapsed = Date.now() - startTime;
        const progress = Math.min((elapsed / duration) * 100, 100);
        item.progress = Math.round(progress);

        if (progress >= 100) {
            clearInterval(intervalId);
            intervals.value.delete(id);
            await uploadFile(item);
        }
    }, 100);

    intervals.value.set(id, intervalId);
}

async function uploadFile(item: ImageItem) {
    if (!item.file) {
        item.status = "error";
        return;
    }

    try {
        const formData = new FormData();
        formData.append("images[]", item.file);

        const response = await fetch("/properties/upload-images", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN":
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute("content") || "",
                Accept: "application/json",
            },
            body: formData,
        });

        if (!response.ok) {
            throw new Error("Upload failed");
        }

        const data = await response.json();
        const path = data.paths?.[0];

        if (!path) {
            throw new Error("Invalid response");
        }

        item.url = path;
        item.status = "done";
        item.progress = 100;
        emitUpdate();
    } catch {
        item.status = "error";
    }
}

function removeImage(id: string) {
    const item = imageItems.value.find((i) => i.id === id);
    if (item && item.url.startsWith("blob:")) {
        URL.revokeObjectURL(item.url);
    }
    if (intervals.value.has(id)) {
        clearInterval(intervals.value.get(id)!);
        intervals.value.delete(id);
    }
    imageItems.value = imageItems.value.filter((i) => i.id !== id);
    emitUpdate();
}

function retryUpload(id: string) {
    const item = imageItems.value.find((i) => i.id === id);
    if (item && item.file) {
        item.status = "uploading";
        item.progress = 0;
        simulateUpload(item);
    }
}

function emitUpdate() {
    const urls = imageItems.value
        .filter((item) => item.status === "done")
        .map((item) => item.url);
    emit("update:modelValue", urls);
}

function getStateLabel(status: ImageItem["status"], progress: number): string {
    switch (status) {
        case "uploading":
            return `Subiendo · ${progress}%`;
        case "error":
            return "Error al subir. Intentar de nuevo.";
        default:
            return "Listo";
    }
}

onUnmounted(() => {
    intervals.value.forEach((intervalId) => clearInterval(intervalId));
    imageItems.value.forEach((item) => {
        if (item.url.startsWith("blob:")) {
            URL.revokeObjectURL(item.url);
        }
    });
});
</script>

<template>
    <div class="grid gap-2">
        <Label v-if="label">{{ label }}</Label>
        <input
            ref="fileInput"
            type="file"
            :accept="accept"
            multiple
            class="hidden"
            @change="handleFileChange"
        />
        <Button
            type="button"
            variant="outline"
            class="cursor-pointer shadow-none"
            @click="triggerFileSelect"
            :disabled="processing"
        >
            <UploadIcon class="size-4 mr-2" />
            Cargar imágenes
        </Button>
        <AttachmentGroup
            v-if="imageItems.length > 0"
            class="flex flex-row gap-3 overflow-x-auto pb-2"
        >
            <Attachment
                v-for="item in imageItems"
                :key="item.id"
                :state="item.status"
                orientation="horizontal"
                class="w-64 shrink-0"
            >
                <AttachmentMedia
                    :variant="item.status === 'done' ? 'image' : 'default'"
                    class="relative size-16 shrink-0"
                >
                    <template v-if="item.status === 'done'">
                        <img
                            :src="item.url"
                            :alt="item.name"
                            class="size-full rounded-md object-cover"
                        />
                        <div class="absolute inset-0 flex items-center justify-center rounded-md bg-black/30">
                            <CheckIcon class="size-4 text-white drop-shadow" />
                        </div>
                    </template>
                    <template v-else-if="item.status === 'uploading'">
                        <Spinner class="size-4" />
                    </template>
                    <template v-else-if="item.status === 'error'">
                        <FileWarningIcon class="size-4 text-red-500" />
                    </template>
                </AttachmentMedia>
                <AttachmentContent>
                    <AttachmentTitle>{{ item.name }}</AttachmentTitle>
                    <AttachmentDescription>
                        <template v-if="item.isNew">
                            {{ getFileExtension(item.name) }} · {{ getFileTypeLabel(item.type) }} · {{ formatFileSize(item.size) }}
                        </template>
                        <template v-else>
                            Imagen guardada · {{ getStateLabel(item.status, item.progress) }}
                        </template>
                    </AttachmentDescription>
                </AttachmentContent>
                <AttachmentActions>
                    <AttachmentAction
                        v-if="item.status === 'error'"
                        aria-label="Reintentar subida"
                        @click="retryUpload(item.id)"
                    >
                        <RefreshCwIcon class="size-4" />
                    </AttachmentAction>
                    <AttachmentAction
                        v-if="item.status === 'uploading'"
                        aria-label="Cancelar subida"
                        @click="removeImage(item.id)"
                    >
                        <XIcon class="size-4" />
                    </AttachmentAction>
                    <AttachmentAction
                        v-if="item.status === 'done'"
                        aria-label="Eliminar imagen"
                        @click="removeImage(item.id)"
                    >
                        <XIcon class="size-4" />
                    </AttachmentAction>
                </AttachmentActions>
            </Attachment>
        </AttachmentGroup>
        <InputError :message="error" />
    </div>
</template>
