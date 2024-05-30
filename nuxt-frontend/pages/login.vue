<template>
  <div>
    <h1>Login</h1>
    <input v-model="username" placeholder="Enter your username" />
    <button @click="login">Login</button>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const username = ref('');
const router = useRouter();
const config = useRuntimeConfig();

const login = async () => {
  try {
    const response = await $fetch(`${config.public.apiBase}/login`, {
      method: 'POST',
      body: { username: username.value },
    });

    if (response.user) {
      localStorage.setItem('user', JSON.stringify(response.user));
      router.push('/');
    } else {
      console.error('Login failed: User data missing in response');
    }
  } catch (error) {
    console.error('Login failed', error);
  }
};
</script>
