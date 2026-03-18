import Sortable from 'sortablejs';

/**
 * Initialize sidebar ordering in Settings page
 * All menus are expanded for easy drag and drop management
 */
export function initSettingsSidebarOrderer() {
    const settingsSidebarMenu = document.getElementById('settingsSidebarMenu');

    if (!settingsSidebarMenu) {
        console.warn('Settings sidebar menu not found');
        return;
    }

    // Expand all submenus initially
    expandAllMenus();

    // Initialize main menu sorting
    Sortable.create(settingsSidebarMenu, {
        animation: 200,
        group: {
            name: 'settings-sidebar-items',
            pull: true,
            put: true
        },
        ghostClass: 'sortable-ghost',
        dragClass: 'sortable-drag',
        handle: '[data-item-id]',
        emptyInsertThreshold: 10,
        onEnd: function (evt) {
            updatePreview();
        },
    });

    // Initialize submenu sorting
    const submenus = settingsSidebarMenu.querySelectorAll('.settings-submenu-list');
    submenus.forEach(submenu => {
        Sortable.create(submenu, {
            animation: 200,
            group: 'settings-submenu-items',
            ghostClass: 'sortable-ghost',
            dragClass: 'sortable-drag',
            handle: 'li',
            emptyInsertThreshold: 10,
            onEnd: function (evt) {
                updatePreview();
            },
        });
    });

    addSettingsDragStyles();
}

/**
 * Expand all menus in settings for easier drag and drop
 */
function expandAllMenus() {
    document.querySelectorAll('#settingsSidebarMenu .settings-submenu-list').forEach(menu => {
        menu.classList.add('show');
        const parent = menu.closest('[data-item-id]');
        if (parent) {
            const button = parent.querySelector('[data-toggle="submenu"]');
            if (button) {
                button.classList.add('active');
            }
        }
    });
}

/**
 * Update preview of the main sidebar with current ordering
 */
function updatePreview() {
    const settingsSidebarMenu = document.getElementById('settingsSidebarMenu');
    const previewSidebarMenu = document.getElementById('previewSidebarMenu');

    if (!previewSidebarMenu) return;

    // Clone the current ordering structure
    const previewOrderItems = Array.from(settingsSidebarMenu.querySelectorAll('[data-item-id]')).map(item => {
        const itemId = item.getAttribute('data-item-id');
        const submenuItems = Array.from(item.querySelectorAll('.settings-submenu-list li')).map(li => ({
            text: li.textContent.trim(),
            href: li.querySelector('a')?.getAttribute('href') || ''
        }));
        return { itemId, submenuItems };
    });

    // Update display
    previewOrderItems.forEach(({ itemId, submenuItems }) => {
        const previewItem = previewSidebarMenu.querySelector(`[data-item-id="${itemId}"]`);
        if (previewItem) {
            const previewSubmenuList = previewItem.querySelector('.submenu-list');
            if (previewSubmenuList) {
                previewSubmenuList.innerHTML = '';
                submenuItems.forEach(item => {
                    const li = document.createElement('li');
                    li.className = 'relative';
                    li.innerHTML = `<a href="${item.href}" class="nav-link flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500"><span class="text-sm">${item.text}</span></a>`;
                    previewSubmenuList.appendChild(li);
                });
            }
        }
    });
}

/**
 * Save the sidebar order from settings
 */
