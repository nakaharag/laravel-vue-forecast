<template>
    <div>
      <h3>Your Locations</h3>
      <div v-if="locations.length === 0">No locations added yet.</div>
      <div v-else>
        <div v-for="location in locations" :key="location.id">
          <h4>{{ location.city }}, {{ location.state }}</h4>
          <button @click="removeLocation(location.id)">Remove</button>
          <div v-for="forecast in location.forecasts" :key="forecast.id">
            <p>Date: {{ forecast.date }}</p>
            <p>Min Temp: {{ forecast.min_temp }}°C</p>
            <p>Max Temp: {{ forecast.max_temp }}°C</p>
            <p>Condition: {{ forecast.condition }}</p>
            <img :src="getIconUrl(forecast.icon)" alt="Weather Icon" />
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import apiClient from '../axios';
  
  export default {
    data() {
      return {
        locations: [],
      };
    },
    created() {
      this.fetchLocations();
    },
    methods: {
      async fetchLocations() {
        try {
          const response = await apiClient.get('/api/locations');
          this.locations = response.data;
        } catch (err) {
          console.error(err);
        }
      },
      async removeLocation(id) {
        try {
          await apiClient.delete(`/api/locations/${id}`);
          this.fetchLocations();
        } catch (err) {
          console.error(err);
        }
      },
      getIconUrl(icon) {
        return `http://openweathermap.org/img/wn/${icon}@2x.png`;
      },
    },
  };
  </script>