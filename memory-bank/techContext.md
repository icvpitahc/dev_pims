# PIMS Technology Context

This document outlines the technology stack and key dependencies of the Personnel Information Management System (PIMS) after the initial dependency upgrade for Laravel 9.

## Core Technologies

*   **PHP:** ^8.0
*   **Laravel Framework:** ^9.0
*   **Livewire:** ^2.10
*   **Bootstrap 5:** Used for standalone, modernized pages (e.g., authentication, newsfeed).
*   **Bootstrap 4:** Used by the core AdminLTE theme, which provides the main application layout.
*   **Custom CSS:** A custom stylesheet (`public/css/login.css`) is used for the modernized authentication pages.

## Key Dependencies

*   **`guzzlehttp/guzzle`:** ^7.0.1
*   **`infyomlabs/laravel-ui-adminlte`:** ^4.0
*   **`kwn/number-to-words`:** ^2.9
*   **`laravel/tinker`:** ^2.7
*   **`maatwebsite/excel`:** ^3.1
*   **`nesbot/carbon`:** ^2.45
*   **`owen-it/laravel-auditing`:** ^13.0
*   **`rappasoft/laravel-livewire-tables`:** ^2.0 (High-risk dependency requiring significant refactoring)

## Development Dependencies

*   **`spatie/laravel-ignition`:** ^1.0
*   **`fakerphp/faker`:** ^1.9.1
*   **`laravel/sail`:** ^1.0.1
*   **`mockery/mockery`:** ^1.4.2
*   **`nunomaduro/collision`:** ^6.1
*   **`phpunit/phpunit`:** ^9.5

## Database Schema

The database schema is managed via Laravel Migrations. Key tables include:

*   **`documents`**: Stores the core information for each document.
    *   `id` (Primary Key)
    *   `document_reference_code` (string)
    *   `document_type_id` (integer)
    *   `document_sub_type_id` (integer)
    *   `document_title` (string)
    *   `specify_attachments` (text, nullable)
    *   `note` (text, nullable)
    *   `division_id` (integer)
    *   `created_by` (integer)
    *   `extremely_urgent_id` (integer, nullable) - *Manually added for urgent document flagging.*
    *   `deleted_by` (integer, nullable)
    *   `deleted_at` (timestamp, nullable)
    *   `created_at`, `updated_at` (timestamps)
*   **`document_logs`**: Tracks the routing history and actions for each document.
*   **`users`**: Stores user account information.
