<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

defineProps<{
    canRegister?: boolean;
}>();
</script>

<template>
    <section class="bg-red-600 py-16">
        <div class="mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                Ready to Start Your Journey?
            </h2>
            <p class="mt-4 text-lg text-red-100">
                Contact us today for personalized travel assistance
            </p>
            <div class="mt-8 flex flex-col justify-center gap-4 sm:flex-row">
                <Button
                    as-child
                    variant="secondary"
                    size="lg"
                    class="bg-white text-red-600 hover:bg-red-50"
                >
                    <Link href="#contact">
                        Contact Us
                    </Link>
                </Button>
                <Button
                    v-if="canRegister && !$page.props.auth.user"
                    as-child
                    variant="outline"
                    size="lg"
                    class="border-2 border-white text-white hover:bg-red-700"
                >
                    <Link href="/access/register">
                        Create Account
                    </Link>
                </Button>
            </div>
        </div>
    </section>
</template>

