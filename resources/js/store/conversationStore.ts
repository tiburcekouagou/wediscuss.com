import { Conversation } from "@/types";
import { defineStore } from "pinia";
import { computed, ref } from "vue";

export const useConversationStore = defineStore('conversationStore', () => {
    // state
    const selectedConversation = ref<Conversation>();
    const conversations = ref<Conversation[]>([]);
    const localConversations = computed<Conversation[]>(() => conversations.value);
    const search = ref<string>('');
    
    // actions
    function setConversations(newConversations: Conversation[]) {
        conversations.value = newConversations;
      }
    
      function setSelectedConversation(conversation: Conversation | undefined) {
        selectedConversation.value = conversation;
      }
    
      function setSearch(value: string) {
        search.value = value;
      }
    
    // getters

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

      return {
        selectedConversation,
        conversations,
        search,
        filteredConversations,
        setConversations,
        setSelectedConversation,
        setSearch
      };
})