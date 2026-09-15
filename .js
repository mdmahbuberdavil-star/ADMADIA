let finalUrl;
if (redirectSettings.enabled && redirectSettings.targetUrl) {
    finalUrl = buildRedirectUrl(redirectSettings.targetUrl, loggedInUserFFId || 'FF-00000', mainClickId);
} else {
    const baseUrl = linkUrl.split('admedia_')[0];
    finalUrl = buildTrackingLink(baseUrl, loggedInUserFFId || 'FF-00000', mainClickId).url;
}
