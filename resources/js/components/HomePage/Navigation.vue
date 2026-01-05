<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { Menu, X, ChevronDown } from 'lucide-vue-next';
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
    { href: '/tours', label: 'Tours' },
    { href: '/visas', label: 'Visa Services' },
    { href: '/blog', label: 'Blog' },
    { href: '/about', label: 'About' },
    { href: '/contact', label: 'Contact' },
];
</script>

<template>
    <nav class="sticky top-0 z-50 border-b border-gray-200 bg-white/95 backdrop-blur-sm shadow-lg">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-20 items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center">
                    <Link href="/" class="group flex items-center space-x-3 transition-transform hover:scale-105">
                        <img 
                            src="/logo.png" 
                            alt="Flyover BD" 
                            class="h-10 w-auto transition-transform group-hover:scale-110"
                        />
                    </Link>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden items-center space-x-1 md:flex">
                    <Link
                        v-for="item in navItems"
                        :key="item.href"
                        :href="item.href"
                        :class="[
                            'relative rounded-lg px-4 py-2.5 text-sm font-semibold transition-all',
                            isActive(item.href)
                                ? 'bg-red-50 text-red-600'
                                : 'text-gray-700 hover:bg-red-50 hover:text-red-600'
                        ]"
                    >
                        {{ item.label }}
                        <span
                            v-if="isActive(item.href)"
                            class="absolute bottom-0 left-1/2 h-0.5 w-8 -translate-x-1/2 translate-y-1 rounded-full bg-red-600"
                        />
                    </Link>
                    
                    <!-- Sign Up / Dashboard Button -->
                    <Link
                        v-if="canRegister && !$page.props.auth.user"
                        href="/access/register"
                        class="ml-4 rounded-lg bg-gradient-to-r from-red-600 to-red-700 px-6 py-2.5 text-sm font-semibold text-white shadow-md transition-all hover:from-red-700 hover:to-red-800 hover:shadow-lg hover:scale-105"
                    >
                        Sign Up
                    </Link>
                    <Link
                        v-else-if="$page.props.auth.user"
                        href="/cp/dashboard"
                        class="ml-4 rounded-lg bg-gradient-to-r from-red-600 to-red-700 px-6 py-2.5 text-sm font-semibold text-white shadow-md transition-all hover:from-red-700 hover:to-red-800 hover:shadow-lg hover:scale-105"
                    >
                        Dashboard
                    </Link>
                </div>

                <!-- Mobile Menu Button -->
                <button
                    @click="toggleMobileMenu"
                    class="rounded-lg p-2 text-gray-700 transition-all hover:bg-gray-100 md:hidden"
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
            class="border-t border-gray-200 bg-white md:hidden"
        >
            <div class="space-y-1 px-4 pb-4 pt-2">
                <Link
                    v-for="item in navItems"
                    :key="item.href"
                    :href="item.href"
                    :class="[
                        'block rounded-lg px-3 py-2.5 text-base font-semibold transition-all',
                        isActive(item.href)
                            ? 'bg-red-50 text-red-600'
                            : 'text-gray-700 hover:bg-red-50 hover:text-red-600'
                    ]"
                    @click="toggleMobileMenu"
                >
                    {{ item.label }}
                </Link>
                
                <div class="border-t border-gray-200 pt-2">
                    <Link
                        v-if="canRegister && !$page.props.auth.user"
                        href="/access/register"
                        class="mt-2 block rounded-lg bg-gradient-to-r from-red-600 to-red-700 px-3 py-2.5 text-center text-base font-semibold text-white shadow-md transition-all hover:from-red-700 hover:to-red-800"
                        @click="toggleMobileMenu"
                    >
                        Sign Up
                    </Link>
                    <Link
                        v-else-if="$page.props.auth.user"
                        href="/cp/dashboard"
                        class="mt-2 block rounded-lg bg-gradient-to-r from-red-600 to-red-700 px-3 py-2.5 text-center text-base font-semibold text-white shadow-md transition-all hover:from-red-700 hover:to-red-800"
                        @click="toggleMobileMenu"
                    >
                        Dashboard
                    </Link>
                </div>
            </div>
        </div>
    </nav>
</template>
