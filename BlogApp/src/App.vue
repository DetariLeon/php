<script setup>
import { ref } from 'vue'
import axios from 'axios';

const posts = ref([]);
const authors = ref({});
const expandedPostId = ref(null);

const fetchPosts = async () => {
  try {
    const response = await axios.get('https://jsonplaceholder.typicode.com/posts');
    posts.value = response.data.map(post => ({
      ...post,
      title: firstLetterCapital(post.title)
    }));

    const authorsPromise = axios.get('https://jsonplaceholder.typicode.com/users');
    const authorsResponse = await authorsPromise;

    const authorsMap = authorsResponse.data.reduce((map, author) => {
      map[author.id] = author.name;
      return map;
    }, {});

    authors.value = authorsMap;
  } catch (error) {
    console.log(error);
  }
};

const firstLetterCapital = (str) => {
  return str.charAt(0).toUpperCase() + str.slice(1);
}

const toggleExpand = (postId) => {
  expandedPostId.value = expandedPostId.value === postId ? null : postId;
};

const toggleAuthorExpand = (authorId) => {
  expandedPostId.value = authors.value[authorId] ? authorId : null;
};

fetchPosts();

</script>

<template>
  <h1>Bejegyzések</h1>
  <div v-for="post in posts" :key="post.id">
    <p class="post">{{ post.title }}</p>
    <p v-if="expandedPostId === post.id">
      <strong>{{ post.body.substring(0, 100) }}</strong>
      <img :src="`https://placehold.co/200x300?text=${post.id}`" alt="Random image">
      <strong>{{ post.body.substring(100) }}</strong>
    </p>
    <p v-else>{{ post.body.substring(0, 100) + '...' }}</p>
    <a @click.prevent="toggleExpand(post.id)">
      {{ expandedPostId === post.id ? 'Kevesebb' : 'Tovább' }}
    </a>
    <p style="text-align: right; font-size: 0.8em">
      <a @click.prevent="toggleAuthorExpand(post.userId)">
        {{ authors[post.userId] }}
      </a>
    </p>
    <hr>
  </div>
</template>

<style scoped>
h1, .post {
  text-align: center;
  color: rgb(33, 136, 33);
  font-weight: bold;
}

a {
  color: blue;
  cursor: pointer;
  text-decoration: underline;
}
</style>

