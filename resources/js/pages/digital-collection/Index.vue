<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { FundWithDigitalObject } from '@/types/digital-collection';
import { Head, Link } from '@inertiajs/vue3';
import { PropType } from 'vue';

defineOptions({
    name: 'DigitalCollectionIndex',
});

const DIGITAL_COLLECTION_TITLE = 'Coleção Digital';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: DIGITAL_COLLECTION_TITLE,
        href: '/digital-collection',
    },
];

defineProps({
    fundWithDigitalObject: { type: Array as PropType<FundWithDigitalObject[]>, required: true },
});
</script>

<template>
    <Head :title="DIGITAL_COLLECTION_TITLE" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <div class="mx-auto max-w-7xl overflow-hidden sm:px-6 lg:px-8">
                    <h2 class="p-8 text-2xl font-bold tracking-tight text-primary">{{ DIGITAL_COLLECTION_TITLE }}</h2>
                    <div class="-mx-px grid grid-cols-2 sm:mx-0 md:grid-cols-3 lg:grid-cols-5">
                        <div v-for="fund in fundWithDigitalObject" :key="fund.id" class="group relative p-4 sm:p-6">
                            <Link prefetch="hover" cache-for="30s" :href="route('digital-collection.show', fund.id)">
                                <img
                                    :src="digital_object.image_thumb"
                                    :alt="digital_object.image_name"
                                    class="aspect-square w-full rounded-lg bg-gray-200 object-cover object-center group-hover:opacity-75"
                                    v-for="digital_object in fund.digital_objects"
                                    :key="digital_object.id"
                                    loading="lazy"
                                />
                                <div class="pt-10 pb-4 text-center">
                                    <h3 class="text-sm font-medium text-primary">
                                        <span aria-hidden="true" class="absolute inset-0" />
                                        {{ fund.acronym }}
                                    </h3>
                                    <p class="mt-4 text-base font-medium text-primary">{{ fund.name }}</p>
                                </div>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
