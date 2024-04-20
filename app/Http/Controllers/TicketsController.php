<?php

namespace App\Http\Controllers;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Http\Requests\Tickets\CreateTicketRequest;
use App\Models\Core;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = QueryBuilder::for(Ticket::class)
            ->with('user')
            ->orderBy('created_at', 'DESC')
            ->allowedFilters([
                'user_id',
                'title',
                'priority',
                'status',
                AllowedFilter::scope('submitted_from'),
                AllowedFilter::scope('submitted_to')
            ])->paginate(Core::ITEMS_PER_PAGE);

        return inertia('Tickets/Index', [
            'tickets' => $tickets,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Tickets/CreateTicket');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTicketRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = auth()->id();

        Ticket::create($data);

        return redirect()->route('tickets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ticket = Ticket::with('user', 'responses')->findOrFail($id);
        return inertia('Tickets/Show', [
            'ticket' => $ticket,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();
        return redirect()->route('tickets.index');
    }
}
