<template>
    <ContactsList :message="message" endpoint="api/contacts" />
</template>

<script setup>
    import { computed } from 'vue';
    import ContactsList from '../components/ContactsList.vue';

    const message = computed(() => {
        return "No contacts yet. Get started!";
    });
</script>
