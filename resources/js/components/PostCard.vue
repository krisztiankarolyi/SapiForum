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
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-center">
                    <img style="float: left" :src="post.img_ref" class="logo" alt="Post Image">
                    {{ post.title }}
                </h5>
                <h6 class="text-center">Category: {{ post.category }}</h6>
                <p class="card-text">{{ post.content }}</p>
            </div>
            <div class="card-footer">
                <small class="text-muted">
                    {{ post.comments_count }}
                    {{ post.comments_count === 1 ? 'comment' : 'comments' }}
                </small>
                <div style="display: flex; flex-direction: row; align-items: center; justify-content: space-between ">
                    <a href="#">Edit</a>
                    <a href="#" class="text-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Your scoped styles */
</style>
