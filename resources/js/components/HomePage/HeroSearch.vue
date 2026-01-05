<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { MapPin, Plane, Calendar, Users, Globe, ChevronDown, Search, X } from 'lucide-vue-next';
import { ref, computed, onMounted, onUnmounted } from 'vue';

interface Props {
    visaCountries?: string[];
    visaTypes?: string[];
}

const props = withDefaults(defineProps<Props>(), {
    visaCountries: () => [],
    visaTypes: () => [],
});

const activeTab = ref('tours');
const destination = ref('');
const checkIn = ref('');
const checkOut = ref('');
const travelers = ref(1);
const destinationCountry = ref('');
const visaType = ref('');
const countrySearch = ref('');
const showCountryDropdown = ref(false);
const showVisaTypeDropdown = ref(false);

const searchTours = (e: Event) => {
    e.preventDefault();
    const params: Record<string, string> = {};
    
    if (destination.value) {
        params.destination = destination.value;
    }
    if (checkIn.value) {
        params.check_in = checkIn.value;
    }
    if (checkOut.value) {
        params.check_out = checkOut.value;
    }
    if (travelers.value) {
        params.travelers = travelers.value.toString();
    }
    
    router.get('/tours', params);
};

const filteredCountries = computed(() => {
    if (!countrySearch.value) {
        return props.visaCountries;
    }
    return props.visaCountries.filter(country =>
        country.toLowerCase().includes(countrySearch.value.toLowerCase())
    );
});

const selectCountry = (country: string) => {
    destinationCountry.value = country;
    countrySearch.value = country;
    showCountryDropdown.value = false;
};

const clearCountry = () => {
    destinationCountry.value = '';
    countrySearch.value = '';
    showCountryDropdown.value = false;
};

const selectVisaType = (type: string) => {
    visaType.value = type;
    showVisaTypeDropdown.value = false;
};

const handleClickOutside = (event: MouseEvent) => {
    const target = event.target as HTMLElement;
    if (!target.closest('.country-dropdown-container')) {
        showCountryDropdown.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});

const searchVisas = (e: Event) => {
    e.preventDefault();
    const params: Record<string, string> = {};
    
    if (destinationCountry.value) {
        params.search = destinationCountry.value;
    }
    if (visaType.value) {
        params.visa_type = visaType.value;
    }
    
    router.get('/visas', params);
};
</script>

