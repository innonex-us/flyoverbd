<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Facebook, Instagram, Twitter, Youtube } from 'lucide-vue-next';
</script>

<template>
    <footer class="border-t border-gray-200 bg-gray-900 text-white pb-mobile-nav md:pb-0">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 sm:py-14 lg:px-8 lg:py-16">
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4 sm:gap-10">
                <div class="lg:col-span-1">
                    <div class="flex items-center space-x-3">
                        <img 
                            src="/logo.png" 
                            alt="Flyover BD" 
                            class="h-12 w-auto"
                        />
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
                <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                    <p class="text-sm text-gray-400">
                        &copy; {{ new Date().getFullYear() }} Flyover BD. All rights reserved.
                    </p>
                    <div class="flex flex-col items-center gap-2 sm:flex-row sm:gap-4">
                        <p class="text-sm text-gray-400">
                            Developed by <a href="https://innonexus.net" target="_blank" rel="noopener noreferrer" class="text-red-500 hover:text-red-400 transition-colors">Innonexus.net</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

