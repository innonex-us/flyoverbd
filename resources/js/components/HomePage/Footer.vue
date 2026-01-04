<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Plane, Facebook, Instagram, Twitter, Youtube } from 'lucide-vue-next';
</script>

<template>
    <footer class="bg-gray-900 text-white">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <div class="flex items-center space-x-2">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-600">
                            <Plane class="h-6 w-6 text-white" />
                        </div>
                        <span class="text-xl font-bold">Flyover BD</span>
                    </div>
                    <p class="mt-4 text-sm text-gray-400">
                        Your trusted partner for visa assistance and tour management services.
                    </p>
                    <div class="mt-6 flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <Facebook class="h-5 w-5" />
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <Instagram class="h-5 w-5" />
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <Twitter class="h-5 w-5" />
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <Youtube class="h-5 w-5" />
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider">Services</h3>
                    <ul class="mt-4 space-y-2">
                        <li>
                            <Link href="#tours" class="text-sm text-gray-400 hover:text-white transition-colors">
                                Tour Packages
                            </Link>
                        </li>
                        <li>
                            <Link href="#visas" class="text-sm text-gray-400 hover:text-white transition-colors">
                                Visa Services
                            </Link>
                        </li>
                        <li>
                            <a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">
                                Travel Consultation
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider">Company</h3>
                    <ul class="mt-4 space-y-2">
                        <li>
                            <a href="#about" class="text-sm text-gray-400 hover:text-white transition-colors">
                                About Us
                            </a>
                        </li>
                        <li>
                            <a href="#contact" class="text-sm text-gray-400 hover:text-white transition-colors">
                                Contact
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">
                                Blog
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider">Support</h3>
                    <ul class="mt-4 space-y-2">
                        <li>
                            <a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">
                                Help Center
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">
                                Privacy Policy
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">
                                Terms of Service
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-800 pt-8 text-center text-sm text-gray-400">
                <p>&copy; {{ new Date().getFullYear() }} Flyover BD. All rights reserved.</p>
            </div>
        </div>
    </footer>
</template>

