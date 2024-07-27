<?php

namespace Database\Seeders;

use App\Models\Faqs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the FAQ data
        $faqs = [
            [
                'question' => 'What is the INGO Forum?',
                'answer' => 'The INGO Forum is a platform for International Non-Governmental Organizations (INGOs) working in Bangladesh. It facilitates information exchange, collaboration, and advocacy to improve the effectiveness of INGOs in the country.',
                'added_by' => 1, // Replace with an existing admin ID
                'status' => 1,
            ],
            [
                'question' => 'How can my organization join the INGO Forum?',
                'answer' => 'The INGO Forum welcomes all INGOs operating in Bangladesh. While there\'s no formal application process, you can express your interest by reaching out to a current member or attending a meeting.',
                'added_by' => 1, // Replace with an existing admin ID
                'status' => 1,
            ],
            [
                'question' => 'What are the benefits of joining the INGO Forum?',
                'answer' => 'Membership offers opportunities for collaboration, knowledge sharing, advocacy, and promoting transparency within the INGO sector.',
                'added_by' => 1, // Replace with an existing admin ID
                'status' => 1,
            ],
            [
                'question' => 'How often does the INGO Forum meet?',
                'answer' => 'The forum generally meets quarterly, with additional meetings possible based on need.',
                'added_by' => 1, // Replace with an existing admin ID
                'status' => 1,
            ],
            [
                'question' => 'How can I find out about upcoming meetings?',
                'answer' => 'Meeting dates and details are typically circulated among members via email. Once you express interest in joining, you\'ll be included in these communications.',
                'added_by' => 1, // Replace with an existing admin ID
                'status' => 1,
            ],
            [
                'question' => 'Who can I contact for more information?',
                'answer' => 'Unfortunately, the INGO Forum doesn\'t maintain a public phone number or physical address due to its reliance on rotating leadership and volunteer efforts. However, you can express your interest by contacting a current member or reaching out through the email address listed below (assuming they establish one).',
                'added_by' => 1, // Replace with an existing admin ID
                'status' => 1,
            ],
        ];

        // Insert the FAQ data
        foreach ($faqs as $faq) {
            Faqs::create($faq);
        }
    }
}
