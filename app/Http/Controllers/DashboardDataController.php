<?php

namespace App\Http\Controllers;

use App\Models\BlacklistPhone;
use App\Models\Client;
use App\Models\Promotion;
use Illuminate\Http\JsonResponse;

class DashboardDataController
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'promotions' => Promotion::count(),
            'all_guests' => Client::count(),
            'local_guests' => Client::where('status', Client::GUEST_TYPE_LOCAL)->count(),
            'in_house_guests' => Client::where('status', Client::GUEST_TYPE_IN_HOUSE)->count(),
            'magazines' => Promotion::where('type', Promotion::TYPE_MAGAZINE)->count(),
            //'email_sent' => BroadcastDetails::whereNotNull('email_delivery_status')->count(),
            //'sms_sent' => BroadcastDetails::whereNotNull('sms_delivery_status')->count(),
            //'broadcast' => Broadcast::count(),
            'blacklisted_phones' => BlacklistPhone::count(),
        ]);
    }
}
