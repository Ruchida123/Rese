<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Reservation;
use Carbon\Carbon;

class SendReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails to users on the day of their reservation';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // 日付取得
        $today = Carbon::today('Asia/Tokyo');

        // 予約当日のデータを取り出す。
        $reserves = Reservation::with('user', 'shop')->DateSearch($today)->get();

        //メール送信をする
        foreach ($reserves as $reserve) {
            // メール本文
            $body = '予約当日となりました。予約時間は '.substr($reserve->time, 0, 5).' 時です。';

            Mail::raw($body, function ($message) use ($reserve) {
                $message->to($reserve->user->email)->subject('【'.$reserve->shop->name.'】ご予約確認');
            });
        }
    }
}
