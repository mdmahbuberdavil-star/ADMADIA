let adminNotifListenerAttached = true;
function initAdminNotifications() {
    if (adminNotifListenerAttached) return;
    adminNotifListenerAttached = true;
    const q = query(ref(db, 'notifications'), limitToLast(30));
    onValue(q, (snap) => {
        const items = [];
        if (snap.exists()) {
            snap.forEach(affSnap => {
                affSnap.forEach(nSnap => {
                    const n = nSnap.val() || {};
                    items.push({ key: nSnap.key, aff: affSnap.key, ...n });
                });
            });
        }
        items.sort((a,b) => (b.createdAt||0) - (a.createdAt||0));
        renderAdminNotifications(items.slice(0, 25));
    });
}
