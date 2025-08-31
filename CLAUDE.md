# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a PHP-based recipe management application built with Docker. The application allows users to create and manage cooking recipes with details like category, difficulty, budget, and instructions.

## Architecture

### Directory Structure
- `src/app/` - Core PHP application files
  - `index.php` - Main homepage with recipe creation form
  - `receive.php` - Form data processing endpoint
  - `func.php` - PHP utility functions and examples
- `src/templates/` - HTML templates
  - `form.html` - Standalone recipe creation form
- `data/` - Database data volume mount point (empty directory for MySQL persistence)

### Technology Stack
- **Backend**: PHP 8.3 with Apache
- **Database**: MySQL 5.7
- **Containerization**: Docker with docker-compose
- **Frontend**: Plain HTML forms with basic styling

## Development Commands

### Starting the Application
```bash
docker-compose up -d
```

### Stopping the Application  
```bash
docker-compose down
```

### Checking Container Status
```bash
docker-compose ps
```

### Rebuilding After Code Changes
```bash
docker-compose up -d --build
```

## Application Access

- **Main Application**: http://localhost:8080
- **Recipe Form**: http://localhost:8080/templates/form.html
- **Database**: MySQL accessible on port 3306
  - Username: `user`
  - Password: `password` 
  - Database: `example_db`

## Form Data Flow

1. Users fill out recipe forms in `index.php` or `form.html`
2. Form data is submitted via POST to `receive.php`
3. `receive.php` processes and displays the submitted recipe data
4. Both forms target the same processing endpoint but have slightly different field names:
   - `index.php` uses `recipe-name`
   - `form.html` uses `recipe_name`

## Docker Configuration

The application runs in two containers:
- **web**: PHP 8.3 with Apache, maps `src/` to `/var/www/html/`
- **db**: MySQL 5.7 with persistent data storage in `db_data` volume

Port mappings:
- 8080:80 (web server)
- 3306:3306 (database)

## Database Setup

Database credentials are configured in docker-compose.yml:
- Root password: `example`
- Database: `example_db`
- User: `user` 
- Password: `password`

The `data/` directory serves as a mount point for database persistence.