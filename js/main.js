document.addEventListener('DOMContentLoaded', () => {
    // BOM Table Logic
    const bomTable = document.getElementById('bom-table');
    if (bomTable && bomTable.dataset.bom) {
        const bomData = JSON.parse(bomTable.dataset.bom);
        const bomBody = document.getElementById('bom-body');
        let currentSort = { column: 0, asc: true };

        const renderBom = () => {
            bomBody.innerHTML = '';
            bomData.forEach(item => {
                const row = document.createElement('tr');
                row.className = 'border-b border-stone-200 hover:bg-stone-50';
                const lcscLink = item.lcsc ? `<a href="https://lcsc.com/product-detail/${item.lcsc}.html" target="_blank" class="text-emerald-600 hover:text-emerald-800 font-medium underline">${item.lcsc}</a>` : '';
                const copyIcon = item.lcsc ? `<span class="copy-icon cursor-pointer text-zinc-400 opacity-0 group-hover:opacity-100 transition-opacity" data-part-number="${item.lcsc}"><i class="fas fa-copy h-4 w-4"></i></span>` : '';
                
                const cells = [
                    `<td class="p-4 font-medium">${item.ref || ''}</td>`,
                    `<td class="p-4">${item.val || ''}</td>`,
                    `<td class="p-4">${item.pkg || ''}</td>`,
                    `<td class="p-4 text-zinc-600">${item.desc || ''}</td>`,
                    `<td class="p-4"><div class="relative group flex items-center gap-2">${lcscLink}${copyIcon}</div></td>`
                ];
                row.innerHTML = cells.join('');
                bomBody.appendChild(row);
            });
        };

        const sortTable = (columnIndex) => {
            if (!Array.isArray(bomData) || bomData.length === 0) {
                renderBom();
                return;
            }
            const columnKey = Object.keys(bomData[0])[columnIndex];
            if (columnKey === undefined) return;
            const isAsc = currentSort.column === columnIndex ? !currentSort.asc : true;
            currentSort = { column: columnIndex, asc: isAsc };
            bomData.sort((a, b) => {
                let valA = a[columnKey] || ''; 
                let valB = b[columnKey] || '';
                return (typeof valA === 'string' ? valA.localeCompare(valB, undefined, { numeric: true }) : valA - b[columnKey]) * (isAsc ? 1 : -1);
            });
            document.querySelectorAll('.sortable-header').forEach((header, index) => {
                header.textContent = header.textContent.replace(/ [▾▴]/, '');
                if (index === columnIndex) {
                    header.textContent += isAsc ? ' ▾' : ' ▴';
                }
            });
            renderBom();
        };
        
        bomBody.addEventListener('click', function(event) {
            const icon = event.target.closest('.copy-icon');
            if (icon) {
                const partNumber = icon.dataset.partNumber;
                const tempInput = document.createElement('textarea');
                tempInput.value = partNumber;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);
                const notification = document.createElement('div');
                notification.textContent = 'Copied!';
                notification.className = 'copy-notification-popup absolute left-full ml-4 top-1/2 -translate-y-1/2 bg-zinc-800/90 text-white text-xs py-1 px-3 rounded-md shadow-lg opacity-0 transition-opacity duration-300 pointer-events-none whitespace-nowrap';
                icon.parentElement.appendChild(notification);
                requestAnimationFrame(() => {
                    notification.classList.remove('opacity-0');
                });
                setTimeout(() => {
                    notification.classList.add('opacity-0');
                    setTimeout(() => {
                        notification.remove();
                    }, 300);
                }, 2000);
            }
        });

        document.querySelectorAll('.sortable-header').forEach((header, index) => {
            header.addEventListener('click', () => sortTable(index));
        });
        
        sortTable(0);
    }

    const schematicImage = document.getElementById('schematic-image');
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightbox-image');

    function openLightbox() {
        if (!schematicImage) return;
        lightboxImage.src = schematicImage.src;
        lightbox.classList.remove('opacity-0', 'pointer-events-none');
        lightboxImage.classList.remove('scale-90');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        lightbox.classList.add('opacity-0');
        lightboxImage.classList.add('scale-90');
        setTimeout(() => {
            lightbox.classList.add('pointer-events-none');
            document.body.style.overflow = '';
        }, 300);
    }

    if (schematicImage) {
        schematicImage.addEventListener('click', openLightbox);
        lightbox.addEventListener('click', closeLightbox);
    }
    
    const modelViewer = document.getElementById('model-viewer-main');
    const zoom3dBtn = document.getElementById('zoom-3d-btn');
    const lightbox3d = document.getElementById('lightbox-3d');
    const lightbox3dContent = document.getElementById('lightbox-3d-content');
    const close3dBtn = document.getElementById('close-3d-btn');

    function open3dLightbox() {
        if (!modelViewer) return;
        const clonedViewer = modelViewer.cloneNode(true);
        clonedViewer.style.width = '100%';
        clonedViewer.style.height = '100%';
        clonedViewer.classList.add('rounded-2xl');
        
        let existingViewer = lightbox3dContent.querySelector('model-viewer');
        if (existingViewer) {
            lightbox3dContent.removeChild(existingViewer);
        }
        
        lightbox3dContent.insertBefore(clonedViewer, close3dBtn);
        lightbox3d.classList.remove('opacity-0', 'pointer-events-none');
        requestAnimationFrame(() => {
            lightbox3dContent.classList.remove('scale-90');
        });
        document.body.style.overflow = 'hidden';
    }

    function close3dLightbox() {
        lightbox3d.classList.add('opacity-0');
        lightbox3dContent.classList.add('scale-90');
        setTimeout(() => {
            lightbox3d.classList.add('pointer-events-none');
            document.body.style.overflow = '';
        }, 300);
    }

    if (zoom3dBtn) {
        zoom3dBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            open3dLightbox();
        });
        close3dBtn.addEventListener('click', close3dLightbox);
        lightbox3d.addEventListener('click', (e) => {
            if (e.target === lightbox3d) {
                close3dLightbox();
            }
        });
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            if (lightbox && !lightbox.classList.contains('pointer-events-none')) {
                closeLightbox();
            }
            if (lightbox3d && !lightbox3d.classList.contains('pointer-events-none')) {
                close3dLightbox();
            }
        }
    });

    // Project Filter Logic
    const categoryFilter = document.getElementById('category-filter');
    if (categoryFilter) {
        const categoryButtons = categoryFilter.querySelectorAll('.category-btn');
        const projectCards = document.querySelectorAll('#project-grid > a, #project-grid > div');
        const glider = document.getElementById('glider');

        const setActiveCategory = (button, isInitial = false) => {
            if (!button) return;
            const category = button.dataset.category;

            // Move glider
            if (!isInitial) {
                glider.style.transition = 'all 0.3s ease-in-out';
            }
            glider.style.width = `${button.offsetWidth}px`;
            glider.style.transform = `translateX(${button.offsetLeft}px)`;

            // Update button styles
            categoryButtons.forEach(btn => {
                btn.classList.remove('text-zinc-800');
                btn.classList.add('text-zinc-500');
            });
            button.classList.add('text-zinc-800');
            button.classList.remove('text-zinc-500');

            // Filter project cards
            projectCards.forEach(card => {
                if (category === 'all' || card.dataset.category === category) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Save last selected category
            if (!isInitial) {
                document.cookie = `lastCategory=${category};path=/;max-age=31536000;samesite=lax`;
            }
        };

        categoryButtons.forEach(button => {
            button.addEventListener('click', () => setActiveCategory(button));
        });

        // Restore last category from cookie
        const lastCategory = document.cookie.split('; ').find(row => row.startsWith('lastCategory='))?.split('=')[1] || 'all';
        const initialButton = categoryFilter.querySelector(`[data-category="${lastCategory}"]`) || categoryButtons[0];
        
        // Use a small timeout to ensure the browser has calculated the layout, especially fonts
        setTimeout(() => {
            if (initialButton) {
                glider.style.transition = 'none'; // Prevent animation on initial load
                setActiveCategory(initialButton, true);
            }
        }, 100);
    }
});
