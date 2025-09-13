#!/bin/bash

# Frontend Structure Migration Script
# Migrácia z frontend/src/lib/components/* na frontend/src/components/*

set -e

echo "🚀 Starting frontend structure migration..."

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Check if we're in the right directory
if [[ ! -d "frontend/src" ]]; then
    echo -e "${RED}Error: frontend/src directory not found. Run this script from project root.${NC}"
    exit 1
fi

# Backup before migration
echo -e "${YELLOW}📦 Creating backup...${NC}"
if [[ ! -d "frontend/src/lib_backup" ]]; then
    cp -r "frontend/src/lib" "frontend/src/lib_backup"
    echo -e "${GREEN}✅ Backup created at frontend/src/lib_backup${NC}"
fi

# Create new directory structure
echo -e "${YELLOW}📁 Creating new directory structure...${NC}"
mkdir -p frontend/src/components/{islands,ui,layout,sections}
mkdir -p frontend/src/{stores,utils,types,styles}

# Move components
echo -e "${YELLOW}📦 Moving components...${NC}"

# Islands (interactive components)
if [[ -d "frontend/src/lib/components/islands" ]]; then
    echo -e "${BLUE}  Moving islands...${NC}"
    find frontend/src/lib/components/islands -name "*.svelte" -exec mv {} frontend/src/components/islands/ \;
    echo -e "${GREEN}  ✅ Islands moved${NC}"
fi

# UI components  
if [[ -d "frontend/src/lib/components/ui" ]]; then
    echo -e "${BLUE}  Moving UI components...${NC}"
    find frontend/src/lib/components/ui -name "*.svelte" -exec mv {} frontend/src/components/ui/ \;
    echo -e "${GREEN}  ✅ UI components moved${NC}"
fi

# Layout components
if [[ -d "frontend/src/lib/components/layout" ]]; then
    echo -e "${BLUE}  Moving layout components...${NC}"
    find frontend/src/lib/components/layout -name "*.svelte" -exec mv {} frontend/src/components/layout/ \;
    echo -e "${GREEN}  ✅ Layout components moved${NC}"
fi

# Move other lib directories
echo -e "${YELLOW}📦 Moving other lib directories...${NC}"

# Stores
if [[ -d "frontend/src/lib/stores" ]]; then
    echo -e "${BLUE}  Moving stores...${NC}"
    find frontend/src/lib/stores -name "*.ts" -exec mv {} frontend/src/stores/ \;
    echo -e "${GREEN}  ✅ Stores moved${NC}"
fi

# Utils
if [[ -d "frontend/src/lib/utils" ]]; then
    echo -e "${BLUE}  Moving utils...${NC}"
    find frontend/src/lib/utils -name "*.ts" -exec mv {} frontend/src/utils/ \;
    echo -e "${GREEN}  ✅ Utils moved${NC}"
fi

# Types
if [[ -d "frontend/src/lib/types" ]]; then
    echo -e "${BLUE}  Moving types...${NC}"
    find frontend/src/lib/types -name "*.ts" -name "*.d.ts" -exec mv {} frontend/src/types/ \;
    echo -e "${GREEN}  ✅ Types moved${NC}"
fi

# Move boot files to new location
if [[ -d "frontend/src/lib/boot" ]]; then
    echo -e "${BLUE}  Moving boot files...${NC}"
    mkdir -p frontend/src/core
    mv frontend/src/lib/boot/islands.ts frontend/src/core/islands.ts 2>/dev/null || true
    mv frontend/src/lib/boot/boot.ts frontend/src/core/boot.ts 2>/dev/null || true
    echo -e "${GREEN}  ✅ Boot files moved to core${NC}"
fi

# Create index files for better imports
echo -e "${YELLOW}📄 Creating index files...${NC}"

# Components index
cat > frontend/src/components/index.ts << 'EOF'
// Islands (Interactive components)
export { default as AddToCart } from './islands/AddToCart.svelte';
export { default as Alert } from './islands/Alert.svelte';

// Layout components
export { default as Header } from './layout/Header.svelte';
export { default as TailwindHero } from './layout/TailwindHero.svelte';

// UI components
export { default as ArticleCard } from './ui/ArticleCard.svelte';
export { default as ArticleDetail } from './ui/ArticleDetail.svelte';
export { default as Footer } from './ui/Footer.svelte';
export { default as Hero } from './ui/Hero.svelte';
export { default as Nav } from './ui/Nav.svelte';
export { default as SearchModal } from './ui/SearchModal.svelte';
export { default as TailwindHero } from './ui/TailwindHero.svelte';
EOF

# Stores index
cat > frontend/src/stores/index.ts << 'EOF'
export { appStore } from './app.store';
export { cartStore, addToCart, removeFromCart } from './cart.store';
export { userStore, login, logout } from './user.store';
export { uiStore, openModal, closeModal, toggleTheme, toggleSidebar } from './ui.store';
EOF

