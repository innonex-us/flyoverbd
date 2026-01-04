<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import TopBar from '@/components/HomePage/TopBar.vue';
import Navigation from '@/components/HomePage/Navigation.vue';
import Footer from '@/components/HomePage/Footer.vue';
import { Card, CardContent } from '@/components/ui/card';

defineProps<{
    canRegister?: boolean;
}>();

withDefaults(defineProps<{
    canRegister?: boolean;
}>(), {
    canRegister: true,
});
</script>

<template>
    <Head title="Privacy Policy - Flyover BD">
        <meta name="description" content="Read our privacy policy to understand how we collect, use, and protect your personal information." />
    </Head>

    <div class="min-h-screen bg-gray-50">
        <TopBar />
        <Navigation :can-register="canRegister" />
        
        <div class="mx-auto max-w-4xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="mb-12 text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Privacy Policy</h1>
                <p class="mt-4 text-sm text-gray-500">Last updated: {{ new Date().toLocaleDateString() }}</p>
            </div>

            <Card>
                <CardContent class="p-8 prose max-w-none">
                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-bold text-gray-900">1. Introduction</h2>
                        <p class="mb-4 text-gray-700">
                            Flyover BD ("we," "our," or "us") is committed to protecting your privacy. 
                            This Privacy Policy explains how we collect, use, disclose, and safeguard your 
                            information when you visit our website and use our services.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-bold text-gray-900">2. Information We Collect</h2>
                        <p class="mb-4 text-gray-700">We collect information that you provide directly to us, including:</p>
                        <ul class="mb-4 list-disc pl-6 text-gray-700">
                            <li>Personal identification information (name, email, phone number)</li>
                            <li>Passport and visa-related documents</li>
                            <li>Travel preferences and booking information</li>
                            <li>Payment information</li>
                            <li>Communication records</li>
                        </ul>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-bold text-gray-900">3. How We Use Your Information</h2>
                        <p class="mb-4 text-gray-700">We use the information we collect to:</p>
                        <ul class="mb-4 list-disc pl-6 text-gray-700">
                            <li>Process visa applications and tour bookings</li>
                            <li>Communicate with you about your requests</li>
                            <li>Improve our services and website</li>
                            <li>Send you promotional materials (with your consent)</li>
                            <li>Comply with legal obligations</li>
                        </ul>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-bold text-gray-900">4. Information Sharing</h2>
                        <p class="mb-4 text-gray-700">
                            We do not sell your personal information. We may share your information with:
                        </p>
                        <ul class="mb-4 list-disc pl-6 text-gray-700">
                            <li>Government agencies for visa processing</li>
                            <li>Service providers who assist in our operations</li>
                            <li>Legal authorities when required by law</li>
                        </ul>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-bold text-gray-900">5. Data Security</h2>
                        <p class="mb-4 text-gray-700">
                            We implement appropriate security measures to protect your personal information. 
                            However, no method of transmission over the internet is 100% secure.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-bold text-gray-900">6. Your Rights</h2>
                        <p class="mb-4 text-gray-700">You have the right to:</p>
                        <ul class="mb-4 list-disc pl-6 text-gray-700">
                            <li>Access your personal information</li>
                            <li>Correct inaccurate information</li>
                            <li>Request deletion of your information</li>
                            <li>Opt-out of marketing communications</li>
                        </ul>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-bold text-gray-900">7. Contact Us</h2>
                        <p class="mb-4 text-gray-700">
                            If you have questions about this Privacy Policy, please contact us at:
                        </p>
                        <p class="text-gray-700">
                            Email: privacy@flyoverbd.com<br />
                            Phone: +880 1234 567890
                        </p>
                    </section>
                </CardContent>
            </Card>
        </div>

        <Footer />
    </div>
</template>

