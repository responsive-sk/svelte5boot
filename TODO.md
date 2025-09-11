# TODO List

## Completed Tasks
- [x] Add sample article data to App.svelte
- [x] Pass article prop to ArticleCard component
- [x] ArticleCard is now properly displayed on the index page with sample data
- [x] Move ArticleCard into existing grid container for proper layout
- [x] Add container wrapper around grid to control maximum width and centering
- [x] Rebuild frontend assets to include latest changes
- [x] Move HTMX dynamic content from below footer to main section
- [x] Position HTMX content below Hero and ArticleCard in main section
- [x] Disable automatic HTMX loading to prevent interference with ArticleCard display
- [x] Create modal preloader for HTMX content with "press any key to continue" functionality
- [x] Fix TypeScript error for TailwindHero import (if needed)
- [x] Fix TypeScript error for HTMX attributes
- [x] Refactor frontend imports to use updated directory structure and path aliases
- [x] Update import paths in boot.ts to match new dir structure (pages, components)
- [x] Verify no references to old "resources" or capitalized folder names

## Pending Tasks
- [ ] Test the ArticleCard display in browser
- [ ] Test HTMX content positioning and functionality
- [ ] Add more articles or integrate with real data source if required

## Notes
- ArticleCard component requires an `article` prop with properties: title, slug, excerpt/content, image, category, author, published_at
- Sample Slovak article data added for demonstration
- Component is now properly integrated in the main App.svelte page
- HTMX content now loads into main section below ArticleCard
- CSP updated to allow Unsplash images
