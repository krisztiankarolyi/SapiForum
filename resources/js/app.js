

import './bootstrap';
import { createApp } from 'vue';


const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue'
import axios from 'axios';
import PostCard from './components/PostCard.vue';


app.component('example-component', ExampleComponent);
app.component('post-card', PostCard)

app.mount('#app');
