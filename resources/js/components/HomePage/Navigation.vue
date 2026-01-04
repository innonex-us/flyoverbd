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
    <nav class="sticky top-0 z-50 border-b border-gray-200 bg-white shadow-sm">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center">
                    <Link href="/" class="flex items-center space-x-2">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-600">
                            <Plane class="h-6 w-6 text-white" />
                        </div>
                        <span class="text-2xl font-bold text-red-600">Flyover BD</span>
                    </Link>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden items-center space-x-8 md:flex">
                    <Link href="#tours" class="text-sm font-medium text-gray-700 hover:text-red-600 transition-colors">
                        Tours
                    </Link>
                    <Link href="#visas" class="text-sm font-medium text-gray-700 hover:text-red-600 transition-colors">
                        Visa Services
                    </Link>
                    <Link href="#about" class="text-sm font-medium text-gray-700 hover:text-red-600 transition-colors">
                        About Us
                    </Link>
                    <Link href="#contact" class="text-sm font-medium text-gray-700 hover:text-red-600 transition-colors">
                        Contact
                    </Link>
                    <Link
                        v-if="canRegister && !$page.props.auth.user"
                        href="/access/register"
                        class="rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 transition-colors"
                    >
                        Sign Up
                    </Link>
                </div>

                <!-- Mobile Menu Button -->
                <button
                    @click="toggleMobileMenu"
                    class="md:hidden p-2 text-gray-700 hover:text-red-600"
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
                    href="#tours"
                    class="block px-3 py-2 text-base font-medium text-gray-700 hover:bg-red-50 hover:text-red-600"
                    @click="toggleMobileMenu"
                >
                    Tours
                </Link>
                <Link
                    href="#visas"
                    class="block px-3 py-2 text-base font-medium text-gray-700 hover:bg-red-50 hover:text-red-600"
                    @click="toggleMobileMenu"
                >
                    Visa Services
                </Link>
                <Link
                    href="#about"
                    class="block px-3 py-2 text-base font-medium text-gray-700 hover:bg-red-50 hover:text-red-600"
                    @click="toggleMobileMenu"
                >
                    About Us
                </Link>
                <Link
                    href="#contact"
                    class="block px-3 py-2 text-base font-medium text-gray-700 hover:bg-red-50 hover:text-red-600"
                    @click="toggleMobileMenu"
                >
                    Contact
                </Link>
                <Link
                    v-if="canRegister && !$page.props.auth.user"
                    href="/access/register"
                    class="block rounded-md bg-red-600 px-3 py-2 text-center text-base font-medium text-white hover:bg-red-700"
                    @click="toggleMobileMenu"
                >
                    Sign Up
                </Link>
            </div>
        </div>
    </nav>
</template>

