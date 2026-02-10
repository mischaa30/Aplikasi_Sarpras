<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Sarpras;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking sarpras table columns:\n";
$columns = Schema::getColumnListing('sarpras');
print_r($columns);

echo "\nChecking sarpras_item table columns:\n";
$columnsItem = Schema::getColumnListing('sarpras_item');
print_r($columnsItem);

$sarpras = Sarpras::first();
if ($sarpras) {
    echo "\nFirst Sarpras stok: " . $sarpras->stok . "\n";
} else {
    echo "\nNo Sarpras found.\n";
}
