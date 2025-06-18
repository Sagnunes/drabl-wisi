<script setup lang="ts">
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

// Import custom components
import UserTable from '@/components/admin/UserTable.vue';
import StatusDialog from '@/components/admin/StatusDialog.vue';
import RolesDialog from '@/components/admin/RolesDialog.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const props = defineProps(['users', 'roles']);

// State management
const selectedUser = ref(null);
const showStatusDialog = ref(false);
const showAddRolesDialog = ref(false);
const showRemoveRolesDialog = ref(false);
const errorMessage = ref('');
const updatedStatus = ref(null);

// Form handling
const form = useForm({
    user_id: null,
    updatedStatus: null,
    roles: [],
});

// Status dialog handlers
const handleStatusChange = (user, status) => {
    selectedUser.value = user;
    form.user_id = user.id;
    form.updatedStatus = status;
    updatedStatus.value = status;
    errorMessage.value = '';
    showStatusDialog.value = true;
};

const cancelStatusDialog = () => {
    errorMessage.value = '';
    showStatusDialog.value = false;
};

const confirmStatus = () => {
    errorMessage.value = '';
    form.post('/admin-panel/status', {
        onSuccess: () => {
            showStatusDialog.value = false;
        },
        onError: (errors) => {
            if (Object.keys(errors).length > 0) {
                errorMessage.value = Object.values(errors).flat().join(', ');
            } else if (form.hasErrors) {
                errorMessage.value = form.errors.message || 'An error occurred. Please try again.';
            }
        },
    });
};

// Add roles dialog handlers
const handleAddRoles = (user) => {
    selectedUser.value = user;
    form.user_id = user.id;
    form.roles = [];
    errorMessage.value = '';
    showAddRolesDialog.value = true;
};

const cancelAddRolesDialog = () => {
    errorMessage.value = '';
    showAddRolesDialog.value = false;
};

const confirmAddRoles = () => {
    form.post('/admin-panel/add-role', {
        onSuccess: () => {
            showAddRolesDialog.value = false;
        },
        onError: (errors) => {
            if (Object.keys(errors).length > 0) {
                errorMessage.value = Object.values(errors).flat().join(', ');
            } else if (form.hasErrors) {
                errorMessage.value = form.errors.message || 'An error occurred. Please try again.';
            }
        },
    });
};

// Remove roles dialog handlers
const handleRemoveRoles = (user) => {
    selectedUser.value = user;
    form.user_id = user.id;
    form.roles = [];
    errorMessage.value = '';
    showRemoveRolesDialog.value = true;
};

const cancelRemoveRolesDialog = () => {
    errorMessage.value = '';
    showRemoveRolesDialog.value = false;
};

const confirmRemoveRoles = () => {
    form.post('/admin-panel/remove-role', {
        onSuccess: () => {
            showRemoveRolesDialog.value = false;
        },
        onError: (errors) => {
            if (Object.keys(errors).length > 0) {
                errorMessage.value = Object.values(errors).flat().join(', ');
            } else if (form.hasErrors) {
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

                <!-- User Table Component -->
                <UserTable
                    :users="props.users"
                    @change-status="handleStatusChange"
                    @add-roles="handleAddRoles"
                    @remove-roles="handleRemoveRoles"
                />

                <!-- Status Dialog Component -->
                <StatusDialog
                    v-model:open="showStatusDialog"
                    :user="selectedUser"
                    :updated-status="updatedStatus"
                    :error-message="errorMessage"
                    @confirm="confirmStatus"
                    @cancel="cancelStatusDialog"
                />

                <!-- Add Roles Dialog Component -->
                <RolesDialog
                    v-model:open="showAddRolesDialog"
                    :user="selectedUser"
                    :roles="props.roles"
                    v-model:selected-roles="form.roles"
                    :error-message="errorMessage"
                    mode="add"
                    @confirm="confirmAddRoles"
                    @cancel="cancelAddRolesDialog"
                />

                <!-- Remove Roles Dialog Component -->
                <RolesDialog
                    v-model:open="showRemoveRolesDialog"
                    :user="selectedUser"
                    :roles="props.roles"
                    v-model:selected-roles="form.roles"
                    :error-message="errorMessage"
                    mode="remove"
                    @confirm="confirmRemoveRoles"
                    @cancel="cancelRemoveRolesDialog"
                />
            </div>
        </div>
    </AppLayout>
</template>
