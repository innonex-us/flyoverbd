<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import TopBar from '@/components/HomePage/TopBar.vue';
import Navigation from '@/components/HomePage/Navigation.vue';
import Footer from '@/components/HomePage/Footer.vue';
import { Card, CardContent } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Phone, Mail, MapPin, Clock, Send, CheckCircle } from 'lucide-vue-next';
import { computed } from 'vue';

withDefaults(
    defineProps<{
        canRegister?: boolean;
    }>(),
    {
        canRegister: true,
    },
);

const page = usePage();
const successMessage = computed(() => page.props.flash?.success);

// Get tour data from URL query params
const getQueryParam = (key: string): string | null => {
    if (typeof window === 'undefined') return null;
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(key);
};

const tourTitle = getQueryParam('tour_title');
const tourId = getQueryParam('tour_id');
const inquiryType = getQueryParam('type');
const preFilledSubject = getQueryParam('subject');

const form = useForm({
    name: '',
    email: '',
    phone: '',
    subject: preFilledSubject || (tourTitle ? `Inquiry about ${tourTitle}` : ''),
    message: tourTitle 
        ? (inquiryType === 'booking' 
            ? `I would like to book: ${tourTitle}\n\nPlease provide me with more information about availability and booking process.` 
            : `I'm interested in: ${tourTitle}\n\n`)
        : '',
});

const submit = () => {
    // Include tour_id if available
    const submitData = {
        ...form.data(),
        ...(tourId ? { tour_id: tourId } : {}),
    };
    
    form.transform(() => submitData).post('/contact/submit', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Head title="Contact Us - Flyover BD">
        <meta name="description" content="Get in touch with Flyover BD. We're here to help with all your travel and visa needs." />
    </Head>

    <div class="min-h-screen bg-gray-50">
        <TopBar />
        <Navigation :can-register="canRegister" />
        
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="mb-12 text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Contact Us</h1>
                <p class="mt-4 text-xl text-gray-600">
                    We're here to help! Get in touch with us for any questions or inquiries.
                </p>
            </div>

            <div class="grid gap-8 lg:grid-cols-3">
                <!-- Contact Information -->
                <div class="lg:col-span-1">
                    <Card>
                        <CardContent class="p-6">
                            <h2 class="mb-6 text-2xl font-bold text-gray-900">Get in Touch</h2>
                            <div class="space-y-6">
                                <div class="flex items-start">
                                    <Phone class="mr-4 h-6 w-6 flex-shrink-0 text-red-600" />
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Phone</h3>
                                        <p class="text-gray-600">+880 1234 567890</p>
                                        <p class="text-gray-600">+880 1234 567891</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <Mail class="mr-4 h-6 w-6 flex-shrink-0 text-red-600" />
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Email</h3>
                                        <p class="text-gray-600">info@flyoverbd.com</p>
                                        <p class="text-gray-600">support@flyoverbd.com</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <MapPin class="mr-4 h-6 w-6 flex-shrink-0 text-red-600" />
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Address</h3>
                                        <p class="text-gray-600">
                                            Dhaka, Bangladesh<br />
                                            Office Hours: 9:00 AM - 6:00 PM
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <Clock class="mr-4 h-6 w-6 flex-shrink-0 text-red-600" />
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Business Hours</h3>
                                        <p class="text-gray-600">Sunday - Thursday: 9:00 AM - 6:00 PM</p>
                                        <p class="text-gray-600">Friday: 9:00 AM - 1:00 PM</p>
                                        <p class="text-gray-600">Saturday: Closed</p>
                                    </div>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Contact Form -->
                <div class="lg:col-span-2">
                    <Card>
                        <CardContent class="p-8">
                            <h2 class="mb-6 text-2xl font-bold text-gray-900">Send us a Message</h2>
                            
                            <!-- Success Message -->
                            <div v-if="successMessage" class="mb-6 rounded-lg bg-green-50 border border-green-200 p-4">
                                <div class="flex items-center">
                                    <CheckCircle class="mr-2 h-5 w-5 text-green-600" />
                                    <p class="text-sm font-medium text-green-800">{{ successMessage }}</p>
                                </div>
                            </div>

                            <form @submit.prevent="submit" class="space-y-6">
                                <div class="grid gap-6 sm:grid-cols-2">
                                    <div>
                                        <Label for="name">Name *</Label>
                                        <Input
                                            id="name"
                                            v-model="form.name"
                                            type="text"
                                            required
                                            class="mt-2"
                                        />
                                        <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">
                                            {{ form.errors.name }}
                                        </p>
                                    </div>
                                    <div>
                                        <Label for="email">Email *</Label>
                                        <Input
                                            id="email"
                                            v-model="form.email"
                                            type="email"
                                            required
                                            class="mt-2"
                                        />
                                        <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">
                                            {{ form.errors.email }}
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <Label for="phone">Phone</Label>
                                    <Input
                                        id="phone"
                                        v-model="form.phone"
                                        type="tel"
                                        class="mt-2"
                                    />
                                    <p v-if="form.errors.phone" class="mt-1 text-sm text-red-600">
                                        {{ form.errors.phone }}
                                    </p>
                                </div>
                                <div>
                                    <Label for="subject">Subject *</Label>
                                    <Input
                                        id="subject"
                                        v-model="form.subject"
                                        type="text"
                                        required
                                        class="mt-2"
                                    />
                                    <p v-if="form.errors.subject" class="mt-1 text-sm text-red-600">
                                        {{ form.errors.subject }}
                                    </p>
                                </div>
                                <div>
                                    <Label for="message">Message *</Label>
                                    <textarea
                                        id="message"
                                        v-model="form.message"
                                        required
                                        rows="6"
                                        class="mt-2 w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm"
                                    />
                                    <p v-if="form.errors.message" class="mt-1 text-sm text-red-600">
                                        {{ form.errors.message }}
                                    </p>
                                </div>
                                <Button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800"
                                >
                                    <Send class="mr-2 h-4 w-4" />
                                    {{ form.processing ? 'Sending...' : 'Send Message' }}
                                </Button>
                            </form>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>

        <Footer />
    </div>
</template>

