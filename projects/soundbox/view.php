<header class="relative text-center mb-12 md:mb-16">
    <img src="https://pluspng.com/img-png/next-logo-png-open-2000.png" alt="NeXT Logo" class="h-20 mx-auto mt-8 mb-12">
    <h1 class="text-4xl md:text-5xl font-bold text-zinc-900"><?= htmlspecialchars($projectData['title']) ?></h1>
    <div class="flex justify-center items-center gap-4 text-base text-zinc-500 mt-4 mb-2 flex-wrap">
        <span><strong>Version:</strong> <?= htmlspecialchars($projectData['version']) ?></span>
        <span class="text-zinc-300 hidden sm:inline">|</span>
        <span><strong>Created:</strong> <?= htmlspecialchars($projectData['createdDate']) ?></span>
        <span class="text-zinc-300 hidden sm:inline">|</span>
        <span><strong>Updated:</strong> <?= htmlspecialchars($projectData['updatedDate']) ?></span>
    </div>
    <p class="mt-4 text-xl md:text-2xl text-zinc-600"><?= htmlspecialchars($projectData['description']) ?></p>
</header>

<main>
    <section id="3d-model" class="mb-12 md:mb-16">
        <div class="bg-white p-6 rounded-2xl shadow-lg relative">
            <model-viewer 
                id="model-viewer-main"
                src="<?= htmlspecialchars($projectPath . $projectData['model3d']) ?>"
                alt="A 3D model of the <?= htmlspecialchars($projectData['title']) ?>"
                camera-controls
                auto-rotate
                shadow-intensity="1"
                style="width: 100%; height: 750px; background-color: #ffffff; border-radius: 0.5rem;">
            </model-viewer>
            <button id="zoom-3d-btn" class="absolute top-4 right-4 bg-white/50 backdrop-blur-sm p-3 rounded-full text-zinc-600 hover:text-zinc-900 hover:bg-white/80 transition-all" title="Zoom 3D Model">
                <i class="fas fa-expand fa-lg"></i>
            </button>
        </div>
    </section>

    <section id="overview" class="mb-12 md:mb-16">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-8 text-zinc-800">Functional Overview</h2>
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <p class="text-zinc-600 mb-8 text-center max-w-3xl mx-auto">
                <?= htmlspecialchars($projectData['overview']['intro']) ?>
            </p>
            <div class="flex flex-col md:flex-row items-center justify-center gap-4 flex-wrap">
                 <?php foreach ($projectData['overview']['blocks'] as $index => $block): ?>
                    <?php if ($index > 0): ?>
                        <div class="hidden md:flex items-center text-zinc-400 text-4xl">→</div>
                    <?php endif; ?>
                    <a href="#<?= htmlspecialchars($block['id']) ?>" class="block hover:scale-105 hover:shadow-xl transition-all duration-300 rounded-lg">
                        <div class="text-center p-3 border-2 border-<?= htmlspecialchars($block['color']) ?>-500 rounded-lg bg-<?= htmlspecialchars($block['color']) ?>-50 w-48 h-20 flex flex-col justify-center">
                            <h3 class="font-semibold text-<?= htmlspecialchars($block['color']) ?>-800"><?= htmlspecialchars($block['title']) ?></h3>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="components" class="mb-12 md:mb-16">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-8 text-zinc-800">Component Blocks in Detail</h2>
        <p class="text-zinc-600 mb-8 text-center max-w-3xl mx-auto">
            The circuit is divided into four main functional groups.
        </p>
        <div class="space-y-10">
            <?php foreach ($projectData['componentSections'] as $section): ?>
                <div id="<?= htmlspecialchars($section['id']) ?>">
                    <h3 class="text-2xl md:text-3xl font-bold text-<?= htmlspecialchars($section['color']) ?>-700 border-b-2 border-<?= htmlspecialchars($section['color']) ?>-200 pb-2 mb-4"><?= htmlspecialchars($section['title']) ?></h3>
                    <p class="text-zinc-600 mb-6 text-lg"><?= htmlspecialchars($section['intro']) ?></p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($section['components'] as $component): ?>
                            <div class="card bg-white p-6 rounded-xl shadow-md">
                                <h4 class="text-xl font-semibold text-zinc-800 mb-2"><?= htmlspecialchars($component['title']) ?></h4>
                                <div><p class="text-zinc-600 text-base"><?= htmlspecialchars($component['description']) ?></p></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="full-schematic" class="mb-12 md:mb-16">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-8 text-zinc-800">Full Schematic</h2>
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <img id="schematic-image" src="<?= htmlspecialchars($projectPath . $projectData['schematicImage']) ?>" alt="Full schematic of the <?= htmlspecialchars($projectData['title']) ?>" class="w-full h-auto rounded-lg cursor-pointer transition-transform duration-300 hover:scale-105">
        </div>
    </section>

    <section id="bom">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-8 text-zinc-800">Interactive Bill of Materials</h2>
        <p class="text-zinc-600 mb-8 text-center max-w-3xl mx-auto">
            The following table lists all components required for this circuit. You can sort the table by clicking on the column headers.
        </p>
        <div class="bg-white rounded-2xl shadow-lg overflow-x-auto">
            <table id="bom-table" class="w-full text-left text-base" data-bom='<?= json_encode($projectData['bom']) ?>'>
                <thead class="bg-stone-50">
                    <tr>
                        <th class="p-4 sortable-header">Reference ▾</th>
                        <th class="p-4 sortable-header">Value/Designation ▾</th>
                        <th class="p-4 sortable-header">Package ▾</th>
                        <th class="p-4">Description</th>
                        <th class="p-4">LCSC Part #</th>
                    </tr>
                </thead>
                <tbody id="bom-body">
                </tbody>
            </table>
        </div>
    </section>
</main>
