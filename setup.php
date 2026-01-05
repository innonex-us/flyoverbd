#!/usr/bin/env php
<?php

/**
 * Setup Script
 *
 * This script runs database migrations and creates the storage link.
 * Usage: php setup.php
 */

use Illuminate\Foundation\Application;

define('LARAVEL_START', microtime(true));

// Register the Composer autoloader
require __DIR__.'/vendor/autoload.php';

// Bootstrap Laravel
/** @var Application $app */
$app = require_once __DIR__.'/bootstrap/app.php';

// Set the application instance
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "Starting setup...\n\n";

// Run migrations
echo "Running database migrations...\n";
try {
    $kernel->call('migrate', ['--force' => true]);
    echo "✓ Migrations completed successfully.\n\n";
} catch (Exception $e) {
    echo '✗ Migration failed: '.$e->getMessage()."\n";
    exit(1);
}

// Create storage link
echo "Creating storage link...\n";
try {
    $kernel->call('storage:link');
    echo "✓ Storage link created successfully.\n\n";
} catch (Exception $e) {
    // Check if link already exists
    if (str_contains($e->getMessage(), 'already exists')) {
        echo "ℹ Storage link already exists.\n\n";
    } else {
        echo '✗ Storage link creation failed: '.$e->getMessage()."\n";
        exit(1);
    }
}

echo "Setup completed successfully!\n";
exit(0);
