<?php
// Start session for potential user authentication
session_start();

// Define destinations data for the planning page
// $destinationsData = [
//     [
//         'id' => 1,
//         'name' => 'Kathmandu',
//         'description' => 'Explore the ancient temples and vibrant culture of Nepal\'s capital city',
//         'image' => 'https://images.unsplash.com/photo-1605640840605-14ac1855827b?q=80&w=300&auto=format&fit=crop',
//         'days_recommended' => '2-3',
//         'activities' => ['Cultural Tours', 'Temple Visits', 'Shopping', 'Food Tours']
//     ],
//     [
//         'id' => 2,
//         'name' => 'Pokhara',
//         'description' => 'Experience the serene lakes and stunning mountain views of this beautiful city',
//         'image' => 'https://images.unsplash.com/photo-1575999502951-4ab25b5ca889?q=80&w=300&auto=format&fit=crop',
//         'days_recommended' => '2-4',
//         'activities' => ['Boating', 'Paragliding', 'Hiking', 'Relaxation']
//     ],
//     [
//         'id' => 3,
//         'name' => 'Chitwan National Park',
//         'description' => 'Encounter wildlife including rhinos and tigers in this UNESCO World Heritage site',
//         'image' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?q=80&w=300&auto=format&fit=crop',
//         'days_recommended' => '2-3',
//         'activities' => ['Safari', 'Canoeing', 'Bird Watching', 'Cultural Programs']
//     ],
//     [
//         'id' => 4,
//         'name' => 'Everest Base Camp',
//         'description' => 'Trek to the base of the world\'s highest mountain for breathtaking views',
//         'image' => 'https://images.unsplash.com/photo-1533130061792-64b345e4a833?q=80&w=300&auto=format&fit=crop',
//         'days_recommended' => '12-16',
//         'activities' => ['Trekking', 'Photography', 'Cultural Experiences', 'Mountain Views']
//     ],
//     [
//         'id' => 5,
//         'name' => 'Annapurna Circuit',
//         'description' => 'Experience one of the world\'s most famous trekking routes with diverse landscapes',
//         'image' => 'https://images.unsplash.com/photo-1626516738029-0e1f3b2d2e0e?q=80&w=300&auto=format&fit=crop',
//         'days_recommended' => '10-18',
//         'activities' => ['Trekking', 'Hot Springs', 'Mountain Views', 'Cultural Experiences']
//     ],
//     [
//         'id' => 6,
//         'name' => 'Lumbini',
//         'description' => 'Visit the birthplace of Buddha and explore its peaceful gardens and monasteries',
//         'image' => 'https://images.unsplash.com/photo-1609942072337-c3370e820998?q=80&w=300&auto=format&fit=crop',
//         'days_recommended' => '1-2',
//         'activities' => ['Pilgrimage', 'Meditation', 'Historical Sites', 'Cultural Tours']
//     ],
// ];

// Define activities data
$activitiesData = [
    'Trekking' => ['difficulty' => ['Easy', 'Moderate', 'Challenging', 'Extreme']],
    'Cultural Tours' => ['duration' => ['Half-day', 'Full-day', 'Multi-day']],
    'Wildlife Safari' => ['options' => ['Jeep Safari', 'Walking Safari', 'Elephant Safari']],
    'Adventure Sports' => ['types' => ['Paragliding', 'Bungee Jumping', 'White Water Rafting', 'Rock Climbing']],
    'Spiritual Experiences' => ['types' => ['Meditation', 'Yoga Retreats', 'Monastery Stays']],
    'Mountain Biking' => ['routes' => ['Kathmandu Valley', 'Annapurna Circuit', 'Lower Mustang']],
    'Photography Tours' => ['focus' => ['Landscape', 'Wildlife', 'Cultural', 'Portrait']]
];

// Process form submission with AI integration
$aiGeneratedContent = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_type']) && $_POST['form_type'] === 'planning') {
    // Collect all form data
    $formData = [
        'duration' => $_POST['duration'] ?? '',
        'start_date' => $_POST['start_date'] ?? '',
        'end_date' => $_POST['end_date'] ?? '',
        'budget' => $_POST['budget'] ?? '',
        'destinations' => $_POST['destinations'] ?? [],
        'activities' => $_POST['activities'] ?? [],
        'name' => $_POST['name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'special_requests' => $_POST['special_requests'] ?? '',
        'custom_destinations' => $_POST['custom_destinations'] ?? ''
    ];

    // Get selected destination names
    $selectedDestinations = [];
    if (!empty($formData['destinations'])) {
        foreach ($formData['destinations'] as $destId) {
            foreach ($destinationsData as $dest) {
                if ($dest['id'] == $destId) {
                    $selectedDestinations[] = $dest['name'];
                    break;
                }
            }
        }
    }

    // In a real application, you would call the AI API here
    // For demonstration, we'll simulate the AI response
    $aiGeneratedContent = generateAIResponse($formData, $selectedDestinations);

    // Set success flag
    $planningSuccess = true;
}

/**
 * Simulate AI API call and response generation
 * In a real application, this would make an API call to Gemini or ChatGPT
 */
