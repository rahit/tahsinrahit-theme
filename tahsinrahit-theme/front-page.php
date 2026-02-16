<?php
/**
 * Template Name: Front Page
 * Template: front-page
 *
 * The homepage — adapted from cv-raw-template.php
 *
 * @package TahsinRahit
 */

if (!defined('ABSPATH')) {
    exit;
}

/* ---------------------------------------------------------------
 * CV Data Arrays
 * --------------------------------------------------------------- */

$experiences = array(
    array('role' => 'Postdoctoral Associate', 'org' => 'Bose Lab, Dept of Oncology, University of Calgary', 'period' => 'Oct 2024 - Present', 'type' => 'academic', 'desc' => 'Skills: GNN, CNN, WGS, Spatial transcriptomics, scRNAseq, ATACSeq, histopathology slides data, Radiology data, EHR. Project focused on using AI methods to integrate multiomics data collected from cancer patients. Involved with collaborative projects (POET) and oversee data warehousing/maintenance.'),
    array('role' => 'Sessional Instructor (MDPR 613)', 'org' => 'University of Calgary (Precision Health Program)', 'period' => 'May - Jun 2025', 'type' => 'academic', 'desc' => 'Course: AI Application in Precision Health. Skills: Lead and manage Post-graduate level course. Designed and ran course for diverse professionals ensuring maximum learning.'),
    array('role' => 'Sessional Instructor (MDSC 523)', 'org' => 'University of Calgary (Bachelor of Health Science)', 'period' => 'Sept 2024 - Apr 2025', 'type' => 'academic', 'desc' => 'Course: AI Application in Health (3 credits). Proposed modernized curriculum, designed/delivered content, graded multiple assessment methods, managed two TAs.'),
    array('role' => 'Teaching Assistant (MDPR 610)', 'org' => 'University of Calgary', 'period' => 'Jan-Apr 2022, 2023, 2024', 'type' => 'academic', 'desc' => 'Course: OMICS Application. Helped in teaching, managing course content, communication, grading, creating quiz questions for diverse mature students.'),
    array('role' => 'Machine Learning Developer', 'org' => 'Stork (storkapp.me)', 'period' => 'Jan 2019 - Jun 2019', 'type' => 'industry', 'desc' => 'Tech Stack: Python [Spacy, Pandas, Numpy, Matplotlib]. Utilized textual big data to train, detect and extract specific information. Built industry level ML model.'),
    array('role' => 'Scientific Officer', 'org' => 'Bangladesh Atomic Energy Commission (Govt.)', 'period' => 'Feb 2018 - Jan 2019', 'type' => 'academic', 'desc' => 'Tenure tracked scientist at Institute of Computer Science (ICS). Design and develop software based R&D. Tech Stack: SQL, C#, .Net Framework, PowerBI.'),
    array('role' => 'Lecturer', 'org' => 'Primeasia University', 'period' => 'Sept 2017 - Jan 2019', 'type' => 'academic', 'desc' => 'Courses taken: Data Mining, Web Technology, Programming Language. Curriculum development, lecture delivery, student assessment.'),
    array('role' => 'Software Engineer', 'org' => 'Job Minister Inc, Canada', 'period' => 'Sept 2017 - Dec 2017', 'type' => 'industry', 'desc' => 'Developed website to display jobs collected from different sources. Tech Stack: Python, Django, MySQL, NodeJS, Docker.'),
    array('role' => 'Project Manager', 'org' => 'Amujamu Co., LTD, Thailand', 'period' => 'Aug 2016 - Aug 2017', 'type' => 'industry', 'desc' => 'South Asian tourism company. Skills: Scrum (Agile), Basecamp, Trello, Jira. Decision making for software/infrastructure, HR, logistics, procurement. Managed software team.'),
    array('role' => 'Software Engineer', 'org' => 'Prochito IT Solution', 'period' => 'Aug 2015 - Jul 2016', 'type' => 'industry', 'desc' => 'Tech Stack: Python, PHP, Symfony, PostgreSQL, MongoDB, Docker, ReactJS, Ansible. Design & develop database, software architecture, DevOps for ERP/Web apps.'),
    array('role' => 'Senior Web Programmer', 'org' => 'Web Technology Bangladesh', 'period' => 'May 2013 - June 2014', 'type' => 'industry', 'desc' => 'Tech Stack: PHP, CakePHP, Java, MariaDB, PostgreSQL. Built PMS for Ministry of Education (EED) and management software for BIAM.'),
    array('role' => 'Freelancer', 'org' => 'oDesk', 'period' => 'Feb 2012 - Aug 2015', 'type' => 'industry', 'desc' => 'PHP, Python, CakePHP, Django, Pyramid, Drupal. Served clients from USA (Incudigm Network) and Europe (Interfile).'),
);

