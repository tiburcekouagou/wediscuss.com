<script setup lang="ts">
import { useToggle } from '@vueuse/shared';
import { isDark } from '@/composables/dark';
import { Icon } from '@iconify/vue';

// const isDark = useDark()
const toggleDark = useToggle(isDark);
</script>

<template>
  <button @click="toggleDark()" class="flex items-center">
    <Icon v-if="isDark" icon="carbon:moon" />
    <Icon v-if="!isDark" icon="carbon:sun" />

    <span class="ml-2">
      {{ isDark ? 'Dark' : 'Light' }}
    </span>
  </button>
</template>
