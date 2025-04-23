<?php
/**
 * AI Service for Trip Planning
 * Handles all AI-related operations including API calls and response processing
 */

class AIService {
    private $apiKey;
    private $apiEndpoint;
    private $error;

    public function __construct() {
        $this->apiKey = 'AIzaSyDsfmKKLTcNqafn0nEN6U2USD6KcNM1vVo';
        $this->apiEndpoint = 'https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent';
        $this->error = null;
    }

    /**
     * Generate travel itinerary using AI
     * 
     * @param array $formData Form data including duration, destinations, activities, etc.
     * @param array $selectedDestinations Array of selected destinations
     * @return array|null Generated itinerary or null if error occurred
     */
    public function generateItinerary($formData, $selectedDestinations) {
        try {
            // Validate input
            if (empty($selectedDestinations)) {
                throw new Exception('No destinations selected');
            }

            // Prepare the prompt
            $prompt = $this->preparePrompt($formData, $selectedDestinations);
            error_log('AI Prompt: ' . $prompt);
            
            // Make API call
            $response = $this->callGeminiAPI($prompt);
            
            // Process and validate response
            $itinerary = $this->processResponse($response);
            
            // Validate the itinerary structure
            $this->validateItinerary($itinerary);
            
            return $itinerary;
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            error_log('AI Service Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Prepare the prompt for the AI
     */
    private function preparePrompt($formData, $selectedDestinations) {
        // Handle destinations - they might be strings or arrays
        $destinations = [];
        foreach ($selectedDestinations as $dest) {
            if (is_array($dest) && isset($dest['name'])) {
                $destinations[] = $dest['name'];
            } else if (is_string($dest)) {
                $destinations[] = $dest;
            }
        }
        
        $destinationsList = implode(', ', $destinations);
        $activities = !empty($formData['activities']) ? implode(', ', $formData['activities']) : 'General sightseeing';
        $duration = $formData['duration'] ?? '8-14 days';
        $budget = $formData['budget'] ?? 'Standard';

        return "You are a travel expert specializing in Nepal tourism. Create a detailed travel itinerary with the following requirements:

1. Trip Duration: {$duration}
2. Destinations: {$destinationsList}
3. Interests: {$activities}
4. Budget Level: {$budget}

Please provide a structured response in JSON format with the following sections:
{
  \"tripDetails\": {
    \"location\": \"[Main Destination]\",
    \"duration\": \"[Duration]\",
    \"budget\": \"[Budget Level]\",
    \"travelers\": \"[Type of Travelers]\"
  },
  \"hotelOptions\": [
    {
      \"hotelName\": \"[Hotel Name]\",
      \"hotelAddress\": \"[Full Address]\",
      \"price\": \"[Price Range]\",
      \"hotelImageUrl\": \"[Image URL]\",
      \"geoCoordinates\": {
        \"latitude\": [Latitude],
        \"longitude\": [Longitude]
      },
      \"rating\": [Rating],
      \"description\": \"[Detailed Description]\",
      \"amenities\": [\"[List of Amenities]\"]
    }
  ],
  \"itinerary\": {
    \"day1\": {
      \"theme\": \"[Day Theme]\",
      \"bestTimeToVisit\": \"[Best Time]\",
      \"places\": [
        {
          \"placeName\": \"[Place Name]\",
          \"placeDetails\": \"[Detailed Description]\",
          \"placeImageUrl\": \"[Image URL]\",
          \"geoCoordinates\": {
            \"latitude\": [Latitude],
            \"longitude\": [Longitude]
          },
          \"ticketPricing\": \"[Price Info]\",
          \"timeToTravel\": \"[Travel Time]\",
          \"bestTimeToVisit\": \"[Best Time]\"
        }
      ]
    }
  },
  \"tipsForSavingMoney\": [
    \"[Money Saving Tips]\"
  ]
}

