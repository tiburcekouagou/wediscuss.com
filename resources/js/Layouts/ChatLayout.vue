<template>
  <div class="flex-1 flex overflow-hidden">
    <!-- Sidebar -->
    <div
      class="transition-all w-full sm:w-[220px] md:w-[320px] bg-accent flex flex-col overflow-hidden"
    >
      <!-- En-Tête fixe -->
      <div class="flex flex-col">
        <div class="flex items-center justify-between py-2 px-3 font-medium sticky top-0 z-10">
          Conversations
          <button title="Créer un groupe" class="text-icon hover:text-icon-hover">
            <Icon class="h-5 w-5" icon="heroicons:pencil-square" />
          </button>
        </div>
        <div class="p-3 border-b border-border sticky top-[3rem] z-10">
          <TextInput v-model="search" class="w-full" />
        </div>
      </div>
      <!-- Liste des conversations -->
      <div
        class="flex-1 scrollbar-thin scrollbar-thumb-slate-700 scrollbar-track-slate-300 overflow-y-auto px-3 h-full"
      >
        <ConversationItem
          v-for="conversation in filteredConversations"
          :key="conversation.is_group ? `group_${conversation.id}` : `user_${conversation.id}`"
          :conversation="conversation"
          :isOnline="isUserOnline(conversation.id.toString())"
        />
      </div>
    </div>
    <!-- Zone d'affichage des messages -->
    <div class="flex-1 flex flex-col overflow-hidden">
      Messages
      <!-- Item de conversation pour chaque conversation -->
    </div>
  </div>
</template>

<script setup lang="ts">
// imports
import TextInput from '@/Components/TextInput.vue';
import { Conversation, User } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import { Icon } from '@iconify/vue';
import ConversationItem from '@/Components/Chat/ConversationItem.vue';
// Données partagées
const page = usePage();

// Données réactives de gestion des conversations
const conversations = ref<Conversation[]>(page.props.conversations);
const localConversations = computed<Conversation[]>(() => conversations.value);
const search = ref<string>('');

const sortedConversations = computed<Conversation[]>(() => {
  return localConversations.value.sort((a, b) => {
    // on recherche les personnes bloquées d'abord
    if (a.blocked_at && b.blocked_at) {
      return a.blocked_at > b.blocked_at ? 1 : -1;
    } else if (a.blocked_at) {
      return 1;
    } else if (b.blocked_at) {
      return -1;
    }

    // on recherche en fonction de la date du message
    if (a.last_message_date && b.last_message_date) {
      return b.last_message_date.localeCompare(a.last_message_date);
    } else if (a.last_message_date) {
      return -1;
    } else if (b.last_message_date) {
      return 1;
    } else {
      return 0;
    }
  });
});

const filteredConversations = computed<Conversation[]>(() => {
  return sortedConversations.value.filter((conversation) => {
    const searchTerm = search.value.toLocaleLowerCase();
    return (
      conversation.name.toLowerCase().includes(searchTerm) ||
      conversation.email?.toLowerCase().includes(searchTerm)
    );
  });
});
// Utilisateurs connectés
const onlineUsersObj = ref<Record<string, User>>({});

/** Fonction qui détermine si un user est actuellement connecté */
function isUserOnline(id: string): boolean {
  return onlineUsersObj.value[id] ? true : false;
}

/**
 * Fonction pour rejoindre le canal 'online' et récupérer les utilisateurs connectés
 */
function setupChannel() {
  window.Echo.join('online')
    .here((users: User[]) => {
      const usersObj = Object.fromEntries(users.map((user) => [user.id, user]));
      onlineUsersObj.value = usersObj;
    })
    .joining((user: User) => {
      onlineUsersObj.value[user.id] = user;
    })
    .leaving((user: User) => {
      delete onlineUsersObj.value[user.id];
    })
    .error((error: any) => {
      console.error('Echo error', error);
    });
}

/** Hook pour se connecter au canal */
onMounted(() => {
  setupChannel();
});

/** Nettoyer le composant avant le démontage du composant */
onBeforeUnmount(() => {
  window.Echo.leave('online');
});
</script>

<style scoped></style>
