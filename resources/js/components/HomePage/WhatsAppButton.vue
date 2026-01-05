<script setup lang="ts">
import { MessageCircle } from 'lucide-vue-next';
import { computed } from 'vue';

// WhatsApp number from TopBar: +880 1335-111370
// Remove spaces and + for WhatsApp URL
const whatsappNumber = '8801335111370';
const defaultMessage = 'Hello! I would like to know more about your services.';

const whatsappUrl = computed(() => {
    const encodedMessage = encodeURIComponent(defaultMessage);
    return `https://wa.me/${whatsappNumber}?text=${encodedMessage}`;
});
</script>

<template>
    <a
        :href="whatsappUrl"
        target="_blank"
        rel="noopener noreferrer"
        class="group fixed bottom-20 right-4 z-40 flex h-14 w-14 items-center justify-center rounded-full bg-[#25D366] shadow-lg transition-all duration-300 hover:scale-110 hover:shadow-xl active:scale-95 md:bottom-6 md:right-6 md:h-16 md:w-16"
        aria-label="Contact us on WhatsApp"
        style="padding-bottom: env(safe-area-inset-bottom);"
    >
        <MessageCircle class="h-7 w-7 text-white transition-transform group-hover:scale-110 md:h-8 md:w-8" />
        
        <!-- Pulse animation -->
        <span class="absolute inset-0 animate-ping rounded-full bg-[#25D366] opacity-20"></span>
        
        <!-- Tooltip on hover (desktop only) -->
        <div class="absolute right-full mr-3 hidden whitespace-nowrap rounded-lg bg-gray-900 px-3 py-2 text-sm font-semibold text-white opacity-0 shadow-lg transition-opacity group-hover:opacity-100 md:block">
            Chat with us on WhatsApp
            <div class="absolute left-full top-1/2 -ml-1 h-2 w-2 -translate-y-1/2 rotate-45 bg-gray-900"></div>
        </div>
    </a>
</template>

