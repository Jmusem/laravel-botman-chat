<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()


    {

         DB::table('faqs')->insert([
            [
                'question' => 'hi',
                'answer'   => 'Hello! How can I assist you today?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        
         
            [
                'question' => 'What is your refund policy?',
                'answer'   => 'We offer a 30-day refund guarantee. See our Refund Policy page.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'How long does delivery take?',
                'answer'   => 'Delivery typically takes 3–5 business days depending on your location.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Where is my order?',
                'answer'   => 'You can track your order in your account dashboard under "My Orders".',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Make Payment',
                'answer'   => 'Use our secure checkout with MPesa, PayPal or card.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
         [
                'question' => 'Reset Password',
                'answer'   => 'Go to Settings > Account > Reset Password.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Check Email',
                'answer'   => 'Open your inbox and check for our confirmation email.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

         
         [
                'question' => 'Check Order',
                'answer'   => 'Open your inbox and check for our confirmation email',
                'created_at' => now(),
                'updated_at' => now(),
            ], 
        [
                'question' => 'hello',
                'answer'   => 'Hi there! What can I help you with?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'hey',
                'answer'   => 'Hey! Need assistance with something?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'bye',
                'answer'   => 'Goodbye! Have a great day!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'goodbye',
                'answer'   => 'Take care! We’re here if you need help.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'how to reset my password',
                'answer'   => 'You can reset your password by clicking on "Forgot Password" on the login page.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'I forgot my password',
                'answer'   => 'No worries! Use the "Forgot Password" link to reset it.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'how do I contact support?',
                'answer'   => 'You can reach support at support@example.com or via our contact page.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'how to update my email address',
                'answer'   => 'Go to your profile settings and update your email address.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'can I delete my account?',
                'answer'   => 'Yes, please go to Settings > Delete Account.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'how do I change my username?',
                'answer'   => 'Unfortunately, changing your username is not currently supported.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'what is your refund policy?',
                'answer'   => 'We offer a 30-day refund guarantee. See our Refund Policy page.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'how long does delivery take?',
                'answer'   => 'Delivery typically takes 3–5 business days depending on your location.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'where is my order?',
                'answer'   => 'You can track your order in your account dashboard under "My Orders".',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'how do I report a bug?',
                'answer'   => 'Email us at bugs@example.com with details of the issue.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'do you have a mobile app?',
                'answer'   => 'Yes! Download it from the App Store or Google Play.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'how do I change my password?',
                'answer'   => 'Go to Account Settings > Security to update your password.',
                'created_at' => now(),
                'updated_at' => now(),
            ],



             [
        'question' => 'habari',
        'answer'   => 'Habari! Naweza kukusaidia vipi leo?',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'question' => 'sera ya kurejesha pesa ni ipi?',
        'answer'   => 'Tunatoa dhamana ya kurejesha pesa ndani ya siku 30. Tafadhali angalia ukurasa wa Sera ya Marejesho.',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'question' => 'utapokea agizo lini?',
        'answer'   => 'Uwasilishaji huchukua siku 3–5 za kazi kutegemea na eneo lako.',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'question' => 'agizo langu liko wapi?',
        'answer'   => 'Unaweza kufuatilia agizo lako kupitia dashibodi ya akaunti yako chini ya "Maagizo Yangu".',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'question' => 'fanya malipo',
        'answer'   => 'Tumia sehemu yetu salama ya malipo kwa MPesa, PayPal au kadi.',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'question' => 'weka upya nenosiri',
        'answer'   => 'Nenda kwa Mipangilio > Akaunti > Weka upya Nenosiri.',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'question' => 'angalia barua pepe',
        'answer'   => 'Fungua kikasha chako na uangalie ujumbe wa uthibitisho kutoka kwetu.',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'question' => 'angalia agizo',
        'answer'   => 'Fungua kikasha chako na uangalie ujumbe wa uthibitisho kutoka kwetu.',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'question' => 'hujambo',
        'answer'   => 'Hujambo! Nitaweza kukusaidia na nini leo?',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'question' => 'vipi',
        'answer'   => 'Vipi! Unahitaji msaada wa aina gani?',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'question' => 'kwaheri',
        'answer'   => 'Kwaheri! Kuwa na siku njema!',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'question' => 'tutaonana',
        'answer'   => 'Kwaheri! Tuko hapa kukusaidia wakati wowote.',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'question' => 'ninawezaje kuweka upya nenosiri langu?',
        'answer'   => 'Bofya "Umesahau Nenosiri" kwenye ukurasa wa kuingia ili kuweka upya nenosiri lako.',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'question' => 'nimesahau nenosiri langu',
        'answer'   => 'Hakuna shida! Tumia kiungo cha "Umesahau Nenosiri" ili kukiweka upya.',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'question' => 'nawezaje kuwasiliana na msaada?',
        'answer'   => 'Unaweza kuwasiliana nasi kwa support@example.com au kupitia ukurasa wa mawasiliano.',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'question' => 'nawezaje kubadilisha barua pepe yangu?',
        'answer'   => 'Nenda kwenye mipangilio ya wasifu wako na uweke barua pepe mpya.',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'question' => 'naweza kufuta akaunti yangu?',
        'answer'   => 'Ndiyo, nenda kwenye Mipangilio > Futa Akaunti.',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'question' => 'nawezaje kubadilisha jina langu la mtumiaji?',
        'answer'   => 'Samahani, kwa sasa huwezi kubadilisha jina la mtumiaji.',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'question' => 'nawezaje kuripoti hitilafu?',
        'answer'   => 'Tuma barua pepe kwa bugs@example.com na maelezo ya hitilafu hiyo.',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'question' => 'una programu ya simu?',
        'answer'   => 'Ndiyo! Pakua kutoka App Store au Google Play.',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'question' => 'nawezaje kubadilisha nenosiri langu?',
        'answer'   => 'Nenda kwa Mipangilio ya Akaunti > Usalama kubadilisha nenosiri lako.',
        'created_at' => now(),
        'updated_at' => now(),
    ],

         ]);

        //
    }
}

