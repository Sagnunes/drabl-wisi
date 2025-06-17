<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import SimpleDataTable from '@/components/ui/datatable/SimpleDataTable.vue';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Fundos',
        href: '/dashboard',
    },
];

defineProps(['funds']);

const columns = [
    { key: 'acronym', label: 'Sigla' },
    { key: 'name', label: 'Nome' },
    { key: 'created_at', label: 'Data de criação' },
];

const showCreateDialog = ref(false);
const showDeleteDialog = ref(false);

const form = useForm({
    name: '',
    acronym: '',
});

const handleCreateDialog = () => {
    showCreateDialog.value = true;
};

const cancelCreateDialog = () => {
    showCreateDialog.value = false;
    form.reset();
};

const submitCreateForm = () => {
    form.post('/funds', {
        onSuccess: () => {
            showCreateDialog.value = false;
            form.reset();
        },
    });
};

const fundToDelete = ref<any>(null);

const handleDeleteDialog = (item: any) => {
    showDeleteDialog.value = true;
    fundToDelete.value = item;
};

const cancelDeleteDialog = () => {
    showDeleteDialog.value = false;
};

const confirmDelete = () => {
    form.delete(`/funds/${fundToDelete.value.id}`, {
        onSuccess: () => {
            showDeleteDialog.value = false;
            fundToDelete.value = null;
        }
    });
};
</script>

<template>
    <Head title="Fundos" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold text-primary/90">Todos os fundos</h1>
                        <p class="mt-2 text-sm text-primary/70">Uma lista de todos os os fundos criados na plataforma para a coleção digital.</p>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                        <Button @click="handleCreateDialog">Novo Fundo</Button>
                    </div>
                </div>
                <div class="mt-8 flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <div class="overflow-hidden shadow-sm ring-1 ring-black/5 sm:rounded-lg">
                                <SimpleDataTable :columns :data="funds" @delete="handleDeleteDialog" />

                                <Dialog :open="showCreateDialog" @update:open="showCreateDialog = $event">
                                    <DialogContent>
                                        <DialogHeader>
                                            <DialogTitle>Novo Perfil</DialogTitle>
                                            <DialogDescription> Inserir um novo estado na plataforma. </DialogDescription>
                                        </DialogHeader>
                                        <form @submit.prevent="submitCreateForm">
                                            <div class="grid gap-4 py-4">
                                                <div class="grid gap-2">
                                                    <label for="name">Nome</label>
                                                    <Input
                                                        id="name"
                                                        ref="nameInput"
                                                        v-model="form.name"
                                                        type="text"
                                                        class="mt-1 block w-full"
                                                        placeholder="Nome do Perfil"
                                                    />
                                                    <InputError :message="form.errors.name" />
                                                </div>
                                                <div class="grid gap-2">
                                                    <label for="name">Sigla</label>
                                                    <Input
                                                        id="description"
                                                        ref="descriptionInput"
                                                        v-model="form.acronym"
                                                        type="text"
                                                        class="mt-1 block w-full"
                                                        placeholder="Descrição"
                                                    />
                                                    <InputError :message="form.errors.acronym" />
                                                </div>
                                            </div>
                                            <DialogFooter>
                                                <Button variant="outline" @click="cancelCreateDialog">Cancelar</Button>
                                                <Button variant="default" type="submit" :disabled="form.processing"> Salvar </Button>
                                            </DialogFooter>
                                        </form>
                                    </DialogContent>
                                </Dialog>

                                <Dialog :open="showDeleteDialog" @update:open="showDeleteDialog = $event">
                                    <DialogContent>
                                        <DialogHeader>
                                            <DialogTitle>Confirmar Apagar</DialogTitle>
                                            <DialogDescription>
                                                <div class="flex flex-col">
                                                    <p class="text-base">Tem a certeza que deseja apagar o perfil "{{ fundToDelete?.name }}"?</p>
                                                    <span class="text-base underline">Está acção não pode ser desfeita.</span>
                                                </div>
                                                <p v-show="form.errors.fund" class="mt-2 text-sm text-red-600 dark:text-red-500">{{ form.errors.fund }}</p>
                                            </DialogDescription>
                                        </DialogHeader>
                                        <DialogFooter>
                                            <Button variant="outline" @click="cancelDeleteDialog">Cancelar</Button>
                                            <Button variant="destructive" @click="confirmDelete">Apagar</Button>
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
