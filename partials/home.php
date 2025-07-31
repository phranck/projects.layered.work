<header class="text-center mb-12 md:mb-16">
    <img src="https://pluspng.com/img-png/next-logo-png-open-2000.png" alt="NeXT Logo" class="h-20 mx-auto mt-8 mb-12">
    <h1 class="text-4xl md:text-5xl font-bold text-zinc-900">Project Overview</h1>
    <p class="mt-4 text-xl md:text-2xl text-zinc-600">A selection of documented projects.</p>
</header>
<main>
    <div class="flex justify-center mb-8">
        <div id="category-filter" class="relative inline-flex rounded-lg shadow-sm bg-stone-200 p-1">
            <div id="glider" class="absolute top-1 bottom-1 bg-white rounded-lg shadow-sm transition-all duration-300 ease-in-out"></div>
            <button data-category="all" class="category-btn flex-1 px-6 py-2 text-sm font-semibold text-zinc-800 z-10 whitespace-nowrap">All</button>
            <?php if (!empty($config['projectCategories'])): ?>
                <?php foreach ($config['projectCategories'] as $category): ?>
                    <button data-category="<?= htmlspecialchars($category['category']) ?>" class="category-btn flex-1 px-6 py-2 text-sm font-semibold text-zinc-500 hover:text-zinc-800 z-10 whitespace-nowrap"><?= htmlspecialchars($category['title']) ?></button>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div id="project-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php
        $visibleProjects = getVisibleAndSortedProjects($projectsData);
        ?>

        <?php if (!empty($visibleProjects)): ?>
            <?php foreach ($visibleProjects as $project): ?>
                <?php
                $isActive = !empty($project['isActive']);
                $tag = $isActive ? 'a' : 'div';
                $href = $isActive ? 'href="?project=' . htmlspecialchars($project['id']) . '"' : '';
                $cardClasses = 'card bg-white rounded-2xl shadow-lg overflow-hidden group flex flex-col';
                if (!$isActive) {
                    $cardClasses .= ' opacity-50 cursor-not-allowed';
                }
                ?>
                <<?= $tag ?> <?= $href ?> class="<?= $cardClasses ?>" data-category="<?= htmlspecialchars($project['projectCategory'] ?? '') ?>">
                    <?php if (!empty($project['previewImage'])): ?>
                        <img src="<?= "projects/{$project['id']}/{$project['previewImage']}" ?>" alt="<?= htmlspecialchars($project['title']) ?>" class="w-full h-56 object-cover <?= $isActive ? 'group-hover:scale-105' : '' ?> transition-transform duration-300">
                    <?php else: ?>
                        <div class="w-full h-56 bg-stone-200 flex items-center justify-center">
                            <i class="fas fa-cube fa-4x text-stone-400"></i>
                        </div>
                    <?php endif; ?>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-2xl font-bold text-zinc-800 mb-2"><?= htmlspecialchars($project['title']) ?></h3>
                        <p class="text-zinc-600 text-base flex-grow"><?= htmlspecialchars($project['description']) ?></p>
                    </div>
                </<?= $tag ?>>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No projects found.</p>
        <?php endif; ?>
    </div>
</main>