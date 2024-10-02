<template>
  <div>
    <h2>Login</h2>
    <form @submit.prevent="login">
      <div>
        <label>Email:</label>
        <input v-model="email" type="email" required />
      </div>
      <div>
        <label>Password:</label>
        <input v-model="password" type="password" required />
      </div>
      <button type="submit">Login</button>
      <p v-if="error">{{ error }}</p>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Login',
  data() {
    return {
      email: '',
      password: '',
      error: '',
    };
  },
  methods: {
  async login() {
    try {
      // await axios.get('/sanctum/csrf-cookie');
      
      await axios.post('http://localhost:8000/login', {
        email: this.email,
        password: this.password,
      });

      console.log(this.email, this.password)
      this.$router.push({ name: 'Dashboard' });
    } catch (error) {
      console.error(error);
    }
  }
}
};
</script>