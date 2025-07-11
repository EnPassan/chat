<?php

namespace App\Http\Controllers;

use App\Models\ChatHistory;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{
    private Client $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chatHistories = ChatHistory::query()->where("user_id", auth()->id())->limit((20))->orderBy("created_at")->orderBy("id")->get();
        return Inertia::render('Chat',[
            'chatHistories' => $chatHistories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    private function generateChatPrompt(string $message): string {
        $a = ChatHistory::query()->orderBy("id",'asc')->get();
        // dd($a);
        $prompt = [
            "History" => [
                
            ]
        ];

        foreach($a as $msg) {
            $entry = [
                'author' => $msg->author,
                'message' => $msg->message_body
            ];
            $prompt["History"][] = $entry;
            
        }
        dd($prompt);
        // $prompt = [
        //     "History" => [
        //         [
        //             'author' => 'user_id',
        //             'message' => 'message_body'
        //         ],
        //     ]
        // ];
        return 'You are a tennis player, the following is a chat between you and the other user. Your replies will be from author "llm", and the user will be from author "user". The last message in the history is the one you need to reply to.' . json_encode($prompt);
    }

    private function generateChessPrompt(): string{
        return 'You are a chess master, you are guiding a chess player helping them understand what moves to make and why, expand. Below is the current history of moves given in chess move notation, the chess player needs to make the next move, and is playing as black: Nf3 d5 d4 Nf6 c4';
    }

    private function generateFullPrompt(): string{
        $entry = 'You are a chess master, you are guiding a chess player helping them understand what moves to make and why, be concise. Below is the current history of moves given in chess move notation, the chess player needs to make the next move, and is playing as black:';
        $h = ChatHistory::query()->where('author', 'user')->orderBy('id','asc')->get();
        foreach($h as $msg) {
            $entry = $entry . ' ' .  $msg->message_body;
        }
        return $entry;
    }

    

    
    // Store a newly created resource in storage.
    
    public function store(Request $request)
    {
        $validate = $request->validate([
            'message_body' => 'required|string'
        ]);
        ChatHistory::create([
            'author' => 'user',
            'user_id' => auth()->id(),
            'message_body' =>$request->get('message_body')
        ]);

        $payload = json_encode([
            "model" => "gpt-4o",
            "input" => $this->generateFullPrompt()
        ]);

        $headers = [
            'Accept'=>'application/json',
            'Content-Type'=>'application/json',
            'Authorization'=>'Bearer ' . env("CHATGPT_KEY") 
        ];
        $request = new GuzzleRequest("POST", "https://api.openai.com/v1/responses", $headers);

        $res = $this->httpClient->send($request,[
            'body' => $payload
        ]);

        $text = json_decode($res->getBody(), true);
        // dd($text["output"]);
        $reply = $text["output"][0]["content"][0]["text"];
         
        // dd($reply);
        // $res = $this->httpClient->request("POST", "https://api.openai.com/v1/responses",[
        //     'headers' => $headers, 
        //     'body' => $payload
        // ]);

    
        ChatHistory::create([
            'author' => 'llm',
            'user_id' => auth()->id(),
            'message_body' => nl2br($reply)
        ]);
        return redirect()->to("chat");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }
}