<template>
    <section class="relative overflow-hidden py-16 lg:py-24" style="background-image: url('/background_image.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <!-- Background Overlay -->
        <!-- <div class="absolute inset-0 bg-gradient-to-br from-red-600/80 via-red-700/80 to-red-800/80"></div> -->
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- <div class="text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Plan Your Perfect Journey
                </h1>
                <p class="mt-6 text-lg font-medium text-red-50 sm:text-xl">
                    Discover amazing destinations and get expert visa assistance
                </p>
            </div> -->

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
                            <Plane :class="['h-5 w-5 transition-transform', activeTab === 'tours' ? 'text-red-600' : '']" />
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
                            <img 
                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAACWUlEQVR4nO2avW7UQBDHf6K4JDSYAgTp8gKhgAroQEI08Aa5VGmiVERECTUEXgB4CEiegAgIygctke6OD4lEuRR8BKGjXxTpb2kVGZ+9vvWai0cayTPeWc3P3t0ZS4YTIA3gCXAAmMDaBZaVU255XAEAc0wfuYB0FXyV8HLNejO5JX4KVRHjmk8N4klMDcIJB4mAaWAVaAN/pG35mhpTVj7kDRwFFoBfGerBIXBfMb7ycQocB7YTEn5lXa8l3N8CLlYFZBzY1divwEtdfwLGrHnG5DMaE8fsZoQxPkFGrTexqbX/UfadhHnu6roDnD0WOxISZEFjPgPngCvWUz6VMM+Rb0/2ZeA88EX2fCiQyNrYt+R7IPtpyjzPZS/Jvm0dAFEIkGndf2354v0xkzLPjOwXlm9dvmaBfJwDV3V/1vLtyHcjZZ6bsj9YvjnrECgdJN7Uk5bvp3wTKfNMyP5u+S7J1y6Qj3NgL0Phy6u9YQH5HQKkk7C0fuRYWt8SllarQD7OgSvDstmbuv9mAMfvO/mmCuTjHBipiNkFcUn2swwFcTGhIJ4JAYJa8UG1KPcGkE+hpnFL47bVCHZyNI3vZW+EbhpRC2635P9q40/rzcWbes9q/S/QX4xvkBhmM6EurPX5sNrICFEaCFoa89YBkKaH2hMjHvMpHBjpaF5RgetJW1pSU31Op8qA+BJTg1CDeBFTg1CDVB+koe9q41nXywBplQDy1jdISDE1CDWIFzE1CEMC0lXg0e8ToeW6ctl3CV4uoV7k1YcuIA3BxG8mpO4Lwuk3p/9K/gI5HHNwyRPgDAAAAABJRU5ErkJggg==" 
                                alt="passport" 
                                class="h-5 w-5 transition-all"
                                :style="activeTab === 'visas' ? { filter: 'brightness(0) saturate(100%) invert(27%) sepia(91%) saturate(7498%) hue-rotate(350deg) brightness(98%) contrast(118%)' } : { filter: 'brightness(0) invert(1)' }"
                            />
                            <span>Visa Services</span>
                        </div>
                    </button>
                </div>

                <!-- Search Form -->
                <div class="rounded-b-2xl rounded-t-none bg-white p-8 shadow-2xl">
                    <form v-if="activeTab === 'tours'" @submit="searchTours" class="space-y-6">
                        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                            <div class="space-y-2">
                                <Label for="destination" class="text-sm font-semibold text-gray-700">Destination</Label>
                                <div class="relative">
                                    <MapPin class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" />
                                    <Input
                                        id="destination"
                                        v-model="destination"
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
                                        v-model="checkIn"
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
                                        v-model="checkOut"
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
                                        v-model.number="travelers"
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

                    <form v-else @submit="searchVisas" class="space-y-6">
                        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-2">
                            <div class="space-y-2 country-dropdown-container">
                                <Label for="destination_country" class="text-sm font-semibold text-gray-700">Destination Country</Label>
                                <div class="relative">
                                    <Globe class="absolute left-3 top-1/2 z-10 h-5 w-5 -translate-y-1/2 text-gray-400" />
                                    <Input
                                        id="destination_country"
                                        v-model="countrySearch"
                                        type="text"
                                        placeholder="Select country"
                                        class="h-12 border-gray-300 pl-10 pr-10 focus:border-red-500 focus:ring-red-500"
                                        @focus="showCountryDropdown = true"
                                        @input="showCountryDropdown = true"
                                        autocomplete="off"
                                    />
                                    <button
                                        v-if="destinationCountry"
                                        type="button"
                                        @click.stop="clearCountry"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                    >
                                        <X class="h-4 w-4" />
                                    </button>
                                    <div
                                        v-if="showCountryDropdown && filteredCountries.length > 0"
                                        class="absolute z-20 mt-1 max-h-60 w-full overflow-auto rounded-md border border-gray-200 bg-white shadow-lg"
                                        @click.stop
                                    >
                                        <div
                                            v-for="country in filteredCountries"
                                            :key="country"
                                            @click="selectCountry(country)"
                                            class="cursor-pointer px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600"
                                        >
                                            {{ country }}
                                        </div>
                                    </div>
                                    <div
                                        v-if="showCountryDropdown && filteredCountries.length === 0 && countrySearch"
                                        class="absolute z-20 mt-1 w-full rounded-md border border-gray-200 bg-white p-4 text-sm text-gray-500 shadow-lg"
                                        @click.stop
                                    >
                                        No countries found
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <Label for="visa_type" class="text-sm font-semibold text-gray-700">Visa Type</Label>
                                <div class="relative">
                                    <ChevronDown class="absolute right-3 top-1/2 z-10 h-5 w-5 -translate-y-1/2 text-gray-400 pointer-events-none" />
                                    <select
                                        id="visa_type"
                                        v-model="visaType"
                                        class="h-12 w-full rounded-md border border-gray-300 bg-transparent px-3 py-2 pl-3 pr-10 text-sm focus:border-red-500 focus:ring-red-500"
                                    >
                                        <option value="">All Types</option>
                                        <option
                                            v-for="type in visaTypes"
                                            :key="type"
                                            :value="type"
                                        >
                                            {{ type }}
                                        </option>
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

