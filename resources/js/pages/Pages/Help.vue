<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import TopBar from '@/components/HomePage/TopBar.vue';
import Navigation from '@/components/HomePage/Navigation.vue';
import Footer from '@/components/HomePage/Footer.vue';
import { Card, CardContent } from '@/components/ui/card';
import { HelpCircle, ChevronDown } from 'lucide-vue-next';
import { ref } from 'vue';

defineProps<{
    canRegister?: boolean;
}>();

withDefaults(defineProps<{
    canRegister?: boolean;
}>(), {
    canRegister: true,
});

const openFaq = ref<number | null>(null);

const faqs = [
    {
        question: 'How do I apply for a visa?',
        answer: 'You can apply for a visa through our website by visiting the Visa Services page, selecting your destination country, and following the application guidelines. Alternatively, you can contact our support team for assistance.',
    },
    {
        question: 'How long does visa processing take?',
        answer: 'Processing times vary depending on the destination country and visa type. Generally, it can take anywhere from 3-30 business days. Check the specific visa page for detailed processing times.',
    },
    {
        question: 'What documents do I need for a visa application?',
        answer: 'Required documents vary by country and visa type. Each visa service page lists all required documents. Common documents include passport, photographs, bank statements, and travel itinerary.',
    },
    {
        question: 'Can I cancel or modify my tour booking?',
        answer: 'Yes, you can cancel or modify your booking. Please contact us as soon as possible. Cancellation policies vary by tour package, so please check the terms and conditions for your specific tour.',
    },
    {
        question: 'What payment methods do you accept?',
        answer: 'We accept various payment methods including bank transfers, credit/debit cards, and mobile banking. Payment options will be available during the booking process.',
    },
    {
        question: 'Do you provide travel insurance?',
        answer: 'We can assist you in obtaining travel insurance. Please contact our team for more information about insurance options and coverage.',
    },
    {
        question: 'How can I track my visa application status?',
        answer: 'You can track your visa application status by logging into your account or contacting our support team with your application reference number.',
    },
    {
        question: 'What if my visa application is rejected?',
        answer: 'If your visa application is rejected, we will provide guidance on the reasons and next steps. In some cases, you may be able to reapply or appeal the decision.',
    },
];
</script>

<template>
    <Head title="Help Center - Flyover BD">
        <meta name="description" content="Find answers to frequently asked questions about our visa and tour services." />
    </Head>

    <div class="min-h-screen bg-gray-50">
        <TopBar />
        <Navigation :can-register="canRegister" />
        
        <div class="mx-auto max-w-4xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="mb-12 text-center">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                    <HelpCircle class="h-8 w-8 text-red-600" />
                </div>
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Help Center</h1>
                <p class="mt-4 text-xl text-gray-600">
                    Find answers to common questions about our services
                </p>
            </div>

            <!-- FAQ Section -->
            <div class="space-y-4">
                <Card
                    v-for="(faq, index) in faqs"
                    :key="index"
                    class="overflow-hidden"
                >
                    <button
                        @click="openFaq = openFaq === index ? null : index"
                        class="w-full p-6 text-left"
                    >
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">{{ faq.question }}</h3>
                            <ChevronDown
                                :class="[
                                    'h-5 w-5 text-gray-500 transition-transform',
                                    openFaq === index ? 'rotate-180' : ''
                                ]"
                            />
                        </div>
                    </button>
                    <div
                        v-if="openFaq === index"
                        class="border-t border-gray-200 bg-gray-50 px-6 py-4"
                    >
                        <p class="text-gray-700">{{ faq.answer }}</p>
                    </div>
                </Card>
            </div>

            <!-- Contact Support -->
            <Card class="mt-12">
                <CardContent class="p-8 text-center">
                    <h2 class="mb-4 text-2xl font-bold text-gray-900">Still Need Help?</h2>
                    <p class="mb-6 text-gray-600">
                        Can't find what you're looking for? Our support team is here to help.
                    </p>
                    <div class="flex flex-col gap-4 sm:flex-row sm:justify-center">
                        <a
                            href="mailto:support@flyoverbd.com"
                            class="inline-flex items-center justify-center rounded-md bg-red-600 px-6 py-3 text-base font-semibold text-white hover:bg-red-700"
                        >
                            Email Support
                        </a>
                        <a
                            href="tel:+8801234567890"
                            class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-6 py-3 text-base font-semibold text-gray-700 hover:bg-gray-50"
                        >
                            Call Us: +880 1234 567890
                        </a>
                    </div>
                </CardContent>
            </Card>
        </div>

        <Footer />
    </div>
</template>

