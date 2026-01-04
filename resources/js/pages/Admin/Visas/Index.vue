<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Badge } from '@/components/ui/badge';
import { Plus, Search, Edit, Trash2, Globe } from 'lucide-vue-next';
import { ref } from 'vue';

interface Visa {
    id: number;
    country: string;
    country_code: string | null;
    slug: string;
    visa_fee: number | null;
    currency: string;
    is_active: boolean;
    created_at: string;
}

interface Props {
    visas: {
        data: Visa[];
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
        title: 'Visa Requirements',
        href: '#',
    },
];

const search = ref(props.filters.search || '');
const status = ref(props.filters.status || 'all');

const handleSearch = () => {
    router.get('/admin/visas', {
        search: search.value || undefined,
        status: status.value !== 'all' ? status.value : undefined,
    }, {
        preserveState: true,
        replace: true,
    });
};

const handleDelete = (id: number) => {
    if (confirm('Are you sure you want to delete this visa requirement?')) {
        router.delete(`/admin/visas/${id}`, {
            preserveScroll: true,
        });
    }
};

const formatCurrency = (amount: number | null, currency: string = 'BDT') => {
    if (!amount) return 'N/A';
    return new Intl.NumberFormat('en-BD', {
        style: 'currency',
        currency: currency,
        minimumFractionDigits: 0,
    }).format(amount);
};
</script>

<template>
    <Head title="Visa Requirements" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">Visa Requirements</h1>
                    <p class="text-muted-foreground">Manage visa requirements by country</p>
                </div>
                <Button as-child>
                    <Link href="/admin/visas/create">
                        <Plus class="mr-2 h-4 w-4" />
                        Add Visa Requirement
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
                                    placeholder="Search countries..."
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
                        </select>
                        <Button @click="handleSearch">Search</Button>
                    </div>
                </CardContent>
            </Card>

            <!-- Visas Table -->
            <Card>
                <CardHeader>
                    <CardTitle>All Visa Requirements ({{ visas.total }})</CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="px-4 py-3 text-left text-sm font-medium">Country</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Country Code</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Visa Fee</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="visa in visas.data"
                                    :key="visa.id"
                                    class="border-b hover:bg-muted/50"
                                >
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <Globe class="h-5 w-5 text-muted-foreground" />
                                            <div>
                                                <div class="font-medium">{{ visa.country }}</div>
                                                <div class="text-xs text-muted-foreground">
                                                    {{ visa.slug }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-sm">{{ visa.country_code || 'N/A' }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="font-medium">
                                            {{ formatCurrency(visa.visa_fee, visa.currency) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <Badge
                                            v-if="visa.is_active"
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
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-end gap-2">
                                            <Button
                                                variant="ghost"
                                                size="icon-sm"
                                                as-child
                                            >
                                                <Link :href="`/admin/visas/${visa.id}/edit`">
                                                    <Edit class="h-4 w-4" />
                                                </Link>
                                            </Button>
                                            <Button
                                                variant="ghost"
                                                size="icon-sm"
                                                @click="handleDelete(visa.id)"
                                            >
                                                <Trash2 class="h-4 w-4 text-destructive" />
                                            </Button>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="visas.data.length === 0">
                                    <td colspan="5" class="px-4 py-8 text-center text-muted-foreground">
                                        No visa requirements found
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div
                        v-if="visas.last_page > 1"
                        class="mt-4 flex items-center justify-between"
                    >
                        <div class="text-sm text-muted-foreground">
                            Showing {{ (visas.current_page - 1) * visas.per_page + 1 }} to
                            {{ Math.min(visas.current_page * visas.per_page, visas.total) }} of
                            {{ visas.total }} results
                        </div>
                        <div class="flex gap-2">
                            <Button
                                variant="outline"
                                size="sm"
                                :disabled="visas.current_page === 1"
                                @click="router.get(visas.current_page > 1 ? `/admin/visas?page=${visas.current_page - 1}` : '#')"
                            >
                                Previous
                            </Button>
                            <Button
                                variant="outline"
                                size="sm"
                                :disabled="visas.current_page === visas.last_page"
                                @click="router.get(visas.current_page < visas.last_page ? `/admin/visas?page=${visas.current_page + 1}` : '#')"
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

