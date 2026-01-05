<script setup lang="ts">
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import {
    LayoutGrid,
    Package,
    Globe,
    MessageSquare,
    Calendar,
    FileText,
} from 'lucide-vue-next';
import { computed } from 'vue';
import AppLogo from './AppLogo.vue';

const page = usePage();
const auth = computed(() => page.props.auth);

// Show admin navigation for all authenticated users
const isAdmin = computed(() => {
    return !!auth.value?.user;
});

const mainNavItems = computed<NavItem[]>(() => {
    const items: NavItem[] = [
        {
            title: 'Dashboard',
            href: isAdmin.value ? '/cp/dashboard' : dashboard(),
            icon: LayoutGrid,
        },
    ];

    if (isAdmin.value) {
        items.push(
            {
                title: 'Tour Packages',
                href: '/cp/tours',
                icon: Package,
            },
            {
                title: 'Visa Requirements',
                href: '/cp/visas',
                icon: Globe,
            },
            {
                title: 'Blogs',
                href: '/cp/blogs',
                icon: FileText,
            },
            {
                title: 'Inquiries',
                href: '/cp/inquiries',
                icon: MessageSquare,
            },
            {
                title: 'Bookings',
                href: '/cp/bookings',
                icon: Calendar,
            }
        );
    }

    return items;
});
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="isAdmin ? '/cp/dashboard' : dashboard()">
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
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
