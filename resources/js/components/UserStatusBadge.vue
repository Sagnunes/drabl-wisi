<script setup lang="ts">
interface StatusType {
    name: 'Pendente' | 'Ativo' | 'Suspenso';
}

interface ColorScheme {
    bg: string;
    text: string;
    ring: string;
}

const STATUS_COLORS: Record<StatusType['name'], ColorScheme> = {
    'Pendente': {
        bg: 'bg-yellow-50',
        text: 'text-yellow-700',
        ring: 'ring-yellow-600/20'
    },
    'Ativo': {
        bg: 'bg-green-50',
        text: 'text-green-700',
        ring: 'ring-green-600/20'
    },
    'Suspenso': {
        bg: 'bg-red-50',
        text: 'text-red-700',
        ring: 'ring-red-600/20'
    }
} as const;

defineProps<{
    status: StatusType;
}>();

const getStatusBadgeClasses = (statusName: StatusType['name']): string => {
    const colors = STATUS_COLORS[statusName] ?? STATUS_COLORS['Pendente'];
    return [colors.bg, colors.text, colors.ring].join(' ');
};
</script>

<template>
  <span
      class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset"
      :class="getStatusBadgeClasses(status.name)"
  >
    {{ status.name }}
  </span>
</template>
