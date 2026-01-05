<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { Menu, X, Plane, BookOpen, FileText, Info, Mail, LogIn } from 'lucide-vue-next';
import { ref, computed } from 'vue';
import { urlIsActive, toUrl } from '@/lib/utils';
import type { InertiaLinkProps } from '@inertiajs/vue3';

const mobileMenuOpen = ref(false);

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

                <!-- Mobile Menu Button -->
                <button
                    @click="toggleMobileMenu"
                    class="relative rounded-lg p-2.5 text-gray-700 transition-all duration-200 hover:bg-gray-100 active:bg-gray-200 md:hidden"
                    aria-label="Toggle menu"
                >
                    <Menu v-if="!mobileMenuOpen" class="h-6 w-6 transition-transform duration-200" />
                    <X v-else class="h-6 w-6 transition-transform duration-200" />
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <Transition
            enter-active-class="transition-all duration-300 ease-out"
            enter-from-class="opacity-0 -translate-y-4"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition-all duration-200 ease-in"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 -translate-y-4"
        >
            <div
                v-if="mobileMenuOpen"
                class="border-t border-gray-200 bg-white/98 backdrop-blur-lg shadow-lg md:hidden"
            >
                <div class="space-y-1 px-4 pb-6 pt-4">
                    <Link
                        v-for="item in navItems"
                        :key="item.href"
                        :href="item.href"
                        :class="[
                            'flex items-center gap-3 rounded-xl px-4 py-3.5 text-base font-semibold transition-all duration-200',
                            isActive(item.href)
                                ? 'bg-gradient-to-r from-red-50 to-red-50/80 text-red-700 shadow-sm'
                                : 'text-gray-700 active:bg-gray-50 hover:bg-gray-50 hover:text-red-600'
                        ]"
                        @click="toggleMobileMenu"
                    >
                        <component 
                            :is="item.icon" 
                            :class="[
                                'h-5 w-5 transition-transform',
                                isActive(item.href) ? 'text-red-600 scale-110' : 'text-gray-500'
                            ]"
                        />
                        {{ item.label }}
                    </Link>
                    
                    <div class="border-t border-gray-200 pt-4">
                        <Link
                            v-if="canRegister && !$page.props.auth.user"
                            href="/access/register"
                            class="flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-red-600 to-red-700 px-4 py-3.5 text-base font-semibold text-white shadow-lg transition-all duration-200 active:scale-95 hover:from-red-700 hover:to-red-800 hover:shadow-xl"
                            @click="toggleMobileMenu"
                        >
                            <LogIn class="h-5 w-5" />
                            Sign Up
                        </Link>
                        <Link
                            v-else-if="$page.props.auth.user"
                            href="/cp/dashboard"
                            class="flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-red-600 to-red-700 px-4 py-3.5 text-base font-semibold text-white shadow-lg transition-all duration-200 active:scale-95 hover:from-red-700 hover:to-red-800 hover:shadow-xl"
                            @click="toggleMobileMenu"
                        >
                            Dashboard
                        </Link>
                    </div>
                </div>
            </div>
        </Transition>
    </nav>
</template>
