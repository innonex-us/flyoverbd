<script setup lang="ts">
import SeoMeta from '@/components/SeoMeta.vue';
import TopBar from '@/components/HomePage/TopBar.vue';
import Navigation from '@/components/HomePage/Navigation.vue';
import Footer from '@/components/HomePage/Footer.vue';
import { Card, CardContent } from '@/components/ui/card';
import { Users, Target, Award, Heart } from 'lucide-vue-next';

const props = withDefaults(
    defineProps<{
        canRegister?: boolean;
        seoMeta?: Record<string, any>;
    }>(),
    {
        canRegister: true,
    },
);
</script>

<template>
    <SeoMeta
        :title="seoMeta?.title"
        :description="seoMeta?.description"
        :canonical="seoMeta?.canonical"
    />

    <div class="min-h-screen bg-gray-50">
        <TopBar />
        <Navigation :can-register="canRegister" />
        
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="mb-16 text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">About Flyover BD</h1>
                <p class="mt-4 text-xl text-gray-600">
                    Your trusted partner for visa assistance and tour management services
                </p>
            </div>

            <!-- Mission Section -->
            <Card class="mb-12">
                <CardContent class="p-8">
                    <h2 class="mb-4 text-3xl font-bold text-gray-900">Our Mission</h2>
                    <p class="mb-4 text-lg leading-relaxed text-gray-700">
                        At Flyover BD, we are committed to making travel accessible and hassle-free for everyone. 
                        Our mission is to provide exceptional visa assistance and tour management services that 
                        enable our clients to explore the world with confidence and peace of mind.
                    </p>
                    <p class="text-lg leading-relaxed text-gray-700">
                        We believe that travel should be an enriching experience, not a stressful one. That's why 
                        we handle all the complexities of visa applications and tour planning, so you can focus on 
                        creating unforgettable memories.
                    </p>
                </CardContent>
            </Card>

            <!-- Values Section -->
            <div class="mb-12">
                <h2 class="mb-8 text-center text-3xl font-bold text-gray-900">Our Core Values</h2>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <Card>
                        <CardContent class="p-6 text-center">
                            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                                <Heart class="h-8 w-8 text-red-600" />
                            </div>
                            <h3 class="mb-2 text-xl font-bold text-gray-900">Passion</h3>
                            <p class="text-gray-600">We are passionate about travel and helping you achieve your dreams.</p>
                        </CardContent>
                    </Card>
                    <Card>
                        <CardContent class="p-6 text-center">
                            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                                <Target class="h-8 w-8 text-red-600" />
                            </div>
                            <h3 class="mb-2 text-xl font-bold text-gray-900">Excellence</h3>
                            <p class="text-gray-600">We strive for excellence in every service we provide.</p>
                        </CardContent>
                    </Card>
                    <Card>
                        <CardContent class="p-6 text-center">
                            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                                <Users class="h-8 w-8 text-red-600" />
                            </div>
                            <h3 class="mb-2 text-xl font-bold text-gray-900">Integrity</h3>
                            <p class="text-gray-600">We conduct our business with honesty and transparency.</p>
                        </CardContent>
                    </Card>
                    <Card>
                        <CardContent class="p-6 text-center">
                            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                                <Award class="h-8 w-8 text-red-600" />
                            </div>
                            <h3 class="mb-2 text-xl font-bold text-gray-900">Reliability</h3>
                            <p class="text-gray-600">You can count on us to deliver on our promises.</p>
                        </CardContent>
                    </Card>
                </div>
            </div>

            <!-- Why Choose Us Section -->
            <Card>
                <CardContent class="p-8">
                    <h2 class="mb-6 text-3xl font-bold text-gray-900">Why Choose Flyover BD?</h2>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="mr-4 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-red-100">
                                <span class="text-red-600">✓</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Expert Team</h3>
                                <p class="text-gray-600">Our experienced team has in-depth knowledge of visa requirements and travel planning.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="mr-4 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-red-100">
                                <span class="text-red-600">✓</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Fast Processing</h3>
                                <p class="text-gray-600">We ensure quick and efficient processing of all visa applications and tour bookings.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="mr-4 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-red-100">
                                <span class="text-red-600">✓</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">24/7 Support</h3>
                                <p class="text-gray-600">Our customer support team is available round the clock to assist you.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="mr-4 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-red-100">
                                <span class="text-red-600">✓</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Competitive Pricing</h3>
                                <p class="text-gray-600">We offer the best prices without compromising on service quality.</p>
                            </div>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>

        <Footer />
    </div>
</template>

