<?php
/*
Template Name: CV / Resume Page
*/

// Function to dequeue theme styles specific to this page template
function cv_remove_theme_styles()
{
    // This removes the main style.css of the parent/child theme.
    // YOU MAY NEED TO INSPECT YOUR SITE TO FIND THE EXACT HANDLE NAMES if these don't work.
    // Common handles: 'style', 'main-style', 'theme-style', 'astra-theme-css', 'twentytwentyfour-style', etc.

    // Attempting to remove common handles:
    wp_dequeue_style('style');
    wp_dequeue_style('wp-block-library'); // Optional: removes Gutenberg block styles if you don't need them
    wp_dequeue_style('wp-block-library-theme');

    // If you know your theme's handle, add it here:
    // wp_dequeue_style('your-theme-handle');
}
add_action('wp_enqueue_scripts', 'cv_remove_theme_styles', 9999);
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php the_title(); ?> - Academic CV</title>

    <?php wp_head(); ?>

    <!-- Tailwind CSS - Loaded AFTER wp_head to override theme styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            // "important: true" forces Tailwind utilities to override other styles (like your theme)
            important: true,
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    colors: {
                        slate: {
                            850: '#151f32',
                            900: '#0f172a',
                            950: '#020617',
                        },
                        teal: {
                            450: '#14b8a6',
                        }
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>

    <!-- Fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;family=JetBrains+Mono:wght@400;700&amp;display=swap"
        rel="stylesheet">

    <!-- Custom Styles & Resets -->
    <style>
        /* Force Reset */
        html,
        body {
            margin: 0 !important;
            padding: 0 !important;
            font-family: 'Inter', sans-serif !important;
            background-color: #020617 !important;
            /* bg-slate-950 */
            color: #cbd5e1 !important;
            /* text-slate-300 */
        }

        /* Override Theme Typography */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: inherit !important;
            margin: 0 !important;
            line-height: inherit !important;
            color: inherit !important;
        }

        p {
            margin-bottom: 0 !important;
            /* Tailwind handles spacing via classes */
        }

        a {
            text-decoration: none !important;
            color: inherit !important;
            box-shadow: none !important;
        }

        /* Custom Components */
        .glass-panel {
            background: rgba(30, 41, 59, 0.4);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .section-heading {
            position: relative;
            display: inline-block;
            padding-bottom: 0.5rem;
        }

        .section-heading::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 60px;
            height: 4px;
            background: #14b8a6;
            border-radius: 2px;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #0f172a;
        }

        ::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #14b8a6;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
                color: black !important;
            }

            .text-slate-300,
            .text-slate-400,
            .text-slate-500 {
                color: #333 !important;
            }
        }
    </style>
</head>

