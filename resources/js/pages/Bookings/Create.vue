<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardContent } from '@/components/ui/card';
import TopBar from '@/components/HomePage/TopBar.vue';
import Navigation from '@/components/HomePage/Navigation.vue';
import Footer from '@/components/HomePage/Footer.vue';
import { ArrowLeft } from 'lucide-vue-next';
import { computed } from 'vue';

interface Tour {
    id: number;
    title: string;
    slug: string;
    price: number;
    currency: string;
    max_participants?: number | null;
    min_participants: number;
}

interface Props {
    tour: Tour;
}

const props = defineProps<Props>();

const form = useForm({
    tour_id: props.tour.id,
    customer_name: '',
    customer_email: '',
    customer_phone: '',
    customer_address: '',
    number_of_participants: props.tour.min_participants,
    travel_date: '',
    special_requests: '',
});

const totalAmount = computed(() => {
    return props.tour.price * form.number_of_participants;
});

const formatCurrency = (amount: number) => {
    const currency = props.tour.currency === 'BDT' ? '৳' : props.tour.currency;
    return `${currency} ${amount.toLocaleString()}`;
};

const submit = () => {
    form.post('/bookings', {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head :title="`Book ${tour.title} - Flyover BD`">
        <meta name="description" :content="`Book ${tour.title} tour package`" />
    </Head>

    <div class="min-h-screen bg-gray-50">
        <TopBar />
        <Navigation />
        
        <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
            <!-- Back Button -->
            <Link 
                :href="`/tours/${tour.slug}`" 
                class="mb-6 inline-flex items-center text-sm font-medium text-gray-600 hover:text-red-600 transition-colors"
            >
                <ArrowLeft class="mr-2 h-4 w-4" />
                Back to Tour Details
            </Link>

            <div class="mb-8 text-center">
                <h1 class="text-3xl font-extrabold text-gray-900">Book Your Tour</h1>
                <p class="mt-2 text-lg text-gray-600">{{ tour.title }}</p>
            </div>

            <div class="grid gap-8 lg:grid-cols-3">
                <!-- Booking Form -->
                <div class="lg:col-span-2">
                    <Card class="bg-white text-gray-900">
                        <CardContent class="p-8">
                            <h2 class="mb-6 text-2xl font-bold text-gray-900">Booking Information</h2>
                            
                            <form @submit.prevent="submit" class="space-y-6">
                                <div class="grid gap-6 sm:grid-cols-2">
                                    <div>
                                        <Label for="customer_name">Full Name *</Label>
                                        <Input
                                            id="customer_name"
                                            v-model="form.customer_name"
                                            type="text"
                                            required
                                            class="mt-2"
                                            placeholder="John Doe"
                                        />
                                        <p v-if="form.errors.customer_name" class="mt-1 text-sm text-red-600">
                                            {{ form.errors.customer_name }}
                                        </p>
                                    </div>
                                    <div>
                                        <Label for="customer_email">Email Address *</Label>
                                        <Input
                                            id="customer_email"
                                            v-model="form.customer_email"
                                            type="email"
                                            required
                                            class="mt-2"
                                            placeholder="john@example.com"
                                        />
                                        <p v-if="form.errors.customer_email" class="mt-1 text-sm text-red-600">
                                            {{ form.errors.customer_email }}
                                        </p>
                                    </div>
                                </div>

                                <div class="grid gap-6 sm:grid-cols-2">
                                    <div>
                                        <Label for="customer_phone">Phone Number *</Label>
                                        <Input
                                            id="customer_phone"
                                            v-model="form.customer_phone"
                                            type="tel"
                                            required
                                            class="mt-2"
                                            placeholder="+880 1234 567890"
                                        />
                                        <p v-if="form.errors.customer_phone" class="mt-1 text-sm text-red-600">
                                            {{ form.errors.customer_phone }}
                                        </p>
                                    </div>
                                    <div>
                                        <Label for="travel_date">Preferred Travel Date</Label>
                                        <Input
                                            id="travel_date"
                                            v-model="form.travel_date"
                                            type="date"
                                            class="mt-2"
                                            :min="new Date().toISOString().split('T')[0]"
                                        />
                                        <p v-if="form.errors.travel_date" class="mt-1 text-sm text-red-600">
                                            {{ form.errors.travel_date }}
                                        </p>
                                    </div>
                                </div>

                                <div>
                                    <Label for="customer_address">Address</Label>
                                    <textarea
                                        id="customer_address"
                                        v-model="form.customer_address"
                                        rows="3"
                                        class="mt-2 w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm"
                                        placeholder="Your full address"
                                    />
                                    <p v-if="form.errors.customer_address" class="mt-1 text-sm text-red-600">
                                        {{ form.errors.customer_address }}
                                    </p>
                                </div>

                                <div>
                                    <Label for="number_of_participants">
                                        Number of Participants *
                                        <span v-if="tour.min_participants > 1" class="text-xs text-gray-500">
                                            (Minimum: {{ tour.min_participants }})
                                        </span>
                                        <span v-if="tour.max_participants" class="text-xs text-gray-500">
                                            (Maximum: {{ tour.max_participants }})
                                        </span>
                                    </Label>
                                    <Input
                                        id="number_of_participants"
                                        v-model.number="form.number_of_participants"
                                        type="number"
                                        required
                                        :min="tour.min_participants"
                                        :max="tour.max_participants || undefined"
                                        class="mt-2"
                                    />
                                    <p v-if="form.errors.number_of_participants" class="mt-1 text-sm text-red-600">
                                        {{ form.errors.number_of_participants }}
                                    </p>
                                </div>

                                <div>
                                    <Label for="special_requests">Special Requests or Notes</Label>
                                    <textarea
                                        id="special_requests"
                                        v-model="form.special_requests"
                                        rows="4"
                                        class="mt-2 w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm"
                                        placeholder="Any special requirements or notes..."
                                    />
                                    <p v-if="form.errors.special_requests" class="mt-1 text-sm text-red-600">
                                        {{ form.errors.special_requests }}
                                    </p>
                                </div>

                                <Button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="w-full bg-gradient-to-r from-red-600 to-red-700 text-base font-bold text-white shadow-lg transition-all hover:from-red-700 hover:to-red-800 hover:shadow-xl"
                                >
                                    {{ form.processing ? 'Submitting...' : 'Submit Booking' }}
                                </Button>
                            </form>
                        </CardContent>
                    </Card>
                </div>

                <!-- Booking Summary -->
                <div class="lg:col-span-1">
                    <Card class="sticky top-24 bg-white text-gray-900">
                        <CardContent class="p-6">
                            <h3 class="mb-6 text-xl font-bold text-gray-900">Booking Summary</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-600">Tour Package</p>
                                    <p class="mt-1 font-semibold text-gray-900">{{ tour.title }}</p>
                                </div>

                                <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                    <span class="text-sm text-gray-600">Price per person</span>
                                    <span class="font-semibold text-gray-900">{{ formatCurrency(tour.price) }}</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Participants</span>
                                    <span class="font-semibold text-gray-900">{{ form.number_of_participants }}</span>
                                </div>

                                <div class="mt-6 rounded-lg bg-gradient-to-br from-red-50 to-red-100 border-2 border-red-200 p-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-base font-bold text-gray-900">Total Amount</span>
                                        <span class="text-xl font-extrabold text-red-700">{{ formatCurrency(totalAmount) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 rounded-lg bg-blue-50 border border-blue-200 p-4">
                                <p class="text-xs text-blue-800">
                                    <strong>Note:</strong> Your booking will be reviewed and confirmed by our team. 
                                    You will receive a confirmation email with payment instructions.
                                </p>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>

        <Footer />
    </div>
</template>

