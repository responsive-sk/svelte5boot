#!/usr/bin/env python3
"""
Import Update Script
Updates all import paths from old lib structure to new component structure
"""

import os
import re
import glob
from pathlib import Path
from typing import List, Dict, Tuple

class ImportUpdater:
    def __init__(self, project_root: str = "."):
        self.project_root = Path(project_root)
        self.updated_files = []
        self.errors = []
        
        # Import mapping patterns - order matters!
        self.import_patterns = [
            # Islands components
            (r"from\s+['\"]\.\.\/lib\/components\/islands\/([^'\"]+)['\"]", r"from '$components/islands/\1'"),
            (r"import\s+([^'\"]+)\s+from\s+['\"]\.\.\/lib\/components\/islands\/([^'\"]+)['\"]", r"import \1 from '$components/islands/\2'"),
            
            # UI components  
            (r"from\s+['\"]\.\.\/lib\/components\/ui\/([^'\"]+)['\"]", r"from '$components/ui/\1'"),
            (r"import\s+([^'\"]+)\s+from\s+['\"]\.\.\/lib\/components\/ui\/([^'\"]+)['\"]", r"import \1 from '$components/ui/\2'"),
            
            # Layout components
            (r"from\s+['\"]\.\.\/lib\/components\/layout\/([^'\"]+)['\"]", r"from '$components/layout/\1'"),
            (r"import\s+([^'\"]+)\s+from\s+['\"]\.\.\/lib\/components\/layout\/([^'\"]+)['\"]", r"import \1 from '$components/layout/\2'"),
            
            # Generic components (fallback)
            (r"from\s+['\"]\.\.\/lib\/components\/([^'\"]+)['\"]", r"from '$components/\1'"),
            (r"import\s+([^'\"]+)\s+from\s+['\"]\.\.\/lib\/components\/([^'\"]+)['\"]", r"import \1 from '$components/\2'"),
            
            # Stores
            (r"from\s+['\"]\.\.\/lib\/stores\/([^'\"]+)['\"]", r"from '$stores/\1'"),
            (r"import\s+([^'\"]+)\s+from\s+['\"]\.\.\/lib\/stores\/([^'\"]+)['\"]", r"import \1 from '$stores/\2'"),
            
            # Utils
            (r"from\s+['\"]\.\.\/lib\/utils\/([^'\"]+)['\"]", r"from '$utils/\1'"),
            (r"import\s+([^'\"]+)\s+from\s+['\"]\.\.\/lib\/utils\/([^'\"]+)['\"]", r"import \1 from '$utils/\2'"),
            
            # Types
            (r"from\s+['\"]\.\.\/lib\/types\/([^'\"]+)['\"]", r"from '$types/\1'"),
            (r"import\s+([^'\"]+)\s+from\s+['\"]\.\.\/lib\/types\/([^'\"]+)['\"]", r"import \1 from '$types/\2'"),
            
            # Boot/Core files
            (r"from\s+['\"]\.\.\/lib\/boot\/([^'\"]+)['\"]", r"from '../core/\1'"),
            (r"import\s+([^'\"]+)\s+from\s+['\"]\.\.\/lib\/boot\/([^'\"]+)['\"]", r"import \1 from '../core/\2'"),
            
            # Alternative relative paths (from different depths)
            (r"from\s+['\"]\.\.\/\.\.\/lib\/components\/islands\/([^'\"]+)['\"]", r"from '$components/islands/\1'"),
            (r"from\s+['\"]\.\.\/\.\.\/lib\/components\/ui\/([^'\"]+)['\"]", r"from '$components/ui/\1'"),
            (r"from\s+['\"]\.\.\/\.\.\/lib\/components\/layout\/([^'\"]+)['\"]", r"from '$components/layout/\1'"),
            (r"from\s+['\"]\.\.\/\.\.\/lib\/stores\/([^'\"]+)['\"]", r"from '$stores/\1'"),
            (r"from\s+['\"]\.\.\/\.\.\/lib\/utils\/([^'\"]+)['\"]", r"from '$utils/\1'"),
            
            # $lib aliases (legacy)
            (r"from\s+['\"](\$lib\/components\/islands\/[^'\"]+)['\"]", r"from '$components/islands/\1".replace('$lib/components/islands/', '')),
            (r"from\s+['\"](\$lib\/components\/ui\/[^'\"]+)['\"]", r"from '$components/ui/\1".replace('$lib/components/ui/', '')),
            (r"from\s+['\"](\$lib\/components\/layout\/[^'\"]+)['\"]", r"from '$components/layout/\1".replace('$lib/components/layout/', '')),
            (r"from\s+['\"](\$lib\/stores\/[^'\"]+)['\"]", r"from '$stores/\1".replace('$lib/stores/', '')),
            (r"from\s+['\"](\$lib\/utils\/[^'\"]+)['\"]", r"from '$utils/\1".replace('$lib/utils/', '')),
            
            # Import with defaults
            (r"import\s+([^'\"]+)\s+from\s+['\"](\$lib\/components\/islands\/[^'\"]+)['\"]", lambda m: f"import {m.group(1)} from '$components/islands/{m.group(2).replace('$lib/components/islands/', '')}'"),
            (r"import\s+([^'\"]+)\s+from\s+['\"](\$lib\/components\/ui\/[^'\"]+)['\"]", lambda m: f"import {m.group(1)} from '$components/ui/{m.group(2).replace('$lib/components/ui/', '')}'"),
            (r"import\s+([^'\"]+)\s+from\s+['\"](\$lib\/components\/layout\/[^'\"]+)['\"]", lambda m: f"import {m.group(1)} from '$components/layout/{m.group(2).replace('$lib/components/layout/', '')}'"),
        ]

    def find_files_to_update(self) -> List[Path]:
        """Find all TypeScript and Svelte files that might need import updates"""
        patterns = [
            "frontend/src/**/*.ts",
            "frontend/src/**/*.svelte", 
            "frontend/src/**/*.js"
        ]
        
        files = []
        for pattern in patterns:
            files.extend(glob.glob(pattern, recursive=True))
        
        return [Path(f) for f in files if Path(f).exists()]

    def update_file_imports(self, file_path: Path) -> Tuple[bool, int]:
        """Update imports in a single file"""
        try:
            with open(file_path, 'r', encoding='utf-8') as f:
                content = f.read()
            
            original_content = content
            changes_count = 0
            
            # Apply all import pattern replacements
            for pattern, replacement in self.import_patterns:
                if callable(replacement):
                    # Handle callable replacements
                    matches = re.finditer(pattern, content)
                    for match in matches:
                        old_import = match.group(0)
                        new_import = replacement(match)
                        content = content.replace(old_import, new_import)
                        changes_count += 1
                else:
                    # Handle string replacements
                    new_content = re.sub(pattern, replacement, content)
                    if new_content != content:
                        changes_count += len(re.findall(pattern, content))
                        content = new_content
            
            # Write back if changes were made
            if content != original_content:
                with open(file_path, 'w', encoding='utf-8') as f:
                    f.write(content)
                return True, changes_count
            
            return False, 0
            
        except Exception as e:
            self.errors.append(f"Error updating {file_path}: {str(e)}")
            return False, 0

    def update_php_backend_references(self):
        """Update PHP backend references to component paths"""
        php_files = [
            "config/autoload/frontend.global.php",
            "src/App/Middleware/SvelteDataMiddleware.php",
            "src/App/View/Twig/SvelteComponentExtension.php"
        ]
        
        for php_file in php_files:
            file_path = self.project_root / php_file
            if not file_path.exists():
                continue
                
            try:
                with open(file_path, 'r') as f:
                    content = f.read()
                
                original = content
                
                # Update component paths in PHP
                replacements = [
                    ('frontend/src/lib/components/islands', 'frontend/src/components/islands'),
                    ('frontend/src/lib/components/ui', 'frontend/src/components/ui'),
                    ('frontend/src/lib/components/layout', 'frontend/src/components/layout'),
                    ('lib/components/islands', 'components/islands'),
                    ('lib/components/ui', 'components/ui'),
                    ('lib/components/layout', 'components/layout'),
                ]
                
                for old, new in replacements:
                    content = content.replace(old, new)
                
                if content != original:
                    with open(file_path, 'w') as f:
                        f.write(content)
                    print(f"✅ Updated PHP file: {php_file}")
                    
            except Exception as e:
                self.errors.append(f"Error updating PHP file {php_file}: {str(e)}")

    def run(self):
        """Run the complete import update process"""
        print("🚀 Starting import path updates...")
        
        # Find all files to update
        files_to_update = self.find_files_to_update()
        print(f"📁 Found {len(files_to_update)} files to check")
        
        total_changes = 0
        updated_count = 0
        
        # Update each file
        for file_path in files_to_update:
            print(f"🔍 Checking: {file_path}")
            was_updated, changes = self.update_file_imports(file_path)
            
            if was_updated:
                self.updated_files.append(str(file_path))
                updated_count += 1
                total_changes += changes
                print(f"  ✅ Updated with {changes} changes")
            else:
                print(f"  ⏭️  No changes needed")
        
        # Update PHP backend references
        print("\n🔧 Updating PHP backend references...")
        self.update_php_backend_references()
        
        # Summary
        print(f"\n🎉 Import update completed!")
        print(f"📊 Summary:")
        print(f"   • Files checked: {len(files_to_update)}")
        print(f"   • Files updated: {updated_count}")
        print(f"   • Total changes: {total_changes}")
        
        if self.errors:
            print(f"\n⚠️  Errors encountered:")
            for error in self.errors:
                print(f"   • {error}")
        
        if updated_count > 0:
            print(f"\n✅ Updated files:")
            for file in self.updated_files:
                print(f"   • {file}")
        
        print(f"\n🎯 Next steps:")
        print(f"   1. Test your application: npm run dev")
        print(f"   2. Check for any remaining manual import fixes")
        print(f"   3. Remove frontend/src/lib_backup when everything works")

def main():
    import sys
    
    # Get project root from command line or use current directory
    project_root = sys.argv[1] if len(sys.argv) > 1 else "."
    
    if not os.path.exists(os.path.join(project_root, "frontend")):
        print("❌ Error: frontend directory not found. Run from project root or specify path.")
        sys.exit(1)
    
    updater = ImportUpdater(project_root)
    updater.run()

if __name__ == "__main__":
    main()