<script setup lang="ts">
withDefaults(
  defineProps<{
    type?: 'button' | 'submit' | 'reset';
  }>(),
  {
    type: 'button'
  }
);
</script>

<template>
  <button
    :type="type"
    class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs dark: uppercase tracking-widest shadow-sm hover: dark:hover: focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
  >
    <slot />
  </button>
</template>
