<template>
    <textarea
    v-model="model"
    ref="messageInput"
    @keydown="onInputKeyDown"
    @input="onChangeEvent"
    rows="1"
    class="input input-bordered w-full text-gray-800 rounded-md resize-none overflow-y-auto max-h-40"
    placeholder="Taper un message"
    ></textarea>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const model = defineModel<string>()

const messageInput = ref<HTMLTextAreaElement|null>(null)

function onInputKeyDown(ev: KeyboardEvent) {
    if (ev.key === "Entrer" && !ev.shiftKey) {
        ev.preventDefault()
        sendMessage()
    }
}
function onChangeEvent(ev: Event) {
    setTimeout(() => {
        ajustHeight()
    }, 10)
}

function ajustHeight() {
    setTimeout(() => {
        if (messageInput.value) {
            messageInput.value.style.height = "auto";
            messageInput.value.style.height = (messageInput.value.scrollHeight + 1) + "px";
        }
    }, 100)
}
function sendMessage() {}
</script>

<style scoped></style>