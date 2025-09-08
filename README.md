# Mezzio + Svelte 5 Demo

A minimal example for building a modern server-driven SPA with:

- **Mezzio** (PSR-15 middleware framework)
- **htmx.js** (server-driven HTMX SPA technique)
- **Svelte** (frontend UI)
- **Vite** (dev server and asset bundler with manifest integration)

Mezzio returns Inertia responses that the Svelte app hydrates on the client, enabling a server-driven SPA without a traditional REST/JSON API.

---

## Prerequisites

- PHP 8.3+
- Composer
- Node.js 18+ and npm (or pnpm/yarn)

---

## Quick Start

1) Install PHP dependencies

```bash
composer install
```

2) Install frontend dependencies

```bash
npm install
```

3) Start for development or build for production

- Development (Vite dev server):

```bash
npm run dev
```

- Production build (outputs to `public/build`):

```bash
npm run build
```

4) Start the PHP server

- If `composer serve` is available:

```bash
composer serve
```

- Fallback (built-in PHP server):

```bash
php -S 0.0.0.0:8080 -t public
```

Then open http://localhost:8080 in your browser.

### Copy/paste setup

```bash
composer install
npm install
npm run dev # or: npm run build
composer serve # or: php -S 0.0.0.0:8080 -t public
```

---

## Development vs. Production

- **Development**
  - The Twig layout uses the Vite dev server at http://localhost:5173 (configured in `vite.config.js`).
  - Ensure `npm run dev` is running so assets are served and hot reloaded.

- **Production**
  - Run `npm run build` once to generate hashed assets in `public/build/`.
  - The Twig Vite integration reads `public/build/manifest.json` to inject the built assets.
  - Do not run the Vite dev server in production.

---

## Project Structure

```text
.
├─ public/
│  └─ build/           # Vite production assets (after build)
├─ resources/
│  └─ js/
│     └─ app.ts        # Inertia/Svelte entrypoint
├─ templates/
│  └─ app.html.twig    # Base Twig layout that mounts Inertia
├─ vite.config.js
├─ composer.json
└─ README.md
```

---

## What’s Inside

- **Backend**
  - [Mezzio](https://docs.mezzio.dev/) (PSR-15)
  - [laminas-diactoros](https://github.com/laminas/laminas-diactoros)
  - `sirix/mezzio-radixrouter` (routing)
  - [Twig](https://twig.symfony.com/) renderer and `sirix/twig-vite-extension` for Vite asset links

- **Frontend**
  - [Svelte 5](https://svelte.dev/)
  - [Vite](https://vitejs.dev/) configured to output to `public/build` with `resources/js/app.ts` as the entry

---

## Key Files

- `templates/app.html.twig` – Twig layout mounts Inertia and injects Vite tags
- `resources/js/app.ts` – Inertia app bootstrapping and Svelte mounting
- `vite.config.js` – Vite build and dev server configuration

---

## Common Scripts

### Composer Scripts

- `composer serve` – run PHP built-in server at http://localhost:8080
- `composer development-enable` | `composer development-disable` | `composer development-status`
- `composer clear-config-cache` – clear merged config cache
- `composer test` – run PHPUnit

### NPM Scripts

- `npm run dev` – start Vite dev server
- `npm run build` – build production assets to `public/build`
- `npm run lint` – lint code
- `npm run format` – format code

---

## Troubleshooting

- **Vite dev server not reachable on 5173**
  - Make sure `npm run dev` is running and port 5173 is free.
  - If the port is in use, either stop the conflicting process or change the port in `vite.config.js`.

- **PHP server port 8080 already in use**
  - Use another port: `php -S 0.0.0.0:8081 -t public` and open http://localhost:8081.

- **Manifest not found in production**
  - Run `npm run build` and confirm `public/build/manifest.json` exists.
  - Ensure the Twig Vite integration is configured to read the manifest.

- **Wrong asset paths in production**
  - Ensure the `base` option in `vite.config.js` matches your deployment subpath (if any).

- **Stale configuration**
  - Run `composer clear-config-cache` after changing configuration.

---

## Credits

- [Mezzio](https://docs.mezzio.dev/)
- [htmx.js](https://htmx.org/)
- [Svelte](https://svelte.dev/)
- [Vite](https://vitejs.dev/)
- [Twig](https://twig.symfony.com/)

---

## License

MIT. See `LICENSE` for details. If the file is missing, add one using the MIT template.
