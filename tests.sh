#!/usr/bin/env bash
set -e

echo "🧪 Generujem Vitest testy pre projekt..."

BASE_DIR="src"
TEST_DIR="tests"

# Funkcia na vytvorenie placeholder testu
create_test() {
  local src_file="$1"
  local test_file="$2"
  local rel_path="${src_file#"$BASE_DIR/"}"

  mkdir -p "$(dirname "$test_file")"

  cat > "$test_file" <<EOL
import { describe, it, expect } from 'vitest';
import * as moduleUnderTest from '@/$rel_path';

describe('$rel_path', () => {
  it('should have placeholder test', () => {
    expect(moduleUnderTest).toBeDefined();
  });
});
EOL

  echo "✅ Test created: $test_file"
}

# Vyčisti staré placeholder testy
rm -rf "$TEST_DIR"
mkdir -p "$TEST_DIR"

# Rekurzívne pre každý JS súbor v src
find "$BASE_DIR" -name "*.js" | while read -r src_file; do
  # Odstráni "src/" a pridá "tests/" a .test.js
  test_file="$TEST_DIR/${src_file#$BASE_DIR/}"
  test_file="${test_file%.js}.test.js"
  create_test "$src_file" "$test_file"
done

echo "🎉 Všetky placeholder testy sú pripravené!"