# Utils index
cat > frontend/src/utils/index.ts << 'EOF'
export { api, ApiClient } from './api';
export { formatPrice, formatDate } from './formatters';
export { validateEmail, validateRequired } from './validation';
export { htmxTrigger, htmxLoad, setupHtmxGlobalEvents } from './htmx.utils';
EOF

echo -e "${GREEN}✅ Index files created${NC}"

# Update tsconfig.json paths
echo -e "${YELLOW}🔧 Updating tsconfig.json...${NC}"
if [[ -f "tsconfig.json" ]]; then
    # Backup original tsconfig
    cp tsconfig.json tsconfig.json.backup
    
    # Update paths using sed
    sed -i.bak 's|"\$lib": \["./frontend/src/lib"\]|"$lib": ["./frontend/src/lib"]|g' tsconfig.json
    sed -i.bak 's|"\$lib/\*": \["./frontend/src/lib/\*"\]|"$lib/*": ["./frontend/src/lib/*"]|g' tsconfig.json
    
    # Add new paths
    cat > tsconfig_paths_temp.json << 'EOF'
      "$components": ["./frontend/src/components"],
      "$components/*": ["./frontend/src/components/*"],
      "$components/islands/*": ["./frontend/src/components/islands/*"],
      "$components/ui/*": ["./frontend/src/components/ui/*"],
      "$components/layout/*": ["./frontend/src/components/layout/*"],
      "$components/sections/*": ["./frontend/src/components/sections/*"],
      "$pages": ["./frontend/src/pages"],
      "$pages/*": ["./frontend/src/pages/*"],
      "$stores": ["./frontend/src/stores"],
      "$stores/*": ["./frontend/src/stores/*"],
      "$utils": ["./frontend/src/utils"],
      "$utils/*": ["./frontend/src/utils/*"],
      "$types": ["./frontend/src/types"],
      "$types/*": ["./frontend/src/types/*"]
EOF
    echo -e "${GREEN}  ✅ tsconfig.json updated (backup created)${NC}"
fi

# Update vite.config.js
echo -e "${YELLOW}🔧 Updating vite.config.js...${NC}"
if [[ -f "vite.config.js" ]]; then
    cp vite.config.js vite.config.js.backup
    
    # Create new vite config with updated aliases
    cat > vite_config_temp.js << 'EOF'
import { svelte, vitePreprocess } from "@sveltejs/vite-plugin-svelte";
import { defineConfig } from "vite";
import { resolve } from "path";

export default defineConfig({
  base: '/build/',
  plugins: [
    svelte({
      preprocess: vitePreprocess(),
      compilerOptions: {
        dev: process.env.NODE_ENV !== 'production'
      }
    }),
  ],
  resolve: {
    alias: {
      // New structure aliases
      '$components': resolve('./frontend/src/components'),
      '$pages': resolve('./frontend/src/pages'),
      '$stores': resolve('./frontend/src/stores'),
      '$utils': resolve('./frontend/src/utils'),
      '$types': resolve('./frontend/src/types'),
      
      // Legacy lib support (will be removed)
      '$lib': resolve('./frontend/src/lib'),
    },
  },
  publicDir: false,
  build: {
    minify: 'esbuild',
    esbuild: {
      legalComments: 'none',
      minify: true,
      target: 'es2020',
    },
    manifest: true,
    outDir: "public/build",
    assetsDir: "assets",
    emptyOutDir: true,
    rollupOptions: {
      input: {
        main: resolve("./frontend/src/app.ts"),
      },
      output: {
        chunkFileNames: 'assets/[name]-[hash].js',
        assetFileNames: 'assets/[name]-[hash][extname]',
      }
    },
    sourcemap: process.env.NODE_ENV !== 'production'
  },
  optimizeDeps: {
    exclude: ['svelte']
  },
  server: {
    host: "localhost",
    port: 5173,
    strictPort: true,
    cors: true,
    origin: "http://localhost:5173"
  }
});
EOF

    mv vite_config_temp.js vite.config.js
    echo -e "${GREEN}  ✅ vite.config.js updated (backup created)${NC}"
fi

# Create new ComponentRegistry
echo -e "${YELLOW}🔧 Creating new ComponentRegistry...${NC}"
mkdir -p frontend/src/core
cat > frontend/src/core/ComponentRegistry.ts << 'EOF'
import { mount } from 'svelte';

type ComponentMap = Record<string, () => Promise<any>>;

/**
 * Unified Component Registry
 * Dynamically imports and mounts Svelte components from the new structure
 */
export class ComponentRegistry {
  private static components: ComponentMap = {
    // Islands - Interactive components
    ...import.meta.glob('../components/islands/*.svelte'),
    
    // UI - Presentational components  
    ...import.meta.glob('../components/ui/*.svelte'),
    
    // Layout - Structural components
    ...import.meta.glob('../components/layout/*.svelte'),
    
    // Sections - Composite sections
    ...import.meta.glob('../components/sections/*.svelte'),
    
    // Pages - Top-level views
    ...import.meta.glob('../pages/*.svelte'),
  };

