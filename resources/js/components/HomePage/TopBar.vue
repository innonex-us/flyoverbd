<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Phone, Mail, HelpCircle, BookOpen } from 'lucide-vue-next';
</script>

<template>
    <div class="border-b border-red-800/30 bg-gradient-to-r from-red-700 via-red-600 to-red-700 text-white shadow-lg">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-12 items-center justify-between text-xs sm:text-sm">
                <div class="flex flex-wrap items-center gap-4 sm:gap-6">
                    <a 
                        href="tel:+8809611677989" 
                        class="group flex items-center gap-2 rounded-lg px-2 py-1 transition-all hover:bg-white/10 hover:scale-105"
                    >
                        <Phone class="h-3.5 w-3.5 sm:h-4 sm:w-4 transition-transform group-hover:scale-110" />
                        <span class="font-semibold">+880 9611-677989</span>
                    </a>
                    <a 
                        href="mailto:info@flyoverbd.com" 
                        class="group flex items-center gap-2 rounded-lg px-2 py-1 transition-all hover:bg-white/10 hover:scale-105"
                    >
                        <Mail class="h-3.5 w-3.5 sm:h-4 sm:w-4 transition-transform group-hover:scale-110" />
                        <span class="font-semibold hidden sm:inline">info@flyoverbd.com</span>
                        <span class="font-semibold sm:hidden">Email Us</span>
                    </a>
                </div>
                <div class="hidden items-center gap-3 md:flex">
                    <Link
                        href="/blog"
                        class="group flex items-center gap-1.5 rounded-lg px-3 py-1.5 font-semibold transition-all hover:bg-white/10 hover:scale-105"
                    >
                        <BookOpen class="h-3.5 w-3.5 transition-transform group-hover:scale-110" />
                        <span>Blog</span>
                    </Link>
                    <Link
                        href="/contact"
                        class="group flex items-center gap-1.5 rounded-lg px-3 py-1.5 font-semibold transition-all hover:bg-white/10 hover:scale-105"
                    >
                        <HelpCircle class="h-3.5 w-3.5 transition-transform group-hover:scale-110" />
                        <span>Help</span>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

