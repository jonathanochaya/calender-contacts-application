<template>
    <div>
        <div v-if="loading">Loading</div>

        <div v-else>
            <div v-if="contacts.length === 0">
                <p>No contacts yet. <router-link :to="{ name: 'ContactCreate' }">Get Started</router-link></p>
            </div>

            <div v-else v-for="{ data } in contacts">
                <router-link class="flex items-center border-b border-gray-400 p-4 hover:bg-gray-100" :to="{ name: 'ContactShow', params: { id: data.contact_id }}">
                    <UserCircle :name="data.name" />

                    <div class="pl-4">
                        <p class="text-blue-400 font-bold">{{ data.name }}</p>
                        <p class="text-gray-600">{{ data.company }}</p>
                    </div>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script setup>
    import axios from 'axios';
    import { ref } from 'vue';
    import UserCircle from '../components/UserCircle.vue';

    const loading = ref(true);
    const contacts = ref([]);

    (async () => {
        try {
            const response = await axios.get('/contacts');
            loading.value = false;

            contacts.value = response.data.data;
        } catch (err) {
            loading.value = false;

            alert("Unable to fetch contacts");
        }
    })();

</script>
