#!/usr/bin/env bash
set -e

# Nastavenie ciest
OLD_DIR="frontend/src/lib/islands"
NEW_DIR="frontend/src/lib/components/islands"

echo "🔍 Kontrolujem priečinky..."
if [ ! -d "$OLD_DIR" ]; then
  echo "❌ Nenájdený priečinok: $OLD_DIR"
  exit 1
fi

mkdir -p "$NEW_DIR"

echo "📦 Presúvam .svelte súbory z $OLD_DIR do $NEW_DIR ..."
find "$OLD_DIR" -type f -name "*.svelte" -exec mv -v {} "$NEW_DIR"/ \;

echo "🧹 Odstraňujem prázdny priečinok $OLD_DIR ..."
rmdir "$OLD_DIR" || echo "⚠️ Priečinok nie je prázdny, skontroluj manuálne."

echo "✍️ Prepisujem importy vo všetkých súboroch..."
# Nájde všetky TS/JS/Svelte/Twig súbory a prepíše importy
grep -rl "$OLD_DIR" frontend/ | while read -r file; do
  sed -i "s|$OLD_DIR|$NEW_DIR|g" "$file"
done

echo "✅ Migrácia hotová!"
echo "ℹ️ Skontroluj a spusti build: npm run dev alebo npm run build"
