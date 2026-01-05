<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import TopBar from '@/components/HomePage/TopBar.vue';
import Navigation from '@/components/HomePage/Navigation.vue';
import Footer from '@/components/HomePage/Footer.vue';
import { Card, CardContent } from '@/components/ui/card';

// No props needed
</script>

<template>
    <Head title="Terms of Service - Flyover BD">
        <meta name="description" content="Read our terms of service to understand the rules and regulations for using our services." />
    </Head>

    <div class="min-h-screen bg-gray-50">
        <TopBar />
        <Navigation />
        
        <div class="mx-auto max-w-4xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="mb-12 text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Terms of Service</h1>
                <p class="mt-4 text-sm text-gray-500">Last updated: {{ new Date().toLocaleDateString() }}</p>
            </div>

            <Card>
                <CardContent class="p-8 prose max-w-none">
                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-bold text-gray-900">1. Acceptance of Terms</h2>
                        <p class="mb-4 text-gray-700">
                            By accessing and using Flyover BD's services, you accept and agree to be bound by 
                            these Terms of Service. If you do not agree, please do not use our services.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-bold text-gray-900">2. Services</h2>
                        <p class="mb-4 text-gray-700">
                            Flyover BD provides visa assistance and tour management services. We act as an 
                            intermediary between you and service providers, including government agencies and 
                            travel operators.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-bold text-gray-900">3. User Responsibilities</h2>
                        <p class="mb-4 text-gray-700">You agree to:</p>
                        <ul class="mb-4 list-disc pl-6 text-gray-700">
                            <li>Provide accurate and complete information</li>
                            <li>Comply with all applicable laws and regulations</li>
                            <li>Not use our services for any illegal purpose</li>
                            <li>Maintain the confidentiality of your account</li>
                        </ul>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-bold text-gray-900">4. Payment Terms</h2>
                        <p class="mb-4 text-gray-700">
                            All payments must be made in accordance with our payment terms. Service fees are 
                            non-refundable unless otherwise stated. Refund policies vary by service type.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-bold text-gray-900">5. Cancellation and Refunds</h2>
                        <p class="mb-4 text-gray-700">
                            Cancellation policies vary by service. Visa application fees are generally 
                            non-refundable once processing begins. Tour booking cancellations are subject 
                            to the terms of the specific tour package.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-bold text-gray-900">6. Limitation of Liability</h2>
                        <p class="mb-4 text-gray-700">
                            Flyover BD is not responsible for visa rejections, travel delays, or other 
                            circumstances beyond our control. We provide assistance services but cannot 
                            guarantee visa approval or travel outcomes.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-bold text-gray-900">7. Intellectual Property</h2>
                        <p class="mb-4 text-gray-700">
                            All content on our website, including text, graphics, logos, and software, 
                            is the property of Flyover BD and protected by copyright laws.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-bold text-gray-900">8. Changes to Terms</h2>
                        <p class="mb-4 text-gray-700">
                            We reserve the right to modify these terms at any time. Continued use of our 
                            services after changes constitutes acceptance of the new terms.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="mb-4 text-2xl font-bold text-gray-900">9. Contact Information</h2>
                        <p class="mb-4 text-gray-700">
                            For questions about these Terms of Service, please contact us at:
                        </p>
                        <p class="text-gray-700">
                            Email: legal@flyoverbd.com<br />
                            Phone: +880 1234 567890
                        </p>
                    </section>
                </CardContent>
            </Card>
        </div>

        <Footer />
    </div>
</template>