function generateAIResponse($formData, $selectedDestinations)
{
    // Process custom destinations from Google Places API
    $customDestinations = [];
    if (!empty($formData['custom_destinations'])) {
        try {
            $customDestinationsData = json_decode($formData['custom_destinations'], true);
            if (is_array($customDestinationsData)) {
                foreach ($customDestinationsData as $place) {
                    if (isset($place['name'])) {
                        $customDestinations[] = $place['name'];
                    }
                }
            }
        } catch (Exception $e) {
            // Handle JSON decode error
        }
    }

    // Combine predefined and custom destinations
    $allDestinations = array_merge($selectedDestinations, $customDestinations);
    $destinations = implode(', ', $allDestinations);

    // This is where you would make the actual API call to Gemini or ChatGPT
    // Example API call (commented out):
    /*
    $apiKey = '';
    $apiUrl = 'https://api.openai.com/v1/chat/completions';
    
    $prompt = "Create a detailed travel itinerary for a " . $formData['duration'] . 
              " trip to Nepal, visiting " . $destinations . 
              ". The traveler is interested in " . implode(', ', $formData['activities'] ?? ['Cultural Tours', 'Trekking']) . 
              " with a " . ($formData['budget'] ?? 'Standard') . " budget. Include day-by-day activities, 
              accommodation recommendations, famous places to visit in each location, recommended hotels to stay, 
              and essential information for travelers.";
    
    $data = [
        'model' => 'gpt-4',
        'messages' => [
            ['role' => 'system', 'content' => 'You are a travel expert specializing in Nepal tourism.'],
            ['role' => 'user', 'content' => $prompt]
        ],
        'temperature' => 0.7
    ];
    
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $apiKey
            ],
            'content' => json_encode($data)
        ]
    ];
    
    $context = stream_context_create($options);
    $response = file_get_contents($apiUrl, false, $context);
    $result = json_decode($response, true);
    
    return $result['choices'][0]['message']['content'];
    */

    // For demonstration, return simulated AI response
    $activities = implode(', ', $formData['activities'] ?? ['Cultural Tours', 'Trekking']);
    $duration = $formData['duration'] ?? '8-14 days';
    $budget = $formData['budget'] ?? 'Standard';

    // Add custom destinations to the daily plan
    $dailyPlan = simulateDailyPlan($allDestinations, $formData);

    // Generate accommodation suggestions for all destinations
    $accommodationSuggestions = simulateAccommodations($allDestinations, $formData['budget'] ?? 'Standard');

    // Generate famous places recommendations
    $famousPlaces = simulateFamousPlacesRecommendations($allDestinations);

    // Simulated AI response
    return [
        'itinerary_title' => "Your Personalized Nepal Adventure: $duration Exploring $destinations",
        'introduction' => "Based on your preferences for $activities with a $budget budget, we've crafted this custom itinerary to make the most of your Nepal adventure. This journey will take you through the breathtaking landscapes and rich cultural experiences that Nepal has to offer.",
        'daily_plan' => $dailyPlan,
        'accommodation_suggestions' => $accommodationSuggestions,
        'famous_places' => $famousPlaces,
        'packing_recommendations' => "Based on your selected activities ($activities) and the regions you'll visit, we recommend packing: lightweight, moisture-wicking clothing that can be layered, a good pair of hiking boots if trekking, rain jacket, sunscreen (the sun is intense at higher altitudes), hat, sunglasses, and any personal medications. Don't forget a universal power adapter and a portable charger for your devices.",
        'local_tips' => "• The best local dishes to try include Dal Bhat (lentils and rice), momos (dumplings), and Newari cuisine.\n• Always drink bottled or purified water.\n• Bargaining is expected in markets, but be respectful.\n• It's customary to remove shoes before entering temples and homes.\n• Tipping guides and drivers is appreciated (10-15% is standard)."
    ];
}

/**
 * Generate a simulated daily plan based on selected destinations
 */
