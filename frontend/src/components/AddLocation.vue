<template>
    <div>
      <h3>Add Location</h3>
      <form @submit.prevent="addLocation">
        <div>
          <label>City:</label>
          <input v-model="city" type="text" required />
        </div>
        <div>
          <label>State:</label>
          <input v-model="state" type="text" required />
        </div>
        <button type="submit">Add Location</button>
        <p v-if="error">{{ error }}</p>
      </form>
    </div>
  </template>
  
  <script>
  import apiClient from '../axios';
  
  export default {
    data() {
      return {
        city: '',
        state: '',
        error: '',
      };
    },
    methods: {
      async addLocation() {
        try {
          await apiClient.post('/api/locations', {
            city: this.city,
            state: this.state,
          });
          this.$emit('locationAdded');
          this.city = '';
          this.state = '';
        } catch (err) {
          this.error = err.response.data.message || 'Error adding location.';
        }
      },
    },
  };
  </script>