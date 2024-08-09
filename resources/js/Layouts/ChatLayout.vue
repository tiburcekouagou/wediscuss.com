<template>
    <div>
        <!-- Navbar Gauche -->
        Chat Layout
        <pre>{{ onlineUsersObj }}</pre>
        <!-- Zone d'affichage des messages -->
    </div>
</template>

<script setup lang="ts">
// imports
import { User } from '@/types';
import { onBeforeUnmount, onMounted, ref } from 'vue';

// Données partagées

// Données réactives de gestion des conversations

// Utilisateurs connectés
const onlineUsersObj = ref<Record<string, User>>({})


/**
 * Fonction pour rejoindre le canal 'online' et récupérer les utilisateurs connectés
 */
function setupChannel() {
    window.Echo.join('online')
    .here((users: User[]) => {
        const usersObj = Object.fromEntries(users.map((user) => [user.id, user]))
        onlineUsersObj.value = usersObj;
    })
    .joining((user: User) => {
        onlineUsersObj.value[user.id] = user;
    })
    .leaving((user: User) => {
        delete onlineUsersObj.value[user.id]
    })
    .error((error: any) => {
        console.error('Echo error', error)
    })
}

/** Hook pour se connecter au canal */
onMounted(() => {
    setupChannel();
})

/** Nettoyer le composant avant le démontage du composant */
onBeforeUnmount(() => {
    window.Echo.leave('online')
})

</script>

<style scoped></style>