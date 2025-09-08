# Mezzio + Inertia.js + Svelte Demo

This repository is a minimal example showing how to build a modern single-page experience with:

- Mezzio (PSR-15 middleware framework)
- Inertia.js (server-driven SPA technique)
- Svelte (frontend UI)
- Vite (asset bundler with manifest integration)

It demonstrates server-side Inertia responses in PHP and a Svelte client mounted via a Twig layout that injects Vite assets.

## Prerequisites

- PHP 8.3+
- Composer
- Node.js 18+ and npm (or pnpm/yarn)

## Quick start

1. Install PHP dependencies
   - composer install
2. Install frontend dependencies
   - npm install
3. Build assets (development server or production build)
   - For hot dev server: npm run dev
   - For production assets: npm run build
4. Start the PHP server
   - composer serve

Then open http://localhost:8080 in your browser.

Notes

- During development, the Twig layout uses Vite dev server on http://localhost:5173 (configured in vite.config.js); make sure npm run dev is running.
- For production, run npm run build once; Twig will read the Vite manifest from public/build/.

## What’s inside

- Backend
  - Mezzio, laminas-diactoros, and sirix/inertia-psr15 (PSR-15 Inertia adapter)
  - sirix/mezzio-radixrouter for routing
  - Twig renderer and sirix/twig-vite-extension to link Vite assets
- Frontend
  - @inertiajs/svelte with Svelte 5
  - Vite config outputs to public/build and serves resources/js/app.ts as the entry

Key files

- templates/app.html.twig – Twig layout mounts Inertia and injects Vite tags
- resources/js/app.ts – Inertia app bootstrapping and Svelte mount
- vite.config.js – Vite build and dev server configuration

## Common scripts

Composer

- composer serve – run PHP built-in server at http://localhost:8080
- composer development-enable | development-disable | development-status
- composer clear-config-cache – clear merged config cache
- composer test – run PHPUnit

NPM

- npm run dev – start Vite dev server
- npm run build – build production assets to public/build
- npm run lint / format – linting and formatting helpers

## Credits

- Mezzio by Laminas
- Inertia.js
- Svelte
