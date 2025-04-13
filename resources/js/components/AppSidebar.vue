<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import {
    BookOpen,
    Folder,
    LayoutGrid,
    AudioWaveform,
    Bot,
    Command,
    Frame,
    GalleryVerticalEnd,
    Map,
    PieChart,
    Settings2,
    SquareTerminal,
    BookCopy,
    UserRoundCog,
    BookCheck,
    BookOpenCheck } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/admin/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'View Examinations',
        href: '/admin/categories',
        icon: BookCopy,
    },
    {
        title: 'Practice',
        href: '/admin/providers',
        icon: SquareTerminal,
    },
    {
        title: 'Subscriptions',
        href: '/admin/exams',
        icon: BookOpenCheck,
    },
    {
        title: 'Help',
        href: '/admin/questions',
        icon: BookCheck,
    }

];

const footerNavItems: NavItem[] = [
{
        title: 'Dashboard',
        href: '/admin/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Categories',
        href: '/admin/categories',
        icon: BookCopy,
    },
    {
        title: 'Providers',
        href: '/admin/providers',
        icon: SquareTerminal,
    },
    {
        title: 'Examinations',
        href: '/admin/exams',
        icon: BookOpenCheck,
    },
    {
        title: 'Questions',
        href: '/admin/questions',
        icon: BookCheck,
    },
    {
        title: 'Users',
        href: '/admin/users',
        icon: UserRoundCog,
    }
];
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
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
