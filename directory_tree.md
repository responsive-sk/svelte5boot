.
├── bin
│   └── clear-config-cache.php
├── config
│   ├── autoload
│   │   ├── csrf.global.php
│   │   ├── dependencies.global.php
│   │   ├── development.local.php -> development.local.php.dist
│   │   ├── development.local.php.dist
│   │   ├── .gitignore
│   │   ├── local.php.dist
│   │   ├── mezzio.global.php
│   │   ├── radix-router.global.php
│   │   ├── security.global.php
│   │   ├── template.global.php
│   │   └── vite.global.php
│   ├── config.php
│   ├── container.php
│   ├── development.config.php -> development.config.php.dist
│   ├── development.config.php.dist
│   ├── .gitignore
│   ├── pipeline.php
│   └── routes.php
├── data
│   ├── cache
│   │   └── radix-cache.php
│   └── .gitignore
├── frontend
│   └── src
│       ├── lib
│       │   ├── boot
│       │   │   └── islands.ts
│       │   └── components
│       │       └── islands
│       │           ├── AddToCart.svelte
│       │           └── Alert.svelte
│       └── styles
│           └── tailwind.css
├── .qodo
├── resources
│   ├── css
│   │   └── app.css
│   └── js
│       ├── Components
│       │   ├── ArticleCard.svelte
│       │   ├── ArticleDetail.svelte
│       │   ├── Footer.svelte
│       │   ├── Header.svelte
│       │   ├── Hero.svelte
│       │   ├── Nav.svelte
│       │   ├── SearchModal.svelte
│       │   └── TailwindHero.svelte
│       ├── lib
│       │   ├── bootstrap
│       │   │   └── islands.ts
│       │   └── types
│       │       ├── global.d.ts
│       │       └── vite-env.d.ts
│       ├── Pages
│       │   ├── CoolIndex.svelte
│       │   └── Welcome.svelte
│       ├── app.svelte
│       └── boot.ts
├── src
│   └── App
│       ├── Handler
│       │   ├── Api
│       │   │   ├── ContentHandlerFactory.php
│       │   │   └── ContentHandler.php
│       │   ├── ComponentDemoHandlerFactory.php
│       │   ├── ComponentDemoHandler.php
│       │   ├── CoolIndexHandlerFactory.php
│       │   ├── CoolIndexHandler.php
│       │   ├── HeroHandlerFactory.php
│       │   ├── HeroHandler.php
│       │   ├── HomePageHandlerFactory.php
│       │   ├── HomePageHandler.php
│       │   ├── PingHandler.php
│       │   ├── TestCsrfHandlerFactory.php
│       │   ├── TestCsrfHandler.php
│       │   ├── TestFrontendHandlerFactory.php
│       │   └── TestFrontendHandler.php
│       ├── Middleware
│       │   ├── CacheMiddleware.php
│       │   └── CspMiddleware.php
│       ├── View
│       │   ├── Helper
│       │   │   └── CsrfHelper.php
│       │   └── Twig
│       │       └── CsrfExtension.php
│       └── ConfigProvider.php
├── templates
│   ├── app
│   │   ├── component-demo.html.twig
│   │   ├── cool-index.html.twig
│   │   ├── hero.html.twig
│   │   ├── home-page.html.twig
│   │   ├── products.html.twig
│   │   └── test-frontend.html.twig
│   ├── error
│   │   ├── 404.html.twig
│   │   └── error.html.twig
│   ├── layout
│   │   └── default.html.twig
│   ├── partials
│   │   └── components.twig
│   └── app.html.twigZAL
├── test
│   └── AppTest
│       ├── Handler
│       │   ├── HomePageHandlerFactoryTest.php
│       │   ├── HomePageHandlerTest.php
│       │   └── PingHandlerTest.php
│       └── InMemoryContainer.php
├── composer.json
├── composer.lock
├── COPYRIGHT.md
├── directory_tree.md
├── .env
├── .env.example
├── eslint.config.js
├── .gitignore
├── LICENSE.md
├── package.json
├── package-lock.json
├── .phpcs-cache
├── phpcs.xml.dist
├── phpunit.xml.dist
├── pnpm-lock.yaml
├── postcss.config.js
├── psalm-baseline.xml
├── psalm.xml.dist
├── README.md
├── svelte.config.js
├── tailwind.config.js
├── TODO.md
├── tsconfig.eslint.json
├── tsconfig.json
└── vite.config.js

38 directories, 101 files
