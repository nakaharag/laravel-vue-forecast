# Laravel Vue Forecast APP

This README file provides step-by-step instructions to set up and run a Dockerized development environment containing:

- Frontend: Vue.js 3 application running on Node.js 22 with hot-reload enabled.
- Backend: Laravel 11 application running on PHP 8.3 with Xdebug configured for debugging.
- Database: MySQL 8.2.

## Prerequisites

Ensure you have the following installed on your machine:

- Git: For cloning the repository.
- Docker: To run and manage containers.
    - Docker version 27.2.0
- Docker Compose: For orchestrating multi-container applications.
    - Docker Compose version v2.29.2-desktop.2

## Folder Structure

The project directory should have the following structure:

- backend/: Contains the Laravel application and its Dockerfile.
- frontend/: Contains the Vue.js application and its Dockerfile.
- db_data/: Docker volume for MySQL data persistence.
- docker-compose.yml: Docker Compose configuration file.

## Setup Instructions

1. Clone the project repository to your local machine. If you haven’t already created a repository, you can create a new directory:

2. Configure Environment Variables

    a. Backend .env file

In the backend directory, update the .env file with the following database configuration:

```
DB_CONNECTION=mysql
DB_HOST=database
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_password
```

b. Frontend vite.config.js

In the frontend directory, create or update vite.config.js with the following content:

```
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [vue()],
  server: {
    host: '0.0.0.0', // Listen on all interfaces
    port: 8080,      // Use port 8080
    strictPort: true,
    hmr: {
      host: 'localhost',
      port: 8080,
    },
  },
})
```

3. Build and Run Docker Containers

    a. Build and Start the Containers `docker compose up --build`

    b. Verify the Containers Are running `docker compose ps`

You should see all three services (backend, frontend, database) running.

4. Run Artisan Commands:

`docker compose exec backend php artisan migrate`

`docker compose exec backend php artisan cache:clear`

5. Permission Issues

If you encounter permission issues:

- Set Correct Permissions on Host Machine:

```
sudo chown -R $(whoami):$(whoami) backend frontend
sudo chmod -R 755 backend frontend
```

## Accessing the Applications

- Laravel Backend Application: <http://localhost:8000>
- Vue.js Frontend Application: <http://localhost:8080>
