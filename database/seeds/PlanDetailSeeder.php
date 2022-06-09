<?php

use Illuminate\Database\Seeder;
use App\PlanDetail;

class PlanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     
     $data = array(
            array('plan_type' => 'free','plan_for'=>'both','main_title'=> 'Just starting out? Well, try the free version to help you get going. You can upgrade at any point you like to boost your visibility to hundreds of customers.', 'title'=>'Free Version','description'=>'Access a limited audience to begin your journey to become a top-rated artist on WamGlamz','advantages' => 'For new users/beginners,No subscription charges,Exposure to a small amount of audience,11% per service charges (standard)','created_at' => date('Y-m-d H:i:s')),
            array('plan_type' => 'vip','plan_for'=>'artist', 'main_title'=> 'Register as a VIP member to appear in the top ratings, maximizing your chances of becoming a client favorite.','title'=>'VIP Version','description'=>'Chose your desired subscription package and steal the show.','advantages' => 'For just $25 per month you can appear in the top-10 listing in your selected category.,For just $50 per month you can appear in the top-5 listing in your selected category.,Maximize your chances of securing top clients and becoming a fan-favorite, increasing your ranking on the platform.,The more you rank the more you do business, the more you earn! 11% per service charge (standard)','creared_at'=>date('Y-m-d H:i:s')),
            array('plan_type' => 'silver','plan_for'=>'client','main_title'=> 'Register as a silver member for one week to access a limited number of artists in your desired category.', 'title'=>'Silver Membership','description'=>'Register for as low as $9 for the duration of 1-week and view up to 10 listings.','advantages' => 'Send unlimited messages to the artist of your selected category,Access of seven days at a mere $9, highly economical for short-term users,See a listing of 10 artists in your desired category,Always have the option to upgrade to the Silver 1-month membership.','creared_at'=> date('Y-m-d H:i:s')),
            array('plan_type' => 'silver_plus','plan_for'=>'client','main_title'=> 'Register as a silver member for one month to access a great number of artists in your desired category.', 'title'=>'Silver Membership (1-Month)','description'=>'Register for as low as $24 for the duration of 1-month ($6 per week) and view up to 20 listings.','advantages' => 'Send unlimited messages to the artist of your selected category,Access of one month (30 days) at a mere $6 per week, highly economical for long-term users,See a listing of 20 artists in your desired category,Always have the option to upgrade to the Gold 3-months membership.','creared_at'=> date('Y-m-d H:i:s')),
            
            array('plan_type' => 'gold','plan_for'=>'client','main_title'=> 'Register as a gold member to access a greater number of artists in your desired category.', 'title'=>'Gold Membership','description'=>'Register for as low as $20 per month for the duration of 3 months and view up to 50 listings.','advantages' => 'Send unlimited messages to the artist of your selected category,Access of 3 months with one free week at a mere $20 per month, highly suitable for long-term users like professionals (media personnel, models, artists, actors, etc.),See a listing of 50 artists in your desired category,Always have the option to upgrade to the platinum 6-month membership.','creared_at'=> date('Y-m-d H:i:s')),
            
            array('plan_type' => 'platinum','plan_for'=>'client','main_title'=> 'Register as a VIP Platinum member to access the highest number of artists in your desired category.','title' => 'Platinum Membership (VIP)','description' => 'Register for as low as $16.5 per month for the duration of 6 months and view up to 70+ listings.','advantages' => 'Send unlimited messages to the artist of your selected category,Access of 6 months at a mere $16.5 per month, highly suitable for long-term users like professionals (media personnel, models, artists, actors, etc.),See a listing of 70+ artists in your desired category,Access all the top-rated service categories with 4+ star ratings,Best package available','creared_at'=> date('Y-m-d H:i:s'))
           );
         
        //   dd($data);
           DB::table('plan_details')->insert($data);
    }
}