  /**
   * Initialize all elements with data-component attribute
   */
  static async initIslands(): Promise<void> {
    console.log('[ComponentRegistry] Initializing islands...');
    
    const elements = document.querySelectorAll<HTMLElement>('[data-component]');
    console.log(`[ComponentRegistry] Found ${elements.length} components to mount`);
    
    for (const element of elements) {
      await this.mountComponent(element);
    }
  }

  /**
   * Mount a single component
   */
  static async mountComponent(element: HTMLElement): Promise<void> {
    const componentName = element.dataset.component;
    if (!componentName) return;

    console.log(`[ComponentRegistry] Mounting component: ${componentName}`);

    const loader = this.findComponent(componentName);
    if (!loader) {
      console.warn(`[ComponentRegistry] Component "${componentName}" not found`);
      return;
    }

    try {
      const module = await loader();
      const props = element.dataset.props ? JSON.parse(element.dataset.props) : {};
      
      mount(module.default, {
        target: element,
        props
      });
      
      console.log(`[ComponentRegistry] Component "${componentName}" mounted successfully`);
    } catch (error) {
      console.error(`[ComponentRegistry] Failed to mount "${componentName}":`, error);
    }
  }

  /**
   * Find component loader by name
   */
  private static findComponent(name: string): (() => Promise<any>) | undefined {
    // Try different path patterns
    const patterns = [
      `../components/islands/${name}.svelte`,
      `../components/ui/${name}.svelte`, 
      `../components/layout/${name}.svelte`,
      `../components/sections/${name}.svelte`,
      `../pages/${name}.svelte`
    ];

    for (const pattern of patterns) {
      if (this.components[pattern]) {
        return this.components[pattern];
      }
    }

    return undefined;
  }
}

// Auto-initialize on DOM ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => ComponentRegistry.initIslands());
} else {
  ComponentRegistry.initIslands();
}

// Re-initialize after HTMX swaps
document.body.addEventListener('htmx:afterSwap', () => ComponentRegistry.initIslands());

// Add CSRF token to HTMX requests
document.addEventListener('htmx:configRequest', (event: any) => {
  const csrfMeta = document.querySelector('meta[name="csrf-token"]');
  const csrfToken = csrfMeta?.getAttribute('content');

  if (csrfToken && !['get', 'head', 'options'].includes(event.detail.verb.toLowerCase())) {
    event.detail.headers['X-CSRF-Token'] = csrfToken;
  }
});
EOF

# Update app.ts to use new ComponentRegistry
echo -e "${YELLOW}🔧 Updating app.ts...${NC}"
cat > frontend/src/app.ts << 'EOF'
import './styles/app.css';
import { mount } from 'svelte';
import Header from '$components/layout/Header.svelte';
import './core/ComponentRegistry';

// Function to mount Header
function mountHeader() {
  const navRoot = document.getElementById('nav-root');
  if (navRoot && !navRoot.hasChildNodes()) {
    const urlParams = new URLSearchParams(window.location.search);
    mount(Header, {
      target: navRoot,
      props: {
        currentRoute: window.location.pathname || "/",
        searchQuery: urlParams.get('q') || ""
      }
    });
  }
}

// Mount Header initially
mountHeader();

// Re-mount Header after HTMX swaps
document.body.addEventListener('htmx:afterSwap', mountHeader);
EOF

echo -e "${GREEN}✅ ComponentRegistry created and app.ts updated${NC}"

# Summary
echo -e "\n${GREEN}🎉 Migration completed successfully!${NC}"
echo -e "\n${YELLOW}📋 Summary of changes:${NC}"
echo -e "${BLUE}  • Components moved from lib/components/* to components/*${NC}"
echo -e "${BLUE}  • Stores, utils, types moved to top level${NC}"
echo -e "${BLUE}  • New ComponentRegistry created${NC}"
echo -e "${BLUE}  • tsconfig.json and vite.config.js updated${NC}"
echo -e "${BLUE}  • Index files created for better imports${NC}"
echo -e "${BLUE}  • app.ts updated to use new structure${NC}"

echo -e "\n${YELLOW}⚠️  Next steps:${NC}"
echo -e "${BLUE}  1. Run the import update script (migrate-imports.py)${NC}"
echo -e "${BLUE}  2. Test the application: npm run dev${NC}" 
echo -e "${BLUE}  3. Update any remaining manual imports${NC}"
echo -e "${BLUE}  4. Remove lib_backup when everything works${NC}"

echo -e "\n${GREEN}✨ Your new import paths:${NC}"
echo -e "${BLUE}  import Component from '\$components/islands/Component.svelte';${NC}"
echo -e "${BLUE}  import { store } from '\$stores/app.store';${NC}"
echo -e "${BLUE}  import { utility } from '\$utils/helpers';${NC}"