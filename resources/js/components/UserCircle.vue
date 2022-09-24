<template>
    <div class="rounded-full border border-gray-400 text-sm text-white bg-blue-400 w-10 h-10 flex items-center justify-center">
        {{ userCircle }}
    </div>
</template>

<script setup>
    import { computed } from 'vue';

    const props = defineProps({
        name: String
    });

    const userCircle = computed(() => {
        return props.name.match(/[A-Z]/g).slice(0, 2).join('');
    });
</script>
