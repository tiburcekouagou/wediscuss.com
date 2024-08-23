<template>
  <div class="h-full flex-1 flex overflow-hidden">
    <!-- Sidebar -->
    <div
      class="transition-all duration-300 w-full sm:w-[220px] md:w-[320px] bg-surface text-on-surface flex flex-col overflow-hidden"
      :class="{ '-ml-[100%] sm:ml-0': selectedConversation }"
    >
      <!-- En-Tête fixe -->
      <div class="flex flex-col">
        <div class="flex items-center justify-between py-2 px-3 font-medium sticky top-0 z-10">
          Conversations
          <button title="Créer un groupe" class="text-icon hover:text-icon-hover">
            <Icon class="h-5 w-5" icon="heroicons:pencil-square" />
          </button>
        </div>
        <div class="p-3 border-b border-secondary sticky top-[3rem] z-10">
          <TextInput
            v-model="searchTerm"
            @input="setSearch(searchTerm)"
            class="w-full"
            placeholder="Rechercher un ami ou un groupe"
          />
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
      <slot />
      <!-- Item de conversation pour chaque conversation -->
    </div>
  </div>
</template>

<script setup lang="ts">
// imports
import TextInput from '@/Components/TextInput.vue';
import { usePage } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { Icon } from '@iconify/vue';
import ConversationItem from '@/Components/Chat/ConversationItem.vue';
import { useOnlineUsers } from '@/composables/useOnlineUsers';
import { useConversations } from '@/composables/useConversations';
// Données partagées
const page = usePage();
const {
  selectedConversation,
  filteredConversations,
  setConversations,
  setSelectedConversation,
  setSearch
} = useConversations();

onMounted(() => {
  setSelectedConversation(page.props.selectedConversation);
  setConversations(page.props.conversations);
});

const { isUserOnline } = useOnlineUsers();
const searchTerm = ref('');
</script>

<style scoped></style>
