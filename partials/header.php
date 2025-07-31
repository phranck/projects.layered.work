<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php if ($projectData): ?>
        <title><?= htmlspecialchars($projectData['title']) ?> Documentation</title>
        <meta name="description" content="<?= htmlspecialchars($projectData['description']) ?>">
        <meta name="keywords" content="<?= implode(', ', $projectData['keywords']) ?>">
        <meta property="og:title" content="<?= htmlspecialchars($projectData['title']) ?> Documentation">
        <meta property="og:description" content="<?= htmlspecialchars($projectData['description']) ?>">
        <meta property="og:image" content="<?= htmlspecialchars($projectPath . $projectData['previewImage']) ?>">
        <meta property="twitter:title" content="<?= htmlspecialchars($projectData['title']) ?> Documentation">
        <meta property="twitter:description" content="<?= htmlspecialchars($projectData['description']) ?>">
        <meta property="twitter:image" content="<?= htmlspecialchars($projectPath . $projectData['previewImage']) ?>">
    <?php else: ?>
        <title>LAYERED.work Projects</title>
        <meta name="description" content="An overview of projects by LAYERED.work.">
        <meta name="keywords" content="DIY, electronics, projects, NeXT, SoundBox, Cube, Megapixel Display">
        <meta property="og:title" content="LAYERED.work Projects">
        <meta property="og:description" content="An overview of projects by LAYERED.work.">
        <meta property="twitter:title" content="LAYERED.work Projects">
        <meta property="twitter:description" content="An overview of projects by LAYERED.work.">
    <?php endif; ?>

    <meta name="author" content="LAYERED.work">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://layered.work">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://layered.work">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    
    <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.5.0/model-viewer.min.js"></script>
</head>
<body class="bg-stone-100 text-zinc-800 antialiased flex flex-col min-h-screen">
    <div class="fixed top-10 -left-24 transform -rotate-45 text-center px-24 py-3 text-sm font-black uppercase tracking-wider shadow-lg z-50 flex items-center justify-center" style="background: repeating-linear-gradient(45deg, #fcd34d, #fcd34d 15px, #18181b 15px, #18181b 30px); color: white; text-shadow: 0 0 2px black, 0 0 2px black, 0 0 2px black, 0 0 2px black;">
        Work in Progress
    </div>
    <div class="container mx-auto px-4 py-8 md:py-12 max-w-6xl flex-grow">