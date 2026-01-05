<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { MapPin, Plane, Users, Globe, ChevronDown, Search, X } from 'lucide-vue-next';
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
const country = ref('');
const participants = ref(1);
const destinationCountry = ref('');
const visaType = ref('');
const countrySearch = ref('');
const showCountryDropdown = ref(false);

const searchTours = (e: Event) => {
    e.preventDefault();
    const params: Record<string, string> = {};
    
    if (country.value) {
        params.destination = country.value;
    }
    if (participants.value) {
        params.participants = participants.value.toString();
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
    <section class="relative overflow-hidden py-12 sm:py-16 lg:py-24 xl:py-32" style="background-image: url('/background_image.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
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
                <div class="flex justify-center space-x-2 sm:space-x-3">
                    <button
                        @click="activeTab = 'tours'"
                        :class="[
                            'group relative rounded-t-xl px-4 py-2.5 text-xs font-bold transition-all duration-300 sm:px-6 sm:py-3 sm:text-sm',
                            activeTab === 'tours'
                                ? 'bg-white text-red-600 shadow-2xl scale-105'
                                : 'bg-white/10 text-white backdrop-blur-sm hover:bg-white/20 hover:scale-105'
                        ]"
                    >
                        <div class="flex items-center space-x-1.5 sm:space-x-2">
                            <Plane :class="['h-4 w-4 sm:h-5 sm:w-5 transition-transform', activeTab === 'tours' ? 'text-red-600' : '']" />
                            <span>Tours</span>
                        </div>
                    </button>
                    <button
                        @click="activeTab = 'visas'"
                        :class="[
                            'group relative rounded-t-xl px-4 py-2.5 text-xs font-bold transition-all duration-300 sm:px-6 sm:py-3 sm:text-sm',
                            activeTab === 'visas'
                                ? 'bg-white text-red-600 shadow-2xl scale-105'
                                : 'bg-white/10 text-white backdrop-blur-sm hover:bg-white/20 hover:scale-105'
                        ]"
                    >
                        <div class="flex items-center space-x-1.5 sm:space-x-2">
                            <img 
                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAACWUlEQVR4nO2avW7UQBDHf6K4JDSYAgTp8gKhgAroQEI08Aa5VGmiVERECTUEXgB4CEiegAgIygctke6OD4lEuRR8BKGjXxTpb2kVGZ+9vvWai0cayTPeWc3P3t0ZS4YTIA3gCXAAmMDaBZaVU255XAEAc0wfuYB0FXyV8HLNejO5JX4KVRHjmk8N4klMDcIJB4mAaWAVaAN/pG35mhpTVj7kDRwFFoBfGerBIXBfMb7ycQocB7YTEn5lXa8l3N8CLlYFZBzY1divwEtdfwLGrHnG5DMaE8fsZoQxPkFGrTexqbX/UfadhHnu6roDnD0WOxISZEFjPgPngCvWUz6VMM+Rb0/2ZeA88EX2fCiQyNrYt+R7IPtpyjzPZS/Jvm0dAFEIkGndf2354v0xkzLPjOwXlm9dvmaBfJwDV3V/1vLtyHcjZZ6bsj9YvjnrECgdJN7Uk5bvp3wTKfNMyP5u+S7J1y6Qj3NgL0Phy6u9YQH5HQKkk7C0fuRYWt8SllarQD7OgSvDstmbuv9mAMfvO/mmCuTjHBipiNkFcUn2swwFcTGhIJ4JAYJa8UG1KPcGkE+hpnFL47bVCHZyNI3vZW+EbhpRC2635P9q40/rzcWbes9q/S/QX4xvkBhmM6EurPX5sNrICFEaCFoa89YBkKaH2hMjHvMpHBjpaF5RgetJW1pSU31Op8qA+BJTg1CDeBFTg1CDVB+koe9q41nXywBplQDy1jdISDE1CDWIFzE1CEMC0lXg0e8ToeW6ctl3CV4uoV7k1YcuIA3BxG8mpO4Lwuk3p/9K/gI5HHNwyRPgDAAAAABJRU5ErkJggg==" 
                                alt="passport" 
                                class="h-4 w-4 sm:h-5 sm:w-5 transition-all"
                                :style="activeTab === 'visas' ? { filter: 'brightness(0) saturate(100%) invert(27%) sepia(91%) saturate(7498%) hue-rotate(350deg) brightness(98%) contrast(118%)' } : { filter: 'brightness(0) invert(1)' }"
                            />
                            <span class="hidden sm:inline">Visa Services</span>
                            <span class="sm:hidden">Visas</span>
                        </div>
                    </button>
                </div>

                <!-- Search Form -->
                <div class="rounded-b-2xl rounded-t-none bg-white p-4 shadow-2xl sm:p-6 lg:p-8">
                    <form v-if="activeTab === 'tours'" @submit="searchTours" class="space-y-4 sm:space-y-6">
                        <div class="grid grid-cols-2 gap-3 sm:grid-cols-2 sm:gap-5">
                            <div class="space-y-1.5 sm:space-y-2">
                                <Label for="country" class="text-xs font-semibold text-gray-700 sm:text-sm">Country</Label>
                                <div class="relative">
                                    <MapPin class="absolute left-2 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400 sm:left-3 sm:h-5 sm:w-5" />
                                    <Input
                                        id="country"
                                        v-model="country"
                                        type="text"
                                        placeholder="Country"
                                        class="h-10 border-gray-300 pl-8 text-sm focus:border-red-500 focus:ring-red-500 sm:h-12 sm:pl-10"
                                    />
                                </div>
                            </div>
                            <div class="space-y-1.5 sm:space-y-2">
                                <Label for="participants" class="text-xs font-semibold text-gray-700 sm:text-sm">People</Label>
                                <div class="relative">
                                    <Users class="absolute left-2 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400 sm:left-3 sm:h-5 sm:w-5" />
                                    <Input
                                        id="participants"
                                        v-model.number="participants"
                                        type="number"
                                        placeholder="1"
                                        min="1"
                                        class="h-10 border-gray-300 pl-8 text-sm focus:border-red-500 focus:ring-red-500 sm:h-12 sm:pl-10"
                                    />
                                </div>
                            </div>
                        </div>
                        <Button
                            type="submit"
                            class="h-11 w-full bg-gradient-to-r from-red-600 to-red-700 text-sm font-bold text-white shadow-lg transition-all hover:from-red-700 hover:to-red-800 hover:shadow-xl hover:scale-[1.02] sm:h-14 sm:text-base"
                            size="lg"
                        >
                            <Search class="mr-2 h-4 w-4 sm:h-5 sm:w-5" />
                            <span class="hidden sm:inline">Search Tours</span>
                            <span class="sm:hidden">Search</span>
                        </Button>
                    </form>

                    <form v-else @submit="searchVisas" class="space-y-4 sm:space-y-6">
                        <div class="grid grid-cols-2 gap-3 sm:grid-cols-2 sm:gap-5">
                            <div class="space-y-1.5 country-dropdown-container sm:space-y-2">
                                <Label for="destination_country" class="text-xs font-semibold text-gray-700 sm:text-sm">Country</Label>
                                <div class="relative">
                                    <Globe class="absolute left-2 top-1/2 z-10 h-4 w-4 -translate-y-1/2 text-gray-400 sm:left-3 sm:h-5 sm:w-5" />
                                    <Input
                                        id="destination_country"
                                        v-model="countrySearch"
                                        type="text"
                                        placeholder="Country"
                                        class="h-10 border-gray-300 pl-8 pr-8 text-sm focus:border-red-500 focus:ring-red-500 sm:h-12 sm:pl-10 sm:pr-10"
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
                            <div class="space-y-1.5 sm:space-y-2">
                                <Label for="visa_type" class="text-xs font-semibold text-gray-700 sm:text-sm">Visa Type</Label>
                                <div class="relative">
                                    <ChevronDown class="absolute right-2 top-1/2 z-10 h-4 w-4 -translate-y-1/2 text-gray-400 pointer-events-none sm:right-3 sm:h-5 sm:w-5" />
                                    <select
                                        id="visa_type"
                                        v-model="visaType"
                                        class="h-10 w-full rounded-md border border-gray-300 bg-transparent px-2 py-2 pl-2 pr-8 text-sm focus:border-red-500 focus:ring-red-500 sm:h-12 sm:px-3 sm:pr-10"
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
                            class="h-11 w-full bg-gradient-to-r from-red-600 to-red-700 text-sm font-bold text-white shadow-lg transition-all hover:from-red-700 hover:to-red-800 hover:shadow-xl hover:scale-[1.02] sm:h-14 sm:text-base"
                            size="lg"
                        >
                            <Search class="mr-2 h-4 w-4 sm:h-5 sm:w-5" />
                            <span class="hidden sm:inline">Check Visa Requirements</span>
                            <span class="sm:hidden">Check Visa</span>
                        </Button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

