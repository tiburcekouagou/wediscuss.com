<template>
  <div>
    <h2>{{ conversation.name }}</h2>
  </div>
</template>

<script setup lang="ts">
import { Conversation } from '@/types';

const props = defineProps<{
  conversation: Conversation;
}>();
</script>

<style scoped></style>
