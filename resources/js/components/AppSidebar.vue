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
    BookOpenCheck,
    Home,
    Users,
    LifeBuoy,
    Send} from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/admin/dashboard',
        icon: Home,
    },
    {
        title: 'Certifications',
        href: '/certifications',
        icon: BookCopy,
    },
    {
        title: 'My Practices',
        href: '/practices',
        icon: SquareTerminal,
    },
    {
        title: 'Subscriptions',
        href: '/subscriptions',
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
    },
    {
        title: 'Roles',
        href: '/admin/acl/roles',
        icon: Users,
    },
    {
        title: 'Support',
        href: '/admin/acl/roles',
        icon: LifeBuoy,
    },
    {
        title: 'Feedback',
        href: '/admin/acl/roles',
        icon: Send,
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
