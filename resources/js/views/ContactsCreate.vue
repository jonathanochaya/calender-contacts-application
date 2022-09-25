<template>
    <div>
        <form @submit.prevent="createContact">
            <InputField name="name" label="Contact Name" placeholder="Contact Name" :errors="errors" type="text" :fields="fields" @update:field="value => fields.name = value" />

            <InputField name="email" label="Contact Email" placeholder="Contact Email" :errors="errors" type="text" :fields="fields" @update:field="value => fields.email = value" />

            <InputField name="company" label="Company" placeholder="Company" :errors="errors" type="text" :fields="fields" @update:field="value => fields.company = value" />

            <InputField name="birthday" label="Birthday" placeholder="Birthday" :errors="errors" type="text" :fields="fields" @update:field="value => fields.birthday = value" />

            <div class="flex justify-end">
                <button @click="router.back()" class="py-2 px-4 rounded text-red-700 border mr-5 hover:border-red-700">Cancel</button>
                <button class="bg-blue-500 py-2 px-4 rounded text-white hover:bg-blue-400">Add New Contact</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router';
import { ref } from 'vue';
import InputField from '../components/InputField.vue';

const fields = ref({
    name: '',
    email: '',
    company: '',
    birthday: ''
});

const errors = ref(null);
const router = useRouter();

const createContact = async () => {
    try {
        const { data } = await axios.post('/contacts', fields.value);

        router.push({ name: 'ContactShow', params: { id: data.data.contact_id }});
    } catch (err) {
        errors.value = err.response.data.errors;
    }
}

</script>
