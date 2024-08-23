<template>
  <ChatLayout>
    <div v-if="!messages" class="flex flex-col gap-8 justify-center items-center h-full opacity-35">
      <p class="text-2xl md:text-4xl p-16 text-on-surface">
        Sélectionnez svp une conversation pour afficher les messages
      </p>
      <Icon icon="heroicons:chat-bubble-left-right-solid" class="w-32 h-32" />
    </div>
    <!-- <div v-else class="flex flex-col scrollbar-thin h-full">
      <ConversationHeader v-if="selectedConversation" :selected-conversation="selectedConversation" />

      <div class="h-full flex-1 flex flex-col flex-end p-5 pb-0 max-w-7xl mx-auto">
          <div class="flex-1 flex justify-center h-full  overflow-y-auto scrollbar-thin">
            <p class="text-lg" v-if="!messages.length">Pas de messages trouvé !</p>
            <div v-else class="h-full flex-1 flex flex-col">
              <MessageItem
              v-for="message in messages"
              :key="message.id"
              :message="message"
              :selected-conversation="selectedConversation"
               />
            </div>
          </div>   
        <MessageInput />
      </div>
    </div> -->
    <div class="h-full flex flex-col  max-w-7xl mx-auto" v-else>
      <ConversationHeader v-if="selectedConversation" :selected-conversation="selectedConversation" />
      <div class="flex-1 overflow-y-auto scrollbar-thin px-5">
        <p class="text-lg" v-if="!messages.length">Pas de messages trouvé !</p>
        <div v-else class="flex-1 flex flex-col justify-end">
          <MessageItem v-for="message in messages" :key="message.id" :message="message"
            :selected-conversation="selectedConversation" />
        </div>
      </div>
      <MessageInput />
    </div>
  </ChatLayout>
</template>

<script setup lang="ts">
import { Icon } from '@iconify/vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ChatLayout from '@/Layouts/ChatLayout.vue';
import { usePage } from '@inertiajs/vue3';
import ConversationHeader from '@/Components/Chat/ConversationHeader.vue';
import MessageInput from '@/Components/Chat/MessageInput.vue';
import MessageItem from '@/Components/Chat/MessageItem.vue';

defineOptions({ layout: AuthenticatedLayout });

const page = usePage();

const selectedConversation = page.props.selectedConversation;
const messagesData = page.props.messages;
const messages = messagesData?.data
</script>

<style scoped></style>
