#!/bin/bash

# Verification script to check if migration files are correctly updated on server

echo "=== Checking Migration Files ==="
echo ""

# Check password_reset_tokens migration
echo "1. Checking password_reset_tokens migration..."
if grep -q "string('email', 191)->primary()" database/migrations/0001_01_01_000000_create_users_table.php; then
    echo "   ✓ password_reset_tokens.email is correctly set to 191"
else
    echo "   ✗ ERROR: password_reset_tokens.email is NOT set to 191"
    echo "   Current line:"
    grep "string('email'" database/migrations/0001_01_01_000000_create_users_table.php
fi
echo ""

# Check sessions migration
echo "2. Checking sessions migration..."
if grep -q "string('id', 191)->primary()" database/migrations/0001_01_01_000000_create_users_table.php; then
    echo "   ✓ sessions.id is correctly set to 191"
else
    echo "   ✗ ERROR: sessions.id is NOT set to 191"
fi
echo ""

# Check cache migrations
echo "3. Checking cache migrations..."
if grep -q "string('key', 191)->primary()" database/migrations/0001_01_01_000001_create_cache_table.php; then
    echo "   ✓ cache.key is correctly set to 191"
else
    echo "   ✗ ERROR: cache.key is NOT set to 191"
fi
echo ""

# Check job_batches migration
echo "4. Checking job_batches migration..."
if grep -q "string('id', 191)->primary()" database/migrations/0001_01_01_000002_create_jobs_table.php; then
    echo "   ✓ job_batches.id is correctly set to 191"
else
    echo "   ✗ ERROR: job_batches.id is NOT set to 191"
fi
echo ""

# Check AppServiceProvider
echo "5. Checking AppServiceProvider..."
if grep -q "Schema::defaultStringLength(191)" app/Providers/AppServiceProvider.php; then
    echo "   ✓ AppServiceProvider has defaultStringLength(191)"
else
    echo "   ✗ ERROR: AppServiceProvider does NOT have defaultStringLength(191)"
fi
echo ""

echo "=== Verification Complete ==="

