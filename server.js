async function resolveAffiliate(clickId, affParam) {
  // 1. Fast path: clickId in the URL path
  if (clickId) {
    const s = await db.ref(`clickIdIndex/${clickId}`).get();
    if (s.exists()) return s.val().affiliateKey;
  }
  // 2. Fast path: FF ID in ?aff=
  if (affParam) {
    const s = await db.ref(`ffidIndex/${affParam}`).get();
    if (s.exists()) return s.val().affiliateKey;

    // 3. Slow fallback for very old users who never had an ffidIndex
    const byFfid = await db.ref('users')
      .orderByChild('profile/ffid').equalTo(affParam).limitToFirst(1).get();
    if (byFfid.exists()) {
      const k = Object.keys(byFfid.val())[0];
      // Backfill the index so this only happens once
      await db.ref(`ffidIndex/${affParam}`).set({
        affiliateKey: k, updatedAt: Date.now()
      });
      return k;
    }
  }
  return null;
}
