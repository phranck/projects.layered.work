    </div>
    <footer class="bg-zinc-800 text-zinc-400 py-12">
        <div class="container mx-auto px-4 relative">
            <div class="text-center">
                <?php if (!empty($config['socialLinks'])): ?>
                <div class="flex justify-center gap-6 mb-8">
                    <?php foreach ($config['socialLinks'] as $link): ?>
                        <a href="<?= htmlspecialchars($link['url']) ?>" target="_blank" rel="noopener noreferrer" title="<?= htmlspecialchars($link['title']) ?>" class="hover:text-white transition-colors">
                            <i class="fab fa-<?= htmlspecialchars($link['icon']) ?> fa-lg"></i>
                        </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                
                <?php if (!empty($config['copyright'])): ?>
                    <p class="text-sm"><?= htmlspecialchars($config['copyright']['title']) ?></p>
                    <p class="text-sm mt-1"><?= $config['copyright']['claim'] // Erlaubt HTML für Zeilenumbrüche ?></p>
                <?php else: ?>
                    <p class="text-sm">© 2025 LAYERED.work</p>
                    <p class="text-sm mt-1">Created with passion in Bregenz at Lake Constance</p>
                <?php endif; ?>
            </div>
        </div>
    </footer>
    <div id="lightbox" class="fixed inset-0 bg-black/75 flex items-center justify-center p-4 opacity-0 pointer-events-none z-50">
        <img id="lightbox-image" src="" alt="Enlarged schematic" class="max-w-[90vw] max-h-[90vh] transform scale-90 bg-white p-4 rounded-lg">
    </div>
    <div id="lightbox-3d" class="fixed inset-0 bg-black/75 flex items-center justify-center p-4 opacity-0 pointer-events-none z-50">
        <div id="lightbox-3d-content" class="relative w-[90vw] h-[90vh] transform scale-90 transition-transform duration-300">
             <button id="close-3d-btn" class="absolute top-4 right-4 bg-white/50 backdrop-blur-sm p-3 rounded-full text-zinc-600 hover:text-zinc-900 hover:bg-white/80 transition-all z-10" title="Close">
                <i class="fas fa-times fa-lg"></i>
             </button>
        </div>
    </div>
    <script src="js/main.js"></script>
</body>
</html>