$publications = array(
    'journal' => array(
        array('year' => '2024', 'title' => 'GPAD: a natural language processing-based application to extract the gene-disease association discovery information from OMIM', 'venue' => 'BMC Bioinformatics 25, 84', 'doi' => 'https://doi.org/10.1186/s12859-024-05693-x'),
        array('year' => '2023', 'title' => 'MOM: A user-friendly Galaxy workflow to detect modifiers from genome sequencing data using C. elegans', 'venue' => 'G3 Genes Genomes Genetics, jkad184', 'doi' => 'https://doi.org/10.1093/g3journal/jkad184'),
        array('year' => '2020', 'title' => 'Genetic Modifiers and Rare Mendelian Disease', 'venue' => 'Genes 2020, 11(3), 239', 'doi' => 'https://doi.org/10.3390/genes11030239'),
        array('year' => '2019', 'title' => 'Machine Translation from Natural Language to Code using Long-Short Term Memory', 'venue' => 'Proceedings of the Future Technologies Conference (FTC) 2019', 'doi' => 'https://doi.org/10.1007/978-3-030-32520-6_6'),
        array('year' => '2018', 'title' => 'BanglaNet: Towards a WordNet for Bengali Language', 'venue' => 'Proceedings of the 9th Global WordNet Conference (GWC 2018)', 'doi' => 'https://aclanthology.org/2018.gwc-1.1/'),
    ),
    'conference' => array(
        array('year' => '2023', 'title' => 'ModSpy: A Machine Learning model detects Genetic Modifiers from Whole Genome Sequencing data', 'venue' => '3rd BioNet Alberta; Edmonton, Alberta'),
        array('year' => '2023', 'title' => 'High Throughput Identification of Genetic Modifiers: A Bioinformatics Approach with Machine Learning', 'venue' => '24th International C. elegans Conference 2023, Glasgow, Scotland (Poster)'),
        array('year' => '2022', 'title' => "Reviewers' Choice Award: A Machine Learning-based approach to extract the gene-disease association discovery information from OMIM", 'venue' => 'ASHG Annual Meeting 2022, Los Angeles, USA (Poster)'),
        array('year' => '2020', 'title' => 'Textual Analyses using NVivo on Thousands of Literature to Extrapolate Insight', 'venue' => 'NVivo Conference 2020'),
        array('year' => '2019', 'title' => 'Identifying genetic modifiers from Whole Genome Sequencing data', 'venue' => '1st BioNet Alberta; Lethbridge, Alberta'),
        array('year' => '2019', 'title' => 'High throughput identification of MCCRP2 genetic modifiers using Caenorhabditis elegans', 'venue' => 'ASHG Annual Meeting 2019 (Poster)'),
    ),
    'thesis' => array(
        array('year' => '2014', 'title' => 'PhD Dissertation: Unveiling Variability in Rare Disease-Gene Association using Bioinformatics and AI', 'venue' => 'University of Calgary'),
        array('year' => '2017', 'title' => 'Masters Thesis: BanglaNet: Towards a WordNet for Bengali Language using Cross Lingual WSD', 'venue' => 'AIUB'),
        array('year' => '2015', 'title' => 'Undergrad Thesis: Product Information Indexing Based on Crowdsourced Review Extraction', 'venue' => 'AIUB'),
        array('year' => 'Invited Talks', 'title' => 'Multiple Seminars (Developmental Biology, Worm Seminar, Bioinformatics Seminar)', 'venue' => 'University of Calgary (2019-2022)'),
        array('year' => 'Invited Talk', 'title' => 'The Zen of Python: Python in Depth and its Frameworks', 'venue' => 'AIUB Workshop (2016)'),
    ),
);

