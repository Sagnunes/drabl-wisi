<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogOverlay,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import ObjectStatus, {getStatusName} from '@/constants/digital_object_status';

import { DigitalObject } from '@/types/digital-collection';
import { DialogPortal } from 'reka-ui';
import { PropType } from 'vue';

defineProps({
    resource: { type: Object as PropType<DigitalObject>, required: true },
});

const DESCRIPTIONS_PATH_PATTERN = /(?=\/descriptions)/;
const VIEWER_PATH_SEGMENT = '/viewer';

function createViewerUrl(url: string): string {
    if (!url?.trim()) {
        return '';
    }

    const [baseUrl, path] = url.split(DESCRIPTIONS_PATH_PATTERN);

    if (!path) {
        return '';
    }

    return `${baseUrl}${VIEWER_PATH_SEGMENT}${path}`;
}


const ACTIVE_STATUSES = new Set([ObjectStatus.ASSOCIATED, ObjectStatus.PUBLISHED]);

const isAssociatedOrPublished = (status: number): boolean =>
    ACTIVE_STATUSES.has(status);

type StatusResponse = {
    text: string;
    color: string;
};

// Define color constants
const STATUS_COLORS = {
    YELLOW: 'bg-yellow-50 text-yellow-800 ring-1 ring-yellow-600/20 ring-inset dark:bg-yellow-400/10 dark:text-yellow-500 dark:ring-1 dark:ring-yellow-400/20',
    RED: 'bg-red-50 text-red-700 ring-1 ring-red-600/10 ring-inset dark:bg-red-400/10 dark:text-red-400 dark:ring-1 dark:ring-red-400/20',
    GREEN: 'bg-green-50 ring-1 ring-green-600/20 ring-inset dark:bg-green-500/10 dark:text-green-400 dark:ring-1 dark:ring-green-500/20',
} as const;


const STATUS_MAP: Record<ObjectStatus, StatusResponse> = {
    [ObjectStatus.noASSOCIATION]: {
        text: getStatusName(ObjectStatus.noASSOCIATION),
        color: STATUS_COLORS.YELLOW,
    },
    [ObjectStatus.ASSOCIATED]: {
        text: getStatusName(ObjectStatus.ASSOCIATED),
        color: STATUS_COLORS.RED,
    },
    [ObjectStatus.PUBLISHED]: {
        text: getStatusName(ObjectStatus.PUBLISHED),
        color: STATUS_COLORS.GREEN,
    },
};

const getResourceStatus = (status: ObjectStatus): StatusResponse => {
    return STATUS_MAP[status] ?? {
        text: 'Erro.',
        color: STATUS_COLORS.RED,
    };
};
</script>

<template>
    <div class="flex flex-col gap-y-1">
        <Dialog class="lg:max-w-xl">
            <DialogTrigger>
                <img
                    :src="resource.image_thumb"
                    :alt="resource.image_name"
                    class="aspect-square w-full rounded-lg bg-gray-100 object-cover group-hover:opacity-75"
                    loading="lazy"
                    decoding="async"
                    fetchpriority="low"
                />
            </DialogTrigger>
            <DialogPortal>
                <DialogOverlay class="bg-primary/10">
                    <DialogContent class="md:max-h-[90vh] md:max-w-6xl">
                        <DialogHeader>
                            <DialogTitle>
                                <div class="mt-4 flex items-center gap-x-3 text-sm">
                                    <div class="font-semibold text-sidebar-primary">
                                        {{ resource.inventory_number }}
                                    </div>
                                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium" :class="getResourceStatus(resource.status).color">{{ getResourceStatus(resource.status).text }}</span>
                                </div>
                            </DialogTitle>
                            <DialogDescription>
                                {{ resource.title }}
                            </DialogDescription>
                        </DialogHeader>
                        <div class="flex min-h-0 w-full flex-1 items-center justify-center">
                            <img
                                :src="resource.image_derivative"
                                :alt="resource.image_name"
                                class="max-h-full max-w-full rounded-lg object-contain"
                            />
                        </div>
                        <DialogFooter class="lg:flex-row" :class="isAssociatedOrPublished(resource.status) ? 'lg:justify-between' : ''">
                            <div class="flex flex-row items-center gap-x-5" v-if="isAssociatedOrPublished(resource.status)">
                                <a
                                    :href="resource.website_link"
                                    class="cursor-pointer text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                                    target="_blank"
                                >Documento</a
                                >
                                <a
                                    :href="createViewerUrl(resource.website_link)"
                                    class="cursor-pointer text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                                    target="_blank"
                                >Objeto</a
                                >
                            </div>
                            <DialogClose as-child>
                                <Button variant="default">Fechar</Button>
                            </DialogClose>
                        </DialogFooter>
                    </DialogContent>
                </DialogOverlay>
            </DialogPortal>
        </Dialog>
        <div class="flex flex-col items-start justify-evenly gap-y-2">
            <h3 class="font-medium text-primary">{{ resource.title }}</h3>
            <p class="float-end text-muted-foreground italic">{{ resource.inventory_number }}</p>
            <a
                :href="resource.website_link"
                class="text-xs font-medium text-primary/30 hover:text-primary"
                target="_blank"
                v-show="resource.website_link"
            >ARCHEEVO</a
            >
        </div>
    </div>
</template>

<style scoped></style>
