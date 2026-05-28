<?php

namespace App\Console\Commands;

use App\Models\Commerce;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GeocodeCommerces extends Command
{
    protected $signature = 'commerces:geocode';
    protected $description = 'Geocode all commerces that lack coordinates';

    public function handle()
    {
        $commerces = Commerce::whereNull('latitude')->orWhereNull('longitude')->get();

        if ($commerces->isEmpty()) {
            $this->info('All commerces already have coordinates.');
            return;
        }

        $count = 0;
        foreach ($commerces as $commerce) {
            $this->line("Geocoding: {$commerce->name} - {$commerce->address}");

            $response = Http::withHeaders([
                'User-Agent' => 'DroneDropApp/1.0',
            ])->get('https://nominatim.openstreetmap.org/search', [
                'q' => $commerce->address . ', Bucaramanga, Colombia',
                'format' => 'json',
                'limit' => 1,
            ]);

            if ($response->successful() && count($response->json()) > 0) {
                $result = $response->json()[0];
                $commerce->update([
                    'latitude' => $result['lat'],
                    'longitude' => $result['lon'],
                ]);
                $this->info("  ✓ {$result['lat']}, {$result['lon']}");
                $count++;
            } else {
                $this->warn("  ✗ Could not geocode");
            }

            sleep(1);
        }

        $this->info("Done. {$count} commerces geocoded.");
    }
}
