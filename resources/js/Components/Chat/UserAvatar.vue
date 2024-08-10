<template>
    <div>
        <div class="avatar" v-if="avatar">
            <div class="rounded-full">
                <img :src="avatar" :alt="`Photo de profil de ${name}`">
            </div>
        </div>
        <div class="avatar placeholder"  v-else>
            <div class="bg-neutral text-neutral-content w-10 rounded-full">
                <span class="text-lg">
                    {{formatUserName(name)}}
                </span>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
const props = defineProps<{
    avatar?: string;
    name: string;
}>()

function formatUserName(name: string): string {
    // utiliser une expression régulière pour trouver les premières lettres
    const initials = name.match(/\b\w/g) || [];
    return initials.join('').toUpperCase();
}
</script>

<style scoped></style>