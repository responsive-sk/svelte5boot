import { readdirSync, readFileSync } from "fs";
import { join, extname } from "path";

const islandsDir = "frontend/src/lib/components/islands";
const templatesDir = "templates";

function getIslands() {
  return readdirSync(islandsDir)
    .filter((file) => extname(file) === ".svelte")
    .map((file) => file.replace(/\.svelte$/, ""));
}

function getTemplateFiles(dir) {
  let results = [];
  for (const file of readdirSync(dir, { withFileTypes: true })) {
    const fullPath = join(dir, file.name);
    if (file.isDirectory()) {
      results = results.concat(getTemplateFiles(fullPath));
    } else if (file.name.endsWith(".twig")) {
      results.push(fullPath);
    }
  }
  return results;
}

function findUsage(component, templates) {
  const regex = new RegExp(`data-component=["']${component}["']`, "i");
  return templates.some((file) => regex.test(readFileSync(file, "utf8")));
}

const islands = getIslands();
const templates = getTemplateFiles(templatesDir);

console.log("🔍 Kontrola islands komponentov...\n");

let unused = [];

for (const component of islands) {
  if (findUsage(component, templates)) {
    console.log(`✅ ${component} → použitý`);
  } else {
    console.log(`⚠️  ${component} → nepoužívaný (žiadny mount point v šablónach)`);
    unused.push(component);
  }
}

if (unused.length) {
  console.log("\n📋 Nepoužívané komponenty:");
  unused.forEach((c) => console.log(` - ${c}.svelte`));
  console.log("\n💡 Môžeš ich odstrániť alebo pridať mount point.");
} else {
  console.log("\n🎉 Všetky islands komponenty sú použité!");
}
