<template>
     <div class="relative pb-4">
        <label :for="name" class="text-blue-500 uppercase text-xs font-bold absolute pt-2">{{ label }}</label>
        <input @input="handleInput" class="focus:outline-none focus:border-blue-400 pt-8 w-full border-b pb-2" :placeholder="placeholder" type="text" :id="name">

        <p v-if="errors && errors[name]" class="text-red-600 text-sm">{{ errorMessage }}</p>
    </div>
</template>

<script setup>

    import { computed } from 'vue';

    const props = defineProps({
        name: String,
        label: String,
        placeholder: String,
        errors: Object
    });

    const errorMessage = computed(() => {
        return props.errors[props.name][0];
    });

    const emit = defineEmits(['update:field']);

    const handleInput = (event) => {
        emit('update:field', event.target.value);
    }

</script>
