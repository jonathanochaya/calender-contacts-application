<template>
    <div v-if="loading">Loading...</div>
    <div v-if="contact">
        <div class="flex justify-between">
            <div>
                Back
            </div>
            <div class="relative">
                <router-link class="px-4 py-2 rounded text-sm font-bold text-green-500 border border-green-500 mr-2" :to="{ name: 'ContactEdit', params: { id: contact.contact_id }}">Edit</router-link>

                <a @click="modal = !modal" class="px-4 py-2 border border-red-500 rounded text-sm font-bold text-red-500" href="#">Delete</a>

                <div v-if="modal" class="right-0 mt-2 absolute bg-blue-900 rounded-lg z-20 text-white p-8 w-64">
                    <p>Are you sure you want to delete this record?</p>

                    <div class="flex items-center mt-6 justify-end">
                        <button class="text-white pr-4" @click="modal = !modal">Cancel</button>
                        <button @click="destroy" class="px-4 py-2 bg-red-500 rounded text-sm font-bold text-white">Delete</button>
                    </div>
                </div>
            </div>

            <div @click="modal = !modal" class="bg-black opacity-25 absolute right-0 left-0 top-0 bottom-0 z-10" v-if="modal"></div>
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
    import { useRoute, useRouter } from 'vue-router';

    import UserCircle from '../components/UserCircle.vue';

    const route = useRoute();
    const router = useRouter();

    const contact = ref(null);
    const loading = ref(false);
    const modal = ref(false);

    (async () => {
        try {
            loading.value = true;
            const { data } = await axios.get(`/contacts/${ route.params.id }`);

            loading.value = false;
            contact.value = data.data;
        } catch(err) {
            loading.value = false;
        }
    })();

    const destroy = async () => {
        try {
            const reply = await axios.delete(`/contacts/${ contact.value.contact_id }`);

            if(reply.status === 204) router.push({ name: 'ContactsList'});
        } catch (err) {
            alert('Internal Error. Unable to delete contact');
        }
    }
</script>
