<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';
import { ArrowLeft } from 'lucide-vue-next';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/cp/dashboard',
    },
    {
        title: 'Visa Requirements',
        href: '/cp/visas',
    },
    {
        title: 'Create',
        href: '#',
    },
];

const requiredDocuments = ref<string[]>(['']);
const addDocument = () => {
    requiredDocuments.value.push('');
};
const removeDocument = (index: number) => {
    requiredDocuments.value.splice(index, 1);
};

const form = useForm({
    country: '',
    country_code: '',
    visa_type: '',
    slug: '',
    description: '',
    required_documents: [] as string[],
    application_guidelines: '',
    processing_time: '',
    visa_fee: null as number | null,
    currency: 'BDT',
    eligibility_criteria: '',
    important_notes: '',
    is_active: true,
    meta_title: '',
    meta_description: '',
    meta_keywords: '',
});

const submit = () => {
    // Filter out empty documents
    form.required_documents = requiredDocuments.value.filter(doc => doc.trim() !== '');
    form.post('/cp/visas', {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Create Visa Requirement" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">Create Visa Requirement</h1>
                    <p class="text-muted-foreground">Add a new visa requirement to your system</p>
                </div>
                <Button variant="outline" as-child>
                    <Link href="/cp/visas">
                        <ArrowLeft class="mr-2 h-4 w-4" />
                        Back
                    </Link>
                </Button>
            </div>

            <!-- Form -->
            <form @submit.prevent="submit">
                <div class="grid gap-6">
                    <!-- Basic Information -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Basic Information</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div class="grid gap-4 md:grid-cols-2">
                                <div class="grid gap-2">
                                    <Label for="country">Country *</Label>
                                    <Input
                                        id="country"
                                        v-model="form.country"
                                        required
                                        placeholder="Country Name"
                                    />
                                    <p v-if="form.errors.country" class="text-sm text-destructive">
                                        {{ form.errors.country }}
                                    </p>
                                </div>

                                <div class="grid gap-2">
                                    <Label for="country_code">Country Code</Label>
                                    <Input
                                        id="country_code"
                                        v-model="form.country_code"
                                        maxlength="3"
                                        placeholder="e.g., USA, UK, UAE"
                                    />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="visa_type">Visa Type</Label>
                                    <Input
                                        id="visa_type"
                                        v-model="form.visa_type"
                                        placeholder="e.g., Tourist Visa, Business Visa"
                                    />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="slug">Slug</Label>
                                    <Input
                                        id="slug"
                                        v-model="form.slug"
                                        placeholder="country-slug (auto-generated if empty)"
                                    />
                                    <p v-if="form.errors.slug" class="text-sm text-destructive">
                                        {{ form.errors.slug }}
                                    </p>
                                </div>

                                <div class="grid gap-2">
                                    <Label for="processing_time">Processing Time</Label>
                                    <Input
                                        id="processing_time"
                                        v-model="form.processing_time"
                                        placeholder="e.g., 5-7 business days"
                                    />
                                </div>
                            </div>

                            <div class="grid gap-2">
                                <Label for="description">Description</Label>
                                <textarea
                                    id="description"
                                    v-model="form.description"
                                    rows="4"
                                    class="min-h-[80px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs"
                                    placeholder="Brief description about the visa requirement"
                                />
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Required Documents -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Required Documents *</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div class="space-y-2">
                                <div
                                    v-for="(doc, index) in requiredDocuments"
                                    :key="index"
                                    class="flex gap-2"
                                >
                                    <Input
                                        v-model="requiredDocuments[index]"
                                        placeholder="Document name (e.g., Passport, Photo, etc.)"
                                        required
                                    />
                                    <Button
                                        v-if="requiredDocuments.length > 1"
                                        type="button"
                                        variant="outline"
                                        size="icon"
                                        @click="removeDocument(index)"
                                    >
                                        ×
                                    </Button>
                                </div>
                                <Button
                                    type="button"
                                    variant="outline"
                                    size="sm"
                                    @click="addDocument"
                                >
                                    + Add Document
                                </Button>
                            </div>
                            <p v-if="form.errors.required_documents" class="text-sm text-destructive">
                                {{ form.errors.required_documents }}
                            </p>
                        </CardContent>
                    </Card>

                    <!-- Application Guidelines -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Application Guidelines</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div class="grid gap-2">
                                <Label for="application_guidelines">Guidelines</Label>
                                <textarea
                                    id="application_guidelines"
                                    v-model="form.application_guidelines"
                                    rows="6"
                                    class="min-h-[120px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs"
                                    placeholder="Step-by-step application guidelines"
                                />
                            </div>

                            <div class="grid gap-2">
                                <Label for="eligibility_criteria">Eligibility Criteria</Label>
                                <textarea
                                    id="eligibility_criteria"
                                    v-model="form.eligibility_criteria"
                                    rows="4"
                                    class="min-h-[80px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs"
                                    placeholder="Eligibility requirements for the visa"
                                />
                            </div>

                            <div class="grid gap-2">
                                <Label for="important_notes">Important Notes</Label>
                                <textarea
                                    id="important_notes"
                                    v-model="form.important_notes"
                                    rows="4"
                                    class="min-h-[80px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs"
                                    placeholder="Important notes or warnings"
                                />
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Pricing -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Pricing</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div class="grid gap-4 md:grid-cols-2">
                                <div class="grid gap-2">
                                    <Label for="visa_fee">Visa Fee</Label>
                                    <Input
                                        id="visa_fee"
                                        v-model.number="form.visa_fee"
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        placeholder="0.00"
                                    />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="currency">Currency</Label>
                                    <Input
                                        id="currency"
                                        v-model="form.currency"
                                        maxlength="3"
                                        placeholder="BDT"
                                    />
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Status -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Status</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div class="flex items-center gap-2">
                                <Checkbox
                                    id="is_active"
                                    v-model:checked="form.is_active"
                                />
                                <Label for="is_active">Active</Label>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- SEO -->
                    <Card>
                        <CardHeader>
                            <CardTitle>SEO Settings</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div class="grid gap-2">
                                <Label for="meta_title">Meta Title</Label>
                                <Input
                                    id="meta_title"
                                    v-model="form.meta_title"
                                    placeholder="SEO meta title"
                                />
                            </div>

                            <div class="grid gap-2">
                                <Label for="meta_description">Meta Description</Label>
                                <textarea
                                    id="meta_description"
                                    v-model="form.meta_description"
                                    rows="3"
                                    class="min-h-[60px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs"
                                    placeholder="SEO meta description"
                                />
                            </div>

                            <div class="grid gap-2">
                                <Label for="meta_keywords">Meta Keywords</Label>
                                <Input
                                    id="meta_keywords"
                                    v-model="form.meta_keywords"
                                    placeholder="keyword1, keyword2, keyword3"
                                />
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-4">
                        <Button
                            type="button"
                            variant="outline"
                            as-child
                        >
                            <Link href="/cp/visas">Cancel</Link>
                        </Button>
                        <Button
                            type="submit"
                            :disabled="form.processing"
                        >
                            {{ form.processing ? 'Creating...' : 'Create Visa Requirement' }}
                        </Button>
                    </div>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

