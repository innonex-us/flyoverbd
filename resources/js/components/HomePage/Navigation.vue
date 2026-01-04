<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Plane, Menu, X } from 'lucide-vue-next';
import { ref } from 'vue';

const mobileMenuOpen = ref(false);

const toggleMobileMenu = () => {
    mobileMenuOpen.value = !mobileMenuOpen.value;
};

defineProps<{
    canRegister?: boolean;
}>();
</script>

<template>
    <nav class="sticky top-0 z-50 border-b border-gray-100 bg-white/95 backdrop-blur-sm shadow-md">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-20 items-center justify-between">
                <div class="flex items-center">
                    <Link href="/" class="group flex items-center space-x-3 transition-transform hover:scale-105">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-red-600 to-red-700 shadow-lg transition-transform group-hover:scale-110">
                            <Plane class="h-7 w-7 text-white" />
                        </div>
                        <div>
                            <span class="text-2xl font-extrabold tracking-tight text-gray-900">Flyover BD</span>
                            <p class="text-xs font-medium text-gray-500">Travel & Visa Services</p>
                        </div>
                    </Link>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden items-center space-x-1 md:flex">
                    <Link 
                        href="#tours" 
                        class="rounded-lg px-4 py-2 text-sm font-semibold text-gray-700 transition-all hover:bg-red-50 hover:text-red-600"
                    >
                        Tours
                    </Link>
                    <Link 
                        href="#visas" 
                        class="rounded-lg px-4 py-2 text-sm font-semibold text-gray-700 transition-all hover:bg-red-50 hover:text-red-600"
                    >
                        Visa Services
                    </Link>
                    <Link 
                        href="#about" 
                        class="rounded-lg px-4 py-2 text-sm font-semibold text-gray-700 transition-all hover:bg-red-50 hover:text-red-600"
                    >
                        About Us
                    </Link>
                    <Link 
                        href="#contact" 
                        class="rounded-lg px-4 py-2 text-sm font-semibold text-gray-700 transition-all hover:bg-red-50 hover:text-red-600"
                    >
                        Contact
                    </Link>
                    <Link
                        v-if="canRegister && !$page.props.auth.user"
                        href="/access/register"
                        class="ml-4 rounded-lg bg-gradient-to-r from-red-600 to-red-700 px-6 py-2.5 text-sm font-semibold text-white shadow-md transition-all hover:from-red-700 hover:to-red-800 hover:shadow-lg hover:scale-105"
                    >
                        Sign Up
                    </Link>
                </div>

                <!-- Mobile Menu Button -->
                <button
                    @click="toggleMobileMenu"
                    class="rounded-lg p-2 text-gray-700 transition-all hover:bg-gray-100 md:hidden"
                >
                    <Menu v-if="!mobileMenuOpen" class="h-6 w-6" />
                    <X v-else class="h-6 w-6" />
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div
            v-if="mobileMenuOpen"
            class="border-t border-gray-100 bg-white md:hidden"
        >
            <div class="space-y-1 px-4 pb-4 pt-2">
                <Link
                    href="#tours"
                    class="block rounded-lg px-3 py-2.5 text-base font-semibold text-gray-700 transition-all hover:bg-red-50 hover:text-red-600"
                    @click="toggleMobileMenu"
                >
                    Tours
                </Link>
                <Link
                    href="#visas"
                    class="block rounded-lg px-3 py-2.5 text-base font-semibold text-gray-700 transition-all hover:bg-red-50 hover:text-red-600"
                    @click="toggleMobileMenu"
                >
                    Visa Services
                </Link>
                <Link
                    href="#about"
                    class="block rounded-lg px-3 py-2.5 text-base font-semibold text-gray-700 transition-all hover:bg-red-50 hover:text-red-600"
                    @click="toggleMobileMenu"
                >
                    About Us
                </Link>
                <Link
                    href="#contact"
                    class="block rounded-lg px-3 py-2.5 text-base font-semibold text-gray-700 transition-all hover:bg-red-50 hover:text-red-600"
                    @click="toggleMobileMenu"
                >
                    Contact
                </Link>
                <Link
                    v-if="canRegister && !$page.props.auth.user"
                    href="/access/register"
                    class="mt-2 block rounded-lg bg-gradient-to-r from-red-600 to-red-700 px-3 py-2.5 text-center text-base font-semibold text-white shadow-md transition-all hover:from-red-700 hover:to-red-800"
                    @click="toggleMobileMenu"
                >
                    Sign Up
                </Link>
            </div>
        </div>
    </nav>
</template>

