<template>
    <div v-if="contact">
        <div class="flex justify-between">
            <div>
                Back
            </div>
            <div>
                <router-link class="px-4 py-2 rounded text-sm font-bold text-green-500 border border-green-500 mr-2" :to="{ name: 'ContactsEdit', params: { id: contact.contact_id }}">Edit</router-link>

                <a class="px-4 py-2 border border-red-500 rounded text-sm font-bold text-red-500" href="#">Delete</a>
            </div>
        </div>

        <div class="flex items-center pt-6">
            <UserCircle :name="contact.name" />

            <p class="pl-5 text-xl">{{ contact.name }}</p>
        </div>

        <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Contact</p>
        <p class="pt-2 text-blue-400">{{ contact.email }}</p>

        <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Company</p>
        <p class="pt-2 text-blue-400">{{ contact.company }}</p>

        <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Birthday</p>
        <p class="pt-2 text-blue-400">{{ contact.birthday }}</p>
    </div>
</template>

<script setup>
    import axios from 'axios';

    import { ref } from 'vue';
    import { useRoute } from 'vue-router';

    import UserCircle from '../components/UserCircle.vue';

    const route = useRoute();
    const contact = ref(null);

    (async () => {
        try {
            const { data } = await axios.get(`/contacts/${ route.params.id }`);

            contact.value = data.data;
        } catch(err) {

        }
    })();
</script>
