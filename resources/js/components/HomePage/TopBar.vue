<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Phone, Mail } from 'lucide-vue-next';
</script>

<template>
    <div class="bg-red-600 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-10 items-center justify-between text-sm">
                <div class="flex items-center space-x-4">
                    <a href="tel:+8801234567890" class="flex items-center space-x-1 hover:text-red-100 transition-colors">
                        <Phone class="h-4 w-4" />
                        <span>+880 1234 567890</span>
                    </a>
                    <a href="mailto:info@flyoverbd.com" class="flex items-center space-x-1 hover:text-red-100 transition-colors">
                        <Mail class="h-4 w-4" />
                        <span>info@flyoverbd.com</span>
                    </a>
                </div>
                <div class="hidden items-center space-x-4 md:flex">
                    <a href="#" class="hover:text-red-100 transition-colors">Help</a>
                    <a href="#" class="hover:text-red-100 transition-colors">Blog</a>
                    <Link
                        v-if="!$page.props.auth.user"
                        href="/access/login"
                        class="hover:text-red-100 transition-colors"
                    >
                        Sign In
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

