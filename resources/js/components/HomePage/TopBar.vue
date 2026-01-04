<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Phone, Mail } from 'lucide-vue-next';
</script>

<template>
    <div class="border-b border-red-700/20 bg-gradient-to-r from-red-600 to-red-700 text-white shadow-sm">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-11 items-center justify-between text-xs sm:text-sm">
                <div class="flex items-center space-x-6">
                    <a href="tel:+8801234567890" class="flex items-center space-x-2 transition-all hover:scale-105 hover:text-red-50">
                        <Phone class="h-3.5 w-3.5 sm:h-4 sm:w-4" />
                        <span class="font-medium">+880 1234 567890</span>
                    </a>
                    <a href="mailto:info@flyoverbd.com" class="flex items-center space-x-2 transition-all hover:scale-105 hover:text-red-50">
                        <Mail class="h-3.5 w-3.5 sm:h-4 sm:w-4" />
                        <span class="font-medium">info@flyoverbd.com</span>
                    </a>
                </div>
                <div class="hidden items-center space-x-5 md:flex">
                    <a href="#" class="font-medium transition-all hover:scale-105 hover:text-red-50">Help Center</a>
                    <a href="#" class="font-medium transition-all hover:scale-105 hover:text-red-50">Blog</a>
                    <Link
                        v-if="!$page.props.auth.user"
                        href="/access/login"
                        class="font-medium transition-all hover:scale-105 hover:text-red-50"
                    >
                        Sign In
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