<body <?php body_class('bg-slate-950 text-slate-300 font-sans antialiased selection:bg-teal-500 selection:text-white overflow-x-hidden'); ?>>

    <!-- Navigation -->
    <nav
        class="fixed top-0 w-full z-50 transition-all duration-300 bg-slate-950/90 backdrop-blur-md border-b border-slate-800/50 no-print">
        <div class="container mx-auto px-6 py-3 flex justify-between items-center">
            <a href="#" class="text-lg font-bold tracking-tight text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-teal-400">radio_button_unchecked</span>
                <span>Rahit<span class="text-teal-400">.PhD</span></span>
            </a>
            <!-- Desktop Nav -->
            <div class="hidden lg:flex items-center gap-6 text-sm font-medium">
                <a href="#about" class="hover:text-teal-400 transition-colors">About</a>
                <a href="#education" class="hover:text-teal-400 transition-colors">Education</a>
                <a href="#experience" class="hover:text-teal-400 transition-colors">Experience</a>
                <a href="#research" class="hover:text-teal-400 transition-colors">Research</a>
                <a href="#service" class="hover:text-teal-400 transition-colors">Service</a>
                <a href="#contact"
                    class="px-4 py-2 bg-teal-500/10 text-teal-400 border border-teal-500/50 rounded-full hover:bg-teal-500 hover:text-white transition-all">Contact</a>
            </div>
            <!-- Mobile Menu Toggle -->
            <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
                class="lg:hidden text-white p-2">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu"
            class="hidden absolute top-full left-0 w-full bg-slate-900 border-b border-slate-800 p-4 flex flex-col gap-4 lg:hidden shadow-2xl">
            <a href="#about" class="text-slate-300 hover:text-teal-400">About</a>
            <a href="#education" class="text-slate-300 hover:text-teal-400">Education</a>
            <a href="#experience" class="text-slate-300 hover:text-teal-400">Experience</a>
            <a href="#research" class="text-slate-300 hover:text-teal-400">Research</a>
            <a href="#service" class="text-slate-300 hover:text-teal-400">Service</a>
        </div>
    </nav>

    <!-- Download/Print Button -->
    <button onclick="window.print()"
        class="fixed bottom-6 right-6 z-50 bg-teal-600 hover:bg-teal-500 text-white p-4 rounded-full shadow-2xl shadow-teal-500/30 transition-all hover:scale-110 flex items-center gap-2 group no-print"
        title="Print / Save as PDF">
        <span class="material-symbols-outlined group-hover:animate-bounce">print</span>
        <span class="font-bold pr-2 hidden group-hover:inline-block">Print CV</span>
    </button>

    <!-- Hero Section -->
    <header id="about" class="relative pt-32 pb-20 overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-10 pointer-events-none">
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-teal-500/20 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-blue-600/20 rounded-full blur-[100px]"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-12 gap-12 items-start">
                <!-- Left Info -->
                <div class="lg:col-span-7 space-y-6 animate-fade-in-up">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-500/10 border border-teal-500/20 text-teal-400 text-xs font-bold uppercase tracking-wider">
                        Computational Oncology • Rare Disease • AI
                    </div>
                    <h1 class="text-5xl md:text-6xl font-bold text-white leading-tight">
                        K.M. Tahsin <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-blue-500">Hassan
                            Rahit</span>
                        <span class="text-2xl text-slate-500 block mt-2 font-mono">Ph.D.</span>
                    </h1>
                    <p class="text-xl text-slate-400 font-light leading-relaxed">
                        A researcher and educator specialized in <strong>"low-resource" problems</strong> in oncology
                        and genomics.
                        Passionate about integrating biological data modalities with <strong>Artificial
                            Intelligence</strong> (esp. Graph Networks) to solve mysteries in <strong>Rare
                            Cancer</strong>.
                    </p>

                    <div class="grid grid-cols-2 gap-4 pt-4">
                        <div class="glass-panel p-4 rounded-lg">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="material-symbols-outlined text-teal-400">hub</span>
                                <h3 class="font-bold text-white">Research Focus</h3>
                            </div>
                            <p class="text-sm text-slate-400">Biological Networks, Knowledge Graphs, Representation
                                Learning, Oncology, Rare Cancer, OMICS.</p>
                        </div>
                        <div class="glass-panel p-4 rounded-lg">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="material-symbols-outlined text-blue-400">psychology</span>
                                <h3 class="font-bold text-white">Technical Core</h3>
                            </div>
                            <p class="text-sm text-slate-400">GNN, NLP, Machine Learning, Game Theory, Low-resource
                                Language Models.</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-4 pt-6">
                        <a href="mailto:kmtahsinhassan.rahit@ucalgary.ca"
                            class="flex items-center gap-2 px-5 py-2.5 bg-teal-600 hover:bg-teal-500 text-white rounded-lg transition-all font-medium">
                            <span class="material-symbols-outlined">mail</span> Email Me
                        </a>
                        <a href="https://linkedin.com/in/rahit" target="_blank"
                            class="flex items-center gap-2 px-5 py-2.5 bg-slate-800 border border-slate-700 hover:border-teal-500 text-white rounded-lg transition-all">
                            LinkedIn
                        </a>
                        <a href="https://github.com/rahit" target="_blank"
                            class="flex items-center gap-2 px-5 py-2.5 bg-slate-800 border border-slate-700 hover:border-teal-500 text-white rounded-lg transition-all">
                            GitHub
                        </a>
                        <a href="http://tahsinrahit.com" target="_blank"
                            class="flex items-center gap-2 px-5 py-2.5 bg-slate-800 border border-slate-700 hover:border-teal-500 text-white rounded-lg transition-all">
                            <span class="material-symbols-outlined">language</span> Website
                        </a>
                    </div>

                    <div class="flex items-center gap-2 text-slate-500 text-sm mt-4">
                        <span class="material-symbols-outlined text-base">call</span> +1 (587) 664 6209
                        <span class="mx-2">•</span>
                        <span class="material-symbols-outlined text-base">location_on</span> Calgary, Canada
                    </div>
                </div>

                <!-- Right Visual -->
                <div class="lg:col-span-5 relative hidden lg:block animate-fade-in-up" style="animation-delay: 0.2s">
                    <div
                        class="glass-panel p-2 rounded-2xl shadow-2xl transform rotate-2 hover:rotate-0 transition-transform duration-500">
                        <!-- REPLACE THIS URL WITH YOUR ACTUAL PHOTO URL -->
                        <img src="https://ui-avatars.com/api/?name=Tahsin+Rahit&background=0F172A&color=fff&size=512"
                            alt="Dr. K.M. Tahsin Hassan Rahit" class="w-full h-auto rounded-xl bg-slate-800">
                    </div>
                    <!-- Stats/Highlights Floating Cards -->
                    <div
                        class="absolute -bottom-6 -left-6 glass-panel p-4 rounded-xl shadow-xl border-l-4 border-teal-500 bg-slate-900/90">
                        <div class="text-2xl font-bold text-white">7+</div>
                        <div class="text-xs text-slate-400 uppercase">Years Research Exp</div>
                    </div>
                    <div
                        class="absolute top-10 -right-6 glass-panel p-4 rounded-xl shadow-xl border-l-4 border-blue-500 bg-slate-900/90">
                        <div class="text-2xl font-bold text-white">Postdoc</div>
                        <div class="text-xs text-slate-400 uppercase">Current Role</div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Education Section -->
    <section id="education" class="py-20 bg-slate-900">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-white mb-12 section-heading">Education</h2>
            <div class="space-y-8">
                <!-- PhD -->
                <div class="relative pl-8 border-l border-slate-700">
                    <div class="absolute -left-1.5 top-0 w-3 h-3 rounded-full bg-teal-500 ring-4 ring-slate-900"></div>
                    <div
                        class="bg-slate-800/50 p-6 rounded-xl border border-slate-700/50 hover:border-teal-500/30 transition-all">
                        <div class="flex flex-col md:flex-row md:items-center justify-between mb-2">
                            <h3 class="text-xl font-bold text-white">Ph.D. in Biochemistry &amp; Molecular Biology
                                (Bioinformatics)</h3>
                            <span class="text-teal-400 font-mono text-sm">Sept 2018 – Aug 2024</span>
                        </div>
                        <h4 class="text-lg text-slate-300 mb-4">University of Calgary, Canada</h4>
                        <div class="space-y-3 text-slate-400 text-sm">
                            <p><strong class="text-slate-300">Research Area:</strong> Machine learning &amp; Artificial
                                Intelligence for Rare disease genomics</p>
                            <p><strong class="text-slate-300">Tech Stack:</strong> Graph Neural Network (GNN), NLP,
                                Classification models (DT, RF, Logit Reg.), SnakeMake, HPC (SLURM), Python [PyTorch,
                                Dask, Kedro, Pandas, Numpy, Scikit-learn, Matplotlib], PowerBI, R, NVivo, Docker,
                                Singularity.</p>
                            <div class="bg-slate-900/50 p-3 rounded border-l-2 border-teal-500 italic">
                                "Designed and developed innovative AI models and workflows based on genome data.
                                Demonstrated ability to solve complicated problems with innovative solutions."
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MSc -->
                <div class="relative pl-8 border-l border-slate-700">
                    <div class="absolute -left-1.5 top-0 w-3 h-3 rounded-full bg-slate-600 ring-4 ring-slate-900"></div>
                    <div
                        class="bg-slate-800/50 p-6 rounded-xl border border-slate-700/50 hover:border-teal-500/30 transition-all">
                        <div class="flex flex-col md:flex-row md:items-center justify-between mb-2">
                            <h3 class="text-xl font-bold text-white">M.Sc. in Intelligent Systems</h3>
                            <span class="text-slate-400 font-mono text-sm">Jan 2016 – Feb 2017</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="text-lg text-slate-300">American International University-Bangladesh</h4>
                            <span class="bg-teal-500/10 text-teal-400 px-2 py-1 rounded text-xs font-bold">GPA:
                                3.90/4.00</span>
                        </div>
                        <div class="space-y-2 text-slate-400 text-sm">
                            <p><strong class="text-slate-300">Research Area:</strong> Natural Language Processing (NLP)
                            </p>
                            <p><strong class="text-slate-300">Key Contribution:</strong> Contributed in developing
                                WordNet for Bengali language.</p>
                            <p><strong class="text-slate-300">Tech Stack:</strong> Python [Tensorflow, Keras, Pandas,
                                Numpy, Scikit-learn], Protege.</p>
                        </div>
                    </div>
                </div>

                <!-- BSc -->
                <div class="relative pl-8 border-l border-slate-700">
                    <div class="absolute -left-1.5 top-0 w-3 h-3 rounded-full bg-slate-600 ring-4 ring-slate-900"></div>
                    <div
                        class="bg-slate-800/50 p-6 rounded-xl border border-slate-700/50 hover:border-teal-500/30 transition-all">
                        <div class="flex flex-col md:flex-row md:items-center justify-between mb-2">
                            <h3 class="text-xl font-bold text-white">B.Sc. in Computer Science &amp; Engineering</h3>
                            <span class="text-slate-400 font-mono text-sm">Jan 2012 – Feb 2016</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="text-lg text-slate-300">American International University-Bangladesh</h4>
                            <span class="bg-teal-500/10 text-teal-400 px-2 py-1 rounded text-xs font-bold">GPA:
                                3.83/4.00</span>
                        </div>
                        <div class="space-y-2 text-slate-400 text-sm">
                            <p><strong class="text-slate-300">Project:</strong> Scrape product reviews &amp; Sentiment
                                analysis.</p>
                            <p><strong class="text-slate-300">Tech Stack:</strong> Python [Scrapy, Django],
                                Elasticsearch.</p>
                        </div>
                    </div>
                </div>

                <!-- Prior Education Toggle -->
                <details class="group relative pl-8 border-l border-slate-700">
                    <summary
                        class="list-none cursor-pointer text-teal-400 text-sm hover:underline flex items-center gap-2 -ml-5">
                        <span class="material-symbols-outlined bg-slate-900 rounded-full">expand_more</span>
                        Show High School &amp; College
                    </summary>
                    <div class="mt-4 space-y-4">
                        <div class="bg-slate-800/30 p-4 rounded-lg">
                            <h5 class="text-white font-bold">High School (Grade 12)</h5>
                            <p class="text-slate-400 text-sm">Notre Dame College, Dhaka (Jun 2009 - Aug 2011) | <span
                                    class="text-teal-400">GPA: 4.60/5.00</span></p>
                        </div>
                        <div class="bg-slate-800/30 p-4 rounded-lg">
                            <h5 class="text-white font-bold">Secondary School (Grade 10)</h5>
                            <p class="text-slate-400 text-sm">B.A.F Shaheen College, Dhaka (Jan 1999 - May 2009) | <span
                                    class="text-teal-400">GPA: 5.00/5.00</span></p>
                        </div>
                    </div>
                </details>
            </div>
        </div>
    </section>

    <!-- Experience Section -->
    <section id="experience" class="py-20 bg-slate-950">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-end mb-12">
                <h2 class="text-3xl font-bold text-white section-heading">Professional Experience</h2>
                <div class="flex gap-2 text-sm no-print">
                    <button onclick="filterExp('all')" class="px-3 py-1 rounded bg-teal-600 text-white">All</button>
                    <button onclick="filterExp('academic')"
                        class="px-3 py-1 rounded bg-slate-800 text-slate-400 hover:bg-slate-700">Academic</button>
                    <button onclick="filterExp('industry')"
                        class="px-3 py-1 rounded bg-slate-800 text-slate-400 hover:bg-slate-700">Industry</button>
                </div>
            </div>
            <!-- EMPTY CONTAINER - FILLED BY JS -->
            <div id="experience-grid" class="grid gap-6"></div>
        </div>
    </section>

    <!-- Research & Publications Section -->
    <section id="research" class="py-20 bg-slate-900">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-white mb-8 section-heading">Publications &amp; Research</h2>

            <!-- Tabs -->
            <div class="flex flex-wrap border-b border-slate-800 mb-8 overflow-x-auto no-print">
                <button onclick="showTab('journal', this)"
                    class="tab-btn active px-6 py-3 text-sm font-medium text-teal-400 border-b-2 border-teal-400">Refereed
                    Articles</button>
                <button onclick="showTab('conference', this)"
                    class="tab-btn px-6 py-3 text-sm font-medium text-slate-400 border-b-2 border-transparent hover:text-white">Conference
                    &amp; Abstracts</button>
                <button onclick="showTab('thesis', this)"
                    class="tab-btn px-6 py-3 text-sm font-medium text-slate-400 border-b-2 border-transparent hover:text-white">Theses
                    &amp; Talks</button>
            </div>

            <!-- Content Containers (EMPTY - FILLED BY JS) -->
            <div id="journal-content" class="tab-content space-y-4 animate-fade-in-up"></div>
            <div id="conference-content" class="tab-content hidden space-y-4 animate-fade-in-up"></div>
            <div id="thesis-content" class="tab-content hidden space-y-4 animate-fade-in-up"></div>
        </div>
    </section>

    <!-- Mentorship & Service (Split Grid) -->
    <section id="service" class="py-20 bg-slate-950">
        <div class="container mx-auto px-6 grid lg:grid-cols-2 gap-12">
            <!-- Mentorship -->
            <div>
                <h3 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-teal-400">school</span> Supervision &amp; Mentorship
                </h3>
                <div class="space-y-4">
                    <div class="p-4 bg-slate-900 border border-slate-800 rounded-lg">
                        <div class="flex justify-between items-start">
                            <h4 class="text-white font-semibold">Maria Mansi (Summer Student)</h4>
                            <span class="text-xs text-slate-500">2025</span>
                        </div>
                        <p class="text-sm text-slate-400 mt-1">@Bose Lab, UofC. Project: Creating a single cell
                            transcriptomic atlas for HPV+ oropharyngeal cancer.</p>
                    </div>
                    <div class="p-4 bg-slate-900 border border-slate-800 rounded-lg">
                        <div class="flex justify-between items-start">
                            <h4 class="text-white font-semibold">Jamie MacDonald (Summer Student)</h4>
                            <span class="text-xs text-slate-500">2025</span>
                        </div>
                        <p class="text-sm text-slate-400 mt-1">@Bose Lab, UofC. Project: Benchmarking Al models
                            predicting spatial transcriptomics from pathology slides.</p>
                    </div>
                    <div class="p-4 bg-slate-900 border border-slate-800 rounded-lg">
                        <div class="flex justify-between items-start">
                            <h4 class="text-white font-semibold">Andrew Galbraith (Thesis Student)</h4>
                            <span class="text-xs text-slate-500">2020-2022</span>
                        </div>
                        <p class="text-sm text-slate-400 mt-1">@Tarailo-Graovac Lab, UofC. Project: Predicting
                            structural variants from genomic data.</p>
                    </div>
                    <div class="p-4 bg-slate-900 border border-slate-800 rounded-lg">
                        <div class="flex justify-between items-start">
                            <h4 class="text-white font-semibold">Rashidul Hasan Nabil</h4>
                            <span class="text-xs text-slate-500">2016-Present</span>
                        </div>
                        <p class="text-sm text-slate-400 mt-1">Professional mentorship (PhD @ Deakin University).
                            Independent paper collaboration.</p>
                    </div>
                </div>
            </div>

            <!-- Community Service -->
            <div>
                <h3 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-teal-400">diversity_3</span> Community Engagement
                </h3>
                <div class="h-96 overflow-y-auto pr-2 space-y-4 custom-scrollbar">
                    <!-- List via JS -->
                    <ul id="community-list" class="space-y-4 text-sm"></ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Honors & Awards -->
    <section class="py-20 bg-slate-900">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-white mb-8 section-heading">Grants, Honors &amp; Awards</h2>
            <div id="awards-grid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Content via JS -->
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-slate-950 border-t border-slate-800 pt-12 pb-8 text-center no-print">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl font-bold text-white mb-4">Let's Collaborate</h2>
            <p class="text-slate-400 max-w-2xl mx-auto mb-8">
                Always open to discussing new opportunities in Computational Oncology and AI.
            </p>
            <div class="flex justify-center gap-6 mb-8">
                <a href="mailto:kmtahsinhassan.rahit@ucalgary.ca"
                    class="text-teal-400 hover:text-white transition-colors"><span
                        class="material-symbols-outlined">mail</span></a>
                <a href="https://linkedin.com/in/rahit"
                    class="text-teal-400 hover:text-white transition-colors">LinkedIn</a>
                <a href="https://github.com/rahit" class="text-teal-400 hover:text-white transition-colors">GitHub</a>
            </div>
            <p class="text-xs text-slate-600">© 2025 K.M. Tahsin Hassan Rahit. Built with Tailwind CSS.</p>
        </div>
    </footer>

    <?php wp_footer(); ?>

    <!-- Logic -->
    <script>
        // Data
        const experiences = [
            {
                role: "Postdoctoral Associate",
                org: "Bose Lab, Dept of Oncology, University of Calgary",
                period: "Oct 2024 - Present",
                type: "academic",
                desc: "Skills: GNN, CNN, WGS, Spatial transcriptomics, scRNAseq, ATACSeq, histopathology slides data, Radiology data, EHR. Project focused on using AI methods to integrate multiomics data collected from cancer patients. Involved with collaborative projects (POET) and oversee data warehousing/maintenance."
            },
            {
                role: "Sessional Instructor (MDPR 613)",
                org: "University of Calgary (Precision Health Program)",
                period: "May - Jun 2025",
                type: "academic",
                desc: "Course: AI Application in Precision Health. Skills: Lead and manage Post-graduate level course. Designed and ran course for diverse professionals ensuring maximum learning."
            },
            {
                role: "Sessional Instructor (MDSC 523)",
                org: "University of Calgary (Bachelor of Health Science)",
                period: "Sept 2024 - Apr 2025",
                type: "academic",
                desc: "Course: AI Application in Health (3 credits). Proposed modernized curriculum, designed/delivered content, graded multiple assessment methods, managed two TAs."
            },
            {
                role: "Teaching Assistant (MDPR 610)",
                org: "University of Calgary",
                period: "Jan-Apr 2022, 2023, 2024",
                type: "academic",
                desc: "Course: OMICS Application. Helped in teaching, managing course content, communication, grading, creating quiz questions for diverse mature students."
            },
            {
                role: "Machine Learning Developer",
                org: "Stork (storkapp.me)",
                period: "Jan 2019 - Jun 2019",
                type: "industry",
                desc: "Tech Stack: Python [Spacy, Pandas, Numpy, Matplotlib]. Utilized textual big data to train, detect and extract specific information. Built industry level ML model."
            },
            {
                role: "Scientific Officer",
                org: "Bangladesh Atomic Energy Commission (Govt.)",
                period: "Feb 2018 - Jan 2019",
                type: "academic",
                desc: "Tenure tracked scientist at Institute of Computer Science (ICS). Design and develop software based R&D. Tech Stack: SQL, C#, .Net Framework, PowerBI."
            },
            {
                role: "Lecturer",
                org: "Primeasia University",
                period: "Sept 2017 - Jan 2019",
                type: "academic",
                desc: "Courses taken: Data Mining, Web Technology, Programming Language. Curriculum development, lecture delivery, student assessment."
            },
            {
                role: "Software Engineer",
                org: "Job Minister Inc, Canada",
                period: "Sept 2017 - Dec 2017",
                type: "industry",
                desc: "Developed website to display jobs collected from different sources. Tech Stack: Python, Django, MySQL, NodeJS, Docker."
            },
            {
                role: "Project Manager",
                org: "Amujamu Co., LTD, Thailand",
                period: "Aug 2016 - Aug 2017",
                type: "industry",
                desc: "South Asian tourism company. Skills: Scrum (Agile), Basecamp, Trello, Jira. Decision making for software/infrastructure, HR, logistics, procurement. Managed software team."
            },
            {
                role: "Software Engineer",
                org: "Prochito IT Solution",
                period: "Aug 2015 - Jul 2016",
                type: "industry",
                desc: "Tech Stack: Python, PHP, Symfony, PostgreSQL, MongoDB, Docker, ReactJS, Ansible. Design & develop database, software architecture, DevOps for ERP/Web apps."
            },
            {
                role: "Senior Web Programmer",
                org: "Web Technology Bangladesh",
                period: "May 2013 - June 2014",
                type: "industry",
                desc: "Tech Stack: PHP, CakePHP, Java, MariaDB, PostgreSQL. Built PMS for Ministry of Education (EED) and management software for BIAM."
            },
            {
                role: "Freelancer",
                org: "oDesk",
                period: "Feb 2012 - Aug 2015",
                type: "industry",
                desc: "PHP, Python, CakePHP, Django, Pyramid, Drupal. Served clients from USA (Incudigm Network) and Europe (Interfile)."
            }
        ];

        const publications = {
            journal: [
                {
                    year: "2024",
                    title: "GPAD: a natural language processing-based application to extract the gene-disease association discovery information from OMIM",
                    venue: "BMC Bioinformatics 25, 84",
                    doi: "https://doi.org/10.1186/s12859-024-05693-x"
                },
                {
                    year: "2023",
                    title: "MOM: A user-friendly Galaxy workflow to detect modifiers from genome sequencing data using C. elegans",
                    venue: "G3 Genes Genomes Genetics, jkad184",
                    doi: "https://doi.org/10.1093/g3journal/jkad184"
                },
                {
                    year: "2020",
                    title: "Genetic Modifiers and Rare Mendelian Disease",
                    venue: "Genes 2020, 11(3), 239",
                    doi: "https://doi.org/10.3390/genes11030239"
                },
                {
                    year: "2019",
                    title: "Machine Translation from Natural Language to Code using Long-Short Term Memory",
                    venue: "Proceedings of the Future Technologies Conference (FTC) 2019",
                    doi: "https://doi.org/10.1007/978-3-030-32520-6_6"
                },
                {
                    year: "2018",
                    title: "BanglaNet: Towards a WordNet for Bengali Language",
                    venue: "Proceedings of the 9th Global WordNet Conference (GWC 2018)",
                    doi: "https://aclanthology.org/2018.gwc-1.1/"
                }
            ],
            conference: [
                {
                    year: "2023",
                    title: "ModSpy: A Machine Learning model detects Genetic Modifiers from Whole Genome Sequencing data",
                    venue: "3rd BioNet Alberta; Edmonton, Alberta"
                },
                {
                    year: "2023",
                    title: "High Throughput Identification of Genetic Modifiers: A Bioinformatics Approach with Machine Learning",
                    venue: "24th International C. elegans Conference 2023, Glasgow, Scotland (Poster)"
                },
                {
                    year: "2022",
                    title: "*** Reviewers' Choice Award: A Machine Learning-based approach to extract the gene-disease association discovery information from OMIM",
                    venue: "ASHG Annual Meeting 2022, Los Angeles, USA (Poster)"
                },
                {
                    year: "2020",
                    title: "Textual Analyses using NVivo on Thousands of Literature to Extrapolate Insight",
                    venue: "NVivo Conference 2020"
                },
                {
                    year: "2019",
                    title: "Identifying genetic modifiers from Whole Genome Sequencing data",
                    venue: "1st BioNet Alberta; Lethbridge, Alberta"
                },
                {
                    year: "2019",
                    title: "High throughput identification of MCCRP2 genetic modifiers using Caenorhabditis elegans",
                    venue: "ASHG Annual Meeting 2019 (Poster)"
                }
            ],
            thesis: [
                {
                    year: "2014",
                    title: "PhD Dissertation: Unveiling Variability in Rare Disease-Gene Association using Bioinformatics and AI",
                    venue: "University of Calgary"
                },
                {
                    year: "2017",
                    title: "Masters Thesis: BanglaNet: Towards a WordNet for Bengali Language using Cross Lingual WSD",
                    venue: "AIUB"
                },
                {
                    year: "2015",
                    title: "Undergrad Thesis: Product Information Indexing Based on Crowdsourced Review Extraction",
                    venue: "AIUB"
                },
                {
                    year: "Invited Talks",
                    title: "Multiple Seminars (Developmental Biology, Worm Seminar, Bioinformatics Seminar)",
                    venue: "University of Calgary (2019-2022)"
                },
                {
                    year: "Invited Talk",
                    title: "The Zen of Python: Python in Depth and its Frameworks",
                    venue: "AIUB Workshop (2016)"
                }
            ]
        };

        const awards = [
            { name: "Alberta Innovates Postdoctoral Fellowship", year: "2024-now", desc: "Health Innovation and Enhancement (Supports top researchers)." },
            { name: "Charbonneau CSM-Phillips Scholar Award", year: "2024-2026", desc: "Recognizes top talents in CSM. (Declined for fellowship)" },
            { name: "Eyes High Doctoral Recruitment Scholarship", year: "2019-24", desc: "Most prestigious internal UCalgary scholarship." },
            { name: "ACHRI Travel Award", year: "2022", desc: "For impactful research presentation at ASHG." },
            { name: "Alberta Graduate Excellence Scholarship", year: "2019-20", desc: "Outstanding academic achievements." },
            { name: "Global WordNet Conference Travel Award", year: "2018", desc: "Singapore." },
            { name: "Vice Chancellor's Gold Medal", year: "2017", desc: "For M.S. Research work." },
            { name: "Magna Cum Laude", year: "2017", desc: "Excellent academic result." },
            { name: "National ICT Fellowship", year: "2016-18", desc: "Bangladesh Govt. Research fellowship for two consecutive years." },
            { name: "Full Free Scholarship", year: "2012-15", desc: "100% scholarship grant throughout undergraduate degree." }
        ];

        const community = [
            "<strong>Patient Research Advocate (PRA)</strong>, STARS Program, IASLC (2025)",
            "<strong>Patient Advocate</strong>, Canadian ROS1ders (2025)",
            "<strong>Admission Application Reviewer</strong>, BHSc, UCalgary (2025)",
            "<strong>Peer Reviewer</strong>, GENETICS & G3 (2024-now)",
            "<strong>Grant Reviewer</strong>, Digital Research Alliance of Canada (2024)",
            "<strong>Cover Design</strong>, G3 - Genes Genomes Genetics (Nov 2023)",
            "<strong>Poster Judge</strong>, CURE & ACHRI Retreat (2023, 2024)",
            "<strong>Director (Social)</strong>, ACHRITA (2022)",
            "<strong>President</strong>, Bangladeshi Scholars' Association, UCalgary (2020-21)",
            "<strong>Vice President (Finance)</strong>, BSA, UCalgary (2019)",
            "<strong>Instructor</strong>, Science of Living (6-9th grade), Cosmo School (2018)"
        ];

        // Rendering Functions
        function renderExperience(filter) {
            const grid = document.getElementById('experience-grid');
            if (!grid) return;
            grid.innerHTML = '';

            const data = filter === 'all' ? experiences : experiences.filter(e => e.type === filter);

            data.forEach(exp => {
                const div = document.createElement('div');
                div.className = 'bg-slate-800/40 border border-slate-700 rounded-xl p-6 hover:border-teal-500/50 transition-all';
                div.innerHTML = `
                    <div class="flex flex-col md:flex-row justify-between md:items-center mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-white">${exp.role}</h3>
                            <div class="text-teal-400 font-medium">${exp.org}</div>
                        </div>
                        <div class="mt-2 md:mt-0 px-3 py-1 bg-slate-900 rounded text-xs text-slate-400 font-mono border border-slate-800 whitespace-nowrap">
                            ${exp.period}
                        </div>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed">${exp.desc}</p>
                `;
                grid.appendChild(div);
            });
        }

        function renderPublications() {
            // Journals
            const jContainer = document.getElementById('journal-content');
            if (jContainer) {
                jContainer.innerHTML = ''; // Ensure empty
                publications.journal.forEach(pub => {
                    jContainer.innerHTML += `
                        <div class="p-5 bg-slate-800/30 border border-slate-700 rounded-lg hover:bg-slate-800/50 transition-colors group">
                            <div class="flex justify-between items-start gap-4">
                                <div>
                                    <div class="text-xs text-teal-400 mb-1 font-mono">${pub.year} &bull; ${pub.venue}</div>
                                    <h4 class="text-white font-bold text-lg group-hover:text-teal-300 transition-colors">${pub.title}</h4>
                                </div>
                                <a href="${pub.doi}" target="_blank" class="p-2 bg-slate-900 rounded-full text-slate-400 hover:text-white hover:bg-teal-600 transition-all"><span class="material-symbols-outlined text-sm">open_in_new</span></a>
                            </div>
                        </div>
                    `;
                });
            }

            // Conferences
            const cContainer = document.getElementById('conference-content');
            if (cContainer) {
                cContainer.innerHTML = '';
                publications.conference.forEach(pub => {
                    cContainer.innerHTML += `
                        <div class="p-4 bg-slate-800/30 border-l-2 border-slate-600 hover:border-teal-500 pl-4 transition-all">
                            <div class="text-xs text-slate-500 font-mono mb-1">${pub.year}</div>
                            <h4 class="text-slate-200 font-medium">${pub.title}</h4>
                            <div class="text-sm text-slate-500 mt-1 italic">${pub.venue}</div>
                        </div>
                    `;
                });
            }

            // Thesis
            const tContainer = document.getElementById('thesis-content');
            if (tContainer) {
                tContainer.innerHTML = '';
                publications.thesis.forEach(pub => {
                    tContainer.innerHTML += `
                         <div class="p-4 bg-slate-800/30 border-l-2 border-blue-500 pl-4 transition-all">
                            <div class="text-xs text-slate-500 font-mono mb-1">${pub.year}</div>
                            <h4 class="text-white font-bold">${pub.title}</h4>
                            <div class="text-sm text-slate-400 mt-1">${pub.venue}</div>
                        </div>
                    `;
                });
            }
        }

        function renderAwards() {
            const grid = document.getElementById('awards-grid');
            if (!grid) return;
            grid.innerHTML = '';
            awards.forEach(a => {
                grid.innerHTML += `
                    <div class="bg-slate-900 border border-slate-800 p-5 rounded-xl hover:border-teal-500/30 transition-all">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="material-symbols-outlined text-yellow-500">emoji_events</span>
                            <span class="text-xs font-mono text-slate-500">${a.year}</span>
                        </div>
                        <h4 class="text-white font-bold mb-1">${a.name}</h4>
                        <p class="text-xs text-slate-400">${a.desc}</p>
                    </div>
                `;
            });
        }

        function renderCommunity() {
            const list = document.getElementById('community-list');
            if (!list) return;
            list.innerHTML = '';
            community.forEach(c => {
                list.innerHTML += `
                    <li class="flex items-start gap-3 text-slate-300">
                        <span class="material-symbols-outlined text-teal-500 text-sm mt-0.5">check_circle</span>
                        <span>${c}</span>
                    </li>
                `;
            });
        }

        // Tabs
        window.showTab = (type, btn) => {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.getElementById(type + '-content').classList.remove('hidden');

            document.querySelectorAll('.tab-btn').forEach(el => {
                el.classList.remove('text-teal-400', 'border-teal-400');
                el.classList.add('text-slate-400', 'border-transparent');
            });
            btn.classList.remove('text-slate-400', 'border-transparent');
            btn.classList.add('text-teal-400', 'border-teal-400');
        };

        // Experience Filter
        window.filterExp = (type) => {
            renderExperience(type);
            // Visual toggle logic
            const buttons = document.querySelectorAll('#experience button');
            buttons.forEach(b => {
                if (b.onclick.toString().includes(type)) {
                    b.className = 'px-3 py-1 rounded bg-teal-600 text-white';
                } else {
                    b.className = 'px-3 py-1 rounded bg-slate-800 text-slate-400 hover:bg-slate-700';
                }
            });
        };

        // Init
        document.addEventListener('DOMContentLoaded', () => {
            renderExperience('all');
            renderPublications();
            renderAwards();
            renderCommunity();
        });
    </script>
</body>

</html>