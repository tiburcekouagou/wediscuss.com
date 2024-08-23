<template>
  <div v-if="selectedConversation" class="p-3 flex justify-center items-center border-b">
    <div class="flex items-center gap-3">
      <Link :href="route('dashboard')" class="inline-block sm:hidden">
        <Icon icon="heroicons:arrow-left-circle" class="w-6 h-6" />
      </Link>

      <UserAvatar
        :avatar="selectedConversation.avatar"
        :name="selectedConversation.name"
        :isOnline="false"
        v-if="selectedConversation.is_user"
      />
      <GroupAvatar v-if="selectedConversation.is_group" />

      <div>
        <h3>{{ selectedConversation.name }}</h3>
        <p v-if="selectedConversation.is_group">{{ selectedConversation.users?.length }} membres</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Icon } from '@iconify/vue';
import { Link } from '@inertiajs/vue3';
import { Conversation } from '@/types';
import UserAvatar from './UserAvatar.vue';
import GroupAvatar from './GroupAvatar.vue';

const props = defineProps<{
  selectedConversation: Conversation;
}>();
</script>

<style scoped></style>
