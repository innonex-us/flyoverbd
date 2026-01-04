<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Badge } from '@/components/ui/badge';
import { Plus, Search, Eye, Calendar } from 'lucide-vue-next';
import { ref } from 'vue';

interface Booking {
    id: number;
    booking_reference: string;
    customer_name: string;
    customer_email: string;
    number_of_participants: number;
    total_amount: number;
    paid_amount: number;
    currency: string;
    booking_status: string;
    payment_status: string;
    tour?: { title: string } | null;
    created_at: string;
}

interface Props {
    bookings: {
        data: Booking[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
    filters: {
        search?: string;
        booking_status?: string;
        payment_status?: string;
    };
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin',
        href: '/admin/dashboard',
    },
    {
        title: 'Bookings',
        href: '#',
    },
];

const search = ref(props.filters.search || '');
const bookingStatus = ref(props.filters.booking_status || 'all');
const paymentStatus = ref(props.filters.payment_status || 'all');

const handleSearch = () => {
    router.get('/admin/bookings', {
        search: search.value || undefined,
        booking_status: bookingStatus.value !== 'all' ? bookingStatus.value : undefined,
        payment_status: paymentStatus.value !== 'all' ? paymentStatus.value : undefined,
    }, {
        preserveState: true,
        replace: true,
    });
};

const formatCurrency = (amount: number, currency: string = 'BDT') => {
    return new Intl.NumberFormat('en-BD', {
        style: 'currency',
        currency: currency,
        minimumFractionDigits: 0,
    }).format(amount);
};

const getBookingStatusColor = (status: string) => {
    const colors: Record<string, string> = {
        pending: 'secondary',
        confirmed: 'default',
        cancelled: 'destructive',
        completed: 'default',
    };
    return colors[status] || 'default';
};

const getPaymentStatusColor = (status: string) => {
    const colors: Record<string, string> = {
        pending: 'secondary',
        partial: 'outline',
        paid: 'default',
        refunded: 'destructive',
    };
    return colors[status] || 'default';
};
</script>

<template>
    <Head title="Bookings" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">Bookings</h1>
                    <p class="text-muted-foreground">Manage tour bookings</p>
                </div>
                <Button as-child>
                    <Link href="/admin/bookings/create">
                        <Plus class="mr-2 h-4 w-4" />
                        Add Booking
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
                                    placeholder="Search bookings..."
                                    class="pl-9"
                                    @keyup.enter="handleSearch"
                                />
                            </div>
                        </div>
                        <select
                            v-model="bookingStatus"
                            class="h-9 rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-xs"
                            @change="handleSearch"
                        >
                            <option value="all">All Booking Status</option>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="completed">Completed</option>
                        </select>
                        <select
                            v-model="paymentStatus"
                            class="h-9 rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-xs"
                            @change="handleSearch"
                        >
                            <option value="all">All Payment Status</option>
                            <option value="pending">Pending</option>
                            <option value="partial">Partial</option>
                            <option value="paid">Paid</option>
                            <option value="refunded">Refunded</option>
                        </select>
                        <Button @click="handleSearch">Search</Button>
                    </div>
                </CardContent>
            </Card>

            <!-- Bookings Table -->
            <Card>
                <CardHeader>
                    <CardTitle>All Bookings ({{ bookings.total }})</CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="px-4 py-3 text-left text-sm font-medium">Reference</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Customer</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Tour</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Participants</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Amount</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="booking in bookings.data"
                                    :key="booking.id"
                                    class="border-b hover:bg-muted/50"
                                >
                                    <td class="px-4 py-3">
                                        <div class="font-mono text-sm">{{ booking.booking_reference }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div>
                                            <div class="font-medium">{{ booking.customer_name }}</div>
                                            <div class="text-xs text-muted-foreground">
                                                {{ booking.customer_email }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-sm">
                                            {{ booking.tour?.title || 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-sm">{{ booking.number_of_participants }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div>
                                            <div class="font-medium">
                                                {{ formatCurrency(booking.total_amount, booking.currency) }}
                                            </div>
                                            <div class="text-xs text-muted-foreground">
                                                Paid: {{ formatCurrency(booking.paid_amount, booking.currency) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex flex-col gap-1">
                                            <Badge :variant="getBookingStatusColor(booking.booking_status)">
                                                {{ booking.booking_status }}
                                            </Badge>
                                            <Badge :variant="getPaymentStatusColor(booking.payment_status)">
                                                {{ booking.payment_status }}
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
                                                <Link :href="`/admin/bookings/${booking.id}`">
                                                    <Eye class="h-4 w-4" />
                                                </Link>
                                            </Button>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="bookings.data.length === 0">
                                    <td colspan="7" class="px-4 py-8 text-center text-muted-foreground">
                                        No bookings found
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div
                        v-if="bookings.last_page > 1"
                        class="mt-4 flex items-center justify-between"
                    >
                        <div class="text-sm text-muted-foreground">
                            Showing {{ (bookings.current_page - 1) * bookings.per_page + 1 }} to
                            {{ Math.min(bookings.current_page * bookings.per_page, bookings.total) }} of
                            {{ bookings.total }} results
                        </div>
                        <div class="flex gap-2">
                            <Button
                                variant="outline"
                                size="sm"
                                :disabled="bookings.current_page === 1"
                                @click="router.get(bookings.current_page > 1 ? `/admin/bookings?page=${bookings.current_page - 1}` : '#')"
                            >
                                Previous
                            </Button>
                            <Button
                                variant="outline"
                                size="sm"
                                :disabled="bookings.current_page === bookings.last_page"
                                @click="router.get(bookings.current_page < bookings.last_page ? `/admin/bookings?page=${bookings.current_page + 1}` : '#')"
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

