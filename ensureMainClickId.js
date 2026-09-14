async function ensureMainClickId(email) {
    if (!email) return null;
    const key = safeKey(email);
    const pRef = ref(db, `users/${key}/profile`);
    try {
        const snap = await get(pRef);
        let cid;
        let ffid;
        if (!snap.exists()) {
            cid  = 'CID-' + generateUniqueClickId();
            ffid = 'FF-' + Math.floor(10000 + Math.random() * 89999);
            await set(pRef, {
                email, mainClickId: cid, ffid,
                createdAt: Date.now(),
                status: 'Approved', rank: 'Standard Affiliate',
                name: email.split('@')[0]
            });
        } else {
            const p = snap.val();
            cid  = p.mainClickId || ('CID-' + generateUniqueClickId());
            ffid = p.ffid        || ('FF-' + Math.floor(10000 + Math.random() * 89999));
            const patch = {};
            if (!p.mainClickId) patch.mainClickId = cid;
            if (!p.ffid)        patch.ffid        = ffid;
            if (Object.keys(patch).length) await update(pRef, patch);
        }

        // Publish both reverse indexes. server.js uses these to resolve
        // /go/:clickId and ?aff=<ffid> back to the same affiliateKey.
        await update(ref(db, `clickIdIndex/${cid}`), {
            affiliateKey: key, ffid, email, updatedAt: Date.now()
        });
        await update(ref(db, `ffidIndex/${ffid}`), {
            affiliateKey: key, clickId: cid, email, updatedAt: Date.now()
        });

        // Make sure the affiliate object carries the FF ID for the UI.
        if (!loggedInUserFFId) loggedInUserFFId = ffid;

        return cid;
    } catch (e) {
        console.warn('ensureMainClickId error:', e);
        return 'CID-' + generateUniqueClickId();
    }
}
