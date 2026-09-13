const functions = require('firebase-functions');
const admin = require('firebase-admin');

admin.initializeApp();
const db = admin.database();

exports.postback = functions.https.onRequest(async (req, res) => {
    // CORS — allow the tracking platform to POST from any origin
    res.set('Access-Control-Allow-Origin', '*');
    res.set('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
    res.set('Access-Control-Allow-Headers', 'Content-Type');

    if (req.method === 'OPTIONS') {
        res.status(204).send('');
        return;
    }

    const params = { ...req.query, ...req.body };

    const clickId     = params.click_id     || '';
    const affiliateId = params.s2           || '';
    const payout      = parseFloat(params.payout || '0');
    const status      = String(params.status || '1');
    const offerId     = params.offer_id     || '';
    const ip          = params.ip           || 'unknown';
    const country     = params.country_code || '';
    const unixTs      = parseInt(params.unix || '0', 10);
    const leadId      = params.lead_id      || '';

    if (!clickId || !affiliateId) {
        console.warn('Postback missing required params', params);
        res.status(400).send('Missing click_id or s2');
        return;
    }

    // Look up the affiliate by matching affiliateFfId == affiliateId
    const usersSnap = await db.ref('users').once('value');
    let affiliateKey = null;
    if (usersSnap.exists()) {
        usersSnap.forEach(child => {
            const prof = (child.val() || {}).profile || {};
            if (prof.ffid === affiliateId) affiliateKey = child.key;
        });
    }
    if (!affiliateKey) {
        // Fall back to using the affiliate ID directly if it looks like a safe key
        affiliateKey = affiliateId;
    }

    const ts = unixTs ? unixTs * 1000 : Date.now();
    const eventId = 'pb_' + ts + '_' + Math.random().toString(36).slice(2, 8);
    const isConversion = status === '1';
    const day = new Date(ts).toISOString().slice(0, 10);

    try {
        // 1) Write the conversion event under trackings/{affiliateKey}/{eventId}
        await db.ref(`trackings/${affiliateKey}/${eventId}`).set({
            timestamp: ts,
            ip: ip,
            conversion: isConversion,
            earnings: isConversion ? payout : 0,
            clickId: clickId,
            offerId: offerId,
            leadId: leadId,
            countryCode: country,
            affiliateFfId: affiliateId,
            isDuplicate: false,
            dateKey: day,
            source: 'postback'
        });

        // 2) Update clickTracking summary if this clickId was previously recorded
        const clickIdRef = db.ref(`clickTracking/${affiliateKey}/clickIds/${clickId}`);
        const clickSnap = await clickIdRef.once('value');
        if (clickSnap.exists()) {
            const c = clickSnap.val();
            await clickIdRef.update({
                lastConversionAt: ts,
                conversions: (c.conversions || 0) + (isConversion ? 1 : 0)
            });
        }

        // 3) Credit affiliate stats
        if (isConversion && payout > 0) {
            const statsRef = db.ref(`users/${affiliateKey}/stats`);
            const statsSnap = await statsRef.once('value');
            const s = statsSnap.val() || {};
            await statsRef.update({
                earnings: (s.earnings || 0) + payout,
                leads: (s.leads || 0) + 1
            });

            // 4) Bump the day's counter
            const dailyRef = db.ref(`dailyCounters/${affiliateKey}/${day}`);
            const dailySnap = await dailyRef.once('value');
            const d = dailySnap.val() || { clicks: 0, leads: 0, earnings: 0 };
            await dailyRef.update({
                leads: (d.leads || 0) + 1,
                earnings: (d.earnings || 0) + payout
            });

            // 5) Push a realtime event so the dashboard feed lights up
            await db.ref(`leads/${ts}`).set({
                clickId: clickId,
                affiliate: affiliateKey,
                earnings: payout,
                offerId: offerId,
                leadId: leadId,
                timestamp: ts
            });
        }

        res.status(200).json({ ok: true, eventId, affiliateKey, credited: isConversion });
    } catch (err) {
        console.error('Postback write failed:', err);
        res.status(500).send('Postback write failed');
    }
});
