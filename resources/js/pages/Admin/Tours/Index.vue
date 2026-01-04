<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Badge } from '@/components/ui/badge';
import { Plus, Search, Edit, Trash2, Eye, Package } from 'lucide-vue-next';
import { ref } from 'vue';

interface Tour {
    id: number;
    title: string;
    slug: string;
    price: number;
    currency: string;
    duration_days: number;
    destination: string;
    is_featured: boolean;
    is_active: boolean;
    thumbnail: string | null;
    created_at: string;
}

interface Props {
    tours: {
        data: Tour[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
    filters: {
        search?: string;
        status?: string;
    };
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin',
        href: '/admin/dashboard',
    },
    {
        title: 'Tour Packages',
        href: '#',
    },
];

const search = ref(props.filters.search || '');
const status = ref(props.filters.status || 'all');

const handleSearch = () => {
    router.get('/admin/tours', {
        search: search.value || undefined,
        status: status.value !== 'all' ? status.value : undefined,
    }, {
        preserveState: true,
        replace: true,
    });
};

const handleDelete = (id: number) => {
    if (confirm('Are you sure you want to delete this tour package?')) {
        router.delete(`/admin/tours/${id}`, {
            preserveScroll: true,
        });
    }
};

const formatCurrency = (amount: number, currency: string = 'BDT') => {
    return new Intl.NumberFormat('en-BD', {
        style: 'currency',
        currency: currency,
        minimumFractionDigits: 0,
    }).format(amount);
};
</script>

<template>
    <Head title="Tour Packages" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">Tour Packages</h1>
                    <p class="text-muted-foreground">Manage your tour packages</p>
                </div>
                <Button as-child>
                    <Link href="/admin/tours/create">
                        <Plus class="mr-2 h-4 w-4" />
                        Add Tour Package
                    </Link>
                </Button>
            </div>

            <!-- Filters -->
            <Card>
                <CardContent class="pt-6">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center">
                        <div class="flex-1">
                            <div class="relative">
                                <Search class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
                                <Input
                                    v-model="search"
                                    placeholder="Search tours..."
                                    class="pl-9"
                                    @keyup.enter="handleSearch"
                                />
                            </div>
                        </div>
                        <select
                            v-model="status"
                            class="h-9 rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-xs"
                            @change="handleSearch"
                        >
                            <option value="all">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="featured">Featured</option>
                        </select>
                        <Button @click="handleSearch">Search</Button>
                    </div>
                </CardContent>
            </Card>

            <!-- Tours Table -->
            <Card>
                <CardHeader>
                    <CardTitle>All Tour Packages ({{ tours.total }})</CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="px-4 py-3 text-left text-sm font-medium">Tour</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Destination</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Duration</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Price</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="tour in tours.data"
                                    :key="tour.id"
                                    class="border-b hover:bg-muted/50"
                                >
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <div
                                                v-if="tour.thumbnail"
                                                class="h-12 w-12 rounded-md bg-muted bg-cover bg-center"
                                                :style="{ backgroundImage: `url(${tour.thumbnail})` }"
                                            />
                                            <Package
                                                v-else
                                                class="h-12 w-12 rounded-md bg-muted p-2 text-muted-foreground"
                                            />
                                            <div>
                                                <div class="font-medium">{{ tour.title }}</div>
                                                <div class="text-xs text-muted-foreground">
                                                    {{ tour.slug }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-sm">{{ tour.destination || 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-sm">{{ tour.duration_days }} days</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="font-medium">
                                            {{ formatCurrency(tour.price, tour.currency) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex gap-2">
                                            <Badge
                                                v-if="tour.is_active"
                                                variant="default"
                                            >
                                                Active
                                            </Badge>
                                            <Badge
                                                v-else
                                                variant="secondary"
                                            >
                                                Inactive
                                            </Badge>
                                            <Badge
                                                v-if="tour.is_featured"
                                                variant="outline"
                                            >
                                                Featured
                                            </Badge>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-end gap-2">
                                            <Button
                                                variant="ghost"
                                                size="icon-sm"
                                                as-child
                                            >
                                                <Link :href="`/admin/tours/${tour.id}`">
                                                    <Eye class="h-4 w-4" />
                                                </Link>
                                            </Button>
                                            <Button
                                                variant="ghost"
                                                size="icon-sm"
                                                as-child
                                            >
                                                <Link :href="`/admin/tours/${tour.id}/edit`">
                                                    <Edit class="h-4 w-4" />
                                                </Link>
                                            </Button>
                                            <Button
                                                variant="ghost"
                                                size="icon-sm"
                                                @click="handleDelete(tour.id)"
                                            >
                                                <Trash2 class="h-4 w-4 text-destructive" />
                                            </Button>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="tours.data.length === 0">
                                    <td colspan="6" class="px-4 py-8 text-center text-muted-foreground">
                                        No tour packages found
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div
                        v-if="tours.last_page > 1"
                        class="mt-4 flex items-center justify-between"
                    >
                        <div class="text-sm text-muted-foreground">
                            Showing {{ (tours.current_page - 1) * tours.per_page + 1 }} to
                            {{ Math.min(tours.current_page * tours.per_page, tours.total) }} of
                            {{ tours.total }} results
                        </div>
                        <div class="flex gap-2">
                            <Button
                                variant="outline"
                                size="sm"
                                :disabled="tours.current_page === 1"
                                @click="router.get(tours.current_page > 1 ? `/admin/tours?page=${tours.current_page - 1}` : '#')"
                            >
                                Previous
                            </Button>
                            <Button
                                variant="outline"
                                size="sm"
                                :disabled="tours.current_page === tours.last_page"
                                @click="router.get(tours.current_page < tours.last_page ? `/admin/tours?page=${tours.current_page + 1}` : '#')"
                            >
                                Next
                            </Button>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>

