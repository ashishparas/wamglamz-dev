<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Mail\ReminderMail;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;

    class Reminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:appointment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is using for send appointment reminder to the client & artist';

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
     * @return mixed
     */
    public function handle()
    {
       
     
         $bookings = \App\Booking::select('id','customer_id','artist_id','date','from')->with('user_details')->get();
            // dd($bookings->toArray());
    
            
            
         foreach($bookings as $booking):
          
            $to =   \Carbon\Carbon::createFromFormat('Y-m-d h:i a',  $booking->date.' '.$booking->from); //  $booking->date.' '.$booking->from  '2022-01-06 06:00 pm'
            $from = \Carbon\Carbon::createFromFormat('Y-m-d h:i a', Carbon::now()->format('Y-m-d h:i a'));
            // dd(Carbon::now()->format('Y-m-d h:i a'));
            $diff_in_hours = $to->diffInHours($from);
        
            // dd($diff_in_hours);
            
            if($diff_in_hours == "24"):
                \Log::info("Reminder Cron is working fine!");
           
                $data   = "Cron test mail";
                $Client =  \App\User::select('id','email')->where('id', $booking->customer_id)->first();
                
                $client_mail =  Mail::to($Client->email)->send(new ReminderMail($data));
                
                
            //   below mail sending to Artist reminder
                $availability = \App\Availability::where('user_id',$booking->artist_id)->first();
                if($availability->availability === '1'):
                    
                    $message = 'Hi ('.$booking->user_details->fname.' '.$booking->user_details->fname.'). This is a friendly reminder for your appointment at '.$booking->from.' on '.$booking->date.'. Please make sure to be available on the scheduled time  to avoid any last minute inconvenience .';
                    elseif($availability->availability === '2'):
                       $message ='Hi ('.$booking->user_details->fname.' '.$booking->user_details->fname.'). This is a friendly reminder for your appointment at '.$booking->from.' on '.$booking->date.'. Please make sure to reach on time to avoid any last minute inconvenience . '; 
                        endif;
                
               
                $mail = Mail::to($booking->user_details->email)->send(new ReminderMail($message));
                // self::sendTextMessage($message,'9817405368');
                // send Text Message
                
                
                       
             else:
                  \Log::info("mail not sending");
                    endif;
              
             
             endforeach;
      
            $this->info('reminder:appointment Command Run successfully!');
    }
    
    
    
    
    
    // protected static function sendTextMessage($message, $to = '9817405368') {
    //     try {
    //         $sid = env('TWILIO_SID');
    //         $token = env('TWILIO_TOKEN');
    //         // dd($sid);
    //         $twilio = new Client($sid, $token);
        
    //         //$return = $twilio->messages->create("" . $to, ["body" => $message, "from" => env('TWILIO_FROM')]);
    //         $return = $twilio->messages->create("+91" . $to, ["body" => $message, "from" => env('TWILIO_FROM')]);
    //         // dd($return);
    //         // return $return;
    //     } catch (\Twilio\Exceptions\TwilioException $ex) {
    //         dd($ex->getMessage());
    //         return true;
    //     }
    // }
    
}
