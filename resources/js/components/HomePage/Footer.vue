<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Plane, Facebook, Instagram, Twitter, Youtube } from 'lucide-vue-next';
</script>

<template>
    <footer class="border-t border-gray-200 bg-gray-900 text-white pb-mobile-nav md:pb-0">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="grid gap-12 sm:grid-cols-2 lg:grid-cols-4">
                <div class="lg:col-span-1">
                    <div class="flex items-center space-x-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-red-600 to-red-700 shadow-lg">
                            <Plane class="h-7 w-7 text-white" />
                        </div>
                        <div>
                            <span class="text-xl font-extrabold">Flyover BD</span>
                            <p class="text-xs font-medium text-gray-400">Travel & Visa</p>
                        </div>
                    </div>
                    <p class="mt-6 text-sm leading-relaxed text-gray-400">
                        Your trusted partner for visa assistance and tour management services worldwide.
                    </p>
                    <div class="mt-6 flex space-x-3">
                        <a href="#" class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-800 text-gray-400 transition-all hover:scale-110 hover:bg-red-600 hover:text-white">
                            <Facebook class="h-5 w-5" />
                        </a>
                        <a href="#" class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-800 text-gray-400 transition-all hover:scale-110 hover:bg-red-600 hover:text-white">
                            <Instagram class="h-5 w-5" />
                        </a>
                        <a href="#" class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-800 text-gray-400 transition-all hover:scale-110 hover:bg-red-600 hover:text-white">
                            <Twitter class="h-5 w-5" />
                        </a>
                        <a href="#" class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-800 text-gray-400 transition-all hover:scale-110 hover:bg-red-600 hover:text-white">
                            <Youtube class="h-5 w-5" />
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-white">Services</h3>
                    <ul class="mt-6 space-y-3">
                        <li>
                            <Link href="/tours" class="text-sm text-gray-400 transition-all hover:translate-x-1 hover:text-white">
                                Tour Packages
                            </Link>
                        </li>
                        <li>
                            <Link href="/visas" class="text-sm text-gray-400 transition-all hover:translate-x-1 hover:text-white">
                                Visa Services
                            </Link>
                        </li>
                        <li>
                            <a href="#" class="text-sm text-gray-400 transition-all hover:translate-x-1 hover:text-white">
                                Travel Consultation
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-sm text-gray-400 transition-all hover:translate-x-1 hover:text-white">
                                Flight Booking
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-white">Company</h3>
                    <ul class="mt-6 space-y-3">
                        <li>
                            <Link href="/about" class="text-sm text-gray-400 transition-all hover:translate-x-1 hover:text-white">
                                About Us
                            </Link>
                        </li>
                        <li>
                            <Link href="/contact" class="text-sm text-gray-400 transition-all hover:translate-x-1 hover:text-white">
                                Contact
                            </Link>
                        </li>
                        <li>
                            <Link href="/blog" class="text-sm text-gray-400 transition-all hover:translate-x-1 hover:text-white">
                                Blog
                            </Link>
                        </li>
                        <li>
                            <Link href="/careers" class="text-sm text-gray-400 transition-all hover:translate-x-1 hover:text-white">
                                Careers
                            </Link>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-white">Support</h3>
                    <ul class="mt-6 space-y-3">
                        <li>
                            <Link href="/help" class="text-sm text-gray-400 transition-all hover:translate-x-1 hover:text-white">
                                Help Center
                            </Link>
                        </li>
                        <li>
                            <Link href="/privacy" class="text-sm text-gray-400 transition-all hover:translate-x-1 hover:text-white">
                                Privacy Policy
                            </Link>
                        </li>
                        <li>
                            <Link href="/terms" class="text-sm text-gray-400 transition-all hover:translate-x-1 hover:text-white">
                                Terms of Service
                            </Link>
                        </li>
                        <li>
                            <Link href="/help" class="text-sm text-gray-400 transition-all hover:translate-x-1 hover:text-white">
                                FAQ
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-800 pt-8">
                <div class="flex flex-col items-center justify-between sm:flex-row">
                    <p class="text-sm text-gray-400">
                        &copy; {{ new Date().getFullYear() }} Flyover BD. All rights reserved.
                    </p>
                    <p class="mt-4 text-sm text-gray-400 sm:mt-0">
                        Made with <span class="text-red-600">❤</span> in Bangladesh
                    </p>
                </div>
            </div>
        </div>
    </footer>
</template>

