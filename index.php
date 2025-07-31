<?php
require_once 'app/functions.php';

$config = loadConfig();
$projectCategories = $config['projectCategories'];

$allProjects = getAllProjects();
$projectData = getCurrentProject($allProjects);

renderPage($config, $projectData, $allProjects);