Make sure to:
- Include realistic daily activities based on the destinations
- Suggest appropriate accommodations for the budget level
- Provide practical packing advice based on the activities
- Include relevant cultural tips and local customs
- Use real image URLs from Unsplash for the daily activities
- Include specific timings and travel durations between locations
- Add money-saving tips specific to the destination

Format the response as a valid JSON object. Do not include any markdown formatting or code blocks.";
    }

    /**
     * Call the Gemini API
     */
    private function callGeminiAPI($prompt) {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $this->apiEndpoint . '?key=' . $this->apiKey);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => $prompt
                        ]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'topK' => 40,
                'topP' => 0.95,
                'maxOutputTokens' => 8192,
            ]
        ]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        
        // Log the raw response for debugging
        error_log('API Raw Response: ' . $response);
        
        if (curl_errno($ch)) {
            $error = 'cURL Error: ' . curl_error($ch);
            error_log($error);
            throw new Exception($error);
        }
        
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode !== 200) {
            $error = 'HTTP Error: ' . $httpCode . ' Response: ' . $response;
            error_log($error);
            throw new Exception($error);
        }
        
        curl_close($ch);
        
        return $response;
    }

    /**
     * Process and validate the API response
     */
    private function processResponse($response) {
        // Log the raw response for debugging
        error_log('Processing API Response: ' . $response);
        
        $result = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            $error = 'JSON Decode Error: ' . json_last_error_msg();
            error_log($error);
            throw new Exception($error);
        }
        
        // Check for API-specific errors
        if (isset($result['error'])) {
            $error = 'API Error: ' . ($result['error']['message'] ?? 'Unknown API error');
            error_log($error);
            throw new Exception($error);
        }
        
        // Extract the generated content
        if (!isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            $error = 'Unexpected API response format: ' . print_r($result, true);
            error_log($error);
            throw new Exception($error);
        }
        
        $generatedText = $result['candidates'][0]['content']['parts'][0]['text'];
        error_log('Generated Text: ' . $generatedText);
        
        // Try to find JSON content within the response
        if (preg_match('/```json\n(.*?)\n```/s', $generatedText, $matches)) {
            $jsonContent = $matches[1];
        } else {
            $jsonContent = $generatedText;
        }
        
        // Clean up the JSON content
        $jsonContent = trim($jsonContent);
        
        // Parse the JSON response
        $parsedResponse = json_decode($jsonContent, true);
        
        if (json_last_error() === JSON_ERROR_NONE) {
            return $parsedResponse;
        } else {
            $error = 'Error parsing API response: ' . json_last_error_msg() . "\nRaw content: " . substr($jsonContent, 0, 1000) . "...";
            error_log($error);
            throw new Exception($error);
        }
    }

    /**
     * Validate the itinerary structure
     */
    private function validateItinerary($itinerary) {
        $requiredFields = [
            'tripDetails',
            'hotelOptions',
            'itinerary',
            'tipsForSavingMoney'
        ];

        foreach ($requiredFields as $field) {
            if (!isset($itinerary[$field])) {
                throw new Exception("Missing required field: {$field}");
            }
        }

        // Validate tripDetails
        $requiredTripDetails = ['location', 'duration', 'budget', 'travelers'];
        foreach ($requiredTripDetails as $field) {
            if (!isset($itinerary['tripDetails'][$field])) {
                throw new Exception("Missing required field in tripDetails: {$field}");
            }
        }

        // Validate hotelOptions
        if (!is_array($itinerary['hotelOptions']) || empty($itinerary['hotelOptions'])) {
            throw new Exception('Hotel options must be a non-empty array');
        }

        // Validate itinerary days
        if (!is_array($itinerary['itinerary']) || empty($itinerary['itinerary'])) {
            throw new Exception('Itinerary must contain at least one day');
        }

        // Validate tips
        if (!is_array($itinerary['tipsForSavingMoney']) || empty($itinerary['tipsForSavingMoney'])) {
            throw new Exception('Tips for saving money must be a non-empty array');
        }
    }

    /**
     * Get the last error message
     */
    public function getError() {
        return $this->error;
    }
} 