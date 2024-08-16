<template>
  <div>
    <Menu as="div" class="relative inline-block text-left">
      <MenuButton class="inline-flex w-full justify-center rounded-md px-4 py-2">
        <span class="sr-only">Ouvrir le menu contextuel</span>
        <!-- <Icon icon="heroicons: ellipsis-vertical-solid" /> -->
        <Icon icon="heroicons:ellipsis-vertical-solid" class="w-6 h-6" />
      </MenuButton>
      <Transition
        enter-active-class="transition duration-100 ease-out"
        enter-from-class="transform scale-95 opacity-0"
        enter-to-class="transform scale-100 opacity-100"
        leave-active-class="transition duration-75 ease-in"
        leave-from-class="transform scale-100 opacity-100"
        leave-to-class="transform scale-95 opacity-0"
      >
        <MenuItems
          as="ul"
          class="absolute right-0 mt-2 w-56 origin-top-right divide-y bg-surface-variant"
        >
          <MenuItem as="li" v-slot="{ active }" class="p-1">
            <button>
              <span
                @click="blockUser"
                class="flex p-2 text-sm items-center gap-2"
                v-if="!conversation.blocked_at"
              >
                <Icon icon="heroicons:lock-closed-solid" />
                Bloquer l'utilisateur
              </span>
              <span @click="unblockUser" class="flex p-2 text-sm items-center gap-2" v-else>
                <Icon icon="heroicons:locklock-open-solid" />
                Débloquer l'utilisateur
              </span>
            </button>
          </MenuItem>
          <MenuItem v-if="currentUser.is_admin" as="li" v-slot="{ active }" class="p-1">
            <button>
              <span class="flex p-2 text-sm items-center gap-2" v-if="conversation.is_admin">
                <Icon icon="heroicons:user-solid" />
                Retrograder en utilisateur
              </span>
              <span class="flex p-2 text-sm items-center gap-2" v-else>
                <Icon icon="heroicons:shield-check-solid" />
                Promouvoir en admin
              </span>
            </button>
          </MenuItem>
        </MenuItems>
      </Transition>
    </Menu>
  </div>
</template>

<script setup lang="ts">
import { Icon } from '@iconify/vue';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
import { Conversation } from '@/types';
import { usePage } from '@inertiajs/vue3';

const page = usePage();

const currentUser = page.props.auth.user;

const props = defineProps<{
  conversation: Conversation;
}>();

async function blockUser() {
  // si c'est un group, on ne fait rien
  if (props.conversation.is_group) return;

  const res = await window.axios.post(route('user.block', props.conversation.id));
  console.log(res);
}

async function unblockUser() {
  const res = await window.axios.post(route('user.unblock', props.conversation.id));
  console.log(res);
}
</script>

<style scoped></style>