function simulateDailyPlan($destinations, $formData)
{
    $plan = [];
    $day = 1;

    // If Kathmandu is selected or no destinations are selected, start with Kathmandu
    if (empty($destinations) || in_array('Kathmandu', $destinations)) {
        $plan[] = [
            'day' => $day++,
            'title' => 'Arrival in Kathmandu',
            'description' => 'Arrive at Tribhuvan International Airport. Transfer to your hotel in Thamel, the tourist district of Kathmandu. Rest and acclimatize to the altitude.',
            'image' => 'https://images.unsplash.com/photo-1605640840605-14ac1855827b?q=80&w=600&auto=format&fit=crop'
        ];

        $plan[] = [
            'day' => $day++,
            'title' => 'Kathmandu Cultural Tour',
            'description' => 'Visit Durbar Square, Swayambhunath (Monkey Temple), and Pashupatinath Temple. These UNESCO World Heritage sites showcase Nepal\'s rich cultural and religious heritage.',
            'image' => 'https://images.unsplash.com/photo-1588430644582-8ffd2bca1673?q=80&w=600&auto=format&fit=crop'
        ];
    }

    // If Pokhara is selected
    if (in_array('Pokhara', $destinations)) {
        $plan[] = [
            'day' => $day++,
            'title' => 'Travel to Pokhara',
            'description' => 'Take a scenic 25-minute flight or a 6-7 hour drive to Pokhara, Nepal\'s beautiful lakeside city. Evening walk along Phewa Lake and dinner at a lakeside restaurant.',
            'image' => 'https://images.unsplash.com/photo-1575999502951-4ab25b5ca889?q=80&w=600&auto=format&fit=crop'
        ];

        $plan[] = [
            'day' => $day++,
            'title' => 'Pokhara Exploration',
            'description' => 'Early morning trip to Sarangkot for sunrise views of the Annapurna range. Visit the International Mountain Museum, Devi\'s Fall, and take a boat ride on Phewa Lake.',
            'image' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?q=80&w=600&auto=format&fit=crop'
        ];
    }

    // If Chitwan is selected
    if (in_array('Chitwan National Park', $destinations)) {
        $plan[] = [
            'day' => $day++,
            'title' => 'Travel to Chitwan National Park',
            'description' => 'Drive to Chitwan National Park (5-6 hours from Kathmandu or 3-4 hours from Pokhara). Check into your jungle lodge and enjoy an evening cultural program.',
            'image' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?q=80&w=600&auto=format&fit=crop'
        ];

        $plan[] = [
            'day' => $day++,
            'title' => 'Chitwan Safari Day',
            'description' => 'Full day of jungle activities: elephant safari or jeep safari to spot rhinos, tigers, and other wildlife. Canoe ride on the Rapti River and bird watching.',
            'image' => 'https://images.unsplash.com/photo-1585144860106-998d6005b8b2?q=80&w=600&auto=format&fit=crop'
        ];
    }

    // If Everest Base Camp is selected
    if (in_array('Everest Base Camp', $destinations)) {
        $plan[] = [
            'day' => $day++,
            'title' => 'Fly to Lukla & Trek to Phakding',
            'description' => 'Early morning flight to Lukla (2,860m). Begin your trek to Phakding (2,610m), a 3-4 hour hike through Sherpa villages and pine forests.',
            'image' => 'https://images.unsplash.com/photo-1533130061792-64b345e4a833?q=80&w=600&auto=format&fit=crop'
        ];

        $plan[] = [
            'day' => $day++,
            'title' => 'Trek to Namche Bazaar',
            'description' => 'Trek from Phakding to Namche Bazaar (3,440m), the gateway to the high Himalayas. This 5-6 hour trek includes your first views of Mt. Everest on a clear day.',
            'image' => 'https://images.unsplash.com/photo-1609924211018-5526c55bad5b?q=80&w=600&auto=format&fit=crop'
        ];
    }

    // Add return to Kathmandu
    if (count($destinations) > 1 || (count($destinations) == 1 && $destinations[0] != 'Kathmandu')) {
        $plan[] = [
            'day' => $day++,
            'title' => 'Return to Kathmandu',
            'description' => 'Travel back to Kathmandu. Free time for souvenir shopping in Thamel. Farewell dinner with traditional Nepali cuisine and cultural performances.',
            'image' => 'https://images.unsplash.com/photo-1558799625-a2a554de5261?q=80&w=600&auto=format&fit=crop'
        ];
    }

    // Add departure day
    $plan[] = [
        'day' => $day++,
        'title' => 'Departure',
        'description' => 'Transfer to Tribhuvan International Airport for your departure flight. End of services.',
        'image' => 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?q=80&w=600&auto=format&fit=crop'
    ];

    return $plan;
}

/**
 * Generate simulated accommodation suggestions based on selected destinations and budget
 */
function simulateAccommodations($destinations, $budget)
{
    $accommodations = [];
    $budgetLevel = '';

    switch ($budget) {
        case 'Budget':
            $budgetLevel = 'budget-friendly';
            break;
        case 'Standard':
            $budgetLevel = 'mid-range';
            break;
        case 'Comfort':
            $budgetLevel = 'comfortable';
            break;
        case 'Luxury':
            $budgetLevel = 'luxury';
            break;
        default:
            $budgetLevel = 'mid-range';
    }

    // If Kathmandu is selected or no destinations are selected
    if (empty($destinations) || in_array('Kathmandu', $destinations)) {
        $accommodations[] = [
            'location' => 'Kathmandu',
            'suggestions' => "For $budgetLevel accommodations in Kathmandu, we recommend staying in the Thamel area for convenience to restaurants, shops, and attractions. Hotels like Hotel Himalaya, Kathmandu Guest House, or Yatri Suites offer good value with comfortable rooms and amenities."
        ];
    }

    // If Pokhara is selected
    if (in_array('Pokhara', $destinations)) {
        $accommodations[] = [
            'location' => 'Pokhara',
            'suggestions' => "In Pokhara, we recommend $budgetLevel accommodations near Phewa Lake for the best views and convenience. Properties like Hotel Barahi, Temple Tree Resort, or Glacier Hotel provide excellent service and amenities for your stay."
        ];
    }

    // If Chitwan is selected
    if (in_array('Chitwan National Park', $destinations)) {
        $accommodations[] = [
            'location' => 'Chitwan',
            'suggestions' => "For your Chitwan stay, we suggest $budgetLevel jungle lodges like Green Park Chitwan, Jungle Villa Resort, or Tigerland Safari Resort that offer comfortable rooms and include safari activities in their packages."
        ];
    }

    // If Everest Base Camp is selected
    if (in_array('Everest Base Camp', $destinations)) {
        $accommodations[] = [
            'location' => 'Everest Region',
            'suggestions' => "Along the Everest Base Camp trek, you'll stay in teahouses/lodges in villages like Phakding, Namche Bazaar, Tengboche, and Gorak Shep. These are simple but comfortable accommodations with basic amenities, suitable for all budget levels."
        ];
    }

    return $accommodations;
}

