<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Pagination } from '@/types';
import { DigitalObject, Fund } from '@/types/digital-collection';
import { Head, router, WhenVisible } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { computed, PropType, ref, watch } from 'vue';

import DigitalObjectCard from '@/components/digital-collection/DigitalObjectCard.vue';
import SearchInput from '@/components/digital-collection/SearchInput.vue';

defineOptions({
    name: 'DigitalCollectionShow',
});

const props = defineProps({
    fund: { type: Object as PropType<Fund>, required: true },
    collections: { type: Array as PropType<DigitalObject[]>, required: true },
    pagination: { type: Object as PropType<Pagination>, required: true },
});

const BASE_ROUTE = '/digital-collection';
const MAIN_TITLE = 'Coleção Digital';

const breadcrumbItems = computed((): BreadcrumbItem[] => [
    {
        title: MAIN_TITLE,
        href: BASE_ROUTE,
    },
    {
        title: props.fund.acronym,
        href: `${BASE_ROUTE}/${props.fund?.id}`,
    },
]);

const searchInput = ref('');
const reachedEnd = computed(() => {
    return (props.pagination?.current_page ?? 0) >= (props.pagination?.last_page ?? 0);
});

watch(searchInput, (value) => {
    router.get(
        route('digital-collection.show', props.fund?.id),
        { search: value },
        {
            preserveState: true,
        },
    );
});

function onSearchInput(value: string) {
    searchInput.value = value;
}
</script>

<template>
    <Head :title="fund?.acronym ?? MAIN_TITLE" />

    <AppLayout :breadcrumbs="breadcrumbItems">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <div class="mx-auto max-w-7xl overflow-hidden px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
                    <div class="sm:flex sm:items-baseline sm:justify-between lg:mb-5 lg:items-center">
                        <h2 class="text-2xl font-bold tracking-tight text-primary">{{ MAIN_TITLE }} - {{ fund?.name }}</h2>
                        <SearchInput :model-value="searchInput" @update:modelValue="onSearchInput" />
                    </div>
                    <p class="my-3 text-xs text-primary">
                        Foram encontrados: <span class="font-bold">{{ pagination.total }}</span> objetos digitais.
                    </p>
                    <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-5 lg:gap-x-8">
                        <div v-for="resource in collections" :key="resource.id" class="group text-sm">
                            <DigitalObjectCard :resource />
                        </div>
                        <WhenVisible
                            :always="!reachedEnd"
                            :params="{ only: ['collections', 'pagination'], data: { page: (pagination?.current_page ?? 0) + 1 } }"
                        >
                            <template #fallback>
                                <LoaderCircle></LoaderCircle>
                            </template>
                        </WhenVisible>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
