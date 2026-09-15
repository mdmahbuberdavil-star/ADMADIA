function showAdminDashboard() {
    ...
    initAdminInbox();
    initChatToggle();
    initAdminNotifications();
    initRedirectController();

    if (!location.hash.replace(/^#/, '')) {
        switchView('admin-view-overview');
    } else {
        restoreViewFromHash();
    }
}
