<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swagger API Documentation | JRS International School</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <!-- Swagger UI CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@5/swagger-ui.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: #fafafa;
        }
        .header-bar {
            background: #031c3f;
            color: white;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 3px solid #e31e24;
        }
        .header-bar h1 {
            margin: 0;
            font-family: 'Manrope', sans-serif;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -0.02em;
        }
        .header-bar p {
            margin: 4px 0 0;
            font-size: 12px;
            color: #94a3b8;
        }
        .back-link {
            background: #e31e24;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: background 0.2s;
        }
        .back-link:hover {
            opacity: 0.9;
        }
        .swagger-ui .topbar { display: none; }
    </style>
</head>
<body>
    <div class="header-bar">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="background: white; border-radius: 8px; padding: 4px 10px; display: flex; align-items: center;">
                <img src="{{ asset('images/logo.png') }}" alt="JRS Logo" style="height: 32px; width: auto; object-fit: contain;">
            </div>
            <div>
                <h1>JRS International School — Swagger API Docs</h1>
                <p>Interactive OpenAPI 3.0 Documentation for News Ticker & Web Services</p>
            </div>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="back-link">&larr; Back to Admin Panel</a>
    </div>

    <div id="swagger-ui"></div>

    <!-- Swagger UI JS -->
    <script src="https://unpkg.com/swagger-ui-dist@5/swagger-ui-bundle.js"></script>
    <script src="https://unpkg.com/swagger-ui-dist@5/swagger-ui-standalone-preset.js"></script>
    <script>
        window.onload = function() {
            const spec = {
                openapi: "3.0.3",
                info: {
                    title: "JRS International School API",
                    description: "RESTful API endpoints for JRS School React Frontend (https://jrs-school.vercel.app/) and Backend Dashboard.",
                    version: "1.0.0",
                    contact: {
                        name: "JRS International School Dev Team",
                        url: "https://jrs-school.vercel.app"
                    }
                },
                servers: [
                    {
                        url: "{{ url('/api') }}",
                        description: "Current Application API Server"
                    }
                ],
                paths: {
                    "/news-ticker": {
                        get: {
                            tags: ["News Ticker (Frontend)"],
                            summary: "Get active marquee ticker announcements for React site",
                            description: "Returns all active announcements sorted by sort_order for the homepage top red marquee banner.",
                            responses: {
                                "200": {
                                    description: "List of active news tickers",
                                    content: {
                                        "application/json": {
                                            example: {
                                                success: true,
                                                count: 2,
                                                data: [
                                                    {
                                                        id: 1,
                                                        title: "Admissions Open for Academic Year 2026–2027 (Nursery to Grade XII) — Enroll Today!",
                                                        badge_text: "NEWS",
                                                        link_url: "https://jrs-school.vercel.app/admissions",
                                                        sort_order: 1,
                                                        is_active: true
                                                    }
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "/hero-slider": {
                        get: {
                            tags: ["Hero Slider (Frontend)"],
                            summary: "Get active hero slider slides for React homepage banner",
                            description: "Returns all published hero banner slides sorted by sort_order including titles, gold highlights, button links, and background photos.",
                            responses: {
                                "200": {
                                    description: "List of active hero slides",
                                    content: {
                                        "application/json": {
                                            example: {
                                                success: true,
                                                count: 2,
                                                data: [
                                                    {
                                                        id: 1,
                                                        badge_title: "NURTURING BRIGHT MINDS • BUILDING A BETTER TOMORROW",
                                                        title: "Empowering",
                                                        highlight_text: "Future Leaders",
                                                        description: "At JRS International School, we inspire curiosity, creativity and compassion. A place where every child discovers their potential and shines in their own unique way.",
                                                        primary_button_text: "Admissions 2026-27",
                                                        secondary_button_text: "Take a Virtual Tour",
                                                        secondary_button_url: "https://jrs-school.vercel.app/#tour",
                                                        image_path: "https://images.unsplash.com/photo-1580582932707-520aed937b7b",
                                                        image_full_url: "https://images.unsplash.com/photo-1580582932707-520aed937b7b",
                                                        contact_phone: "+91 91574 04321",
                                                        sort_order: 1,
                                                        is_active: true
                                                    }
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "/sliders": {
                        get: {
                            tags: ["Hero Slider (REST CRUD)"],
                            summary: "List all hero slides",
                            parameters: [
                                {
                                    name: "active",
                                    in: "query",
                                    description: "Filter by status (true or false)",
                                    required: false,
                                    schema: { type: "boolean" }
                                }
                            ],
                            responses: {
                                "200": { description: "Full list of slides" }
                            }
                        },
                        post: {
                            tags: ["Hero Slider (REST CRUD)"],
                            summary: "Create a new hero slide",
                            requestBody: {
                                required: true,
                                content: {
                                    "multipart/form-data": {
                                        schema: {
                                            type: "object",
                                            properties: {
                                                title: { type: "string", example: "Empowering" },
                                                highlight_text: { type: "string", example: "Future Leaders" },
                                                badge_title: { type: "string", example: "NURTURING BRIGHT MINDS" },
                                                description: { type: "string" },
                                                primary_button_text: { type: "string", example: "Admissions 2026-27" },
                                                secondary_button_text: { type: "string", example: "Take a Virtual Tour" },
                                                secondary_button_url: { type: "string" },
                                                image: { type: "string", format: "binary" },
                                                image_url: { type: "string" },
                                                contact_phone: { type: "string", example: "+91 91574 04321" },
                                                sort_order: { type: "integer", example: 1 },
                                                is_active: { type: "boolean", example: true }
                                            },
                                            required: ["title"]
                                        }
                                    }
                                }
                            },
                            responses: {
                                "201": { description: "Hero slide created successfully" }
                            }
                        }
                    },
                    "/sliders/{id}": {
                        get: {
                            tags: ["Hero Slider (REST CRUD)"],
                            summary: "Get specific slide by ID",
                            parameters: [{ name: "id", in: "path", required: true, schema: { type: "integer" } }],
                            responses: { "200": { description: "Slide details" } }
                        },
                        delete: {
                            tags: ["Hero Slider (REST CRUD)"],
                            summary: "Delete a slide by ID",
                            parameters: [{ name: "id", in: "path", required: true, schema: { type: "integer" } }],
                            responses: { "200": { description: "Slide deleted successfully" } }
                        }
                    },
                    "/sliders/{id}/toggle": {
                        patch: {
                            tags: ["Hero Slider (REST CRUD)"],
                            summary: "Toggle active status of a slide",
                            parameters: [{ name: "id", in: "path", required: true, schema: { type: "integer" } }],
                            responses: { "200": { description: "Status toggled" } }
                        }
                    },
                    "/facilities": {
                        get: {
                            tags: ["Facilities (Public Frontend)"],
                            summary: "Get active school facilities / infrastructure cards",
                            description: "Returns all active facilities sorted by sort_order for the 'World-Class Infrastructure' section on the frontend.",
                            responses: {
                                "200": {
                                    description: "List of active facilities",
                                    content: {
                                        "application/json": {
                                            example: {
                                                success: true,
                                                message: "Active facilities fetched successfully",
                                                total: 5,
                                                data: [
                                                    {
                                                        id: 1,
                                                        title: "Smart Classrooms",
                                                        description: "Modern and interactive learning spaces",
                                                        image_path: "uploads/facilities/smart_classrooms.jpg",
                                                        image_url: "http://127.0.0.1:8000/uploads/facilities/smart_classrooms.jpg",
                                                        icon: "monitor",
                                                        theme_color: "navy",
                                                        sort_order: 1,
                                                        is_active: true
                                                    }
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "/admin/facilities": {
                        get: {
                            tags: ["Facilities (REST CRUD)"],
                            summary: "List all facilities with optional status filter",
                            parameters: [
                                {
                                    name: "active",
                                    in: "query",
                                    description: "Filter by status (true or false)",
                                    required: false,
                                    schema: { type: "boolean" }
                                }
                            ],
                            responses: {
                                "200": { description: "Full list of facilities" }
                            }
                        },
                        post: {
                            tags: ["Facilities (REST CRUD)"],
                            summary: "Create a new facility / infrastructure card",
                            requestBody: {
                                required: true,
                                content: {
                                    "multipart/form-data": {
                                        schema: {
                                            type: "object",
                                            properties: {
                                                title: { type: "string", example: "Smart Classrooms" },
                                                description: { type: "string", example: "Modern and interactive learning spaces" },
                                                icon: { type: "string", enum: ["monitor", "flask", "book", "trophy", "bus"], example: "monitor" },
                                                theme_color: { type: "string", enum: ["navy", "red"], example: "navy" },
                                                sort_order: { type: "integer", example: 1 },
                                                is_active: { type: "boolean", example: true },
                                                image: { type: "string", format: "binary" },
                                                image_url: { type: "string" }
                                            },
                                            required: ["title"]
                                        }
                                    }
                                }
                            },
                            responses: {
                                "201": { description: "Facility created successfully" }
                            }
                        }
                    },
                    "/admin/facilities/{id}": {
                        get: {
                            tags: ["Facilities (REST CRUD)"],
                            summary: "Get specific facility details by ID",
                            parameters: [{ name: "id", in: "path", required: true, schema: { type: "integer" } }],
                            responses: { "200": { description: "Facility details" } }
                        },
                        delete: {
                            tags: ["Facilities (REST CRUD)"],
                            summary: "Delete a facility by ID",
                            parameters: [{ name: "id", in: "path", required: true, schema: { type: "integer" } }],
                            responses: { "200": { description: "Facility deleted successfully" } }
                        }
                    },
                    "/admin/facilities/{id}/toggle": {
                        patch: {
                            tags: ["Facilities (REST CRUD)"],
                            summary: "Toggle active status of a facility",
                            parameters: [{ name: "id", in: "path", required: true, schema: { type: "integer" } }],
                            responses: { "200": { description: "Status toggled" } }
                        }
                    },
                    "/academic-programs": {
                        get: {
                            tags: ["Academic Programs (Frontend)"],
                            summary: "Get active academic stage cards for React homepage",
                            description: "Returns all active academic programmes (Pre-Primary, Primary School, Middle School, etc.) sorted by sort_order. Matches the exact curriculum cards on the homepage with stage badges, titles, subtitles, checklists, and images.",
                            responses: {
                                "200": {
                                    description: "List of active academic programmes",
                                    content: {
                                        "application/json": {
                                            example: {
                                                success: true,
                                                message: "Active academic programs fetched successfully",
                                                total: 3,
                                                data: [
                                                    {
                                                        id: 1,
                                                        stage_badge: "STAGE 01 • EARLY YEARS",
                                                        title: "Pre-Primary",
                                                        slug: "pre-primary",
                                                        subtitle: "NURSERY, LKG & UKG",
                                                        description: "Feel grounded and supported in an environment where early learners are encouraged to participate, share ideas, explore phonics, and build confidence through play.",
                                                        highlights: [
                                                            "Phonics-based English language & early communication",
                                                            "Montessori-inspired sensorial and tactile activities",
                                                            "Early numeracy, number sense and playful logical thinking"
                                                        ],
                                                        image: "images/programs/pre-primary.jpg",
                                                        image_url: "http://127.0.0.1:8000/images/programs/pre-primary.jpg",
                                                        button_text: "Explore More",
                                                        button_link: "https://jrs-school.vercel.app/academics/pre-primary",
                                                        sort_order: 1,
                                                        is_active: true
                                                    }
                                                ]
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "/admin/programs": {
                        get: {
                            tags: ["Academic Programs (REST CRUD)"],
                            summary: "List all academic programmes with optional active filter",
                            parameters: [
                                {
                                    name: "active",
                                    in: "query",
                                    description: "Filter by status (true or false)",
                                    required: false,
                                    schema: { type: "boolean" }
                                }
                            ],
                            responses: { "200": { description: "Full list of academic programmes" } }
                        },
                        post: {
                            tags: ["Academic Programs (REST CRUD)"],
                            summary: "Create a new academic stage programme",
                            requestBody: {
                                required: true,
                                content: {
                                    "multipart/form-data": {
                                        schema: {
                                            type: "object",
                                            properties: {
                                                stage_badge: { type: "string", example: "STAGE 01 • EARLY YEARS" },
                                                title: { type: "string", example: "Pre-Primary" },
                                                subtitle: { type: "string", example: "NURSERY, LKG & UKG" },
                                                description: { type: "string" },
                                                highlights: {
                                                    type: "array",
                                                    items: { type: "string" },
                                                    example: ["Phonics-based English language", "Montessori activities"]
                                                },
                                                image: { type: "string", format: "binary" },
                                                image_url: { type: "string" },
                                                button_text: { type: "string", example: "Explore More" },
                                                button_link: { type: "string" },
                                                sort_order: { type: "integer", example: 1 },
                                                is_active: { type: "boolean", example: true }
                                            },
                                            required: ["title"]
                                        }
                                    }
                                }
                            },
                            responses: { "201": { description: "Programme created successfully" } }
                        }
                    },
                    "/admin/programs/{id}": {
                        get: {
                            tags: ["Academic Programs (REST CRUD)"],
                            summary: "Get specific academic programme details by ID",
                            parameters: [{ name: "id", in: "path", required: true, schema: { type: "integer" } }],
                            responses: { "200": { description: "Academic programme details" } }
                        },
                        delete: {
                            tags: ["Academic Programs (REST CRUD)"],
                            summary: "Delete an academic programme by ID",
                            parameters: [{ name: "id", in: "path", required: true, schema: { type: "integer" } }],
                            responses: { "200": { description: "Programme deleted successfully" } }
                        }
                    },
                    "/admin/programs/{id}/toggle": {
                        patch: {
                            tags: ["Academic Programs (REST CRUD)"],
                            summary: "Toggle active status of an academic programme",
                            parameters: [{ name: "id", in: "path", required: true, schema: { type: "integer" } }],
                            responses: { "200": { description: "Status toggled" } }
                        }
                    }
                }
            };

            const ui = SwaggerUIBundle({
                spec: spec,
                dom_id: '#swagger-ui',
                deepLinking: true,
                presets: [
                    SwaggerUIBundle.presets.apis,
                    SwaggerUIStandalonePreset
                ],
                plugins: [
                    SwaggerUIBundle.plugins.DownloadUrl
                ],
                layout: "BaseLayout"
            });
            window.ui = ui;
        };
    </script>
</body>
</html>
