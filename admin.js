onValue(ref(db, 'trackings'), (snap) => {
    let clicks=0, conversions=0, revenue=0;
    const days = [...7 days...];
    const dailyClicks = days.map(()=>0), dailyConv = ..., dailyRev = ..., dailyPay = ...;
    if (snap.exists()) {
        snap.forEach(aSnap => {
            aSnap.forEach(evSnap => {
                const t = evSnap.val() || {};
                clicks++;
                const ds = new Date(t.timestamp).toISOString().slice(0,10);
                const idx = days.indexOf(ds);
                if (idx >= 0) dailyClicks[idx]++;
                if (t.conversion) {
                    conversions++;
                    revenue += Number(t.earnings||0);
                    if (idx>=0){ dailyConv[idx]++; dailyRev[idx]+=Number(t.earnings||0); }
                }
            });
        });
    }
    // payouts from users
    get(ref(db,'users')).then(uSnap => {
        let payouts = 0;
        ...
        update UI + chart
    });
});
