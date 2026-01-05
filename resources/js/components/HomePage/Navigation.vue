<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { Plane, BookOpen, FileText, Home, Mail, LogIn, Info } from 'lucide-vue-next';
import { computed } from 'vue';
import { urlIsActive, toUrl } from '@/lib/utils';
import type { InertiaLinkProps } from '@inertiajs/vue3';

defineProps<{
    canRegister?: boolean;
}>();

const page = usePage();

const isActive = (href: NonNullable<InertiaLinkProps['href']>) => {
    const currentUrl = page.url.split('?')[0]; // Remove query params
    const targetUrl = toUrl(href);
    
    // Exact match
    if (currentUrl === targetUrl) return true;
    
    // For nested routes (e.g., /tours/slug should highlight /tours)
    if (targetUrl !== '/' && currentUrl.startsWith(targetUrl + '/')) return true;
    
    return false;
};

// Desktop navigation items
const navItems = [
    { href: '/tours', label: 'Tours', icon: Plane },
    { href: '/visas', label: 'Visa Services', icon: BookOpen },
    { href: '/about', label: 'About', icon: Info },
];

// Mobile bottom navigation items
const mobileNavItems = [
    { href: '/', label: 'Home', icon: Home },
    { href: '/tours', label: 'Tours', icon: Plane },
    { href: '/visas', label: 'Visa', icon: BookOpen },
];
</script>

<template>
    <nav class="sticky top-0 z-50 border-b border-gray-200 bg-white shadow-md backdrop-blur-lg">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-20 items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center">
                    <Link href="/" class="group flex items-center space-x-3 transition-all duration-200 hover:scale-105">
                        <div class="relative">
                            <img 
                                src="/logo.png" 
                                alt="Flyover BD" 
                                class="h-12 w-auto transition-all duration-300 group-hover:scale-110 group-hover:brightness-110"
                            />
                            <div class="absolute inset-0 rounded-lg bg-red-600/0 transition-all duration-300 group-hover:bg-red-600/10 blur-xl"></div>
                        </div>
                    </Link>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden items-center gap-1 md:flex">
                    <Link
                        v-for="item in navItems"
                        :key="item.href"
                        :href="item.href"
                        :class="[
                            'group relative flex items-center gap-2 rounded-lg px-4 py-2.5 text-sm font-semibold transition-all duration-300',
                            isActive(item.href)
                                ? 'bg-gradient-to-r from-red-50 to-red-50/80 text-red-700 shadow-sm'
                                : 'text-gray-700 hover:bg-gray-50 hover:text-red-600'
                        ]"
                    >
                        <component 
                            :is="item.icon" 
                            :class="[
                                'h-4 w-4 transition-all duration-300',
                                isActive(item.href) 
                                    ? 'text-red-600 scale-110' 
                                    : 'text-gray-500 group-hover:text-red-600 group-hover:scale-110'
                            ]"
                        />
                        <span class="relative z-10">{{ item.label }}</span>
                        <span
                            v-if="isActive(item.href)"
                            class="absolute bottom-0 left-1/2 h-0.5 w-8 -translate-x-1/2 rounded-full bg-gradient-to-r from-red-600 to-red-700"
                        />
                    </Link>
                    
                    <!-- Sign Up / Dashboard Button -->
                    <Link
                        v-if="canRegister && !$page.props.auth.user"
                        href="/access/register"
                        class="ml-3 flex items-center gap-2 rounded-lg bg-gradient-to-r from-red-600 via-red-600 to-red-700 px-5 py-2.5 text-sm font-semibold text-white shadow-lg transition-all duration-300 hover:from-red-700 hover:via-red-700 hover:to-red-800 hover:shadow-xl hover:scale-105 active:scale-95"
                    >
                        <LogIn class="h-4 w-4 transition-transform group-hover:scale-110" />
                        <span>Sign Up</span>
                    </Link>
                    <Link
                        v-else-if="$page.props.auth.user"
                        href="/cp/dashboard"
                        class="ml-3 flex items-center gap-2 rounded-lg bg-gradient-to-r from-red-600 via-red-600 to-red-700 px-5 py-2.5 text-sm font-semibold text-white shadow-lg transition-all duration-300 hover:from-red-700 hover:via-red-700 hover:to-red-800 hover:shadow-xl hover:scale-105 active:scale-95"
                    >
                        <span>Dashboard</span>
                    </Link>
                </div>

            </div>
        </div>
    </nav>

    <!-- Mobile Bottom Navigation -->
    <nav class="fixed bottom-0 left-0 right-0 z-50 border-t border-gray-200/80 bg-white/98 backdrop-blur-xl shadow-[0_-4px_20px_rgba(0,0,0,0.08)] md:hidden" style="padding-bottom: env(safe-area-inset-bottom);">
        <div class="flex h-16 items-center justify-around px-1" style="height: calc(4rem + env(safe-area-inset-bottom));">
            <Link
                v-for="item in mobileNavItems"
                :key="item.href"
                :href="item.href"
                :class="[
                    'relative flex flex-col items-center justify-center gap-0.5 flex-1 rounded-lg py-1.5 transition-all duration-200 active:scale-95 min-w-0',
                    isActive(item.href)
                        ? 'text-red-600'
                        : 'text-gray-600'
                ]"
            >
                <div 
                    :class="[
                        'relative flex items-center justify-center rounded-lg p-1.5 transition-all duration-200',
                        isActive(item.href) ? 'bg-red-50' : ''
                    ]"
                >
                    <component 
                        :is="item.icon" 
                        :class="[
                            'h-5 w-5 transition-all duration-200',
                            isActive(item.href) 
                                ? 'text-red-600' 
                                : 'text-gray-500'
                        ]"
                    />
                </div>
                <span 
                    :class="[
                        'text-[10px] font-semibold leading-tight truncate max-w-full px-1',
                        isActive(item.href) ? 'text-red-600' : 'text-gray-600'
                    ]"
                >
                    {{ item.label }}
                </span>
                <span
                    v-if="isActive(item.href)"
                    class="absolute -top-0.5 left-1/2 h-1 w-1 -translate-x-1/2 rounded-full bg-red-600"
                />
            </Link>
        </div>
    </nav>
</template>
