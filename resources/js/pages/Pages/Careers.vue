<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import TopBar from '@/components/HomePage/TopBar.vue';
import Navigation from '@/components/HomePage/Navigation.vue';
import Footer from '@/components/HomePage/Footer.vue';
import { Card, CardContent } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Briefcase, MapPin, Clock, ArrowRight } from 'lucide-vue-next';

withDefaults(
    defineProps<{
        canRegister?: boolean;
    }>(),
    {
        canRegister: true,
    },
);
</script>

<template>
    <Head title="Careers - Flyover BD">
        <meta name="description" content="Join the Flyover BD team. Explore career opportunities in travel and visa services." />
    </Head>

    <div class="min-h-screen bg-gray-50">
        <TopBar />
        <Navigation :can-register="canRegister" />
        
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="mb-12 text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Join Our Team</h1>
                <p class="mt-4 text-xl text-gray-600">
                    Be part of a dynamic team that's shaping the future of travel services
                </p>
            </div>

            <div class="mb-12">
                <Card>
                    <CardContent class="p-8">
                        <h2 class="mb-4 text-2xl font-bold text-gray-900">Why Work With Us?</h2>
                        <div class="grid gap-6 sm:grid-cols-2">
                            <div>
                                <h3 class="mb-2 text-lg font-semibold text-gray-900">Growth Opportunities</h3>
                                <p class="text-gray-600">We invest in our employees' professional development and career growth.</p>
                            </div>
                            <div>
                                <h3 class="mb-2 text-lg font-semibold text-gray-900">Competitive Benefits</h3>
                                <p class="text-gray-600">Enjoy competitive salaries, health insurance, and other benefits.</p>
                            </div>
                            <div>
                                <h3 class="mb-2 text-lg font-semibold text-gray-900">Work-Life Balance</h3>
                                <p class="text-gray-600">We believe in maintaining a healthy work-life balance for all our team members.</p>
                            </div>
                            <div>
                                <h3 class="mb-2 text-lg font-semibold text-gray-900">Innovative Environment</h3>
                                <p class="text-gray-600">Work in a dynamic, innovative environment with cutting-edge technology.</p>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>

            <div class="mb-8">
                <h2 class="mb-6 text-3xl font-bold text-gray-900">Open Positions</h2>
                <div class="space-y-4">
                    <Card>
                        <CardContent class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3">
                                        <Briefcase class="h-5 w-5 text-red-600" />
                                        <h3 class="text-xl font-bold text-gray-900">Travel Consultant</h3>
                                    </div>
                                    <div class="mt-2 flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                        <span class="flex items-center">
                                            <MapPin class="mr-1 h-4 w-4" />
                                            Dhaka, Bangladesh
                                        </span>
                                        <span class="flex items-center">
                                            <Clock class="mr-1 h-4 w-4" />
                                            Full-time
                                        </span>
                                    </div>
                                    <p class="mt-3 text-gray-700">
                                        We are looking for an experienced Travel Consultant to join our team. 
                                        You will be responsible for assisting clients with tour packages and travel planning.
                                    </p>
                                </div>
                                <Button as-child class="ml-4">
                                    <a href="mailto:careers@flyoverbd.com?subject=Application for Travel Consultant">
                                        Apply Now
                                        <ArrowRight class="ml-2 h-4 w-4" />
                                    </a>
                                </Button>
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardContent class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3">
                                        <Briefcase class="h-5 w-5 text-red-600" />
                                        <h3 class="text-xl font-bold text-gray-900">Visa Processing Specialist</h3>
                                    </div>
                                    <div class="mt-2 flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                        <span class="flex items-center">
                                            <MapPin class="mr-1 h-4 w-4" />
                                            Dhaka, Bangladesh
                                        </span>
                                        <span class="flex items-center">
                                            <Clock class="mr-1 h-4 w-4" />
                                            Full-time
                                        </span>
                                    </div>
                                    <p class="mt-3 text-gray-700">
                                        Join our visa services team as a Visa Processing Specialist. 
                                        You will help clients navigate visa requirements and application processes.
                                    </p>
                                </div>
                                <Button as-child class="ml-4">
                                    <a href="mailto:careers@flyoverbd.com?subject=Application for Visa Processing Specialist">
                                        Apply Now
                                        <ArrowRight class="ml-2 h-4 w-4" />
                                    </a>
                                </Button>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>

            <Card>
                <CardContent class="p-8 text-center">
                    <h2 class="mb-4 text-2xl font-bold text-gray-900">Don't See a Position That Fits?</h2>
                    <p class="mb-6 text-gray-600">
                        We're always looking for talented individuals to join our team. 
                        Send us your resume and we'll keep you in mind for future opportunities.
                    </p>
                    <Button as-child>
                        <a href="mailto:careers@flyoverbd.com?subject=General Application">
                            Send Your Resume
                            <ArrowRight class="ml-2 h-4 w-4" />
                        </a>
                    </Button>
                </CardContent>
            </Card>
        </div>

        <Footer />
    </div>
</template>

