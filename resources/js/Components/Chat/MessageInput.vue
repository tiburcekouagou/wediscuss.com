<template>
    <div class="flex flex-wrap items-center py-3 border-t">
        <!-- 1ere div -->
        <div class="flex-1 xs:flex-none">
            <button class="p-1 relative">
                <Icon class="w-6 h-6" icon="heroicons:paper-clip-solid" />
                <input type="file" multiple class="flex flex-1 absolute z-10 top-0 left-0 w-full h-full opacity-0 cursor-pointer">
            </button>
            <button class="p-1 relative">
                <Icon class="w-6 h-6" icon="heroicons:photo-solid" />
                <input type="file" multiple accept="image/*" class="flex flex-1 absolute z-10 top-0 left-0 w-full h-full opacity-0 cursor-pointer">
            </button>
        </div>

        <div class="px-3 xs:p-0 min-w-[220px] basis-full xs:basis-0 flex-1">
            <div class="flex items-end gap-1 xs:gap-2 md:gap-4">
                <NewMessageInput v-model="messageInput" />
                <button v-if="messageInput" class="btn btn-info text-white rounded-full aspect-square">
                    <span class="sr-only">Envoyer</span>
                    <Icon class="w-6 h-6" icon="heroicons:paper-airplane-solid" />
                </button>
            </div>
        </div>
        
        <!-- 2eme div -->
        <div class="">
            <button class="">
                <Icon class="w-6 h-6" icon="heroicons:face-smile-solid" />
            </button>
        </div>

    </div>
</template>

<script setup lang="ts">
import { Icon } from '@iconify/vue';
import NewMessageInput from './NewMessageInput.vue';
import { ref } from 'vue';

const messageInput = ref("")
</script>

<style scoped></style>