<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CommerceController extends Controller
{
    public function updateStatus(Request $request, Order $order)
{
    $order->update(['status' => $request->status]);
    return redirect()->route('commerce.orders')->with('status', 'Pedido actualizado correctamente.');
}
    public function index(Request $request)
    {
        $query = Commerce::query();
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $commerces = $query->get();
        return view('commerce.index', compact('commerces'));
    }

    public function show(Commerce $commerce)
    {
        $products = $commerce->products()->where('is_available', true)->get();
        return view('commerce.show', compact('commerce', 'products'));
    }

    public function edit()
    {
        $commerce = auth()->user()->commerces()->firstOrCreate(
            ['user_id' => auth()->id()],
            ['name' => auth()->user()->name, 'address' => 'Not set']
        );
        return view('commerce.edit', compact('commerce'));
    }

    public function update(Request $request)
    {
        $commerce = auth()->user()->commerces()->first();
        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'opening_time' => 'nullable|date_format:H:i',
            'closing_time' => 'nullable|date_format:H:i',
        ]);

        $data = $request->only('name', 'address', 'opening_time', 'closing_time');

        if ($request->address !== $commerce->address) {
            $coords = $this->geocode($request->address);
            if ($coords) {
                $data['latitude'] = $coords['lat'];
                $data['longitude'] = $coords['lng'];
            }
        }

        $commerce->update($data);

        return redirect()->route('commerce.dashboard')->with('status', 'Profile updated!');
    }

    private function geocode(string $address): ?array
    {
        $response = Http::withHeaders([
            'User-Agent' => 'DroneDropApp/1.0',
        ])->get('https://nominatim.openstreetmap.org/search', [
            'q' => $address . ', Bucaramanga, Colombia',
            'format' => 'json',
            'limit' => 1,
        ]);

        if ($response->successful() && count($response->json()) > 0) {
            $result = $response->json()[0];
            return [
                'lat' => $result['lat'],
                'lng' => $result['lon'],
            ];
        }

        return null;
    }
}
