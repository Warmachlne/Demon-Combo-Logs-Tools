<?php
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'config.php';
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'functions.php';
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'hunting.php';
?>
<!DOCTYPE html>
<html lang="e">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $config_app["title"]?> - <?php echo $config_app["slogan"]?></title>
    <link rel="icon" href="assets/favicon.png"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-redteam">
        <div class="container">
            <a class="navbar-brand" href="" target="">
                <div class="d-flex align-items-center">
                    <div class="logo-container me-2">
                        <i class="fas fa-crosshairs logo-icon"></i>
                    </div>
                    <div>
                        <div class="logo-main"><?php echo $config_app["title"]?></div>
                        <div class="logo-subtitle"><?php echo $config_app["slogan"]?></div>
                    </div>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"><i class="fas fa-bars text-light"></i></span>
            </button>
            <div class="navbar-nav ms-auto">
                <a href="" class="back-btn">
                    <i class="fas fa-cogs me-2"></i>Tools
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="search-hero">
        <div class="scan-line"></div>
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-10">
                    <h2 class="hero-title">Extract Credentials</h2>
                    <p class="hero-subtitle typewriter-text">Domain-specific data from our available data-sets. Make sure to include your domain extension</p>
                    
                    <!-- Search Form -->
                    <div class="cve-input-container">
                        <form action="loot.php" method="POST">
                            <div class="cve-input-group">
                                <input type="text" 
                                       class="form-control cve-input" 
                                       name="search_url" 
                                       placeholder="facebook.com" 
                                       value=""
                                       required>
                                <div class="text-center mt-4">
                                    <button class="btn btn-hunt" type="submit">
                                        <i class="fas fa-bullseye me-2"></i>Let's Dance!
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Quick CVE Buttons
                    <div class="text-center mt-5">
                        <p class="text-light mb-3">Quick Test CVEs:</p>
                        <div class="quick-cve-grid">
                            <div class="quick-cve" onclick="setCVE('CVE-2021-44228')">
                                <i class="fas fa-fire me-2"></i>Log4Shell
                            </div>
                            <div class="quick-cve" onclick="setCVE('CVE-2021-34527')">
                                <i class="fas fa-print me-2"></i>PrintNightmare
                            </div>
                            <div class="quick-cve" onclick="setCVE('CVE-2020-1472')">
                                <i class="fas fa-shield-alt me-2"></i>ZeroLogon
                            </div>
                            <div class="quick-cve" onclick="setCVE('CVE-2019-0708')">
                                <i class="fas fa-desktop me-2"></i>BlueKeep
                            </div>
                        </div>
                    </div> -->

                </div>
            </div>

            <!-- Features -->
            <div id="features" class="feature-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h4 class="text-light">Credential Datasets</h4>
                    <p class="text-light">Scans through <span class="text-warning stat-number" style="font-size: 18px;">~<?=count($data);?></span> rows of data and handles processing & sorting for you</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h4 class="text-light">Real-time Analysis</h4>
                    <p class="text-light">Gets live data from 3rd party sources like checkers, api's, pwn-checkers</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h4 class="text-light">Search Results</h4>
                    <p class="text-light">Options to convert results in formats like JSON, CVE, TXT, Combolist</p>
                </div>
            </div>

            <!-- Stats
            <div id="stats" class="stats-section">
                <div class="row">
                    <div class="col-md-3 col-6 stat-item">
                        <div class="stat-number">15+</div>
                        <div class="stat-label">Verified Sources</div>
                    </div>
                    <div class="col-md-3 col-6 stat-item">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Live Checking</div>
                    </div>
                    <div class="col-md-3 col-6 stat-item">
                        <div class="stat-number">420+</div>
                        <div class="stat-label">Accounts Available</div>
                    </div>
                    <div class="col-md-3 col-6 stat-item">
                        <div class="stat-number">RedTeam</div>
                        <div class="stat-label">Data Gathering</div>
                    </div>
                </div>
            </div> -->

            <!-- About Section -->
            <div id="about" class="about-section text-center mt-5">
                <div class="glass-card">
                    <div class="card-body">
                        <h3 class="text-warning mb-3"><?php echo $config_app["title"]?></h3>
                        <p class="text-muted">
                            Our credentials database is being gathered by extracting and processing HQ & Private Stealers & Bot-net data-sets. Our database assets we have gathered over many years of working and collecting. Be careful when using checker tools, if you use them wrong - you will just get all the bulk of accounts blocked.
                        </p>
                    </div>
                </div>
            </div>
            <!--
            <div class="glass-card-2">
                <h2 class="section-title">📊 System Status Information</h2>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="text-light">
                            <li>✅ Basic CVE Information</li>
                            <li>✅ CVSS Scores &amp; Severity</li>
                            <li>✅ Exploit Sources</li>
                            <li>✅ GitHub Proof-of-Concepts</li>
                            <li>✅ Verified Database Links</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="text-light">
                            <li>✅ Technical Resources</li>
                            <li>✅ Attack Analysis</li>
                            <li>✅ RedTeam Recommendations</li>
                            <li>✅ Priority Assessment</li>
                            <li>✅ Live Verification</li>
                        </ul>
                    </div>
                </div>
            </div>
            -->
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer mt-0">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="mb-0 text-light">
                        <span class="text-warning">Warmachine.exe</span>
                        <span class="text-muted"> - HackForums.net</span>
                        <br>
                        <small>&copy; 2025 <?php echo $config_app["title"]?>. For authorized use only.</small>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function setCVE(cveId) {
            document.querySelector('input[name="cve_id"]').value = cveId;
            document.querySelector('form').submit();
        }

        // Smooth scrolling for navigation links
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.getAttribute('href').startsWith('#')) {
                        e.preventDefault();
                        const targetId = this.getAttribute('href');
                        const targetElement = document.querySelector(targetId);
                        
                        if (targetElement) {
                            targetElement.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    }
                });
            });

            // Add interactive effects
            const inputs = document.querySelectorAll('.cve-input, .quick-cve');
            
            inputs.forEach(input => {
                input.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                
                input.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>