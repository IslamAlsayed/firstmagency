import Sortable from 'sortablejs';

/**
 * Get the API base URL for sidebar preferences
 */
function getApiUrl(endpoint) {
    const baseUrl = window.location.origin;
    const pathMatch = window.location.pathname.match(/\/dashboard\//);
    if (pathMatch) {
        return `${baseUrl}/dashboard${endpoint}`;
    }
    return `${baseUrl}/dashboard${endpoint}`;
}

/**
 * Get CSRF token from meta tag
 */
function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content || '';
}

export function initSidebarSortable() {
    // Sidebar is now read-only - drag and drop moved to Settings page
    const sidebarMenu = document.getElementById('sidebarMenu');
    if (!sidebarMenu) {
        console.warn('Sidebar menu not found');
        return;
    }
    // Just add visual styles, no Sortable initialization
    addDragStyles();
}

/**
 * Save the current sidebar order to the backend
 */
export function saveSidebarOrder() {
    const sidebarMenu = document.getElementById('sidebarMenu');

    // Get the order of main menu items
    const mainMenuOrder = Array.from(sidebarMenu.querySelectorAll('[data-item-id]')).map(item =>
        item.getAttribute('data-item-id')
    );

    // Get the order of submenu items per parent with their parent info
    const submenuOrder = {};
    document.querySelectorAll('.submenu-list').forEach(submenu => {
        const parentId = submenu.closest('[data-item-id]')?.getAttribute('data-item-id');
        if (parentId) {
            submenuOrder[parentId] = Array.from(submenu.querySelectorAll('li')).map((li, index) => {
                const link = li.querySelector('a');
                const href = link ? link.getAttribute('href') : '';
                const item = {
                    order: index,
                    text: li.textContent.trim() || `item-${index}`,
                    href: href,
                    parentId: parentId // Track which parent this item belongs to
                };
                console.log(`Saving ${parentId} item:`, { text: item.text, href: item.href });
                return item;
            });
        }
    });

    console.log('Full submenu order to save:', submenuOrder);

    // Send the order to the backend
    fetch(getApiUrl('/sidebar/save-order'), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken()
        },
        body: JSON.stringify({
            menu_order: mainMenuOrder,
            submenu_order: submenuOrder
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Sidebar order saved successfully');
                // Optional: Show a toast notification
                // showNotification('Sidebar order saved', 'success');
            } else {
                console.error('Failed to save sidebar order:', data);
            }
        })
        .catch(error => {
            console.error('Error saving sidebar order:', error);
        });
}

/**
 * Add drag and drop visual styles
 */
function addDragStyles() {
    // Visual styles removed - drag and drop is now only available in Settings page
    // Do nothing here
}

/**
 * Load sidebar order from backend and apply it
 */
export function loadSidebarOrder() {
    return fetch(getApiUrl('/sidebar/get-order'), {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken()
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data && data.data.menu_order) {
                console.log('Loaded sidebar preferences:', data.data);
                applySavedOrder(data.data);
                return true;
            } else {
                console.log('No saved sidebar preferences found');
                return false;
            }
        })
        .catch(error => {
            console.error('Error loading sidebar order:', error);
            return false;
        });
}

/**
 * Apply the saved order to the sidebar
 */
