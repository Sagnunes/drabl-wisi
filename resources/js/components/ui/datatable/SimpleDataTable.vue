<script setup lang="ts">
import { Pencil, X } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';

defineProps(['columns', 'data']);

const emit = defineEmits(['delete']);

const handleDelete = (item: any) => {
    emit('delete', item);
};
</script>

<template>
    <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col"
                class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                v-for="column in columns" :key="column.key">{{ column.label }}
            </th>
            <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-6">
                <span class="sr-only">Edit</span>
            </th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
        <tr v-for="(row, index) in data" :key="index">
            <td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-500 sm:pl-6"
                v-for="column in columns"
                :key="column.key">
                {{ row[column.key] }}
            </td>
            <td class="relative py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-6">
                <div class="flex justify-end gap-3">
                    <Button variant="ghost" class="h-8 w-8">
                        <Pencil class="h-4 w-4" />
                        <span class="sr-only">Editar</span>
                    </Button>
                    <Button variant="ghost" class="h-8 w-8" @click="handleDelete(row)">
                        <X class="h-4 w-4" />
                        <span class="sr-only">Apagar</span>
                    </Button>
                </div>
            </td>
        </tr>
        <tr v-if="data.length === 0">
            <td colspan="3" class="p-8 text-center text-muted-foreground">
                Sem registos
            </td>
        </tr>
        </tbody>
    </table>
</template>

<style scoped>

</style>
