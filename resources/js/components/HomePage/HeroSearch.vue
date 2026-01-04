<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { MapPin, Calendar, Users, Globe, ChevronDown, Search } from 'lucide-vue-next';
import { ref } from 'vue';

const activeTab = ref('tours');
</script>

<template>
    <section class="relative overflow-hidden bg-gradient-to-br from-red-600 via-red-700 to-red-800 py-16 lg:py-24">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Plan Your Perfect Journey
                </h1>
                <p class="mt-6 text-lg font-medium text-red-50 sm:text-xl">
                    Discover amazing destinations and get expert visa assistance
                </p>
            </div>

            <!-- Service Tabs -->
            <div class="mt-12">
                <div class="flex justify-center space-x-3">
                    <button
                        @click="activeTab = 'tours'"
                        :class="[
                            'group relative rounded-t-xl px-8 py-4 text-sm font-bold transition-all duration-300',
                            activeTab === 'tours'
                                ? 'bg-white text-red-600 shadow-2xl scale-105'
                                : 'bg-white/10 text-white backdrop-blur-sm hover:bg-white/20 hover:scale-105'
                        ]"
                    >
                        <div class="flex items-center space-x-2">
                            <MapPin :class="['h-5 w-5 transition-transform', activeTab === 'tours' ? 'text-red-600' : '']" />
                            <span>Tours</span>
                        </div>
                    </button>
                    <button
                        @click="activeTab = 'visas'"
                        :class="[
                            'group relative rounded-t-xl px-8 py-4 text-sm font-bold transition-all duration-300',
                            activeTab === 'visas'
                                ? 'bg-white text-red-600 shadow-2xl scale-105'
                                : 'bg-white/10 text-white backdrop-blur-sm hover:bg-white/20 hover:scale-105'
                        ]"
                    >
                        <div class="flex items-center space-x-2">
                            <Globe :class="['h-5 w-5 transition-transform', activeTab === 'visas' ? 'text-red-600' : '']" />
                            <span>Visa Services</span>
                        </div>
                    </button>
                </div>

                <!-- Search Form -->
                <div class="rounded-b-2xl rounded-t-none bg-white p-8 shadow-2xl">
                    <form v-if="activeTab === 'tours'" class="space-y-6">
                        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                            <div class="space-y-2">
                                <Label for="destination" class="text-sm font-semibold text-gray-700">Destination</Label>
                                <div class="relative">
                                    <MapPin class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" />
                                    <Input
                                        id="destination"
                                        type="text"
                                        placeholder="Where to?"
                                        class="h-12 border-gray-300 pl-10 focus:border-red-500 focus:ring-red-500"
                                    />
                                </div>
                            </div>
                            <div class="space-y-2">
                                <Label for="checkin" class="text-sm font-semibold text-gray-700">Check In</Label>
                                <div class="relative">
                                    <Calendar class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" />
                                    <Input
                                        id="checkin"
                                        type="date"
                                        class="h-12 border-gray-300 pl-10 focus:border-red-500 focus:ring-red-500"
                                    />
                                </div>
                            </div>
                            <div class="space-y-2">
                                <Label for="checkout" class="text-sm font-semibold text-gray-700">Check Out</Label>
                                <div class="relative">
                                    <Calendar class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" />
                                    <Input
                                        id="checkout"
                                        type="date"
                                        class="h-12 border-gray-300 pl-10 focus:border-red-500 focus:ring-red-500"
                                    />
                                </div>
                            </div>
                            <div class="space-y-2">
                                <Label for="travelers" class="text-sm font-semibold text-gray-700">Travelers</Label>
                                <div class="relative">
                                    <Users class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" />
                                    <Input
                                        id="travelers"
                                        type="number"
                                        placeholder="1"
                                        min="1"
                                        class="h-12 border-gray-300 pl-10 focus:border-red-500 focus:ring-red-500"
                                    />
                                </div>
                            </div>
                        </div>
                        <Button
                            type="submit"
                            class="h-14 w-full bg-gradient-to-r from-red-600 to-red-700 text-base font-bold text-white shadow-lg transition-all hover:from-red-700 hover:to-red-800 hover:shadow-xl hover:scale-[1.02]"
                            size="lg"
                        >
                            <Search class="mr-2 h-5 w-5" />
                            Search Tours
                        </Button>
                    </form>

                    <form v-else class="space-y-6">
                        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                            <div class="space-y-2">
                                <Label for="destination_country" class="text-sm font-semibold text-gray-700">Destination Country</Label>
                                <div class="relative">
                                    <Globe class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" />
                                    <Input
                                        id="destination_country"
                                        type="text"
                                        placeholder="Select country"
                                        class="h-12 border-gray-300 pl-10 focus:border-red-500 focus:ring-red-500"
                                    />
                                </div>
                            </div>
                            <div class="space-y-2">
                                <Label for="nationality" class="text-sm font-semibold text-gray-700">Your Nationality</Label>
                                <div class="relative">
                                    <MapPin class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" />
                                    <Input
                                        id="nationality"
                                        type="text"
                                        placeholder="Your nationality"
                                        class="h-12 border-gray-300 pl-10 focus:border-red-500 focus:ring-red-500"
                                    />
                                </div>
                            </div>
                            <div class="space-y-2">
                                <Label for="visa_type" class="text-sm font-semibold text-gray-700">Visa Type</Label>
                                <div class="relative">
                                    <ChevronDown class="absolute right-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400 pointer-events-none" />
                                    <select
                                        id="visa_type"
                                        class="h-12 w-full rounded-md border border-gray-300 bg-transparent px-3 py-2 pl-3 pr-10 text-sm focus:border-red-500 focus:ring-red-500"
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
                            class="h-14 w-full bg-gradient-to-r from-red-600 to-red-700 text-base font-bold text-white shadow-lg transition-all hover:from-red-700 hover:to-red-800 hover:shadow-xl hover:scale-[1.02]"
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

