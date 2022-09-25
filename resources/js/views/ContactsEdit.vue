<template>
    <div v-if="loading">
        Loading...
    </div>
    <div v-if="!loading && fields">
        <div class="text-blue-400 cursor-pointer" @click="router.back()">
            &lt; Back
        </div>

        <form @submit.prevent="updateContact">
            <InputField name="name" label="Contact Name" placeholder="Contact Name" :errors="errors" type="text" :fields="fields" @update:field="value => fields.name = value" />

            <InputField name="email" label="Contact Email" placeholder="Contact Email" :errors="errors" type="text" :fields="fields" @update:field="value => fields.email = value" />

            <InputField name="company" label="Company" placeholder="Company" :errors="errors" type="text" :fields="fields" @update:field="value => fields.company = value" />

            <InputField name="birthday" label="Birthday" placeholder="Birthday" :errors="errors" type="text" :fields="fields" @update:field="value => fields.birthday = value" />

            <div class="flex justify-end">
                <button class="py-2 px-4 rounded text-red-700 border mr-5 hover:border-red-700">Cancel</button>
                <button class="bg-blue-500 py-2 px-4 rounded text-white hover:bg-blue-400">Save</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { useRouter, useRoute } from 'vue-router';
import { ref } from 'vue';
import InputField from '../components/InputField.vue';

const fields = ref({});

const errors = ref(null);
const loading = ref(false);

const route = useRoute();
const router = useRouter();

(async () => {
    try {
        loading.value = true;
        const { data } = await axios.get(`/contacts/${ route.params.id }`);

        loading.value = false;
        fields.value = data.data;
    } catch(err) {
        loading.value = false;
    }
})();

const updateContact = async () => {
    try {
        const { data } = await axios.patch(`/contacts/${ fields.value.contact_id }`, fields.value);

        router.push({ name: 'ContactShow', params: { id: fields.value.contact_id }});
    } catch (err) {
        errors.value = err.response.data.errors;
    }
}

</script>
