<?php
/**
 * NLP Class
 *
 * Process text with Natural Language Processing
 */
class NLP
{
    public function __construct()
    {
    }

    function categorizeNoteWithChatGPT($inputNote)
    {
        $apiKey = ''; // Replace with your OpenAI API key
        $apiUrl = 'https://api.openai.com/v1/engines/text-davinci-003/completions';
        //Test note
        $note = "In today's meeting, we discussed the development of a new interactive dashboard feature for user analytics, focusing on using React for a responsive and modular front-end design and integrating D3.js for advanced data visualization. The team emphasized the importance of a minimalistic user interface, prioritizing ease of navigation and user experience, with inputs from the UX team on the initial wireframes. We also highlighted the need for cross-browser compatibility, mobile responsiveness, fast loading times, and robust data security. A review meeting with the backend team is scheduled to ensure API compatibility and accurate data representation. Emma, our Lead Developer, and Mike, our UI/UX Designer, are assigned to this project, aiming to meet the deadline of January 20, 2024.";
        // Prepare the prompt for ChatGPT
        $prompt = "Given the following note, identify the most relevant topic from this list: " .
            "Programming & Development, Design & User Experience, Project Management, " .
            "Team Management, Finance & Budgeting, Marketing & Sales, Product Strategy, " .
            "Customer Support & Feedback, Legal & Compliance, Technology Trends, " .
            "Operational Efficiency, Security & Data Privacy. Note: " . $inputNote;


        // Data for the POST request
        $postData = [
            'prompt' => $prompt,
            'max_tokens' => 100, // Adjust as needed
            'temperature' => 0.7 // Adjust as needed
        ];

        // Initialize cURL session
        $ch = curl_init($apiUrl);
        if(curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        }
        // Set headers and POST data
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute and get the response
        $response = curl_exec($ch);

        // Close cURL session
        curl_close($ch);
        // Decode the response
        $decodedResponse = json_decode($response, true);
        //print_r($decodedResponse);
        // Extract the text response
        $textResponse = $decodedResponse['choices'][0]['text'] ?? 'No Topic';
        echo $textResponse;
        // Trim and return the response
        return trim($textResponse);
    }
}