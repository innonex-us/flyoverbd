<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { Menu, X, Plane, BookOpen, FileText, Info, Mail, LogIn } from 'lucide-vue-next';
import { ref, computed } from 'vue';
import { urlIsActive, toUrl } from '@/lib/utils';
import type { InertiaLinkProps } from '@inertiajs/vue3';

const mobileMenuOpen = ref(false);
const servicesDropdownOpen = ref(false);

const toggleMobileMenu = () => {
    mobileMenuOpen.value = !mobileMenuOpen.value;
};

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

const navItems = [
    { href: '/tours', label: 'Tours', icon: Plane },
    { href: '/visas', label: 'Visa Services', icon: BookOpen },
    { href: '/blog', label: 'Blog', icon: FileText },
    { href: '/about', label: 'About', icon: Info },
    { href: '/contact', label: 'Contact', icon: Mail },
];
</script>

<template>
    <nav class="sticky top-0 z-50 border-b border-gray-200/80 bg-white/98 backdrop-blur-md shadow-sm">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-20 items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center">
                    <Link href="/" class="group flex items-center space-x-2 transition-transform hover:scale-105">
                        <img 
                            src="/logo.png" 
                            alt="Flyover BD" 
                            class="h-10 w-auto transition-transform group-hover:scale-110"
                        />
                    </Link>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden items-center space-x-2 md:flex">
                    <Link
                        v-for="item in navItems"
                        :key="item.href"
                        :href="item.href"
                        :class="[
                            'group relative flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition-all duration-200',
                            isActive(item.href)
                                ? 'bg-red-50 text-red-600 shadow-sm'
                                : 'text-gray-700 hover:bg-red-50/50 hover:text-red-600'
                        ]"
                    >
                        <component 
                            :is="item.icon" 
                            :class="[
                                'h-4 w-4 transition-transform',
                                isActive(item.href) ? 'text-red-600' : 'text-gray-500 group-hover:text-red-600'
                            ]"
                        />
                        <span>{{ item.label }}</span>
                        <span
                            v-if="isActive(item.href)"
                            class="absolute -bottom-1 left-1/2 h-1 w-1 -translate-x-1/2 rounded-full bg-red-600"
                        />
                    </Link>
                    
                    <!-- Sign Up / Dashboard Button -->
                    <Link
                        v-if="canRegister && !$page.props.auth.user"
                        href="/access/register"
                        class="ml-2 flex items-center gap-2 rounded-xl bg-gradient-to-r from-red-600 to-red-700 px-5 py-2.5 text-sm font-semibold text-white shadow-md transition-all duration-200 hover:from-red-700 hover:to-red-800 hover:shadow-lg hover:scale-105"
                    >
                        <LogIn class="h-4 w-4" />
                        Sign Up
                    </Link>
                    <Link
                        v-else-if="$page.props.auth.user"
                        href="/cp/dashboard"
                        class="ml-2 flex items-center gap-2 rounded-xl bg-gradient-to-r from-red-600 to-red-700 px-5 py-2.5 text-sm font-semibold text-white shadow-md transition-all duration-200 hover:from-red-700 hover:to-red-800 hover:shadow-lg hover:scale-105"
                    >
                        Dashboard
                    </Link>
                </div>

                <!-- Mobile Menu Button -->
                <button
                    @click="toggleMobileMenu"
                    class="rounded-xl p-2.5 text-gray-700 transition-all hover:bg-gray-100 md:hidden"
                    aria-label="Toggle menu"
                >
                    <Menu v-if="!mobileMenuOpen" class="h-6 w-6" />
                    <X v-else class="h-6 w-6" />
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div
            v-if="mobileMenuOpen"
            class="border-t border-gray-200/80 bg-white/98 backdrop-blur-md md:hidden"
        >
            <div class="space-y-1 px-4 pb-4 pt-3">
                <Link
                    v-for="item in navItems"
                    :key="item.href"
                    :href="item.href"
                    :class="[
                        'flex items-center gap-3 rounded-xl px-4 py-3 text-base font-semibold transition-all duration-200',
                        isActive(item.href)
                            ? 'bg-red-50 text-red-600 shadow-sm'
                            : 'text-gray-700 hover:bg-red-50/50 hover:text-red-600'
                    ]"
                    @click="toggleMobileMenu"
                >
                    <component 
                        :is="item.icon" 
                        :class="[
                            'h-5 w-5',
                            isActive(item.href) ? 'text-red-600' : 'text-gray-500'
                        ]"
                    />
                    {{ item.label }}
                </Link>
                
                <div class="border-t border-gray-200/80 pt-3">
                    <Link
                        v-if="canRegister && !$page.props.auth.user"
                        href="/access/register"
                        class="flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-red-600 to-red-700 px-4 py-3 text-base font-semibold text-white shadow-md transition-all duration-200 hover:from-red-700 hover:to-red-800"
                        @click="toggleMobileMenu"
                    >
                        <LogIn class="h-5 w-5" />
                        Sign Up
                    </Link>
                    <Link
                        v-else-if="$page.props.auth.user"
                        href="/cp/dashboard"
                        class="flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-red-600 to-red-700 px-4 py-3 text-base font-semibold text-white shadow-md transition-all duration-200 hover:from-red-700 hover:to-red-800"
                        @click="toggleMobileMenu"
                    >
                        Dashboard
                    </Link>
                </div>
            </div>
        </div>
    </nav>
</template>
