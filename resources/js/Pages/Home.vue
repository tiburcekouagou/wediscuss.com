<template>
  <ChatLayout>
    <div class="flex flex-col gap-8 justify-center items-center h-full opacity-35">
      <p class="text-2xl md:text-4xl p-16 text-on-surface">
        Sélectionnez svp une conversation pour afficher les messages
      </p>
      <Icon icon="heroicons:chat-bubble-left-right-solid" class="w-32 h-32" />
    </div>
  </ChatLayout>
</template>

<script setup lang="ts">
import {Icon} from "@iconify/vue"
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ChatLayout from '@/Layouts/ChatLayout.vue';

defineOptions({ layout: AuthenticatedLayout });
</script>

<style scoped></style>
