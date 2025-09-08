.
├── bin
│   └── clear-config-cache.php
├── config
│   ├── autoload
│   │   ├── dependencies.global.php
│   │   ├── development.local.php -> development.local.php.dist
│   │   ├── development.local.php.dist
│   │   ├── .gitignore
│   │   ├── local.php.dist
│   │   ├── mezzio.global.php
│   │   ├── radix-router.global.php
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
│       │   └── types
│       │       ├── global.d.ts
│       │       └── vite-env.d.ts
│       ├── Pages
│       │   ├── CoolIndex.svelte
│       │   └── Welcome.svelte
│       ├── app.svelte
│       ├── app.ts
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
│       │   └── PingHandler.php
│       └── ConfigProvider.php
├── templates
│   ├── app
│   │   ├── component-demo.html.twig
│   │   ├── cool-index.html.twig
│   │   ├── hero.html.twig
│   │   └── home-page.html.twig
│   ├── error
│   │   ├── 404.html.twig
│   │   └── error.html.twig
│   ├── layout
│   │   └── default.html.twig
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

25 directories, 82 files