/**
 * Generate simulated famous places recommendations based on selected destinations
 */
function simulateFamousPlacesRecommendations($destinations)
{
    $recommendations = [];

    // Define famous places for common destinations
    $famousPlacesData = [
        'Kathmandu' => [
            [
                'name' => 'Swayambhunath (Monkey Temple)',
                'description' => 'Ancient religious complex with a stupa and panoramic views of Kathmandu Valley',
                'image' => 'https://images.unsplash.com/photo-1588430644582-8ffd2bca1673?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'name' => 'Pashupatinath Temple',
                'description' => 'Sacred Hindu temple complex and UNESCO World Heritage site on the banks of the Bagmati River',
                'image' => 'https://images.unsplash.com/photo-1605640840605-14ac1855827b?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'name' => 'Boudhanath Stupa',
                'description' => 'One of the largest spherical stupas in Nepal and an important center of Tibetan Buddhism',
                'image' => 'https://images.unsplash.com/photo-1558799625-a2a554de5261?q=80&w=600&auto=format&fit=crop'
            ]
        ],
        'Pokhara' => [
            [
                'name' => 'Phewa Lake',
                'description' => 'Serene lake offering boating opportunities and stunning reflections of the Annapurna range',
                'image' => 'https://images.unsplash.com/photo-1575999502951-4ab25b5ca889?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'name' => 'World Peace Pagoda',
                'description' => 'Buddhist stupa offering panoramic views of Pokhara, the lake, and the Himalayan range',
                'image' => 'https://images.unsplash.com/photo-1575999502951-4ab25b5ca889?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'name' => 'Devi\'s Fall',
                'description' => 'Impressive waterfall where the Pardi Khola stream vanishes underground',
                'image' => 'https://images.unsplash.com/photo-1575999502951-4ab25b5ca889?q=80&w=600&auto=format&fit=crop'
            ]
        ],
        'Chitwan National Park' => [
            [
                'name' => 'Elephant Breeding Center',
                'description' => 'Conservation center where you can learn about elephant care and see baby elephants',
                'image' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'name' => 'Rapti River',
                'description' => 'Take a canoe ride to spot crocodiles and diverse bird species along the riverbanks',
                'image' => 'https://images.unsplash.com/photo-1585144860106-998d6005b8b2?q=80&w=600&auto=format&fit=crop'
            ]
        ],
        'Lumbini' => [
            [
                'name' => 'Maya Devi Temple',
                'description' => 'Marks the exact spot where Queen Maya Devi gave birth to Siddhartha Gautama (Buddha)',
                'image' => 'https://images.unsplash.com/photo-1609942072337-c3370e820998?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'name' => 'Ashoka Pillar',
                'description' => 'Ancient pillar erected by Emperor Ashoka to mark his pilgrimage to Buddha\'s birthplace',
                'image' => 'https://images.unsplash.com/photo-1609942072337-c3370e820998?q=80&w=600&auto=format&fit=crop'
            ]
        ],
        'Nagarkot' => [
            [
                'name' => 'Nagarkot View Tower',
                'description' => 'Observation tower offering spectacular sunrise and sunset views of the Himalayas',
                'image' => 'https://images.unsplash.com/photo-1605640840605-14ac1855827b?q=80&w=600&auto=format&fit=crop'
            ]
        ],
        'Bandipur' => [
            [
                'name' => 'Bandipur Bazaar',
                'description' => 'Charming pedestrian-only street lined with traditional Newari architecture',
                'image' => 'https://images.unsplash.com/photo-1605640840605-14ac1855827b?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'name' => 'Siddha Cave',
                'description' => 'One of the largest caves in Nepal with impressive stalactites and stalagmites',
                'image' => 'https://images.unsplash.com/photo-1605640840605-14ac1855827b?q=80&w=600&auto=format&fit=crop'
            ]
        ],
        'Bhaktapur' => [
            [
                'name' => 'Bhaktapur Durbar Square',
                'description' => 'Ancient royal palace complex with intricate wood carvings and traditional architecture',
                'image' => 'https://images.unsplash.com/photo-1605640840605-14ac1855827b?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'name' => 'Nyatapola Temple',
                'description' => 'Five-story pagoda temple, the tallest in Nepal, with guardian statues on each level',
                'image' => 'https://images.unsplash.com/photo-1605640840605-14ac1855827b?q=80&w=600&auto=format&fit=crop'
            ]
        ]
    ];

    // Default recommendations if no destinations are selected
    if (empty($destinations)) {
        $recommendations[] = [
            'location' => 'Kathmandu Valley',
            'places' => $famousPlacesData['Kathmandu']
        ];
        return $recommendations;
    }

    // Add recommendations for each selected destination
    foreach ($destinations as $destination) {
        if (isset($famousPlacesData[$destination])) {
            $recommendations[] = [
                'location' => $destination,
                'places' => $famousPlacesData[$destination]
            ];
        } else {
            // For destinations not in our predefined list, generate generic recommendations
            $recommendations[] = [
                'location' => $destination,
                'places' => [
                    [
                        'name' => 'Local Cultural Sites',
                        'description' => 'Explore the unique cultural heritage and historical sites of ' . $destination,
                        'image' => 'https://images.unsplash.com/photo-1605640840605-14ac1855827b?q=80&w=600&auto=format&fit=crop'
                    ],
                    [
                        'name' => 'Natural Attractions',
                        'description' => 'Discover the natural beauty surrounding ' . $destination . ' with local guides',
                        'image' => 'https://images.unsplash.com/photo-1575999502951-4ab25b5ca889?q=80&w=600&auto=format&fit=crop'
                    ]
                ]
            ];
        }
    }

    return $recommendations;
}