$awards = array(
    array('name' => 'Alberta Innovates Postdoctoral Fellowship', 'year' => '2024-now', 'desc' => 'Health Innovation and Enhancement (Supports top researchers).'),
    array('name' => 'Charbonneau CSM-Phillips Scholar Award', 'year' => '2024-2026', 'desc' => 'Recognizes top talents in CSM. (Declined for fellowship)'),
    array('name' => 'Eyes High Doctoral Recruitment Scholarship', 'year' => '2019-24', 'desc' => 'Most prestigious internal UCalgary scholarship.'),
    array('name' => 'ACHRI Travel Award', 'year' => '2022', 'desc' => 'For impactful research presentation at ASHG.'),
    array('name' => 'Alberta Graduate Excellence Scholarship', 'year' => '2019-20', 'desc' => 'Outstanding academic achievements.'),
    array('name' => 'Global WordNet Conference Travel Award', 'year' => '2018', 'desc' => 'Singapore.'),
    array('name' => "Vice Chancellor's Gold Medal", 'year' => '2017', 'desc' => 'For M.S. Research work.'),
    array('name' => 'Magna Cum Laude', 'year' => '2017', 'desc' => 'Excellent academic result.'),
    array('name' => 'National ICT Fellowship', 'year' => '2016-18', 'desc' => 'Bangladesh Govt. Research fellowship for two consecutive years.'),
    array('name' => 'Full Free Scholarship', 'year' => '2012-15', 'desc' => '100% scholarship grant throughout undergraduate degree.'),
);

$community = array(
    array('role' => 'Patient Research Advocate (PRA)', 'org' => 'STARS Program, IASLC', 'year' => '2025'),
    array('role' => 'Patient Advocate', 'org' => 'Canadian ROS1ders', 'year' => '2025'),
    array('role' => 'Admission Application Reviewer', 'org' => 'BHSc, UCalgary', 'year' => '2025'),
    array('role' => 'Peer Reviewer', 'org' => 'GENETICS & G3', 'year' => '2024-now'),
    array('role' => 'Grant Reviewer', 'org' => 'Digital Research Alliance of Canada', 'year' => '2024'),
    array('role' => 'Cover Design', 'org' => 'G3 - Genes Genomes Genetics', 'year' => 'Nov 2023'),
    array('role' => 'Poster Judge', 'org' => 'CURE & ACHRI Retreat', 'year' => '2023, 2024'),
    array('role' => 'Director (Social)', 'org' => 'ACHRITA', 'year' => '2022'),
    array('role' => 'President', 'org' => "Bangladeshi Scholars' Association, UCalgary", 'year' => '2020-21'),
    array('role' => 'Vice President (Finance)', 'org' => 'BSA, UCalgary', 'year' => '2019'),
    array('role' => 'Instructor', 'org' => 'Science of Living (6-9th grade), Cosmo School', 'year' => '2018'),
);

get_header();
?>

