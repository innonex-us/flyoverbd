<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

// No props needed
</script>

<template>
    <section class="relative overflow-hidden bg-gradient-to-r from-red-600 via-red-700 to-red-800 py-12 sm:py-14 lg:py-16">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        <div class="relative mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl lg:text-5xl">
                Ready to Start Your Journey?
            </h2>
            <p class="mt-4 text-lg font-medium text-red-50 sm:mt-5 sm:text-xl">
                Contact us today for personalized travel assistance and expert guidance
            </p>
            <div class="mt-6 flex flex-col justify-center gap-4 sm:mt-8 sm:flex-row">
                <Button
                    as-child
                    size="lg"
                    class="h-14 bg-white px-8 text-base font-bold text-red-600 shadow-xl transition-all hover:scale-105 hover:bg-red-50 hover:shadow-2xl"
                >
                    <Link href="#contact">
                        Contact Us
                    </Link>
                </Button>
            </div>
        </div>
    </section>
</template>

