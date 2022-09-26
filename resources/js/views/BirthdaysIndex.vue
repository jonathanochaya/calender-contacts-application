<template>
    <ContactsList :message="message" endpoint="api/birthdays" />
</template>

<script setup>
    import { computed } from 'vue';
    import ContactsList from '../components/ContactsList.vue';

    const message = computed(() => {
        return "No upcoming birthdays!";
    });
</script>
