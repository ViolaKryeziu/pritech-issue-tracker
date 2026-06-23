<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <strong>Issue Tracker Application</strong>
</p>

<p align="center">
A Laravel-based Issue Tracking system with Projects, Issues, Tags, Comments, User Assignment and Authorization Policies.
</p>

---

## About the Project

This is a full-stack Laravel application built using Laravel Breeze authentication. It allows users to manage projects and track issues with relationships, AJAX features, and secure authorization.

---

## Features

- Laravel Breeze authentication (login, register, logout)
- Projects CRUD (Create, Read, Update, Delete)
- Only project owners can edit or delete projects (Policy-based authorization)
- Issues management linked to projects
- Filter issues by status priority and tags
- Assign users to issues (AJAX)
- Tags system with attach/detach (AJAX)
- Comments system with AJAX and pagination

---

## Tech Stack

- Laravel 13+
- Laravel Breeze
- MySQL
- Blade + Tailwind CSS

---

## Installation

Clone the repository:

git clone <your-repo-url>
cd pritech-issue-tracker

Install dependencies:

composer install
npm install
npm run dev

Setup environment:

cp .env.example .env
php artisan key:generate

Configure your database inside .env file.

Run migrations:

php artisan migrate

(Optional seed database)

php artisan db:seed

Start the server:

php artisan serve

---

## Authorization Rules

Only the owner of a project can:
- Edit project
- Delete project

Implemented using:
- ProjectPolicy
- authorize() in controller
- @can in Blade views

---

## Business Logic

- Any authenticated user can create projects
- Issues are shared inside projects
- Tags are reusable and attachable to issues
- Users can be assigned to issues
- Comments support AJAX + pagination
- Only project owner has full control over project

---

## Project Structure

- Project → has many Issues
- Issue → belongs to Project
- Issue → has many Tags (many-to-many)
- Issue → has many Users (many-to-many)
- Issue → has many Comments (one-to-many)


## License

MIT License - Open source project