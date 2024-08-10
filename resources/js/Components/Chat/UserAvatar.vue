<template>
  <div>
    <div class="avatar" v-if="avatar" :class="onlineClass">
      <div class="rounded-full">
        <img :src="avatar" :alt="`Photo de profil de ${name}`" />
      </div>
    </div>
    <div class="avatar placeholder" :class="onlineClass" v-else>
      <div class="bg-neutral text-neutral-content w-10 rounded-full">
        <span class="text-lg">
          {{ formatUserName(name) }}
        </span>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps<{
  avatar?: string;
  name: string;
  isOnline: boolean;
}>();

function formatUserName(name: string): string {
  // utiliser une expression régulière pour trouver les premières lettres
  const initials = name.match(/\b\w/g) || [];
  return initials.join('').toUpperCase();
}

const onlineClass = computed<string>(() => (props.isOnline ? 'online' : ''));
</script>

<style scoped></style>
