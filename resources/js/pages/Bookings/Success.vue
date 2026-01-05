<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import TopBar from '@/components/HomePage/TopBar.vue';
import Navigation from '@/components/HomePage/Navigation.vue';
import Footer from '@/components/HomePage/Footer.vue';
import { CheckCircle, Calendar, Users, DollarSign, Mail } from 'lucide-vue-next';

interface Booking {
    booking_reference: string;
    customer_name: string;
    customer_email: string;
    tour_title: string;
    number_of_participants: number;
    total_amount: number;
    currency: string;
    travel_date?: string | null;
    booking_status: string;
}

interface Props {
    booking: Booking;
}

const props = defineProps<Props>();

const formatCurrency = (amount: number) => {
    const currency = props.booking.currency === 'BDT' ? '৳' : props.booking.currency;
    return `${currency} ${amount.toLocaleString()}`;
};
</script>

<template>
    <Head title="Booking Confirmed - Flyover BD">
        <meta name="description" content="Your tour booking has been submitted successfully" />
    </Head>

    <div class="min-h-screen bg-gray-50">
        <TopBar />
        <Navigation />
        
        <div class="mx-auto max-w-3xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-green-100">
                    <CheckCircle class="h-12 w-12 text-green-600" />
                </div>
                <h1 class="mt-6 text-3xl font-extrabold text-gray-900">Booking Submitted Successfully!</h1>
                <p class="mt-2 text-lg text-gray-600">
                    Thank you for your booking. We've received your request and will contact you shortly.
                </p>
            </div>

            <Card class="mt-8">
                <CardContent class="p-8">
                    <h2 class="mb-6 text-2xl font-bold text-gray-900">Booking Details</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                            <div class="flex items-center text-gray-600">
                                <span class="font-medium">Booking Reference</span>
                            </div>
                            <span class="font-mono text-lg font-bold text-gray-900">{{ booking.booking_reference }}</span>
                        </div>

                        <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                            <div class="flex items-center text-gray-600">
                                <span class="font-medium">Tour Package</span>
                            </div>
                            <span class="font-semibold text-gray-900">{{ booking.tour_title }}</span>
                        </div>

                        <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                            <div class="flex items-center text-gray-600">
                                <Users class="mr-2 h-5 w-5" />
                                <span class="font-medium">Participants</span>
                            </div>
                            <span class="font-semibold text-gray-900">{{ booking.number_of_participants }}</span>
                        </div>

                        <div v-if="booking.travel_date" class="flex items-center justify-between border-b border-gray-200 pb-4">
                            <div class="flex items-center text-gray-600">
                                <Calendar class="mr-2 h-5 w-5" />
                                <span class="font-medium">Travel Date</span>
                            </div>
                            <span class="font-semibold text-gray-900">{{ booking.travel_date }}</span>
                        </div>

                        <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                            <div class="flex items-center text-gray-600">
                                <DollarSign class="mr-2 h-5 w-5" />
                                <span class="font-medium">Total Amount</span>
                            </div>
                            <span class="text-2xl font-extrabold text-red-600">{{ formatCurrency(booking.total_amount) }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-gray-600">
                                <Mail class="mr-2 h-5 w-5" />
                                <span class="font-medium">Email</span>
                            </div>
                            <span class="font-semibold text-gray-900">{{ booking.customer_email }}</span>
                        </div>
                    </div>

                    <div class="mt-8 rounded-lg bg-blue-50 border border-blue-200 p-4">
                        <h3 class="mb-2 font-semibold text-blue-900">What's Next?</h3>
                        <ul class="space-y-2 text-sm text-blue-800">
                            <li>• Our team will review your booking and contact you within 24 hours.</li>
                            <li>• You will receive a confirmation email with payment instructions.</li>
                            <li>• Please keep your booking reference ({{ booking.booking_reference }}) for future reference.</li>
                        </ul>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <Button 
                            as-child
                            class="flex-1 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800"
                        >
                            <Link href="/tours">Browse More Tours</Link>
                        </Button>
                        <Button 
                            as-child
                            variant="outline"
                            class="flex-1"
                        >
                            <Link href="/">Back to Home</Link>
                        </Button>
                    </div>
                </CardContent>
            </Card>
        </div>

        <Footer />
    </div>
</template>

