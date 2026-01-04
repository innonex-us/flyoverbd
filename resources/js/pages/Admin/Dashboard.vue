<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import {
    Package,
    Globe,
    MessageSquare,
    Calendar,
    TrendingUp,
    ArrowRight,
    FileText,
} from 'lucide-vue-next';

interface Props {
    stats: {
        tours: {
            total: number;
            active: number;
            featured: number;
        };
        visas: {
            total: number;
            active: number;
        };
        blogs: {
            total: number;
            published: number;
            draft: number;
            featured: number;
        };
        inquiries: {
            total: number;
            new: number;
            in_progress: number;
        };
        bookings: {
            total: number;
            pending: number;
            confirmed: number;
            revenue: number;
        };
    };
    recentInquiries: any[];
    recentBookings: any[];
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '#',
    },
];

const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat('en-BD', {
        style: 'currency',
        currency: 'BDT',
        minimumFractionDigits: 0,
    }).format(amount);
};
</script>

<template>
    <Head title="Admin Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4">
            <!-- Stats Grid -->
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-5">
                <!-- Tours Card -->
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">Tour Packages</CardTitle>
                        <Package class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ stats.tours.total }}</div>
                        <p class="text-xs text-muted-foreground">
                            {{ stats.tours.active }} active, {{ stats.tours.featured }} featured
                        </p>
                    </CardContent>
                </Card>

                <!-- Visas Card -->
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">Visa Requirements</CardTitle>
                        <Globe class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ stats.visas.total }}</div>
                        <p class="text-xs text-muted-foreground">
                            {{ stats.visas.active }} active
                        </p>
                    </CardContent>
                </Card>

                <!-- Blogs Card -->
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">Blog Posts</CardTitle>
                        <FileText class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ stats.blogs.total }}</div>
                        <p class="text-xs text-muted-foreground">
                            {{ stats.blogs.published }} published, {{ stats.blogs.draft }} draft
                        </p>
                    </CardContent>
                </Card>

                <!-- Inquiries Card -->
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">Inquiries</CardTitle>
                        <MessageSquare class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ stats.inquiries.total }}</div>
                        <p class="text-xs text-muted-foreground">
                            {{ stats.inquiries.new }} new, {{ stats.inquiries.in_progress }} in progress
                        </p>
                    </CardContent>
                </Card>

                <!-- Bookings Card -->
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">Bookings</CardTitle>
                        <Calendar class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ stats.bookings.total }}</div>
                        <p class="text-xs text-muted-foreground">
                            {{ stats.bookings.pending }} pending, {{ stats.bookings.confirmed }} confirmed
                        </p>
                    </CardContent>
                </Card>
            </div>

            <!-- Revenue Card -->
            <Card>
                <CardHeader>
                    <CardTitle class="flex items-center gap-2">
                        <TrendingUp class="h-5 w-5" />
                        Total Revenue
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="text-4xl font-bold">{{ formatCurrency(stats.bookings.revenue) }}</div>
                    <p class="text-sm text-muted-foreground mt-2">
                        From confirmed and paid bookings
                    </p>
                </CardContent>
            </Card>

            <!-- Recent Activity -->
            <div class="grid gap-4 md:grid-cols-2">
                <!-- Recent Inquiries -->
                <Card>
                    <CardHeader>
                        <div class="flex items-center justify-between">
                            <CardTitle>Recent Inquiries</CardTitle>
                            <Button variant="ghost" size="sm" as-child>
                                <Link href="/cp/inquiries">
                                    View All
                                    <ArrowRight class="ml-2 h-4 w-4" />
                                </Link>
                            </Button>
                        </div>
                    </CardHeader>
                    <CardContent>
                        <div class="space-y-4">
                            <div
                                v-for="inquiry in recentInquiries"
                                :key="inquiry.id"
                                class="flex items-start justify-between border-b pb-3 last:border-0 last:pb-0"
                            >
                                <div class="flex-1">
                                    <p class="font-medium">{{ inquiry.name }}</p>
                                    <p class="text-sm text-muted-foreground">{{ inquiry.email }}</p>
                                    <p class="text-xs text-muted-foreground mt-1">
                                        {{ inquiry.type }} • {{ inquiry.status }}
                                    </p>
                                </div>
                                <span class="text-xs text-muted-foreground">
                                    {{ new Date(inquiry.created_at).toLocaleDateString() }}
                                </span>
                            </div>
                            <div v-if="recentInquiries.length === 0" class="text-center py-8 text-muted-foreground">
                                No inquiries yet
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <!-- Recent Bookings -->
                <Card>
                    <CardHeader>
                        <div class="flex items-center justify-between">
                            <CardTitle>Recent Bookings</CardTitle>
                            <Button variant="ghost" size="sm" as-child>
                                <Link href="/cp/bookings">
                                    View All
                                    <ArrowRight class="ml-2 h-4 w-4" />
                                </Link>
                            </Button>
                        </div>
                    </CardHeader>
                    <CardContent>
                        <div class="space-y-4">
                            <div
                                v-for="booking in recentBookings"
                                :key="booking.id"
                                class="flex items-start justify-between border-b pb-3 last:border-0 last:pb-0"
                            >
                                <div class="flex-1">
                                    <p class="font-medium">{{ booking.customer_name }}</p>
                                    <p class="text-sm text-muted-foreground">
                                        {{ booking.booking_reference }}
                                    </p>
                                    <p class="text-xs text-muted-foreground mt-1">
                                        {{ booking.booking_status }} • {{ booking.payment_status }}
                                    </p>
                                </div>
                                <span class="text-xs text-muted-foreground">
                                    {{ new Date(booking.created_at).toLocaleDateString() }}
                                </span>
                            </div>
                            <div v-if="recentBookings.length === 0" class="text-center py-8 text-muted-foreground">
                                No bookings yet
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>

            <!-- Quick Actions -->
            <Card>
                <CardHeader>
                    <CardTitle>Quick Actions</CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="grid gap-4 md:grid-cols-5">
                        <Button as-child>
                            <Link href="/cp/tours/create">
                                <Package class="mr-2 h-4 w-4" />
                                Add Tour Package
                            </Link>
                        </Button>
                        <Button variant="outline" as-child>
                            <Link href="/cp/visas/create">
                                <Globe class="mr-2 h-4 w-4" />
                                Add Visa Requirement
                            </Link>
                        </Button>
                        <Button variant="outline" as-child>
                            <Link href="/cp/blogs/create">
                                <FileText class="mr-2 h-4 w-4" />
                                Add Blog Post
                            </Link>
                        </Button>
                        <Button variant="outline" as-child>
                            <Link href="/cp/inquiries">
                                <MessageSquare class="mr-2 h-4 w-4" />
                                View Inquiries
                            </Link>
                        </Button>
                        <Button variant="outline" as-child>
                            <Link href="/cp/bookings">
                                <Calendar class="mr-2 h-4 w-4" />
                                View Bookings
                            </Link>
                        </Button>
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>