export function saveSidebarOrderFromSettings() {
    const settingsSidebarMenu = document.getElementById('settingsSidebarMenu');

    if (!settingsSidebarMenu) {
        console.error('❌ Settings sidebar menu not found');
        showNotification('القائمة غير موجودة', 'error');
        return;
    }

    // Get the order of main menu items
    const mainMenuOrder = Array.from(settingsSidebarMenu.querySelectorAll('[data-item-id]')).map(item =>
        item.getAttribute('data-item-id')
    );

    // Get the order of submenu items per parent
    const submenuOrder = {};
    settingsSidebarMenu.querySelectorAll('.settings-submenu-list').forEach(submenu => {
        const parentId = submenu.closest('[data-item-id]')?.getAttribute('data-item-id');
        if (parentId) {
            submenuOrder[parentId] = Array.from(submenu.querySelectorAll('li')).map((li, index) => {
                const link = li.querySelector('a');
                const href = link ? link.getAttribute('href') : '';
                return {
                    order: index,
                    text: li.textContent.trim() || `item-${index}`,
                    href: href,
                    parentId: parentId
                };
            });
        }
    });

    const payload = {
        menu_order: mainMenuOrder,
        submenu_order: submenuOrder
    };

    console.log('💾 Saving sidebar order:', payload);
    console.log('🔗 API URL:', getApiUrl('/sidebar/save-order'));
    console.log('🔐 CSRF Token:', getCsrfToken());

    // Send to backend
    fetch(getApiUrl('/sidebar/save-order'), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken()
        },
        body: JSON.stringify(payload)
    })
        .then(response => {
            console.log('📡 Response Status:', response.status);
            console.log('📡 Response Headers:', response.headers);

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            return response.text().then(text => {
                console.log('📡 Raw Response:', text);
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('❌ Failed to parse JSON:', e);
                    throw new Error('Invalid JSON response');
                }
            });
        })
        .then(data => {
            console.log('✅ Response Data:', data);
            if (data.success) {
                console.log('✅ Sidebar order saved successfully');
                showNotification('تم حفظ ترتيب الـ Sidebar بنجاح ✅', 'success');
            } else {
                console.error('❌ Server returned error:', data);
                showNotification('فشل حفظ الترتيب: ' + (data.message || 'خطأ غير معروف'), 'error');
            }
        })
        .catch(error => {
            console.error('❌ Save Error:', error);
            showNotification('حدث خطأ في الحفظ: ' + error.message, 'error');
        });
}

/**
 * Reset sidebar order to default
 */
export function resetSidebarOrder() {
    if (!confirm('هل تريد إعادة ترتيب الـ Sidebar إلى الإعدادات الافتراضية؟')) {
        return;
    }

    fetch(getApiUrl('/sidebar/reset-order'), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken()
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('✅ Sidebar order reset successfully');
                window.location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
}

/**
 * Add drag and drop visual styles
 */
function addSettingsDragStyles() {
    let styleId = 'settings-sidebar-sortable-styles';
    if (document.getElementById(styleId)) return;

    const style = document.createElement('style');
    style.id = styleId;
    style.textContent = `
        .sortable-ghost {
            opacity: 0.4;
            background-color: rgba(100, 200, 255, 0.2) !important;
        }
        
        .sortable-drag {
            opacity: 0.7;
            background-color: rgba(100, 150, 255, 0.3) !important;
            border-radius: 4px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
      
        [data-item-id]:active {
            cursor: grabbing;
        }
        
        [data-item-id]:hover {
            background-color: rgba(100, 150, 255, 0.1);
        }
        
        .settings-submenu-list li {
            cursor: grab;
            transition: background-color 0.15s ease;
        }
        
        .settings-submenu-list li:active {
            cursor: grabbing;
        }
        
        .settings-submenu-list li:hover {
            background-color: rgba(100, 150, 255, 0.1);
        }
    `;

    document.head.appendChild(style);
}

/**
 * Get API base URL
 */
function getApiUrl(endpoint) {
    const baseUrl = window.location.origin;
    return `${baseUrl}/dashboard${endpoint}`;
}

/**
 * Get CSRF token from meta tag
 */
function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content || '';
}

/**
 * Show notification (basic implementation)
 */
function showNotification(message, type = 'info') {
    console.log(`[${type.toUpperCase()}] ${message}`);

    // Create a simple notification element
    const notification = document.createElement('div');
    notification.className = `px-4 py-3 rounded-lg mb-3 text-white font-semibold shadow-lg ${type === 'success' ? 'bg-green-500' :
        type === 'error' ? 'bg-red-500' :
            'bg-blue-500'
        }`;
    notification.textContent = message;
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.zIndex = '9999';
    notification.style.maxWidth = '400px';
    notification.style.animation = 'slideIn 0.3s ease-out';

    // Add animation style
    if (!document.getElementById('notification-styles')) {
        const style = document.createElement('style');
        style.id = 'notification-styles';
        style.textContent = `
            @keyframes slideIn {
                from {
                    transform: translateX(400px);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(400px);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    }

    document.body.appendChild(notification);

    // Auto-remove after 4 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-in';
        setTimeout(() => notification.remove(), 300);
    }, 4000);
}

// Expose functions to window for direct access from HTML
if (typeof window !== 'undefined') {
    window.initSettingsSidebarOrderer = initSettingsSidebarOrderer;
    window.saveSidebarOrderFromSettings = saveSidebarOrderFromSettings;
    window.resetSidebarOrder = resetSidebarOrder;
}
