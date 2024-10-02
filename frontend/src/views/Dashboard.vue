<template>
    <div>
      <h2>Welcome to the Dashboard</h2>
      <button @click="logout">Logout</button>
      <AddLocation @locationAdded="handleLocationAdded" />
      <LocationList ref="locationList" />
    </div>
  </template>
  
  <script>
  import apiClient from '../axios';
  import AddLocation from '../components/AddLocation.vue';
  import LocationList from '../components/LocationList.vue';
  
  export default {
    name: 'Dashboard',
    components: {
      AddLocation,
      LocationList,
    },
    methods: {
      async logout() {
        try {
          await apiClient.post('/logout');
          localStorage.removeItem('authToken');
          this.$router.push({ name: 'Login' });
        } catch (err) {
          console.error(err);
        }
      },
      handleLocationAdded() {
        this.$refs.locationList.fetchLocations();
      },
    },
  };
  </script>