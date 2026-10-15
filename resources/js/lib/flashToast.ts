import { router } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import type { FlashToast } from '@/types/ui';

const VALID_TOAST_TYPES: FlashToast['type'][] = ['success', 'error', 'info', 'warning'];

export function initializeFlashToast(): void {
    router.on('finish', (event: CustomEvent) => {
        const flash = event.detail?.page?.props?.flash as Record<string, string> | undefined;

        if (!flash) {
            return;
        }

        for (const [type, message] of Object.entries(flash)) {
            if (VALID_TOAST_TYPES.includes(type as FlashToast['type'])) {
                toast[type as FlashToast['type']](message);
            }
        }
    });
}
