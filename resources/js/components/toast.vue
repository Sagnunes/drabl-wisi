<!-- resources/js/Components/Toast.vue -->
<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { ToastClose, ToastDescription, ToastProvider, ToastRoot, ToastTitle, ToastViewport } from 'reka-ui';
import { ref, watch } from 'vue';

interface ToastData {
    title: string;
    message: string;
}

const page = usePage();
const toastData = ref<ToastData | null>(null);

watch(
    () => page.props.toast,
    (data) => {
        if (data) {
            toastData.value = data;
            setTimeout(() => (toastData.value = null), 5000);
        }
    },
    { immediate: true },
);
</script>

<template>
    <ToastProvider>
        <div class="fixed top-5 right-5 z-50">
            <Transition
                enter-active-class="animate-[slide-in-left_0.3s_ease-out_forwards]"
                leave-active-class="animate-[slide-out-left_0.3s_ease-out_forwards]"
            >
                <ToastRoot v-if="toastData" type="foreground" class="w-full max-w-sm rounded-lg border border-green-300 bg-white shadow-lg">
                    <div class="flex items-center space-x-4 p-4">
                        <div class="flex-shrink-0">
                            <svg
                                class="h-6 w-6 text-green-500"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <ToastTitle class="text-lg font-semibold text-gray-900">{{ toastData.title }}</ToastTitle>
                            <ToastDescription class="text-sm text-gray-600">
                                {{ toastData.message }}
                            </ToastDescription>
                        </div>
                        <ToastClose
                            @click="toastData = null"
                            class="rounded text-gray-400 hover:text-gray-600 focus:ring-2 focus:ring-green-500 focus:outline-none"
                            >Dismiss
                            <span class="sr-only">Close</span>
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                        </ToastClose>
                    </div>
                </ToastRoot>
            </Transition>
        </div>
        <ToastViewport />
    </ToastProvider>
</template>
<style scoped>
@keyframes slide-in-left {
    from {
        transform: translateX(-100%);
    }
    to {
        transform: translateX(0);
    }
}

@keyframes slide-out-left {
    from {
        transform: translateX(0);
    }
    to {
        transform: translateX(-100%);
    }
}
</style>
