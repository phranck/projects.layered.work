<?php
// lib/Spyc.php einbinden, falls nicht bereits vorhanden
if (file_exists('lib/Spyc.php')) {
    require_once 'lib/Spyc.php';
} else {
    die('Spyc library not found. Please upload lib/Spyc.php.');
}

/**
 * Lädt die globale Konfigurationsdatei.
 * @return array Die Konfigurationsdaten.
 */
function loadConfig(): array {
    $configFile = 'site/config.yml';
    if (file_exists($configFile)) {
        return Spyc::YAMLLoad($configFile);
    }
    return [];
}

/**
 * Lädt die Daten aller verfügbaren Projekte.
 * @return array Ein Array mit den Daten aller Projekte.
 */
function getAllProjects(): array {
    $projectsDir = 'projects/';
    $availableProjects = array_filter(glob($projectsDir . '*'), 'is_dir');
    $projectsData = [];

    foreach ($availableProjects as $dir) {
        $id = basename($dir);
        $dataFile = $dir . '/data.yml';
        if (file_exists($dataFile)) {
            $data = Spyc::YAMLLoad($dataFile);
            if (is_array($data) && !empty($data)) {
                $data['id'] = $id;
                $projectsData[$id] = $data;
            }
        }
    }
    return $projectsData;
}

/**
 * Ermittelt das aktuell angeforderte Projekt und prüft dessen Status.
 * Leitet bei inaktiven Projekten auf die Startseite um.
 * @param array $projectsData Das Array aller Projekte.
 * @return array|null Die Daten des aktuellen Projekts oder null.
 */
function getCurrentProject(array $projectsData): ?array {
    $projectId = $_GET['project'] ?? null;
    if ($projectId && isset($projectsData[$projectId])) {
        if (!empty($projectsData[$projectId]['isActive'])) {
            return $projectsData[$projectId];
        } else {
            // Projekt ist inaktiv, auf Startseite umleiten
            header('Location: /');
            exit;
        }
    }
    return null;
}

/**
 * Filtert und sortiert Projekte für die Startseiten-Übersicht.
 * @param array $projectsData Das Array aller Projekte.
 * @return array Das sortierte Array der sichtbaren Projekte.
 */
function getVisibleAndSortedProjects(array $projectsData): array {
    $visibleProjects = array_filter($projectsData, function($p) {
        return !empty($p['isVisible']);
    });

    usort($visibleProjects, function($a, $b) {
        $aIsActive = !empty($a['isActive']);
        $bIsActive = !empty($b['isActive']);

        if ($aIsActive === $bIsActive) {
            return strcmp($a['id'], $b['id']);
        }
        return $aIsActive ? -1 : 1;
    });
    
    return $visibleProjects;
}

/**
 * Baut die komplette HTML-Seite zusammen.
 * @param array $config Die globalen Konfigurationsdaten.
 * @param array|null $projectData Die Daten des aktuellen Projekts oder null.
 * @param array $projectsData Das Array aller Projekte (für die Startseite).
 */
function renderPage(array $config, ?array $projectData, array $projectsData): void {
    $projectPath = $projectData ? "projects/{$projectData['id']}/" : null;

    include 'partials/header.php';

    if ($projectData) {
        include $projectPath . 'view.php';
    } else {
        include 'partials/home.php';
    }

    include 'partials/footer.php';
}