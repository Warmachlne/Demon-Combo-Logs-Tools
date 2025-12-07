<?php
session_start();
require_once __DIR__ . DIRECTORY_SEPARATOR . 'config.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'functions.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'hunting.php';

if (isset($_GET['download']) && $_GET['download'] === 'txt') {
    $rows = $_SESSION['last_result'] ?? null;
    if (empty($rows)) {
        header("Location: ../?veryVeryIdiot");
        exit;
    }
    header('Content-Type: text/plain; charset=utf-8');
    header('Content-Disposition: attachment; filename="results.txt"');
    $out = fopen('php://output', 'w');
    foreach ($rows as $r) {
        $lineParts = [];
        //$lineParts[] = isset($r['url']) ? $r['url'] : '';
        $lineParts[] = isset($r['login']) ? $r['login'] : '';
        $lineParts[] = isset($r['password']) ? $r['password'] : '';
        fwrite($out, implode(':', $lineParts) . "\n");
    }
    fclose($out);
    exit;
}

if (isset($_GET['download']) && $_GET['download'] === 'json') {
    $rows = $_SESSION['last_result'] ?? null;
    if (empty($rows)) {
        header("Location: ../?veryVeryIdiot");
        exit;
    }
    header('Content-Type: application/json; charset=utf-8');
    header('Content-Disposition: attachment; filename="results.json"');
    echo json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

if (isset($_POST["search_url"])) {
    if (count($result) == 0) {
        header("Location: ../?veryVeryIdiot");
        exit;
    }
    // store last results so downloads can be triggered via GET
    $_SESSION['last_result'] = $result;
} else {
    header("Location: ../?veryVeryIdiot");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$config_app["title"]?> - <?=$config_app["slogan"]?></title>
    <link rel="icon" href="assets/favicon.png"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>
    span.copyText {
        position: relative;
        display: block;
    }
    textarea {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0 none transparent;
        margin: 0;
        padding: 0;
        outline: none;
        resize: none;
        overflow: hidden;
        font-family: inherit;
        font-size: 1em;
    }
    </style>    
</head>
<body class="text-reset">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-redteam">
        <div class="container">
            <a class="navbar-brand" href="" target="">
                <div class="d-flex align-items-center">
                    <div class="logo-container me-2">
                        <i class="fas fa-crosshairs logo-icon"></i>
                    </div>
                    <div>
                        <div class="logo-main"><?=$config_app["title"]?></div>
                        <div class="logo-subtitle"><?=$config_app["slogan"]?></div>
                    </div>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"><i class="fas fa-bars text-light"></i></span>
            </button>
            <div class="navbar-nav ms-auto">
                <a href="../" target="" class="btn btn-outline-dark text-warning">
                    <i class="fa fa-search me-2"></i> 2 Hunts Left
                </a>
                <a href="../" target="" class="btn btn-outline-dark text-success ms-2">
                    <i class="fa fa-plus me-2"></i> Buy More
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="glass-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h1 class="card-title h2 text-light">
                                    <i class="fas fa-bug me-3 text-danger"></i>
                                    <?=$search_keyword;?>
                                </h1>
                                <!--
                                <p class="text-muted mb-0">
                                    <i class="fas fa-clock me-2"></i>
                                    Hunt: (pohuj) milliseconds..
                                </p>
                                -->
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="attack-badge-2"><?=$config_combo_list;?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="glass-card mb-4">
            <div class="card-header card-header-custom">
                <h4 class="mb-0">
                    <i class="fas fa-crosshairs me-2"></i>
                    Summary of Your Hunt
                </h4>
            </div>
            <div class="card-body pb-0">
                <div class="row text-center pb-2">
                    <div class="col-md-3">
                        <h3 class="score-display"><?=count($result);?></h3>
                        <p class="score-label">credentials found</p>
                    </div>
                    <div class="col-md-3 mt-3">
                        <h3 class="text-success"><?=count($data);?></h3>
                        <p class="text-light">Total Found</p>
                    </div>
                    <div class="col-md-3 mt-3">
                        <h3 class="text-primary">0</h3>
                        <p class="text-light">Verified by Checkers</p>
                    </div>
                    <div class="col-md-3 mt-3">
                        <h3 class="text-info">1</h3>
                        <p class="text-light">Processed</p>
                    </div>
                </div>

                <hr class="bg-light mt-0">
                <p class="text-muted">Make sure the format matches your requirements..</p>
                <div class="row text-center pt-1">
                    <div class="col-md-4">
                        <a href="?download=txt" target="_blank" class="btn btn-outline-success w-100">
                            <i class="fas fa-external-link me-2"></i> Download as TXT File
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="?download=json" target="_blank" class="btn btn-outline-light w-100">
                            <i class="fas fa-external-link me-2"></i> Download as JSON File
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="#" target="_blank" class="btn btn-outline-danger w-100">
                            <i class="fas fa-external-link me-2"></i> Open in new Tab
                        </a>
                    </div>
                </div>
                <!--
                <h6 class="mt-3 text-warning">Operational Recommendations:</h6>
                <ul class="list-group list-group-flush bg-transparent">
                    <li class="list-group-item bg-transparent text-light border-light">
                        <i class="fas fa-chevron-right btn-outline-dark"></i>
                        Please try to keep track of how much each of you have processed, dont make a mess of things..
                    </li>
                </ul>
                -->
            </div>
        </div>

        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-12">
                <!-- GitHub PoCs -->
                <div class="glass-card mb-6">
                    <div class="card-header card-header-github p-3">
                        <h5 class="mb-0 text-light">
                            <i class="fa fa-user-secret me-2"></i>
                            Credentials
                        </h5>
                    </div>
                    <div class="card-body">
                            <!--
                            <div class="resource-item {% if poc.verified %}resource-item-verified{% else %}resource-item-unverified{% endif %}">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1 text-light">rereree</h6>
                                        <small class="text-light">ew r ew rreew wr ewr erewr wrew rewrew rerwreew ewr ew</small>
                                        <div class="mt-1">
                                            <small class="text-success">
                                                <i class="fas fa-check-circle me-1"></i>Live repository confirmed
                                            </small>
                                        </div>
                                    </div>
                                    <span class="badge {% if poc.verified %}bg-success{% else %}bg-info{% endif %}">
                                        hdddddd
                                    </span>
                                </div>
                                <a href="{{ poc.url }}" target="_blank" class="btn btn-sm {% if poc.verified %}btn-success{% else %}btn-outline-dark{% endif %} mt-2">
                                    <i class="fab fa-github me-1"></i>
                                   Open Live Repository{
                                </a>
                            </div>
                            -->
                            <p class="text-muted">No sensitive api-keys, wallets, private/public signatures not found.</p>

                        <?php foreach($result as $key => $data) { ?>
                        <div class="mt-3 px-3 glass-card">
                            <h6><i class="fa fa-link ms-2 me-2 text-warning"></i><a class="text-warning" href="//<?=$data["url"];?>" target="_blank"><?=$data["url"];?></a></h6>
                            <ul class="small mb-0 text-light float-start">
                                <li><span class="copyText"><?=$data["login"];?></span></li>
                                <li><span class="copyText"><?=$data["password"];?></span></li>
                            </ul>
                            <div class="float-end">
                                <a href="" target="" class="btn btn-outline-dark text-success ms-2">
                                    <i class="fa fa-plus me-2"></i> Validated
                                </a>
                                <a href="" target="" class="btn btn-outline-dark text-danger ms-2">
                                    <i class="fa fa-plus me-2"></i> Remove
                                </a>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- Exploits
                <div class="glass-card mb-4">
                    <div class="card-header card-header-exploits">
                        <h5 class="mb-0">
                            <i class="fas fa-bomb me-2"></i>
                            Exploits & Proof-of-Concepts
                        </h5>
                    </div>
                    <div class="card-body">
                            <div class="resource-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1 text-light">yyrryyryyr</h6>
                                        <small class="text-light">
                                            <i class="fas fa-database me-1"></i>rtrt.db • RARE
                                        </small>
                                    </div>
                                    <span class="badge bg-info">
                                        nu
                                    </span>
                                </div>
                                <a href="{{ exploit.url }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                    <i class="fas fa-external-link-alt me-1"></i>Search
                                </a>
                            </div>
                            <p class="text-light">No exploit sources configured.</p>
                    </div>
                </div>
                -->
            </div>

            <!--
            <div class="col-lg-6">
                <div class="glass-card mb-4">
                    <div class="card-header card-header-databases">
                        <h5 class="mb-0">
                            <i class="fas fa-database me-2"></i>
                            Verified Vulnerability Databases
                            <span class="badge bg-success ms-2">
                               15 Live
                            </span>
                        </h5>
                    </div>
                    <div class="card-body">
                            <div class="resource-item {% if db.verified %}resource-item-verified{% else %}resource-item-unverified{% endif %}">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1 text-light">1</h6>
                                        <small class="text-light">3333333333331</small>
                                        <p class="mb-1 small text-light">1232313 13 1231331313 ggg}</p>
                                    </div>
                                    <span class="badge {% if db.verified %}bg-success{% else %}bg-warning{% endif %}">
                                        {{ db.status }}
                                    </span>
                                </div>
                                <a href="{{ db.url }}" target="_blank" class="btn btn-sm btn-outline-info mt-2">
                                    <i class="fas fa-external-link-alt me-1"></i>View Database
                                </a>
                            </div>
                            <p class="text-light">No verified databases found.</p>
                    </div>
                </div>

                <div class="glass-card mb-4">
                    <div class="card-header card-header-technical">
                        <h5 class="mb-0">
                            <i class="fas fa-tools me-2"></i>
                            Technical Resources
                        </h5>
                    </div>
                    <div class="card-body">
                            <div class="resource-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1 text-light">{{ resource.source }}</h6>
                                        <small class="text-light">{{ resource.description }}</small>
                                        <p class="mb-1 small text-light">Type: {{ resource.type }}</p>
                                    </div>
                                    <span class="badge bg-info">{{ resource.status }}</span>
                                </div>
                                <a href="{{ resource.url }}" target="_blank" class="btn btn-sm btn-outline-warning mt-2">
                                    <i class="fas fa-external-link-alt me-1"></i>Access Resource
                                </a>
                            </div>
                            <p class="text-light">No technical resources configured.</p>
                    </div>
                </div>

  
                <div class="glass-card mb-4">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Hunting Errors
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-danger">
                            <i class="fas fa-bug me-2"></i>
                            <strong>Error during hunt:</strong> {{ results.error }}
                        </div>
                        <p class="text-light small">
                            Some information might be incomplete. Try refreshing or check your internet connection.
                        </p>
                    </div>
                </div>

            </div>
            -->
        </div>

        <div class="glass-card mt-4">
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <a href="https://nvd.nist.gov/vuln/search" target="_blank" class="btn btn-outline-primary w-100">
                            <i class="fas fa-search me-2"></i> Search Dehashed
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="https://github.com/search?q={{ results.cve_id }}+PoC" target="_blank" class="btn btn-outline-dark w-100">
                            <i class="fab fa-github me-2"></i> Mark as Processed
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="https://www.exploit-db.com/search?cve={{ results.cve_id }}" target="_blank" class="btn btn-outline-danger w-100">
                            <i class="fas fa-bomb me-2"></i> Separate Data
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer
        <div class="row mt-4">
            <div class="col-12 text-center">
                <p class="text-light">
                    <i class="fas fa-sync-alt me-2"></i>
                    Results are automatically gathered from verified vulnerability databases
                    <br>
                    <small class="text-light">All links open in new tabs for your security</small>
                </p>
                <a href="/" class="back-btn">
                    <i class="fas fa-arrow-left me-2"></i>Search Another CVE
                </a>
            </div>
        </div>
         -->
    </div>

    <!-- Footer -->
    <footer class="footer mt-0">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="mb-0 text-light">
                        <span class="text-warning">Warmachine.exe</span>
                        <span class="text-muted"> - HackForums.net</span>
                        <br>
                        <small>&copy; 2025 <?=$config_app["title"]?>. For authorized use only.</small>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
    <script>
    $(document).ready(
        function() {
            $('.copyText').click(
                function() {
                    if ($('#tmp').length) {
                        $('#tmp').remove();
                    }
                    var clickText = $(this).text();
                    $('<textarea id="tmp" />')
                        .appendTo($(this))
                        .val(clickText)
                        .focus()
                        .select();
                        document.execCommand("copy");
            return false;
        });
    $(':not(.copyText)').click(
        function(){
            $('#tmp').remove();
        });

    });
    </script>    
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