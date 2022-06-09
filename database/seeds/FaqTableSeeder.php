<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class FaqTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'key' => 'What Really Is Acne, And How Is It Caused?',
                'value' => 'Acne is a skin condition that appears as bumps on the skin. These bumps come in the form of whiteheads, blackheads, cysts, or pimples. Teenage girls are prone to pimples as they undergo hormonal changes during their puberty. Chances are even higher when your parents also had acne as teens. Pimples also result from blocked pores. The excessive production of sebum, bacteria, and dead skin cells gets trapped in the pores of the skin, thereby causing bumps on the surface of your skin. The good thing about acne is that it completely disappears by the time you are an adult.  ',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
            [
                'key' => 'What NOT to Do When You Get a Pimple',
                'value' => 'The first thing that you must prevent yourself from doing is popping a pimple. Try not to pinch, scratch, or pop it. It\'s difficult stopping yourself from doing so as it\'s kind of tempting. But know that doing this would only make your face look worse. A popped pimple leaves a lasting blemish on the skin. So trust us when we say you DO NOT have to do that! ',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
            [
                'key' => 'What You SHOULD do!',
                'value' => 'Now that we have an idea about what pimples are and how they happen let\'s also analyze some very doable tips that can help you overcome your pimple issues.',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')        
                ],
            [
                'key' => 'Foremost Step – Apply Ice To The Pimple! ',
                'value' => 'If your pimple has started to hurt a lot, then you can simmer down the pain by applying ice to it. Wrap an ice cube in a piece of cloth and place it against that particular part of the skin. If the ice is melting too quickly, then you can try it another way.  Place a couple of ice cubes in a plastic sandwich bag, and then wrap it in a cloth. ',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ], 
            [
                'key' => 'Use Turmeric and Honey  ',
                'value' => 'urmeric has anti-inflammatory, antioxidant, and antimicrobial properties. It\'s highly effective for reducing pimples\' size and the dark spots they leave behind on your face. Meanwhile, honey is good to ward off certain bacteria, and it also has antimicrobial properties. Mix them together and apply them on the affected area',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                'key' => 'Apply Crushed Aspirin To The Pimple',
                'value' => 'Aspirin includes salicylic acid, which is very beneficial in removing the dead skin and the excess oil. Crush a couple of aspirins and add a few drops of water. Mix well to form a paste. With your clean finger, dab the paste lightly on the pimple. This helps in eliminating the redness and swelling that the pimple causes. It also helps in reducing its pain and itchiness. Let it on for 10 to 15 minutes and then wash your face with lukewarm water.',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],  
                [
                'key' => 'Try the Aloe Vera Treatment: ',
                'value' => 'Aloe vera is a fruitful way to treat your pimples. Use a fresh aloe vera that is directly taken from the plant. Aloe vera helps in speeding up the recovery process of a pimple. Its anti-fungal traits help against the cysts that are produced on the skin. It\'s also proven to be effective in lightening the blemishes on the face. ',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                'key' => 'Try the Benzoyl peroxide-based treatment:',
                'value' => 'Before you begin using the specific treatment for pimples, make sure to check out the manufactured directions of the product you\'re using. You can apply this treatment (a lotion, gel, or cream) a couple of times on a daily basis until the pimple vanishes. ',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                'key' => 'Yogurt Can Help Too!',
                'value' => 'Yogurt involves lactic acid, which helps to eradicate dead skin cells. With a small brush, apply one-fourth cup of organic yogurt to your face. Leave it on for a little over 10 minutes or until it dries. Then wash off with lukewarm water.',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                
                [
                'key' => 'Hydrocortisone Cream May Do The Trick Quickly!',
                'value' => 'Hydrocortisone cream is a highly fruitful treatment when it comes to pimples. It\'s even better than cortisone injections. Simple, apply the cream to the pimple twice a day, and you\' ll have the results in no time! A precautionary tip here would be to not apply this cream too excessively or frequently. Closely follow the instructions written on the tube, and avoid its overuse.',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                
                [
                'key' => 'Use a Cleanser',
                'value' => 'Cleansing is the primary step to a fruitful skincare regime. Our skin is exposed to dust, harmful Sweet Foam Cleanser” as they wash away the excess oil giving you an invigorating feel. The kind of cleanser you use is the key factor here. If you have oily skin that you can consider UV rays, and pollution. So it is necessary that you spare some time out for cleansing your face daily. using “La Roche-Posay Effaclar Purifying Foaming Gel Cleanser” or “TONYMOLY Peach Punch ',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                'key' => 'When Heading Out in Daytime, Wear a Sunscreen',
                'value' => 'The damage done with UV skin affects your skin all year, not just in summers. All the buzz about SPF is true. SPF is important when it comes to maintaining a skincare routine. A foundation with SPF or a moisturizer that includes SPF won’t do. You’ll have to apply a sunscreen product separately. Alex Sarron, a skin therapist expert who works at Heyday says that the sun is responsible for about 90% of skin’s aging, so he recommends SPF 30 and SPF 50 as the best anti-aging product that you can buy.',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                'key' => 'Moisturize Your Skin Everyday',
                'value' => 'Skin is prone to losing hydration that keeps it healthy and plump. It’s advised that you apply a good moisturizer at least once or twice a day, in the morning and at night.',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                'key' => 'Occasionally Exfoliate Your Skin',
                'value' => 'Exfoliating your skin frees it from the dead skin that buildup and causes dullness, acne, and irritation. While exfoliating regularly is not recommended, make it a step of tour skincare regime and so it a couple of times a week.',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                
                [
                'key' => 'If Need Be, Use an Anti-Aging Product',
                'value' => 'The first few steps mentioned above are necessary to maintain healthy skin. However, in order to optimize the most basic skincare routine, you should opt to use an anti-aging product to remove the dirt and grime created by environmental aggressors.  Retinol is a great ingredient in this regard. It’s one of the very few unique ingredients that go deep into the dermis and stimulate collagen production at the origin. It also serves great help in evening out the dry lines, pore sizes, texture, and wrinkles.',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                'key' => 'Apply Vitamin C Serums',
                'value' => 'Dr. Ashley  MaGovern,  the  founder of Manhattan Dermatology, suggests using a vitamin C serum during the daytime. According to her, people of all age groups should use vitamin C serum, even people in their early 20s can do so. She states how it helps to overcome the damage done by pollution and sun rays. People with darker skin tones often face hyperpigmentation as a problem. The usage of vitamin C serum can be fruitful if used during the day to mitigate dark marks on the skin.',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                'key' => 'Use a Toner',
                'value' => 'Toner is most commonly used after the washing of the face to soften your skin. The ingredient that a toner include helps to restore nutrients and replenish your skin. It also helps against the dry patches and in diminishing the redness on the skin. Toner can be an optional product for a skin care regime.  If you do have a mind to include it in your regime, then saturate some cotton balls and dab it over your face. Apply it with clean hands.',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                'key' => 'Do Face Masks Help?',
                'value' => 'Most certainly they do! Face masks are a great way to separately address specific skin issues. Sheet masks, overnight masks, and mud masks have their own specifications and benefits. Sheet masks are helpful in hydrating your skin. Overnight masks or sleeping packs are ideal for severely dry skin or mature skin. Whereas mud masks have an exfoliating effect. They’re good for oily areas. You don’t necessarily have to apply it all over your face, only on parts of your skin that needs it.',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                'key' => 'Drink Lots of Water!',
                'value' => 'Drinking water has to be one of the most important steps in the skincare regime. Many people are so focused on products, tips, and application methods, that they forget the most significant part of the regime. Drinking lots of water helps in having clearer skin. If you really want to nail your skincare regime, then remember to drink water from time to time during your day.',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                'key' => 'The secret to Face Freshness – Wash Your Face!',
                'value' => 'Before you get your face makeup ready, splash your face with lukewarm water. Use a good face wash that suits your skin type or a cleanser that rinses away any debris. Dry your face with gentle dabs with a soft towel. ',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
            
            ];
            
            DB::table('faq')->insert($data);
    }
}
