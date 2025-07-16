<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SwaFaqsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('faqs')->insert([
            [
                'question' => 'habari',
                'answer'   => 'Habari! Naweza kukusaidia vipi leo?',
                'language' => 'sw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'niaje',
                'answer'   => 'Poa sana! Una swali lolote?',
                'language' => 'sw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'hello',
                'answer'   => 'Habari! Naweza kukusaidia leo?',
                'language' => 'sw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'hey',
                'answer'   => 'Hey! Unaweza kuniambia jinsi ninavyoweza kusaidia?',
                'language' => 'sw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'kwaheri',
                'answer'   => 'Kwaheri! Kuwa na siku nzuri!',
                'language' => 'sw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'bye',
                'answer'   => 'Kwaheri! Tutaonana tena!',
                'language' => 'sw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'sera yenu ya kurejesha pesa ni ipi?',
                'answer'   => 'Tunatoa dhamana ya kurejesha pesa ndani ya siku 30. Tafadhali angalia ukurasa wetu wa sera ya kurejesha kwa maelezo zaidi.',
                'language' => 'sw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'je, naweza kurudisha bidhaa?',
                'answer'   => 'Ndiyo, unaweza kurudisha bidhaa ndani ya siku 30 kukidhi masharti yetu ya marejesho.',
                'language' => 'sw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'unasafirisha kwa muda gani?',
                'answer'   => 'Usafirishaji huchukua siku 3–5 za kazi kulingana na eneo lako.',
                'language' => 'sw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'oda yangu iko wapi?',
                'answer'   => 'Tafuta oda yako kwenye dashibodi yako chini ya sehemu ya "Oda Zangu".',
                'language' => 'sw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'je, mna nyongeza ya siku za haraka?',
                'answer'   => 'Ndiyo, tuna chaguo la usafirishaji wa haraka kwa ada ndogo.',
                'language' => 'sw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'fanya malipo',
                'answer'   => 'Tumia njia zetu salama za malipo: MPesa, PayPal, au malipo ya kadi.',
                'language' => 'sw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'je, MPesa inafanya kazi?',
                'answer'   => 'Ndiyo, MPesa inakubaliwa na ni salama na rahisi kutumia.',
                'language' => 'sw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'nataka kubadilisha nenosiri langu',
                'answer'   => 'Nenda kuelekea Mipangilio > Akaunti > Badilisha Nenosiri.',
                'language' => 'sw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'nimesahau nenosiri langu',
                'answer'   => 'Tumia kiungo cha "Nimesahau Nenosiri" kwenye ukurasa wa kuingia kupokea barua pepe kwa kubadilisha.',
                'language' => 'sw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'je, ninawezaje kuwasiliana na msaada?',
                'answer'   => 'Tafadhali tuma barua pepe kwa support@example.com au tembelea ukurasa wetu wa kuwasiliana.',
                'language' => 'sw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'nataka kusasisha barua pepe yangu',
                'answer'   => 'Nenda kwa mipangilio ya wasifu na ubadilishe anwani yako ya barua pepe.',
                'language' => 'sw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'naweza kufuta akaunti yangu?',
                'answer'   => 'Ndiyo, unaweza kufuta akaunti yako kwenye Mipangilio > Futa Akaunti.',
                'language' => 'sw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'je, ninaweza kubadilisha jina langu la mtumiaji?',
                'answer'   => 'Samahani, kwa wakati huu haziwezi kubadilishwa.',
                'language' => 'sw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'nataka kuripoti hitilafu',
                'answer'   => 'Tafadhali tuma maelezo ya hitilafu kwa bugs@example.com.',
                'language' => 'sw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'mna programu ya simu?',
                'answer'   => 'Ndiyo! Pakua programu yetu kwenye App Store au Google Play.',
                'language' => 'sw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'je, kuna nyongeza za msaada wa lugha?',
                'answer'   => 'Tunasaidia Kiingereza na Kiswahili. Lete ongezeko jipya.',
                'language' => 'sw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'napenda kujua kuhusu bidhaa zenu',
                'answer'   => 'Tafadhali eleza unavyotaka kujua – tuna furaha kukusaidia!',
                'language' => 'sw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
