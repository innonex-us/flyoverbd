<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Badge } from '@/components/ui/badge';
import { Search, Eye, MessageSquare } from 'lucide-vue-next';
import { ref } from 'vue';

interface Inquiry {
    id: number;
    type: string;
    name: string;
    email: string;
    phone: string | null;
    status: string;
    tour?: { title: string } | null;
    visa_requirement?: { country: string } | null;
    created_at: string;
}

interface Props {
    inquiries: {
        data: Inquiry[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
    filters: {
        search?: string;
        type?: string;
        status?: string;
    };
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/cp/dashboard',
    },
    {
        title: 'Inquiries',
        href: '#',
    },
];

const search = ref(props.filters.search || '');
const type = ref(props.filters.type || 'all');
const status = ref(props.filters.status || 'all');

const handleSearch = () => {
    router.get('/cp/inquiries', {
        search: search.value || undefined,
        type: type.value !== 'all' ? type.value : undefined,
        status: status.value !== 'all' ? status.value : undefined,
    }, {
        preserveState: true,
        replace: true,
    });
};

const getStatusColor = (status: string) => {
    const colors: Record<string, string> = {
        new: 'default',
        contacted: 'outline',
        in_progress: 'secondary',
        resolved: 'default',
        closed: 'secondary',
    };
    return colors[status] || 'default';
};
</script>

<template>
    <Head title="Inquiries" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">Inquiries</h1>
                    <p class="text-muted-foreground">Manage customer inquiries</p>
                </div>
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
                                    placeholder="Search inquiries..."
                                    class="pl-9"
                                    @keyup.enter="handleSearch"
                                />
                            </div>
                        </div>
                        <select
                            v-model="type"
                            class="h-9 rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-xs"
                            @change="handleSearch"
                        >
                            <option value="all">All Types</option>
                            <option value="tour">Tour</option>
                            <option value="visa">Visa</option>
                            <option value="general">General</option>
                        </select>
                        <select
                            v-model="status"
                            class="h-9 rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-xs"
                            @change="handleSearch"
                        >
                            <option value="all">All Status</option>
                            <option value="new">New</option>
                            <option value="contacted">Contacted</option>
                            <option value="in_progress">In Progress</option>
                            <option value="resolved">Resolved</option>
                            <option value="closed">Closed</option>
                        </select>
                        <Button @click="handleSearch">Search</Button>
                    </div>
                </CardContent>
            </Card>

            <!-- Inquiries Table -->
            <Card>
                <CardHeader>
                    <CardTitle>All Inquiries ({{ inquiries.total }})</CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="px-4 py-3 text-left text-sm font-medium">Customer</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Type</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Related To</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Date</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="inquiry in inquiries.data"
                                    :key="inquiry.id"
                                    class="border-b hover:bg-muted/50"
                                >
                                    <td class="px-4 py-3">
                                        <div>
                                            <div class="font-medium">{{ inquiry.name }}</div>
                                            <div class="text-xs text-muted-foreground">
                                                {{ inquiry.email }}
                                            </div>
                                            <div
                                                v-if="inquiry.phone"
                                                class="text-xs text-muted-foreground"
                                            >
                                                {{ inquiry.phone }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <Badge variant="outline">{{ inquiry.type }}</Badge>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-sm">
                                            <span v-if="inquiry.tour">{{ inquiry.tour.title }}</span>
                                            <span v-else-if="inquiry.visa_requirement">
                                                {{ inquiry.visa_requirement.country }}
                                            </span>
                                            <span v-else class="text-muted-foreground">N/A</span>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <Badge :variant="getStatusColor(inquiry.status)">
                                            {{ inquiry.status.replace('_', ' ') }}
                                        </Badge>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-sm text-muted-foreground">
                                            {{ new Date(inquiry.created_at).toLocaleDateString() }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-end gap-2">
                                            <Button
                                                variant="ghost"
                                                size="icon-sm"
                                                as-child
                                            >
                                                <Link :href="`/cp/inquiries/${inquiry.id}`">
                                                    <Eye class="h-4 w-4" />
                                                </Link>
                                            </Button>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="inquiries.data.length === 0">
                                    <td colspan="6" class="px-4 py-8 text-center text-muted-foreground">
                                        No inquiries found
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div
                        v-if="inquiries.last_page > 1"
                        class="mt-4 flex items-center justify-between"
                    >
                        <div class="text-sm text-muted-foreground">
                            Showing {{ (inquiries.current_page - 1) * inquiries.per_page + 1 }} to
                            {{ Math.min(inquiries.current_page * inquiries.per_page, inquiries.total) }} of
                            {{ inquiries.total }} results
                        </div>
                        <div class="flex gap-2">
                            <Button
                                variant="outline"
                                size="sm"
                                :disabled="inquiries.current_page === 1"
                                @click="router.get(inquiries.current_page > 1 ? `/cp/inquiries?page=${inquiries.current_page - 1}` : '#')"
                            >
                                Previous
                            </Button>
                            <Button
                                variant="outline"
                                size="sm"
                                :disabled="inquiries.current_page === inquiries.last_page"
                                @click="router.get(inquiries.current_page < inquiries.last_page ? `/cp/inquiries?page=${inquiries.current_page + 1}` : '#')"
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