function applySavedOrder(preferences) {
    if (!preferences || !preferences.menu_order) {
        console.log('No menu order to apply');
        return;
    }

    const sidebarMenu = document.getElementById('sidebarMenu');
    if (!sidebarMenu) {
        console.warn('Sidebar menu not found');
        return;
    }

    const menuOrder = preferences.menu_order;
    console.log('📋 Applying menu order:', menuOrder);

    // Get all menu items that have data-item-id
    const allItems = sidebarMenu.querySelectorAll('[data-item-id]');
    const allItemIds = Array.from(allItems).map(el => el.getAttribute('data-item-id'));

    console.log('Total items found:', allItems.length);
    console.log('Available item IDs:', allItemIds);
    console.log('Saved order:', menuOrder);

    // Create a DocumentFragment to hold reordered items
    const fragment = document.createDocumentFragment();

    // Add items in saved order first
    menuOrder.forEach((itemId) => {
        const item = sidebarMenu.querySelector(`[data-item-id="${itemId}"]`);
        if (item) {
            console.log('✅ Moving item to saved position:', itemId);
            fragment.appendChild(item);
        } else {
            console.warn('⚠️ Item not found in saved order:', itemId);
        }
    });

    // Add any new items that weren't in the saved order
    const movedItemIds = new Set(Array.from(fragment.querySelectorAll('[data-item-id]')).map(el => el.getAttribute('data-item-id')));
    allItemIds.forEach(itemId => {
        if (!movedItemIds.has(itemId)) {
            const item = sidebarMenu.querySelector(`[data-item-id="${itemId}"]`);
            if (item) {
                console.log('🆕 Adding newly added item:', itemId);
                fragment.appendChild(item);
            }
        }
    });

    // Clear and repopulate the menu
    while (sidebarMenu.firstChild) {
        sidebarMenu.removeChild(sidebarMenu.firstChild);
    }
    sidebarMenu.appendChild(fragment);

    console.log('✅ Main menu order applied successfully');

    // Reorder submenu items if submenu_order is provided
    if (preferences.submenu_order) {
        console.log('📦 Processing submenu order:', preferences.submenu_order);

        // First, collect and preserve all items from all submenus BEFORE any modifications
        const allItemsMap = {}; // Map by href to find items easily
        const itemsByParent = {}; // Group items by their parent

        document.querySelectorAll('.submenu-list li').forEach(li => {
            const link = li.querySelector('a');
            if (link) {
                const href = link.getAttribute('href');
                const text = link.textContent.trim();
                const parent = li.closest('.submenu-list')?.closest('[data-item-id]')?.getAttribute('data-item-id');

                // IMPORTANT: Store reference to actual element, not clone
                allItemsMap[href] = { li: li, text: text, href: href };

                if (!itemsByParent[parent]) {
                    itemsByParent[parent] = [];
                }
                itemsByParent[parent].push({ li: li, href: href, text: text });
            }
        });

        console.log('📍 Collected', Object.keys(allItemsMap).length, 'submenu items');
        console.log('👥 Items grouped by parent');

        // Now apply the saved order for each parent
        Object.entries(preferences.submenu_order).forEach(([parentId, items]) => {
            const parentElement = sidebarMenu.querySelector(`[data-item-id="${parentId}"]`);
            if (parentElement) {
                const submenuList = parentElement.querySelector('.submenu-list');
                if (submenuList && Array.isArray(items)) {
                    console.log(`🔄 Reordering submenu for ${parentId}:`, items.length, 'items');

                    // Create a map to track which items should be in this submenu
                    const itemsToAdd = [];
                    const processedHrefs = new Set();

                    // First, add items in the saved order
                    items.forEach((itemData) => {
                        if (itemData.href && allItemsMap[itemData.href]) {
                            const liElement = allItemsMap[itemData.href].li;
                            itemsToAdd.push(liElement);
                            processedHrefs.add(itemData.href);
                            console.log(`✅ Found item by href: ${itemData.text}`);
                        }
                    });

                    // Add any new items that weren't in saved order
                    if (itemsByParent[parentId]) {
                        itemsByParent[parentId].forEach(itemData => {
                            if (!processedHrefs.has(itemData.href)) {
                                itemsToAdd.push(itemData.li);
                                console.log(`🆕 Added new submenu item: ${itemData.text}`);
                            }
                        });
                    }

                    // Now reorder by removing and re-appending items
                    // This preserves the elements and their content
                    itemsToAdd.forEach(li => {
                        if (li.parentNode !== submenuList) {
                            console.log(`🔀 Moving item from different parent`);
                        }
                        submenuList.appendChild(li); // appendChild moves element if already in DOM
                    });

                    console.log(`✅ Submenu ${parentId} reordered with ${itemsToAdd.length} items`);
                }
            } else {
                console.warn(`❌ Parent element not found for ${parentId}`);
            }
        });
    }

    console.log('✅ Sidebar order applied successfully (including submenu reorganization)');
}

// Initialize on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', async function () {
        console.log('DOM Content Loaded - Starting sidebar initialization');
        await loadSidebarOrder();
        console.log('Sidebar order loaded - Initializing Sortable');
        initSidebarSortable();
    });
} else {
    console.log('DOM already loaded - Starting sidebar initialization');
    loadSidebarOrder().then(() => {
        console.log('Sidebar order loaded - Initializing Sortable');
        initSidebarSortable();
    });
}