<!-- Hero Section -->
<header id="about" class="hero">
    <div class="container">
        <div class="hero__grid">
            <!-- Left Info -->
            <div class="fade-in-up" style="display:flex;flex-direction:column;gap:var(--space-6);">
                <div class="hero__badge">
                    <?php echo esc_html__('Computational Oncology • Rare Disease • AI', 'tahsinrahit'); ?>
                </div>

                <h1 class="hero__title">
                    K.M. Tahsin <span class="hero__title-gradient">Hassan Rahit</span>
                    <span class="hero__title-suffix">
                        <?php echo esc_html(tahsinrahit_get_profile_title()); ?>
                    </span>
                </h1>

                <p class="hero__desc">
                    <?php echo wp_kses_post(__('A researcher and educator specialized in <strong>"low-resource" problems</strong> in oncology and genomics. Passionate about integrating biological data modalities with <strong>Artificial Intelligence</strong> (esp. Graph Networks) to solve mysteries in <strong>Rare Cancer</strong>.', 'tahsinrahit')); ?>
                </p>

                <div class="hero__cards">
                    <div class="glass-panel hero__card" style="padding:var(--space-4);border-radius:var(--radius-lg);">
                        <div style="display:flex;align-items:center;gap:var(--space-3);margin-bottom:var(--space-2);">
                            <span class="material-symbols-outlined hero__card-icon" aria-hidden="true">hub</span>
                            <h3>
                                <?php echo esc_html__('Research Focus', 'tahsinrahit'); ?>
                            </h3>
                        </div>
                        <p>
                            <?php echo esc_html__('Biological Networks, Knowledge Graphs, Representation Learning, Oncology, Rare Cancer, OMICS.', 'tahsinrahit'); ?>
                        </p>
                    </div>
                    <div class="glass-panel hero__card" style="padding:var(--space-4);border-radius:var(--radius-lg);">
                        <div style="display:flex;align-items:center;gap:var(--space-3);margin-bottom:var(--space-2);">
                            <span class="material-symbols-outlined hero__card-icon--alt"
                                aria-hidden="true">psychology</span>
                            <h3>
                                <?php echo esc_html__('Technical Core', 'tahsinrahit'); ?>
                            </h3>
                        </div>
                        <p>
                            <?php echo esc_html__('GNN, NLP, Machine Learning, Game Theory, Low-resource Language Models.', 'tahsinrahit'); ?>
                        </p>
                    </div>
                </div>

                <div class="hero__actions">
                    <?php $email_url = tahsinrahit_get_social_url('email'); ?>
                    <?php if ($email_url): ?>
                        <a href="<?php echo esc_url($email_url); ?>" class="btn btn--primary">
                            <span class="material-symbols-outlined" aria-hidden="true">mail</span>
                            <?php echo esc_html__('Email Me', 'tahsinrahit'); ?>
                        </a>
                    <?php endif; ?>

                    <?php $linkedin_url = tahsinrahit_get_social_url('linkedin'); ?>
                    <?php if ($linkedin_url): ?>
                        <a href="<?php echo esc_url($linkedin_url); ?>" target="_blank" rel="noopener noreferrer"
                            class="btn btn--secondary">
                            <?php echo tahsinrahit_social_icon('linkedin'); // phpcs:ignore ?>
                            <?php echo esc_html__('LinkedIn', 'tahsinrahit'); ?>
                        </a>
                    <?php endif; ?>

                    <?php $github_url = tahsinrahit_get_social_url('github'); ?>
                    <?php if ($github_url): ?>
                        <a href="<?php echo esc_url($github_url); ?>" target="_blank" rel="noopener noreferrer"
                            class="btn btn--secondary">
                            <?php echo tahsinrahit_social_icon('github'); // phpcs:ignore ?>
                            <?php echo esc_html__('GitHub', 'tahsinrahit'); ?>
                        </a>
                    <?php endif; ?>

                    <?php $scholar_url = tahsinrahit_get_social_url('google_scholar'); ?>
                    <?php if ($scholar_url): ?>
                        <a href="<?php echo esc_url($scholar_url); ?>" target="_blank" rel="noopener noreferrer"
                            class="btn btn--secondary">
                            <?php echo tahsinrahit_social_icon('scholar'); // phpcs:ignore ?>
                            <?php echo esc_html__('Google Scholar', 'tahsinrahit'); ?>
                        </a>
                    <?php endif; ?>

                    <?php $orcid_url = tahsinrahit_get_social_url('orcid'); ?>
                    <?php if ($orcid_url): ?>
                        <a href="<?php echo esc_url($orcid_url); ?>" target="_blank" rel="noopener noreferrer"
                            class="btn btn--secondary">
                            <?php echo tahsinrahit_social_icon('orcid'); // phpcs:ignore ?>
                            <?php echo esc_html__('ORCID', 'tahsinrahit'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Visual -->
            <div class="hero__visual fade-in-up" style="animation-delay: 0.2s;">
                <div class="glass-panel hero__photo-wrap">
                    <img src="<?php echo esc_url('http://www.tahsinrahit.com/wp-content/uploads/2026/01/IMG-20260126-WA0030-1.jpg'); ?>"
                        alt="<?php echo esc_attr__('Dr. K.M. Tahsin Hassan Rahit', 'tahsinrahit'); ?>" loading="lazy"
                        width="500" height="600">
                </div>
                <div class="hero__stat hero__stat--left glass-panel">
                    <div class="hero__stat-value">
                        <?php echo esc_html__('16+', 'tahsinrahit'); ?>
                    </div>
                    <div class="hero__stat-label">
                        <?php echo esc_html__('Years of experience', 'tahsinrahit'); ?>
                    </div>
                </div>
                <div class="hero__stat hero__stat--right glass-panel">
                    <div class="hero__stat-value">
                        <?php echo esc_html__('Postdoc', 'tahsinrahit'); ?>
                    </div>
                    <div class="hero__stat-label">
                        <?php echo esc_html__('Current Role', 'tahsinrahit'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Education Section -->
<section id="education" class="section section--alt">
    <div class="container">
        <?php tahsinrahit_section_heading(__('Education', 'tahsinrahit'), 'education-heading'); ?>

        <div class="edu-grid">
            <!-- PhD -->
            <div class="glass-panel edu-card reveal">
                <div class="edu-card__header">
                    <div class="edu-card__icon">
                        <span class="material-symbols-outlined" aria-hidden="true">school</span>
                    </div>
                    <div>
                        <div class="edu-card__degree">
                            <?php echo esc_html__('Ph.D. in Biochemistry & Molecular Biology', 'tahsinrahit'); ?>
                        </div>
                        <div class="edu-card__school">
                            <?php echo esc_html__('University of Calgary, Canada', 'tahsinrahit'); ?>
                        </div>
                        <div class="edu-card__period">
                            <?php echo esc_html__('2019 — 2024', 'tahsinrahit'); ?>
                        </div>
                    </div>
                </div>
                <p class="edu-card__details">
                    <?php echo esc_html__('Specialization: Bioinformatics & Rare Disease Genetics. Focus on developing computational tools and machine learning models for genetic modifier identification.', 'tahsinrahit'); ?>
                </p>
                <div class="edu-card__thesis">
                    <strong>
                        <?php echo esc_html__('Thesis:', 'tahsinrahit'); ?>
                    </strong>
                    <?php echo esc_html__('Unveiling Variability in Rare Disease-Gene Association using Bioinformatics and AI', 'tahsinrahit'); ?>
                </div>
            </div>

            <!-- MSc -->
            <div class="glass-panel edu-card reveal">
                <div class="edu-card__header">
                    <div class="edu-card__icon">
                        <span class="material-symbols-outlined" aria-hidden="true">school</span>
                    </div>
                    <div>
                        <div class="edu-card__degree">
                            <?php echo esc_html__('M.Sc. in Computer Science', 'tahsinrahit'); ?>
                        </div>
                        <div class="edu-card__school">
                            <?php echo esc_html__('American International University-Bangladesh (AIUB)', 'tahsinrahit'); ?>
                        </div>
                        <div class="edu-card__period">
                            <?php echo esc_html__('2015 — 2017', 'tahsinrahit'); ?>
                        </div>
                    </div>
                </div>
                <p class="edu-card__details">
                    <?php echo esc_html__("Vice Chancellor's Gold Medal. Magna Cum Laude. Focus on NLP and Cross-Lingual approaches.", 'tahsinrahit'); ?>
                </p>
                <div class="edu-card__thesis">
                    <strong>
                        <?php echo esc_html__('Thesis:', 'tahsinrahit'); ?>
                    </strong>
                    <?php echo esc_html__('BanglaNet: Towards a WordNet for Bengali Language using Cross Lingual WSD', 'tahsinrahit'); ?>
                </div>
            </div>

            <!-- BSc -->
            <div class="glass-panel edu-card reveal">
                <div class="edu-card__header">
                    <div class="edu-card__icon">
                        <span class="material-symbols-outlined" aria-hidden="true">school</span>
                    </div>
                    <div>
                        <div class="edu-card__degree">
                            <?php echo esc_html__('B.Sc. in Computer Science & Engineering', 'tahsinrahit'); ?>
                        </div>
                        <div class="edu-card__school">
                            <?php echo esc_html__('American International University-Bangladesh (AIUB)', 'tahsinrahit'); ?>
                        </div>
                        <div class="edu-card__period">
                            <?php echo esc_html__('2012 — 2015', 'tahsinrahit'); ?>
                        </div>
                    </div>
                </div>
                <p class="edu-card__details">
                    <?php echo esc_html__('Full Free Scholarship. Focus on Software Engineering and Data Mining.', 'tahsinrahit'); ?>
                </p>
            </div>

            <!-- Prior Education Toggle -->
            <button class="edu-toggle" id="edu-toggle" type="button">
                <span class="material-symbols-outlined" aria-hidden="true">expand_more</span>
                <?php echo esc_html__('Show Prior Education', 'tahsinrahit'); ?>
            </button>

            <div id="edu-prior" class="edu-prior">
                <div class="glass-panel edu-card">
                    <div class="edu-card__header">
                        <div class="edu-card__icon">
                            <span class="material-symbols-outlined" aria-hidden="true">menu_book</span>
                        </div>
                        <div>
                            <div class="edu-card__degree">
                                <?php echo esc_html__('Higher Secondary Certificate (HSC)', 'tahsinrahit'); ?>
                            </div>
                            <div class="edu-card__school">
                                <?php echo esc_html__('Notre Dame College, Dhaka', 'tahsinrahit'); ?>
                            </div>
                            <div class="edu-card__period">
                                <?php echo esc_html__('2009 — 2011', 'tahsinrahit'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Experience Section -->
<section id="experience" class="section">
    <div class="container">
        <?php tahsinrahit_section_heading(__('Experience', 'tahsinrahit'), 'experience-heading'); ?>

        <div class="exp-filters">
            <button class="exp-filter-btn active" data-filter="all" type="button">
                <?php echo esc_html__('All', 'tahsinrahit'); ?>
            </button>
            <button class="exp-filter-btn" data-filter="academic" type="button">
                <?php echo esc_html__('Academic', 'tahsinrahit'); ?>
            </button>
            <button class="exp-filter-btn" data-filter="industry" type="button">
                <?php echo esc_html__('Industry', 'tahsinrahit'); ?>
            </button>
        </div>

        <div class="exp-grid" id="experience-grid">
            <?php foreach ($experiences as $exp): ?>
                <div class="glass-panel exp-card reveal" data-type="<?php echo esc_attr($exp['type']); ?>">
                    <div class="exp-card__header">
                        <div>
                            <div class="exp-card__role">
                                <?php echo esc_html($exp['role']); ?>
                            </div>
                            <div class="exp-card__org">
                                <?php echo esc_html($exp['org']); ?>
                            </div>
                        </div>
                        <span class="exp-card__type exp-card__type--<?php echo esc_attr($exp['type']); ?>">
                            <?php echo esc_html(ucfirst($exp['type'])); ?>
                        </span>
                    </div>
                    <div class="exp-card__period">
                        <?php echo esc_html($exp['period']); ?>
                    </div>
                    <p class="exp-card__desc">
                        <?php echo esc_html($exp['desc']); ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Research & Publications Section -->
<section id="research" class="section section--alt">
    <div class="container">
        <?php tahsinrahit_section_heading(__('Research & Publications', 'tahsinrahit'), 'research-heading'); ?>

        <div class="research-tabs">
            <button class="research-tab active" data-tab="panel-journal" type="button">
                <?php echo esc_html__('Refereed Articles', 'tahsinrahit'); ?>
            </button>
            <button class="research-tab" data-tab="panel-conference" type="button">
                <?php echo esc_html__('Conference & Abstracts', 'tahsinrahit'); ?>
            </button>
            <button class="research-tab" data-tab="panel-thesis" type="button">
                <?php echo esc_html__('Theses & Talks', 'tahsinrahit'); ?>
            </button>
        </div>

        <!-- Journal Panel -->
        <div class="research-panel active" id="panel-journal">
            <?php foreach ($publications['journal'] as $pub): ?>
                <div class="glass-panel pub-item">
                    <div class="pub-item__venue">
                        <?php echo esc_html($pub['year'] . ' · ' . $pub['venue']); ?>
                    </div>
                    <div class="pub-item__title">
                        <?php if (!empty($pub['doi'])): ?>
                            <a href="<?php echo esc_url($pub['doi']); ?>" target="_blank" rel="noopener noreferrer">
                                <?php echo esc_html($pub['title']); ?>
                                <span class="material-symbols-outlined" style="font-size:14px;vertical-align:middle;"
                                    aria-hidden="true">open_in_new</span>
                            </a>
                        <?php else: ?>
                            <?php echo esc_html($pub['title']); ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Conference Panel -->
        <div class="research-panel" id="panel-conference">
            <?php foreach ($publications['conference'] as $pub): ?>
                <div class="glass-panel pub-item">
                    <div class="pub-item__venue">
                        <?php echo esc_html($pub['year'] . ' · ' . $pub['venue']); ?>
                    </div>
                    <div class="pub-item__title">
                        <?php echo esc_html($pub['title']); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Thesis & Talks Panel -->
        <div class="research-panel" id="panel-thesis">
            <?php foreach ($publications['thesis'] as $pub): ?>
                <div class="glass-panel pub-item">
                    <div class="pub-item__venue">
                        <?php echo esc_html($pub['year'] . ' · ' . $pub['venue']); ?>
                    </div>
                    <div class="pub-item__title">
                        <?php echo esc_html($pub['title']); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Mentorship & Service Section -->
<section id="service" class="section">
    <div class="container">
        <?php tahsinrahit_section_heading(__('Service & Community', 'tahsinrahit'), 'service-heading'); ?>

        <div class="service-grid">
            <!-- Mentorship -->
            <div class="reveal">
                <h3 style="margin-bottom:var(--space-6);">
                    <?php echo esc_html__('Mentorship', 'tahsinrahit'); ?>
                </h3>
                <ul class="service-list">
                    <li>
                        <span class="icon material-symbols-outlined" aria-hidden="true">person</span>
                        <div>
                            <strong>
                                <?php echo esc_html__('Graduate Students', 'tahsinrahit'); ?>
                            </strong>
                            <p>
                                <?php echo esc_html__('Mentored multiple graduate and undergraduate students in bioinformatics and computational biology research projects.', 'tahsinrahit'); ?>
                            </p>
                        </div>
                    </li>
                    <li>
                        <span class="icon material-symbols-outlined" aria-hidden="true">groups</span>
                        <div>
                            <strong>
                                <?php echo esc_html__('Teaching Assistants', 'tahsinrahit'); ?>
                            </strong>
                            <p>
                                <?php echo esc_html__('Supervised TAs for MDSC 523 and coordinated course delivery.', 'tahsinrahit'); ?>
                            </p>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Community Service -->
            <div class="reveal">
                <h3 style="margin-bottom:var(--space-6);">
                    <?php echo esc_html__('Community Service', 'tahsinrahit'); ?>
                </h3>
                <ul class="service-list">
                    <?php foreach ($community as $item): ?>
                        <li>
                            <span class="icon material-symbols-outlined" aria-hidden="true">volunteer_activism</span>
                            <div>
                                <strong>
                                    <?php echo esc_html($item['role']); ?>
                                </strong>
                                <span style="color:var(--color-text-muted);font-size:var(--text-xs);"> —
                                    <?php echo esc_html($item['org']); ?> (
                                    <?php echo esc_html($item['year']); ?>)
                                </span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Honors & Awards Section -->
<section id="awards" class="section section--alt">
    <div class="container">
        <?php tahsinrahit_section_heading(__('Honors & Awards', 'tahsinrahit'), 'awards-heading'); ?>

        <div class="awards-grid">
            <?php foreach ($awards as $award): ?>
                <div class="glass-panel award-card reveal">
                    <div class="award-card__icon">
                        <span class="material-symbols-outlined" aria-hidden="true">emoji_events</span>
                    </div>
                    <div class="award-card__title">
                        <?php echo esc_html($award['name']); ?>
                    </div>
                    <div class="award-card__year">
                        <?php echo esc_html($award['year']); ?>
                    </div>
                    <div class="award-card__org">
                        <?php echo esc_html($award['desc']); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="section">
    <div class="container">
        <?php tahsinrahit_section_heading(__('Get In Touch', 'tahsinrahit'), 'contact-heading'); ?>

        <div class="contact-grid">
            <div class="contact-info reveal">
                <p style="max-width:600px;text-align:center;margin-bottom:var(--space-6);">
                    <?php echo esc_html__("I'm always open to discussing research collaborations, teaching opportunities, or interesting projects. Feel free to reach out!", 'tahsinrahit'); ?>
                </p>

                <?php $email = get_theme_mod('tahsinrahit_social_email', ''); ?>
                <?php if ($email): ?>
                    <div class="contact-item">
                        <span class="icon material-symbols-outlined" aria-hidden="true">mail</span>
                        <a href="mailto:<?php echo esc_attr(sanitize_email($email)); ?>">
                            <?php echo esc_html(sanitize_email($email)); ?>
                        </a>
                    </div>
                <?php endif; ?>

                <div class="contact-item">
                    <span class="icon material-symbols-outlined" aria-hidden="true">location_on</span>
                    <span>
                        <?php echo esc_html__('Calgary, Alberta, Canada', 'tahsinrahit'); ?>
                    </span>
                </div>

                <div style="display:flex;gap:var(--space-3);margin-top:var(--space-4);">
                    <?php
                    $contact_socials = array('github', 'linkedin', 'google_scholar', 'orcid');
                    foreach ($contact_socials as $key):
                        $url = tahsinrahit_get_social_url($key);
                        if ($url):
                            ?>
                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer"
                                class="footer-social__link"
                                aria-label="<?php echo esc_attr(ucfirst(str_replace('_', ' ', $key))); ?>">
                                <?php echo tahsinrahit_social_icon(str_replace('google_scholar', 'scholar', $key)); // phpcs:ignore ?>
                            </a>
                            <?php
                        endif;
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>