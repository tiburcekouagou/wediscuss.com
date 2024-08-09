<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
  href: string;
}>();
</script>

<template>
  <Link
    :href="href"
    class="block w-full px-4 py-2 text-start text-sm leading-5 dark: hover: dark:hover: focus:outline-none focus: dark:focus: transition duration-150 ease-in-out"
  >
    <slot />
  </Link>
</template>
