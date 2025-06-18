<script setup lang="ts">
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import UserStatusBadge from '@/components/UserStatusBadge.vue';
import { useInitials } from '@/composables/useInitials';
import UserStatus from '@/constants/userStatus';
import { UserCheck, UserPlus, UserMinus, UserX } from 'lucide-vue-next';

defineProps({
  users: {
    type: Array,
    required: true
  }
});

const emit = defineEmits(['changeStatus', 'addRoles', 'removeRoles']);

const { getInitials } = useInitials();

const handleStatusChange = (user, status) => {
  emit('changeStatus', user, status);
};

const handleAddRoles = (user) => {
  emit('addRoles', user);
};

const handleRemoveRoles = (user) => {
  emit('removeRoles', user);
};
</script>

<template>
  <div class="mt-8 flow-root">
    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-sm ring-1 ring-black/1 sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-300">
            <thead>
              <tr>
                <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-primary/90">Nome</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-primary/90">Profissão</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-primary/90">Estado</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-primary/90">Funções</th>
                <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-0">
                  <span class="sr-only">Edit</span>
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-background">
              <tr v-for="user in users" :key="user.id">
                <td class="py-5 pr-3 pl-4 text-sm whitespace-nowrap sm:pl-0">
                  <div class="flex items-center">
                    <Avatar class="h-11 w-11 overflow-hidden rounded-lg">
                      <AvatarFallback class="rounded-lg text-black dark:text-white">
                        {{ getInitials(user.name) }}
                      </AvatarFallback>
                    </Avatar>
                    <div class="ml-4">
                      <div class="font-medium text-primary/80">{{ user.name }}</div>
                      <div class="mt-1 text-primary/60">{{ user.email }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-3 py-5 text-sm whitespace-nowrap text-primary/60">
                  <div class="text-primary/80">{{ user.job_title }}</div>
                  <div class="mt-1 text-primary/60">
                    {{ user.gov_department }}
                  </div>
                </td>
                <td class="px-3 py-5 text-sm whitespace-nowrap text-gray-500">
                  <UserStatusBadge :status="user.status" />
                </td>
                <td class="px-3 py-5 text-sm whitespace-nowrap text-primary/60">
                  <span v-for="role in user.roles" :key="role.id" class="ml-1">{{ role.name }}</span>
                </td>
                <td class="relative py-5 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-0">
                  <div class="flex justify-end gap-3">
                    <Button
                      variant="ghost"
                      class="h-8 w-8"
                      title="Adicionar Funcao"
                      @click="handleAddRoles(user)"
                    >
                      <UserPlus class="h-4 w-4" />
                      <span class="sr-only">Adicionar Funcao</span>
                    </Button>
                    <Button
                      variant="ghost"
                      class="h-8 w-8"
                      title="Apagar Funcao"
                      @click="handleRemoveRoles(user)"
                    >
                      <UserMinus class="h-4 w-4" />
                      <span class="sr-only">Retirar Funcao</span>
                    </Button>
                    <Button
                      variant="ghost"
                      class="h-8 w-8"
                      title="Ativar"
                      v-if="user.status.name == UserStatus.PENDING || user.status.name == UserStatus.SUSPENDED"
                      @click="handleStatusChange(user, UserStatus.ACTIVE)"
                    >
                      <UserCheck class="h-4 w-4" />
                      <span class="sr-only">Ativar</span>
                    </Button>
                    <Button
                      variant="ghost"
                      class="h-8 w-8"
                      title="Desativar"
                      v-else
                      @click="handleStatusChange(user, UserStatus.SUSPENDED)"
                    >
                      <UserX class="h-4 w-4" />
                      <span class="sr-only">Desativar</span>
                    </Button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
