<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Checkbox, CheckboxGroup } from '@/components/ui/checkbox';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';

defineProps({
  open: {
    type: Boolean,
    required: true
  },
  user: {
    type: Object,
    default: null
  },
  roles: {
    type: Array,
    required: true
  },
  selectedRoles: {
    type: Array,
    required: true
  },
  errorMessage: {
    type: String,
    default: ''
  },
  mode: {
    type: String,
    default: 'add',
    validator: (value) => ['add', 'remove'].includes(value)
  }
});

const emit = defineEmits(['update:open', 'update:selectedRoles', 'confirm', 'cancel']);

const handleCancel = () => {
  emit('cancel');
};

const handleConfirm = () => {
  emit('confirm');
};

const updateOpen = (value) => {
  emit('update:open', value);
};

const updateSelectedRoles = (value) => {
  emit('update:selectedRoles', value);
};
</script>

<template>
  <Dialog :open="open" @update:open="updateOpen">
    <DialogContent>
      <DialogHeader>
        <DialogTitle>
          {{ mode === 'add' ? 'Adicionar' : 'Tirar' }} Funções ao utilizador {{ user?.name }}
        </DialogTitle>
        <DialogDescription>
          <CheckboxGroup
            :model-value="selectedRoles"
            @update:model-value="updateSelectedRoles"
            as="div"
            orientation="horizontal"
            :loop="false"
            :as-child="true"
            dir="ltr"
          >
            <div v-for="role in roles" :key="role.id" class="flex items-center gap-2 my-2">
              <Checkbox :value="role.id" />
              <span>{{ role.name }}</span>
            </div>
          </CheckboxGroup>
          <!-- Display error message if there is one -->
          <p v-if="errorMessage" class="mt-2 text-sm text-red-600">
            {{ errorMessage }}
          </p>
        </DialogDescription>
      </DialogHeader>
      <DialogFooter>
        <Button variant="outline" @click="handleCancel">Cancelar</Button>
        <Button variant="default" @click="handleConfirm">Guardar</Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
