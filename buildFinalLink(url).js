function buildFinalLink(baseUrl) {
    const ffid = loggedInUserFFId || 'FF-00000';
    const cid = loggedInUserMainClickId || ('CID-' + generateUniqueClickId());
    if (redirectSettings.enabled && redirectSettings.targetUrl) {
        return buildRedirectUrl(redirectSettings.targetUrl, ffid, cid);
    }
    return buildTrackingLink(baseUrl, ffid, cid).url;
}
