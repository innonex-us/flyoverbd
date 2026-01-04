<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { MapPin, Calendar, Users, Globe, ChevronDown, Search } from 'lucide-vue-next';
import { ref } from 'vue';

const activeTab = ref('tours');
</script>

<template>
    <section class="relative bg-gradient-to-br from-red-600 via-red-700 to-red-800 py-12 lg:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Plan Your Perfect Journey
                </h1>
                <p class="mt-4 text-lg text-red-100 sm:text-xl">
                    Discover amazing destinations and get expert visa assistance
                </p>
            </div>

            <!-- Service Tabs -->
            <div class="mt-8">
                <div class="flex justify-center space-x-2">
                    <button
                        @click="activeTab = 'tours'"
                        :class="[
                            'rounded-t-lg px-6 py-3 text-sm font-semibold transition-colors',
                            activeTab === 'tours'
                                ? 'bg-white text-red-600 shadow-lg'
                                : 'bg-white/20 text-white hover:bg-white/30'
                        ]"
                    >
                        <div class="flex items-center space-x-2">
                            <MapPin class="h-5 w-5" />
                            <span>Tours</span>
                        </div>
                    </button>
                    <button
                        @click="activeTab = 'visas'"
                        :class="[
                            'rounded-t-lg px-6 py-3 text-sm font-semibold transition-colors',
                            activeTab === 'visas'
                                ? 'bg-white text-red-600 shadow-lg'
                                : 'bg-white/20 text-white hover:bg-white/30'
                        ]"
                    >
                        <div class="flex items-center space-x-2">
                            <Globe class="h-5 w-5" />
                            <span>Visa Services</span>
                        </div>
                    </button>
                </div>

                <!-- Search Form -->
                <div class="rounded-b-lg rounded-t-none bg-white p-6 shadow-xl">
                    <form v-if="activeTab === 'tours'" class="space-y-4">
                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                            <div>
                                <Label for="destination">Destination</Label>
                                <div class="relative mt-2">
                                    <MapPin class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" />
                                    <Input
                                        id="destination"
                                        type="text"
                                        placeholder="Where to?"
                                        class="pl-10"
                                    />
                                </div>
                            </div>
                            <div>
                                <Label for="checkin">Check In</Label>
                                <div class="relative mt-2">
                                    <Calendar class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" />
                                    <Input
                                        id="checkin"
                                        type="date"
                                        class="pl-10"
                                    />
                                </div>
                            </div>
                            <div>
                                <Label for="checkout">Check Out</Label>
                                <div class="relative mt-2">
                                    <Calendar class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" />
                                    <Input
                                        id="checkout"
                                        type="date"
                                        class="pl-10"
                                    />
                                </div>
                            </div>
                            <div>
                                <Label for="travelers">Travelers</Label>
                                <div class="relative mt-2">
                                    <Users class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" />
                                    <Input
                                        id="travelers"
                                        type="number"
                                        placeholder="1"
                                        min="1"
                                        class="pl-10"
                                    />
                                </div>
                            </div>
                        </div>
                        <Button
                            type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white"
                            size="lg"
                        >
                            <Search class="mr-2 h-5 w-5" />
                            Search Tours
                        </Button>
                    </form>

                    <form v-else class="space-y-4">
                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            <div>
                                <Label for="destination_country">Destination Country</Label>
                                <div class="relative mt-2">
                                    <Globe class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" />
                                    <Input
                                        id="destination_country"
                                        type="text"
                                        placeholder="Select country"
                                        class="pl-10"
                                    />
                                </div>
                            </div>
                            <div>
                                <Label for="nationality">Your Nationality</Label>
                                <div class="relative mt-2">
                                    <MapPin class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" />
                                    <Input
                                        id="nationality"
                                        type="text"
                                        placeholder="Your nationality"
                                        class="pl-10"
                                    />
                                </div>
                            </div>
                            <div>
                                <Label for="visa_type">Visa Type</Label>
                                <div class="relative mt-2">
                                    <ChevronDown class="absolute right-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400 pointer-events-none" />
                                    <select
                                        id="visa_type"
                                        class="h-10 w-full rounded-md border border-input bg-transparent px-3 py-2 pl-3 pr-10 text-sm"
                                    >
                                        <option>Tourist Visa</option>
                                        <option>Business Visa</option>
                                        <option>Transit Visa</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <Button
                            type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white"
                            size="lg"
                        >
                            <Search class="mr-2 h-5 w-5" />
                            Check Visa Requirements
                        </Button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