// Process form submission
$planningSuccess = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_type']) && $_POST['form_type'] === 'planning') {
    // In a real application, you would process the form data and create a custom itinerary
    // For now, just set a success flag
    $planningSuccess = true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan Your Trip - Nepal Travel Guide</title>
    <meta name="description" content="Create your custom Nepal travel itinerary">

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        rose: {
                            100: '#ffe4e6',
                            600: '#e11d48',
                            700: '#be123c',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Custom CSS */
        .hero-image {
            background-image: url('https://images.unsplash.com/photo-1533130061792-64b345e4a833?q=80&w=1920&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .mobile-menu {
                display: none;
            }
        }
    </style>
</head>

<body class="flex min-h-screen flex-col">
    <!-- Header -->
    <header class="sticky top-0 z-50 w-full border-b bg-white/95 backdrop-blur">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl flex h-16 items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-globe text-rose-600"></i>
                <a href="index.php" class="text-xl font-bold">Nepal Travel Guide</a>
            </div>
            <nav class="hidden md:flex gap-6">
                <a href="index.php#destinations" class="text-sm font-medium transition-colors hover:text-rose-600">
                    Destinations
                </a>
                <a href="index.php#tips" class="text-sm font-medium transition-colors hover:text-rose-600">
                    Travel Tips
                </a>
                <a href="index.php#testimonials" class="text-sm font-medium transition-colors hover:text-rose-600">
                    Testimonials
                </a>
                <a href="index.php#contact" class="text-sm font-medium transition-colors hover:text-rose-600">
                    Contact Us
                </a>
            </nav>
            <div class="flex items-center gap-4">
                <a href="#" class="hidden md:flex px-4 py-2 text-sm border rounded-md hover:bg-gray-100">
                    Login
                </a>
                <a href="#" class="px-4 py-2 text-sm text-white bg-rose-600 rounded-md hover:bg-rose-700">
                    Book Now
                </a>
            </div>
        </div>
    </header>

    <main class="flex-1">
        <!-- Hero Section -->
        <section class="relative">
            <div class="absolute inset-0 z-10 bg-black/40"></div>
            <div class="relative h-[400px] w-full hero-image"></div>
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl absolute inset-0 z-20 flex flex-col items-center justify-center text-center text-white">
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl md:text-6xl">
                    Plan Your Nepal Adventure
                </h1>
                <p class="mt-6 max-w-2xl text-lg">
                    Create your custom itinerary based on your interests, budget, and travel dates
                </p>
            </div>
        </section>

        <?php if ($planningSuccess): ?>
            <!-- Update the AI-Generated Itinerary Display section to include famous places -->

            <!-- AI-Generated Itinerary Display -->
            <section class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl py-16">
                <div class="bg-white border rounded-lg shadow-lg p-8">
                    <div class="text-center mb-8">
                        <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-green-100 text-green-600 mb-4">
                            <i class="fa-solid fa-check text-2xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold"><?php echo htmlspecialchars($aiGeneratedContent['itinerary_title']); ?></h2>
                        <p class="text-gray-600 mt-4 max-w-3xl mx-auto">
                            <?php echo htmlspecialchars($aiGeneratedContent['introduction']); ?>
                        </p>
                    </div>

                    <!-- Trip Summary -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-8">
                        <h3 class="text-xl font-bold mb-4">Trip Summary</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="border-b md:border-b-0 md:border-r pb-4 md:pb-0 md:pr-4">
                                <span class="block text-sm text-gray-500">Duration</span>
                                <span class="block font-medium"><?php echo isset($_POST['duration']) ? htmlspecialchars($_POST['duration']) : '8-14 days'; ?></span>
                            </div>
                            <div class="border-b md:border-b-0 md:border-r py-4 md:py-0 md:px-4">
                                <span class="block text-sm text-gray-500">Travel Dates</span>
                                <span class="block font-medium">
                                    <?php
                                    if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
                                        echo htmlspecialchars(date('M d, Y', strtotime($_POST['start_date']))) . ' - ' .
                                            htmlspecialchars(date('M d, Y', strtotime($_POST['end_date'])));
                                    } else {
                                        echo 'Dates not specified';
                                    }
                                    ?>
                                </span>
                            </div>
                            <div class="pt-4 md:pt-0 md:pl-4">
                                <span class="block text-sm text-gray-500">Budget Category</span>
                                <span class="block font-medium"><?php echo isset($_POST['budget']) ? htmlspecialchars($_POST['budget']) : 'Standard'; ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Daily Itinerary -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold mb-6">Your Day-by-Day Itinerary</h3>
                        <div class="space-y-6">
                            <?php foreach ($aiGeneratedContent['daily_plan'] as $day): ?>
                                <div class="flex flex-col md:flex-row gap-6 border-b pb-6">
                                    <div class="md:w-1/3">
                                        <div class="relative h-48 rounded-lg overflow-hidden">
                                            <img
                                                src="<?php echo htmlspecialchars($day['image']); ?>"
                                                alt="Day <?php echo $day['day']; ?>"
                                                class="object-cover w-full h-full">
                                        </div>
                                    </div>
                                    <div class="md:w-2/3">
                                        <div class="flex items-center mb-2">
                                            <span class="bg-rose-100 text-rose-600 text-sm font-medium px-2.5 py-0.5 rounded-full mr-2">Day <?php echo $day['day']; ?></span>
                                            <h4 class="text-lg font-medium"><?php echo htmlspecialchars($day['title']); ?></h4>
                                        </div>
                                        <p class="text-gray-600"><?php echo htmlspecialchars($day['description']); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Famous Places to Visit -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold mb-6">Famous Places to Visit</h3>
                        <?php foreach ($aiGeneratedContent['famous_places'] as $locationPlaces): ?>
                            <div class="mb-6">
                                <h4 class="text-lg font-medium mb-4"><?php echo htmlspecialchars($locationPlaces['location']); ?></h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <?php foreach ($locationPlaces['places'] as $place): ?>
                                        <div class="border rounded-lg overflow-hidden">
                                            <div class="relative h-40">
                                                <img
                                                    src="<?php echo htmlspecialchars($place['image']); ?>"
                                                    alt="<?php echo htmlspecialchars($place['name']); ?>"
                                                    class="object-cover w-full h-full">
                                            </div>
                                            <div class="p-4">
                                                <h5 class="font-medium mb-1"><?php echo htmlspecialchars($place['name']); ?></h5>
                                                <p class="text-sm text-gray-600"><?php echo htmlspecialchars($place['description']); ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Accommodation Suggestions -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold mb-6">Recommended Accommodations</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php foreach ($aiGeneratedContent['accommodation_suggestions'] as $accommodation): ?>
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h4 class="text-lg font-medium mb-2"><?php echo htmlspecialchars($accommodation['location']); ?></h4>
                                    <p class="text-gray-600"><?php echo htmlspecialchars($accommodation['suggestions']); ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Packing Recommendations -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold mb-4">Packing Recommendations</h3>
                        <div class="bg-gray-50 rounded-lg p-6">
                            <p class="text-gray-600"><?php echo htmlspecialchars($aiGeneratedContent['packing_recommendations']); ?></p>
                        </div>
                    </div>

                    <!-- Local Tips -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold mb-4">Local Tips & Cultural Insights</h3>
                        <div class="bg-gray-50 rounded-lg p-6">
                            <p class="text-gray-600 whitespace-pre-line"><?php echo htmlspecialchars($aiGeneratedContent['local_tips']); ?></p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap justify-center gap-4 mt-8">
                        <a href="#" class="px-6 py-3 bg-rose-600 text-white rounded-md hover:bg-rose-700">
                            <i class="fa-solid fa-download mr-2"></i> Download Itinerary
                        </a>
                        <a href="#" class="px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700">
                            <i class="fa-solid fa-check mr-2"></i> Book This Trip
                        </a>
                        <a href="planning.php" class="px-6 py-3 border border-gray-300 rounded-md hover:bg-gray-100">
                            <i class="fa-solid fa-pencil mr-2"></i> Modify Plan
                        </a>
                    </div>
                </div>
            </section>
        <?php else: ?>
            <!-- Planning Form -->
            <section class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl py-16">
                <div class="bg-white border rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold mb-6">Create Your Custom Travel Plan</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="space-y-8">
                        <input type="hidden" name="form_type" value="planning">

                        <!-- Trip Duration -->
                        <div>
                            <h3 class="text-lg font-medium mb-4">How long will you be traveling?</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <label class="relative border rounded-lg p-4 cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="duration" value="1-3 days" class="absolute opacity-0">
                                    <div class="flex flex-col items-center">
                                        <span class="text-lg font-medium">1-3 days</span>
                                        <span class="text-sm text-gray-500">Short trip</span>
                                    </div>
                                </label>
                                <label class="relative border rounded-lg p-4 cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="duration" value="4-7 days" class="absolute opacity-0">
                                    <div class="flex flex-col items-center">
                                        <span class="text-lg font-medium">4-7 days</span>
                                        <span class="text-sm text-gray-500">Standard trip</span>
                                    </div>
                                </label>
                                <label class="relative border rounded-lg p-4 cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="duration" value="8-14 days" class="absolute opacity-0" >
                                    <div class="flex flex-col items-center">
                                        <span class="text-lg font-medium">8-14 days</span>
                                        <span class="text-sm text-gray-500">Extended trip</span>
                                    </div>
                                </label>
                                <label class="relative border rounded-lg p-4 cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="duration" value="15+ days" class="absolute opacity-0">
                                    <div class="flex flex-col items-center">
                                        <span class="text-lg font-medium">15+ days</span>
                                        <span class="text-sm text-gray-500">Long journey</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Travel Dates -->
                        <div>
                            <h3 class="text-lg font-medium mb-4">When are you planning to travel?</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-2">Start Date</label>
                                    <input type="date" name="start_date" class="w-full rounded-md border px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2">End Date</label>
                                    <input type="date" name="end_date" class="w-full rounded-md border px-3 py-2">
                                </div>
                            </div>
                        </div>

                        <!-- Budget Range -->
                        <div>
                            <h3 class="text-lg font-medium mb-4">What's your budget range?</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <label class="relative border rounded-lg p-4 cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="budget" value="Budget" class="absolute opacity-0">
                                    <div class="flex flex-col items-center">
                                        <span class="text-lg font-medium">Budget</span>
                                        <span class="text-sm text-gray-500">$30-50/day</span>
                                    </div>
                                </label>
                                <label class="relative border rounded-lg p-4 cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="budget" value="Standard" class="absolute opacity-0" >
                                    <div class="flex flex-col items-center">
                                        <span class="text-lg font-medium">Standard</span>
                                        <span class="text-sm text-gray-500">$50-100/day</span>
                                    </div>
                                </label>
                                <label class="relative border rounded-lg p-4 cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="budget" value="Comfort" class="absolute opacity-0">
                                    <div class="flex flex-col items-center">
                                        <span class="text-lg font-medium">Comfort</span>
                                        <span class="text-sm text-gray-500">$100-200/day</span>
                                    </div>
                                </label>
                                <label class="relative border rounded-lg p-4 cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="budget" value="Luxury" class="absolute opacity-0">
                                    <div class="flex flex-col items-center">
                                        <span class="text-lg font-medium">Luxury</span>
                                        <span class="text-sm text-gray-500">$200+/day</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Destinations -->
                        <div>
                            <h3 class="text-lg font-medium mb-4">Which destinations would you like to visit?</h3>

                            <!-- Google Places API Search Input -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium mb-2">Search for destinations</label>
                                <div class="relative">
                                    <input
                                        type="text"
                                        id="places-search"
                                        placeholder="Type to search for destinations..."
                                        class="w-full rounded-md border px-3 py-2 pr-10">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                                    </div>
                                </div>
                                <input type="hidden" name="custom_destinations" id="custom-destinations-input" value="">
                            </div>

                            <!-- Popular Destinations in Nepal -->
                            <!-- <p class="text-sm text-gray-500 mb-4">Or choose from popular destinations in Nepal:</p> -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <?php foreach ($destinationsData as $destination): ?>
                                    <label class="relative border rounded-lg overflow-hidden cursor-pointer hover:shadow-md transition-shadow">
                                        <input type="checkbox" name="destinations[]" value="<?php echo $destination['id']; ?>" class="absolute top-4 left-4 z-10">
                                        <div class="relative h-48">
                                            <img
                                                src="<?php echo htmlspecialchars($destination['image']); ?>"
                                                alt="<?php echo htmlspecialchars($destination['name']); ?>"
                                                class="object-cover w-full h-full">
                                            <div class="absolute inset-0 bg-black/30"></div>
                                            <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                                                <h4 class="text-lg font-medium"><?php echo htmlspecialchars($destination['name']); ?></h4>
                                                <p class="text-sm"><?php echo htmlspecialchars($destination['days_recommended']); ?> days recommended</p>
                                            </div>
                                        </div>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Activities -->
                        <div>
                            <h3 class="text-lg font-medium mb-4">What activities are you interested in?</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <?php foreach (array_keys($activitiesData) as $activity): ?>
                                    <label class="flex items-center space-x-3 border rounded-lg p-4 cursor-pointer hover:bg-gray-50">
                                        <input type="checkbox" name="activities[]" value="<?php echo $activity; ?>" class="h-5 w-5 text-rose-600 rounded">
                                        <span><?php echo htmlspecialchars($activity); ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Traveler Information -->
                        <div>
                            <h3 class="text-lg font-medium mb-4">Traveler Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium mb-2">Full Name</label>
                                        <input type="text" name="name" class="w-full rounded-md border px-3 py-2" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-2">Email</label>
                                        <input type="email" name="email" class="w-full rounded-md border px-3 py-2" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-2">Phone Number</label>
                                        <input type="tel" name="phone" class="w-full rounded-md border px-3 py-2">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2">Special Requests or Requirements</label>
                                    <textarea name="special_requests" rows="5" class="w-full rounded-md border px-3 py-2"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-center">
                            <button type="submit" class="px-8 py-3 bg-rose-600 text-white rounded-md hover:bg-rose-700">
                                Create My Travel Plan
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer class="border-t bg-slate-50 py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            <div class="grid gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
                <div class="lg:col-span-1">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-globe text-rose-600"></i>
                        <span class="text-xl font-bold">Nepal Travel Guide</span>
                    </div>
                    <p class="mt-4 text-sm text-gray-600">
                        Providing the most comprehensive travel information and services for Nepal, making your trip more
                        convenient and enjoyable.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-medium">Destinations</h3>
                    <ul class="mt-4 space-y-2 text-sm">
                        <li>
                            <a href="#" class="text-gray-600 hover:text-rose-600">
                                Kathmandu
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 hover:text-rose-600">
                                Pokhara
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 hover:text-rose-600">
                                Chitwan
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 hover:text-rose-600">
                                Lumbini
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 hover:text-rose-600">
                                Everest Region
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-medium">Travel Services</h3>
                    <ul class="mt-4 space-y-2 text-sm">
                        <li>
                            <a href="#" class="text-gray-600 hover:text-rose-600">
                                Trekking
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 hover:text-rose-600">
                                Hotel Booking
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 hover:text-rose-600">
                                Flight Booking
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 hover:text-rose-600">
                                Custom Travel
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 hover:text-rose-600">
                                Travel Insurance
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-medium">About Us</h3>
                    <ul class="mt-4 space-y-2 text-sm">
                        <li>
                            <a href="#" class="text-gray-600 hover:text-rose-600">
                                Company Profile
                            </a>
                        </li>
                        <li>
                            <a href="#contact" class="text-gray-600 hover:text-rose-600">
                                Contact Us
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 hover:text-rose-600">
                                Join Us
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 hover:text-rose-600">
                                Privacy Policy
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 hover:text-rose-600">
                                Terms of Service
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-medium">Partner Links</h3>
                    <ul class="mt-4 space-y-2 text-sm">
                        <li>
                            <a
                                href="https://www.welcomenepal.com"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="text-gray-600 hover:text-rose-600">
                                Nepal Tourism Board
                            </a>
                        </li>
                        <li>
                            <a
                                href="https://www.taan.org.np"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="text-gray-600 hover:text-rose-600">
                                Trekking Agencies' Association
                            </a>
                        </li>
                        <li>
                            <a
                                href="https://www.nepalmountaineering.org"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="text-gray-600 hover:text-rose-600">
                                Nepal Mountaineering Association
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-12 border-t pt-6 text-center text-sm text-gray-600">
                <p>© <?php echo date('Y'); ?> Nepal Travel Guide. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Handle radio button selection styling
        document.addEventListener('DOMContentLoaded', function() {
            const radioLabels = document.querySelectorAll('input[type="radio"]');

            radioLabels.forEach(radio => {
                radio.addEventListener('change', function() {
                    // Remove selected class from all siblings
                    const name = this.getAttribute('name');
                    document.querySelectorAll(`input[name="${name}"]`).forEach(sibling => {
                        sibling.closest('label').classList.remove('bg-rose-50', 'border-rose-300');
                    });

                    // Add selected class to checked radio
                    if (this.checked) {
                        this.closest('label').classList.add('bg-rose-50', 'border-rose-300');
                    }
                });

                // Initialize selected state
                if (radio.checked) {
                    radio.closest('label').classList.add('bg-rose-50', 'border-rose-300');
                }
            });

            // Handle checkbox styling
            const checkboxLabels = document.querySelectorAll('input[type="checkbox"]');

            checkboxLabels.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        this.closest('label').classList.add('bg-rose-50', 'border-rose-300');
                    } else {
                        this.closest('label').classList.remove('bg-rose-50', 'border-rose-300');
                    }
                });
            });
        });
    </script>
    <!-- Add this right before the closing </body> tag -->

    <!-- Google Places API Script -->
    <script>
        // Google Places API key
        const GOOGLE_PLACES_API_KEY = 'AIzaSyD6p7UZTGZxpZJt5zJ0DDD35g9DWOqvIEM';

        function initPlacesAutocomplete() {
            // Check if the Google Places API is loaded
            if (typeof google === 'undefined' || typeof google.maps === 'undefined' || typeof google.maps.places === 'undefined') {
                console.error('Google Places API not loaded');
                return;
            }

            const input = document.getElementById('places-search');
            const hiddenInput = document.getElementById('custom-destinations-input');

            // Store selected place (only one at a time)
            let selectedPlace = null;

            // Prevent form submission on Enter key
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    return false;
                }
            });

            // Initialize the autocomplete with Nepal restriction
            const autocomplete = new google.maps.places.Autocomplete(input, {
                types: ['(cities)'],
                componentRestrictions: {
                    country: 'np'
                }, // Restrict to Nepal only
                bounds: new google.maps.LatLngBounds(
                    new google.maps.LatLng(26.3478, 80.0982), // SW corner of Nepal
                    new google.maps.LatLng(30.4227, 88.1748) // NE corner of Nepal
                ),
                strictBounds: true // Strictly enforce the bounds
            });

            // Listen for place selection
            autocomplete.addListener('place_changed', function() {
                const place = autocomplete.getPlace();

                if (!place.geometry) {
                    console.log("No details available for input: '" + place.name + "'");
                    return;
                }

                // Update the selected place
                selectedPlace = {
                    id: place.place_id,
                    name: place.name,
                    address: place.formatted_address,
                    location: {
                        lat: place.geometry.location.lat(),
                        lng: place.geometry.location.lng()
                    }
                };

                // Update the input field with the selected place name
                input.value = selectedPlace.name;
                updateHiddenInput();
            });

            // Add clear button functionality
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && input.value === '') {
                    selectedPlace = null;
                    updateHiddenInput();
                }
            });

            // Function to update the hidden input with JSON data
            function updateHiddenInput() {
                hiddenInput.value = selectedPlace ? JSON.stringify([selectedPlace]) : '';
            }
        }

        // Load Google Places API
        function loadGooglePlacesAPI() {
            const script = document.createElement('script');
            script.src = `https://maps.googleapis.com/maps/api/js?key=${GOOGLE_PLACES_API_KEY}&libraries=places&callback=initPlacesAutocomplete`;
            script.async = true;
            script.defer = true;
            document.head.appendChild(script);
        }

        // Call this function when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadGooglePlacesAPI();
        });
    </script>
</body>

</html>