<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Card, CardContent } from '@/components/ui/card';
import TopBar from '@/components/HomePage/TopBar.vue';
import Navigation from '@/components/HomePage/Navigation.vue';
import Footer from '@/components/HomePage/Footer.vue';
import VisaServiceCard from '@/components/HomePage/VisaServiceCard.vue';
import { Search, Globe } from 'lucide-vue-next';
import { ref } from 'vue';

interface Visa {
    id: number;
    country: string;
    slug: string;
    description?: string | null;
    processing_time?: string | null;
    visa_fee?: number | null;
    currency: string;
}

interface Props {
    visas: {
        data: Visa[];
        links: any;
        meta: any;
    };
    filters?: {
        search?: string;
    };
    canRegister?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    filters: () => ({}),
    canRegister: true,
});

const search = ref(props.filters?.search || '');

const performSearch = () => {
    router.get('/visas', {
        search: search.value || undefined,
    }, {
        preserveState: true,
        replace: true,
    });
};
</script>

<template>
    <Head title="Visa Services - Flyover BD">
        <meta name="description" content="Get expert visa assistance for countries worldwide. Complete support for all visa types." />
    </Head>

    <div class="min-h-screen bg-gray-50">
        <TopBar />
        <Navigation :can-register="canRegister" />
        
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">Visa Services</h1>
                <p class="mt-2 text-lg text-gray-600">Get expert help with visa applications for countries worldwide</p>
            </div>

            <!-- Search -->
            <Card class="mb-8">
                <CardContent class="p-6">
                    <form @submit.prevent="performSearch" class="flex gap-4">
                        <div class="flex-1">
                            <Input
                                v-model="search"
                                type="text"
                                placeholder="Search by country..."
                                class="w-full"
                            />
                        </div>
                        <Button type="submit" class="bg-red-600 hover:bg-red-700">
                            <Search class="mr-2 h-4 w-4" />
                            Search
                        </Button>
                    </form>
                </CardContent>
            </Card>

            <!-- Visas Grid -->
            <div v-if="visas.data.length > 0" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <VisaServiceCard
                    v-for="visa in visas.data"
                    :key="visa.id"
                    :id="visa.id"
                    :slug="visa.slug"
                    :icon="Globe"
                    :title="visa.country"
                    :description="visa.description || `Complete assistance for ${visa.country} visa applications`"
                />
            </div>
            <div v-else class="py-12 text-center">
                <p class="text-lg text-gray-500">No visa services found. Try adjusting your search criteria.</p>
            </div>

            <!-- Pagination -->
            <div v-if="visas.links && visas.links.length > 3" class="mt-8 flex justify-center">
                <div class="flex space-x-2">
                    <Link
                        v-for="(link, index) in visas.links"
                        :key="index"
                        :href="link.url || '#'"
                        :class="[
                            'px-4 py-2 rounded-md text-sm font-medium transition-colors',
                            link.active
                                ? 'bg-red-600 text-white'
                                : 'bg-white text-gray-700 hover:bg-gray-100',
                            !link.url ? 'opacity-50 cursor-not-allowed' : ''
                        ]"
                        v-html="link.label"
                    />
                </div>
            </div>
        </div>

        <Footer />
    </div>
</template>

