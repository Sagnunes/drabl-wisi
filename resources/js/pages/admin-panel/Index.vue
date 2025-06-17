<script setup lang="ts">
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import UserStatusBadge from '@/components/UserStatusBadge.vue';
import { useInitials } from '@/composables/useInitials';
import UserStatus from '@/constants/userStatus';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { UserCheck, UserCog, UserX } from 'lucide-vue-next';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

defineProps(['users']);

const { getInitials } = useInitials();

const dataFromUser = ref(null);
const showConfirmStatusDialog = ref(false);
const errorMessage = ref('');

const handleConfirmStatusDialog = (user: any, status) => {
    dataFromUser.value = user;
    form.user_id = user.id;
    form.updatedStatus = status;
    errorMessage.value = ''; // Clear any previous error messages
    showConfirmStatusDialog.value = true;
};

const cancelConfirmStatusDialog = () => {
    errorMessage.value = ''; // Clear error messages when dialog is closed
    showConfirmStatusDialog.value = false;
};

const form = useForm({
    user_id: null,
    updatedStatus: null,
});

const confirmStatus = () => {
    errorMessage.value = ''; // Clear any previous error messages
    form.post('/admin-panel/status', {
        onSuccess: () => {
            showConfirmStatusDialog.value = false;
        },
        onError: (errors) => {
            console.log(errors);
            // Handle validation errors
            if (Object.keys(errors).length > 0) {
                // If we have specific field errors, display them
                errorMessage.value = Object.values(errors).flat().join(', ');
            } else if (form.hasErrors) {
                // If there's a general error message
                errorMessage.value = form.errors.message || 'An error occurred. Please try again.';
            }
        },
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold text-primary/90">Painel de Administração</h1>
                        <p class="mt-2 text-sm text-primary/70">Uma listagem dos utilizadores registados na plataforma.</p>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                        <Button>Novo Perfil</Button>
                    </div>
                </div>
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
                                                    <Button variant="ghost" class="h-8 w-8" title="Funções">
                                                        <UserCog class="h-4 w-4" />
                                                        <span class="sr-only">Editar</span>
                                                    </Button>
                                                    <Button
                                                        variant="ghost"
                                                        class="h-8 w-8"
                                                        title="Ativar"
                                                        v-if="user.status.name == UserStatus.PENDING || user.status.name == UserStatus.SUSPENDED"
                                                        @click="handleConfirmStatusDialog(user,UserStatus.ACTIVE)"
                                                    >
                                                        <UserCheck class="h-4 w-4" />
                                                        <span class="sr-only">Ativar</span>
                                                    </Button>
                                                    <Button variant="ghost" class="h-8 w-8" title="Desativar" v-else
                                                            @click="handleConfirmStatusDialog(user,UserStatus.SUSPENDED)">
                                                        <UserX class="h-4 w-4" />
                                                        <span class="sr-only">Desativar</span>
                                                    </Button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <Dialog :open="showConfirmStatusDialog" @update:open="showConfirmStatusDialog = $event">
                                    <DialogContent>
                                        <DialogHeader>
                                            <DialogTitle>{{dataFromUser?.status.name === UserStatus.ACTIVE ? 'Suspender' : 'Ativar'}} Utilizador</DialogTitle>
                                            <DialogDescription>
                                                <div class="flex flex-col">
                                                    <p class="text-base">Tem a certeza que deseja {{dataFromUser?.status.name === UserStatus.ACTIVE ? 'suspender' : 'ativar'}} o utilizador <span class="font-bold">{{dataFromUser.name}}</span>?</p>
                                                    <!-- Display error message if there is one -->
                                                    <p v-if="errorMessage" class="mt-2 text-sm text-red-600">{{ errorMessage }}</p>
                                                </div>
                                            </DialogDescription>
                                        </DialogHeader>
                                        <DialogFooter>
                                            <Button variant="outline" @click="cancelConfirmStatusDialog">Cancelar </Button>
                                            <Button variant="default" @click="confirmStatus">{{dataFromUser?.status.name === UserStatus.ACTIVE ? 'Suspender' : 'Ativar'}}</Button>
                                        </DialogFooter>
                                    </DialogContent>
                                </Dialog>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
