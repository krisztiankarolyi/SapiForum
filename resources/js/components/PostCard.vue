<!-- PostCard.vue -->
<script setup>
import { ref, onMounted, defineProps } from 'vue';

// Define props for the component
const { post } = defineProps(['post']);

// Define a reactive variable for the post
const postRef = ref(post);

// Use the onMounted hook to log the received data
onMounted(() => {
    console.log('PostCard received data:', JSON.stringify(postRef.value, null, 2));
});
</script>

<template>
    <p>CARD</p>
</template>

<style scoped>
/* Your scoped styles */
</style>
