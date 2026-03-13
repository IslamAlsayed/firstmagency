<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    /**
     * Return HTML for a ticket row to be inserted dynamically
     */
    public function getRowHtml($id)
    {
        try {
            Log::info('Fetching ticket row for ID: ' . $id);

            $ticket = Ticket::with(['messages'])->findOrFail($id);

            Log::info('Ticket found: ' . $ticket->id);

            $html = view('dashboard.components.ticket-row', [
                'ticket' => $ticket
            ])->render();

            Log::info('Row HTML rendered successfully');

            return response()->json([
                'success' => true,
                'html' => $html
            ], 200, [], JSON_UNESCAPED_SLASHES);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Ticket not found: ' . $id);
            return response()->json([
                'success' => false,
                'error' => 'Ticket not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error fetching ticket row: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
