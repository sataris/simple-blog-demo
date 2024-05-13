# Simple Demo Blog

## Introduction

Simple Demo blog coded in PHP Core 8.2

## Installation & Setup

### Docker
1. Clone the repository:
2. Run `docker-compose up --build -d`
3. Access application on `localhost:8000`

### Nginx
1. Clone the repository
2. Setup Nginx and point the root to the /src/html folder
3. Run the migration 
   1. `php8.2 database/migration`
4. Access the application