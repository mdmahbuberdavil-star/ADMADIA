let adminOverviewListenerAttached = true;
function initializeAdminOverview() {
    initAdminOverviewChart();
    if (adminOverviewListenerAttached) return;
    adminOverviewListenerAttached = true;
    const compute = () => {
        get(ref(db,'trackings')).then(snap => {
            ...
        });
    };
    onValue(ref(db,'trackings'), () => compute());
}
