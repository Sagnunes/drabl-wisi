<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import UserStatus from '@/constants/userStatus';

defineProps({
  open: {
    type: Boolean,
    required: true
  },
  user: {
    type: Object,
    default: null
  },
  updatedStatus: {
    type: String,
    default: null
  },
  errorMessage: {
    type: String,
    default: ''
  }
});

const emit = defineEmits(['update:open', 'confirm', 'cancel']);

const handleCancel = () => {
  emit('cancel');
};

const handleConfirm = () => {
  emit('confirm');
};

const updateOpen = (value) => {
  emit('update:open', value);
};
</script>

<template>
  <Dialog :open="open" @update:open="updateOpen">
    <DialogContent>
      <DialogHeader>
        <DialogTitle>
          {{ user?.status?.name === UserStatus.ACTIVE ? 'Suspender' : 'Ativar' }}
          Utilizador
        </DialogTitle>
        <DialogDescription>
          <div class="flex flex-col">
            <p class="text-base">
              Tem a certeza que deseja
              {{ user?.status?.name === UserStatus.ACTIVE ? 'suspender' : 'ativar' }}
              o utilizador <span class="font-bold">{{ user?.name }}</span>?
            </p>
            <!-- Display error message if there is one -->
            <p v-if="errorMessage" class="mt-2 text-sm text-red-600">
              {{ errorMessage }}
            </p>
          </div>
        </DialogDescription>
      </DialogHeader>
      <DialogFooter>
        <Button variant="outline" @click="handleCancel">Cancelar</Button>
        <Button variant="default" @click="handleConfirm">
          {{ user?.status?.name === UserStatus.ACTIVE ? 'Suspender' : 'Ativar' }}
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
