<?php

namespace App\Http\Controllers;

use App\Category;
use App\Mailers\AppMailer;
use App\Priority;
use App\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TicketsController extends Controller
{
    const CACHE_DURATION = 86400;
    const CODE_OPEN_REQUEST_STATUS = 1;
    const CODE_CLOSED_REQUEST_STATUS = 2;
    const CODE_REOPENED_REQUEST_STATUS = 3;
    protected $categories;
    protected $priorities;
    protected $statuses;


    public function __construct()
    {
        $this->middleware('auth');
        $this->priorities = Cache::remember('priorities', self::CACHE_DURATION, function () {
            return Priority::all();
        });
        $this->categories = Cache::remember('categories', self::CACHE_DURATION, function () {
            return Category::all();
        });
        $this->statuses = Cache::remember('statuses', self::CACHE_DURATION, function () {
            return Status::all();
        });
    }

    public function index()
    {
        $assignedTicketsIds = DB::table('assigned_tickets')->pluck('ticket_id');
        $tickets = Ticket::whereNotIn('id', $assignedTicketsIds)->latest()->paginate(10);
        return view('tickets.index', [
            'tickets' => $tickets,
            'categories' => $this->categories,
            'priorities' => $this->priorities,
            'statuses' => $this->statuses,
        ]);
    }

    public function userTickets()
    {
        $tickets = Ticket::where('user_id', auth()->user()->id)->latest()->paginate(10);

        return view('tickets.user_tickets', [
            'tickets' => $tickets,
            'categories' => $this->categories,
            'priorities' => $this->priorities,
            'statuses' => $this->statuses,
        ]);
    }

    public function show($ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->first(); // получение заявки
        $ticket = DB::table('assigned_tickets')->where('ticket_id', '=', $ticket->id)->get(); // получение заявки из таблицы назначенных заявок (может не быть)
        if ($ticket->isEmpty()) {
            $ticket = Ticket::where('ticket_id', $ticket_id)->first();
        } else {
            $ticket = Ticket::where('tickets.ticket_id', $ticket_id)
                ->join('assigned_tickets', 'assigned_tickets.ticket_id', '=', 'tickets.id')
                ->join('users', 'assigned_tickets.admin_id', '=', 'users.id')
                ->select('tickets.*','users.name as assigned_to')->first();
        }
        $comments = $ticket->comments->reverse();
        $category = $ticket->category;
        $status = $ticket->status;
        return view('tickets.show', compact('ticket', 'category', 'status', 'comments'));
    }

    public function create()
    {
        return view('tickets.create', [
            'categories' => $this->categories,
            'priorities' => $this->priorities
        ]);
    }

    public function store(Request $request, AppMailer $mailer)
    {
        $this->validate($request, [
            'title'     => 'required',
            'category'  => 'required',
            'priority'  => 'required',
            'message'   => 'required'
        ]);

        $ticket = new Ticket([
            'title'     => $request->input('title'),
            'user_id'   => auth()->user()->id,
            'ticket_id' =>  $this->getLatestIncrementedTicketId(),
            'category_id'  => $request->input('category'),
            'priority_id'  => $request->input('priority'),
            'status_id'    => static::CODE_OPEN_REQUEST_STATUS,
            'message'   => $request->input('message'),
        ]);

        $ticket->save();

        $mailer->sendTicketInformation(Auth::user(), $ticket);

        return redirect('/requests')->with("status", "Заявка с идентификатором: #$ticket->ticket_id успешно создана.");
    }

    public function close($ticket_id, AppMailer $mailer)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
        $ticket->status_id = static::CODE_CLOSED_REQUEST_STATUS;
        $ticket->save();
        $ticketOwner = $ticket->user;
        $mailer->sendTicketStatusNotification($ticketOwner, $ticket);
        return redirect()->back()->with("status", "Заявка успешно закрыта.");
    }

    public function reOpen($ticket_id, AppMailer $mailer)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
        $ticket->status_id = static::CODE_REOPENED_REQUEST_STATUS;
        $ticket->save();
        $ticketOwner = $ticket->user;
        $mailer->sendTicketStatusNotification($ticketOwner, $ticket);
        return redirect()->back()->with("status", "Заявка успешно переоткрыта.");
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $searchResults = Ticket::where('ticket_id', 'like', '%' . $query . '%')->paginate(10);
        return view('tickets.search', [
            'searchResults' => $searchResults,
            'categories' => $this->categories,
            'priorities' => $this->priorities,
            'statuses' => $this->statuses
        ]);
    }

    public function assign($ticket_id)
    {
        DB::table('assigned_tickets')->insert(['admin_id' => auth()->user()->id, 'ticket_id' => $ticket_id, 'created_at' => Carbon::now()]);
        return redirect()->route('requests.assigned')->with("status", "Заявка была успешно назначена на Вас.");
    }

    public function assignedTickets()
    {
        $assignedTicketsIds = DB::table('assigned_tickets')->where('admin_id', '=', auth()->user()->id)->pluck('ticket_id');
        $assignedTickets = Ticket::whereIn('tickets.id', $assignedTicketsIds)
                                    ->join('priorities', 'tickets.priority_id', '=', 'priorities.id')
                                    ->orderByDesc('priorities.weight')
                                    ->select('tickets.*')
                                    ->paginate(10);

        return view('tickets.assigned_tickets', [
            'assignedTickets' => $assignedTickets,
            'categories' => $this->categories,
            'priorities' => $this->priorities,
            'statuses' => $this->statuses
        ]);
    }

    /**
     * Получает последнюю заявку, берёт её id и увеличивает его на 1. Возвращает увеличенный id
     * @return string
     */
    private function getLatestIncrementedTicketId()
    {
        $latestTicket = Ticket::latest('created_at')->first();
        if (!$latestTicket) {
            return 'SD10000';
        }
        $latestTicketId = $latestTicket->ticket_id;
        $incrementedId = substr($latestTicketId, 2, strlen($latestTicketId)) + 1;
        return 'SD' . $incrementedId;
    }

}
