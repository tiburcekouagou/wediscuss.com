<template>
    <div>
        <AuthenticatedLayout>
            <template #header>
                <h2>Dashboard</h2>
            </template>

            <p>Vous êtes connecté</p>
        </AuthenticatedLayout>
    </div>
</template>

<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>

<style scoped></style>