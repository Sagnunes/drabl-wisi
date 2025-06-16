<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import UserRole from '@/constants/UserRole';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { LayoutGrid, Library, Proportions } from 'lucide-vue-next';
import { computed } from 'vue';
import AppLogo from './AppLogo.vue';

const page = usePage();
const userRoles = page.props.auth.roles as string[] | [];

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Coleção Digital',
        href: '/digital-collection',
        icon: Library,
        roles: [UserRole.DIGITAL_COLLECTION],
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Perfis',
        href: '/roles',
        icon: Proportions,
        roles: [UserRole.ADMIN],
    },
    {
        title: 'Fundos',
        href: '/funds',
        icon: Proportions,
        roles: [UserRole.ADMIN],
    },
    {
        title: 'Utilizadores Estados',
        href: '/statuses',
        icon: Proportions,
        roles: [UserRole.ADMIN],
    }
];

const filterNavItemsByUserRoles = (items: NavItem[], userRoles: string[]): NavItem[] => {
    return items.filter((item) => {
        if (!item.roles) {
            return true;
        }
        return item.roles.some((role) => userRoles.includes(role));
    });
};

const filteredMainNavItems = computed(() => filterNavItemsByUserRoles(mainNavItems, userRoles));
const filteredFooterNavItems = computed(() => filterNavItemsByUserRoles(footerNavItems, userRoles));
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="filteredMainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="filteredFooterNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
