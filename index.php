<?php
require_once 'app/functions.php';

$config = loadConfig();
$allProjects = getAllProjects();
$projectData = getCurrentProject($allProjects);

renderPage($config, $projectData, $allProjects);