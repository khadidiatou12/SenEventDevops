<?php
header("Content-Type: text/plain");

// Déterminer la version de l'application
$version = getenv("APP_VERSION");

if (!$version) {
    $version = "unknown";
}

// Fichier qui stocke le nombre de visites
$file = __DIR__ . "/counter.txt";

if (!file_exists($file)) {
    file_put_contents($file, "0");
}

$count = (int) file_get_contents($file);

// Format Prometheus
echo "# HELP senevent_requests_total Nombre total de visites\n";
echo "# TYPE senevent_requests_total counter\n";
echo "senevent_requests_total{version=\"$version\"} $count\n";