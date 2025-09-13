#!/bin/bash

# Migration Validation Script - Fixed Version
# Validates that the frontend structure migration was successful

set -e

echo "🔍 Validating frontend structure migration..."

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

ERRORS=0
WARNINGS=0

# Check if we're in the right directory
if [[ ! -d "frontend/src" ]]; then
    echo -e "${RED}❌ Error: frontend/src directory not found${NC}"
    exit 1
fi

echo -e "${BLUE}📂 Checking directory structure...${NC}"

# Check new directory structure exists
REQUIRED_DIRS=(
    "frontend/src/components"
    "frontend/src/components/islands"
    "frontend/src/components/ui"
    "frontend/src/components/layout"
    "frontend/src/pages"
    "frontend/src/stores"
    "frontend/src/utils"
    "frontend/src/types"
    "frontend/src/core"
)

for dir in "${REQUIRED_DIRS[@]}"; do
    if [[ -d "$dir" ]]; then
        echo -e "${GREEN}  ✅ $dir${NC}"
    else
        echo -e "${RED}  ❌ $dir - MISSING${NC}"
        ((ERRORS++))
    fi
done

# Check if components were moved correctly
echo -e "\n${BLUE}📦 Checking component files...${NC}"

# Islands components
if [[ -d "frontend/src/components/islands" ]]; then
    ISLANDS_COUNT=$(find frontend/src/components/islands -name "*.svelte" | wc -l)
    echo -e "${GREEN}  ✅ Islands: $ISLANDS_COUNT components found${NC}"
    
    # List islands
    for component in frontend/src/components/islands/*.svelte; do
        if [[ -f "$component" ]]; then
            basename_comp=$(basename "$component")
            echo -e "${GREEN}    • $basename_comp${NC}"
        fi
    done
else
    echo -e "${RED}  ❌ Islands directory missing${NC}"
    ((ERRORS++))
fi

# Layout components
if [[ -d "frontend/src/components/layout" ]]; then
    LAYOUT_COUNT=$(find frontend/src/components/layout -name "*.svelte" | wc -l)
    echo -e "${GREEN}  ✅ Layout: $LAYOUT_COUNT components found${NC}"
    
    # List layout components
    for component in frontend/src/components/layout/*.svelte; do
        if [[ -f "$component" ]]; then
            basename_comp=$(basename "$component")
            echo -e "${GREEN}    • $basename_comp${NC}"
        fi
    done
else
    echo -e "${RED}  ❌ Layout directory missing${NC}"
    ((ERRORS++))
fi

# UI components
if [[ -d "frontend/src/components/ui" ]]; then
    UI_COUNT=$(find frontend/src/components/ui -name "*.svelte" | wc -l)
    echo -e "${GREEN}  ✅ UI: $UI_COUNT components found${NC}"
else
    echo -e "${YELLOW}  ⚠️  UI directory empty or missing${NC}"
    ((WARNINGS++))
fi

# Stores
if [[ -d "frontend/src/stores" ]]; then
    STORES_COUNT=$(find frontend/src/stores -name "*.ts" | wc -l)
    echo -e "${GREEN}  ✅ Stores: $STORES_COUNT files found${NC}"
else
    echo -e "${RED}  ❌ Stores directory missing${NC}"
    ((ERRORS++))
fi

# Utils
if [[ -d "frontend/src/utils" ]]; then
    UTILS_COUNT=$(find frontend/src/utils -name "*.ts" | wc -l)
    echo -e "${GREEN}  ✅ Utils: $UTILS_COUNT files found${NC}"
else
    echo -e "${RED}  ❌ Utils directory missing${NC}"
    ((ERRORS++))
fi

# Check for old lib directory
echo -e "\n${BLUE}🗂️  Checking legacy structure...${NC}"
if [[ -d "frontend/src/lib" ]]; then
    # Check if lib directory is empty (except backup)
    if [[ -d "frontend/src/lib_backup" ]]; then
        echo -e "${GREEN}  ✅ Backup created: lib_backup${NC}"
    fi
    
    # Check if original lib still has files
    LIB_FILE_COUNT=$(find frontend/src/lib -name "*.svelte" -o -name "*.ts" 2>/dev/null | wc -l)
    if [[ $LIB_FILE_COUNT -gt 0 ]]; then
        echo -e "${YELLOW}  ⚠️  Original lib directory still has $LIB_FILE_COUNT files${NC}"
        echo -e "${YELLOW}     Consider removing after validation${NC}"
        ((WARNINGS++))
    else
        echo -e "${GREEN}  ✅ Original lib directory is clean${NC}"
    fi
else
    echo -e "${GREEN}  ✅ Legacy lib directory removed${NC}"
fi

# Check configuration files
echo -e "\n${BLUE}⚙️  Checking configuration files...${NC}"

# tsconfig.json
if [[ -f "tsconfig.json" ]]; then
    if grep -q '\$components' tsconfig.json; then
        echo -e "${GREEN}  ✅ tsconfig.json has new paths${NC}"
    else
        echo -e "${RED}  ❌ tsconfig.json missing new path aliases${NC}"
        ((ERRORS++))
    fi
    
    if [[ -f "tsconfig.json.backup" ]]; then
        echo -e "${GREEN}  ✅ tsconfig.json backup exists${NC}"
    fi
else
    echo -e "${YELLOW}  ⚠️  tsconfig.json not found${NC}"
    ((WARNINGS++))
fi

# vite.config.js
if [[ -f "vite.config.js" ]]; then
    if grep -q '\$components' vite.config.js; then
        echo -e "${GREEN}  ✅ vite.config.js has new aliases${NC}"
    else
        echo -e "${RED}  ❌ vite.config.js missing new aliases${NC}"
        ((ERRORS++))
    fi
    
    if [[ -f "vite.config.js.backup" ]]; then
        echo -e "${GREEN}  ✅ vite.config.js backup exists${NC}"
    fi
else
    echo -e "${YELLOW}  ⚠️  vite.config.js not found${NC}"
    ((WARNINGS++))
fi

# Check index files
echo -e "\n${BLUE}📄 Checking index files...${NC}"

INDEX_FILES=(
    "frontend/src/components/index.ts"
    "frontend/src/stores/index.ts"
    "frontend/src/utils/index.ts"
)

for index_file in "${INDEX_FILES[@]}"; do
    if [[ -f "$index_file" ]]; then
        echo -e "${GREEN}  ✅ $index_file${NC}"
    else
        echo -e "${YELLOW}  ⚠️  $index_file - not created${NC}"
        ((WARNINGS++))
    fi
done

# Check ComponentRegistry
echo -e "\n${BLUE}🏗️  Checking ComponentRegistry...${NC}"

if [[ -f "frontend/src/core/ComponentRegistry.ts" ]]; then
    echo -e "${GREEN}  ✅ ComponentRegistry.ts created${NC}"
    
    # Check if it has the right imports
    if grep -q 'components/islands' frontend/src/core/ComponentRegistry.ts; then
        echo -e "${GREEN}  ✅ ComponentRegistry has islands imports${NC}"
    else
        echo -e "${RED}  ❌ ComponentRegistry missing islands imports${NC}"
        ((ERRORS++))
    fi
else
    echo -e "${RED}  ❌ ComponentRegistry.ts not found${NC}"
    ((ERRORS++))
fi

# Check app.ts
if [[ -f "frontend/src/app.ts" ]]; then
    if grep -q 'ComponentRegistry' frontend/src/app.ts; then
        echo -e "${GREEN}  ✅ app.ts imports ComponentRegistry${NC}"
    else
        echo -e "${YELLOW}  ⚠️  app.ts doesn't import ComponentRegistry${NC}"
        ((WARNINGS++))
    fi
else
    echo -e "${RED}  ❌ app.ts not found${NC}"
    ((ERRORS++))
fi

# Check for import issues
echo -e "\n${BLUE}🔍 Checking for potential import issues...${NC}"

# Search for old import patterns
OLD_IMPORT_PATTERNS=(
    "../lib/components"
    "../lib/stores"
    "../lib/utils"
    "\\\$lib/components"
    "\\\$lib/stores"
    "\\\$lib/utils"
)

IMPORT_ISSUES=0
for pattern in "${OLD_IMPORT_PATTERNS[@]}"; do
    FILES_WITH_OLD_IMPORTS=$(grep -r "$pattern" frontend/src --include="*.ts" --include="*.svelte" --include="*.js" 2>/dev/null | wc -l || echo "0")
    if [[ $FILES_WITH_OLD_IMPORTS -gt 0 ]]; then
        echo -e "${YELLOW}  ⚠️  Found $FILES_WITH_OLD_IMPORTS files with old import pattern: $pattern${NC}"
        ((IMPORT_ISSUES++))
    fi
done

if [[ $IMPORT_ISSUES -eq 0 ]]; then
    echo -e "${GREEN}  ✅ No old import patterns detected${NC}"
else
    echo -e "${YELLOW}  ⚠️  Found $IMPORT_ISSUES old import patterns${NC}"
    ((WARNINGS++))
fi

# Test build (optional)
echo -e "\n${BLUE}🏗️  Testing build configuration...${NC}"

if command -v npm &> /dev/null; then
    echo -e "${BLUE}  Testing TypeScript compilation...${NC}"
    
    # Check if node_modules exists
    if [[ -d "node_modules" ]]; then
        # Try TypeScript check
        if npx tsc --noEmit --skipLibCheck 2>/dev/null; then
            echo -e "${GREEN}  ✅ TypeScript compilation successful${NC}"
        else
            echo -e "${YELLOW}  ⚠️  TypeScript compilation has issues${NC}"
            echo -e "${YELLOW}     Run 'npx tsc --noEmit' for details${NC}"
            ((WARNINGS++))
        fi
    else
        echo -e "${YELLOW}  ⚠️  node_modules not found, run 'npm install' first${NC}"
    fi
else
    echo -e "${YELLOW}  ⚠️  npm not found, skipping build test${NC}"
fi

# Final summary
echo -e "\n${BLUE}📊 Migration Validation Summary${NC}"
echo -e "================================="

if [[ $ERRORS -eq 0 && $WARNINGS -eq 0 ]]; then
    echo -e "${GREEN}🎉 Perfect! Migration completed successfully${NC}"
    echo -e "${GREEN}   • No errors found${NC}"
    echo -e "${GREEN}   • No warnings${NC}"
elif [[ $ERRORS -eq 0 ]]; then
    echo -e "${YELLOW}✅ Migration completed with minor warnings${NC}"
    echo -e "${GREEN}   • Errors: $ERRORS${NC}"
    echo -e "${YELLOW}   • Warnings: $WARNINGS${NC}"
else
    echo -e "${RED}❌ Migration has critical issues${NC}"
    echo -e "${RED}   • Errors: $ERRORS${NC}"
    echo -e "${YELLOW}   • Warnings: $WARNINGS${NC}"
fi

echo -e "\n${BLUE}🎯 Next steps:${NC}"
if [[ $IMPORT_ISSUES -gt 0 ]]; then
    echo -e "${YELLOW}   1. Check import patterns manually${NC}"
fi
echo -e "${BLUE}   2. Run: npm run dev${NC}"
echo -e "${BLUE}   3. Test your application thoroughly${NC}"
echo -e "${BLUE}   4. Remove lib_backup when everything works${NC}"

if [[ $ERRORS -gt 0 ]]; then
    exit 1
else
    exit 0
fi