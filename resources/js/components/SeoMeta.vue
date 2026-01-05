<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { computed, onMounted, onUnmounted } from 'vue';

interface Props {
    title?: string;
    description?: string;
    keywords?: string;
    ogTitle?: string;
    ogDescription?: string;
    ogType?: string;
    ogUrl?: string;
    ogImage?: string;
    twitterCard?: string;
    canonical?: string;
    articlePublishedTime?: string;
    articleAuthor?: string;
    schema?: Record<string, any>;
    breadcrumbs?: Array<{ title: string; href?: string }>;
}

const props = withDefaults(defineProps<Props>(), {
    ogType: 'website',
    twitterCard: 'summary_large_image',
});

const siteName = 'Flyover BD';
const siteUrl = typeof window !== 'undefined' ? window.location.origin : 'https://flyoverbd.com';

const finalTitle = computed(() => props.title || `${siteName} - Visa & Tour Management`);
const finalDescription = computed(() => props.description || 'Professional visa assistance and tour management services in Bangladesh.');
const finalOgTitle = computed(() => props.ogTitle || finalTitle.value);
const finalOgDescription = computed(() => props.ogDescription || finalDescription.value);
const finalOgImage = computed(() => props.ogImage || `${siteUrl}/logo.png`);
const finalCanonical = computed(() => props.canonical || (typeof window !== 'undefined' ? window.location.href : siteUrl));

const breadcrumbSchema = computed(() => {
    if (!props.breadcrumbs || props.breadcrumbs.length === 0) {
        return null;
    }

    return {
        '@context': 'https://schema.org',
        '@type': 'BreadcrumbList',
        itemListElement: props.breadcrumbs.map((item, index) => ({
            '@type': 'ListItem',
            position: index + 1,
            name: item.title,
            item: item.href && item.href !== '#' ? `${siteUrl}${item.href}` : undefined,
        })),
    };
});

let schemaScript: HTMLScriptElement | null = null;
let breadcrumbScript: HTMLScriptElement | null = null;

onMounted(() => {
    if (props.schema) {
        schemaScript = document.createElement('script');
        schemaScript.type = 'application/ld+json';
        schemaScript.textContent = JSON.stringify(props.schema);
        schemaScript.id = 'seo-schema';
        document.head.appendChild(schemaScript);
    }

    if (breadcrumbSchema.value) {
        breadcrumbScript = document.createElement('script');
        breadcrumbScript.type = 'application/ld+json';
        breadcrumbScript.textContent = JSON.stringify(breadcrumbSchema.value);
        breadcrumbScript.id = 'seo-breadcrumb';
        document.head.appendChild(breadcrumbScript);
    }
});

onUnmounted(() => {
    if (schemaScript && schemaScript.parentNode) {
        schemaScript.parentNode.removeChild(schemaScript);
    }
    if (breadcrumbScript && breadcrumbScript.parentNode) {
        breadcrumbScript.parentNode.removeChild(breadcrumbScript);
    }
});
</script>

<template>
    <Head :title="finalTitle">
        <!-- Basic Meta Tags -->
        <meta name="description" :content="finalDescription" />
        <meta v-if="keywords" name="keywords" :content="keywords" />
        <meta name="robots" content="index, follow" />
        <link rel="canonical" :href="finalCanonical" />

        <!-- Open Graph / Facebook -->
        <meta property="og:type" :content="ogType" />
        <meta property="og:url" :content="ogUrl || finalCanonical" />
        <meta property="og:title" :content="finalOgTitle" />
        <meta property="og:description" :content="finalOgDescription" />
        <meta property="og:image" :content="finalOgImage" />
        <meta property="og:site_name" :content="siteName" />

        <!-- Twitter -->
        <meta name="twitter:card" :content="twitterCard" />
        <meta name="twitter:title" :content="finalOgTitle" />
        <meta name="twitter:description" :content="finalOgDescription" />
        <meta name="twitter:image" :content="finalOgImage" />

        <!-- Article specific meta -->
        <meta v-if="articlePublishedTime" property="article:published_time" :content="articlePublishedTime" />
        <meta v-if="articleAuthor" property="article:author" :content="articleAuthor" />
    </Head>
</template>

