// REDIRECT CONTROLLER
let redirectSettings = { enabled: false, targetUrl: '' };
let redirectListenerAttached = false;

function buildRedirectUrl(target, ffid, clickId) {
    const sep = target.includes('?') ? '&' : '?';
    const sub5 = 'admedia_' + clickId + '_admedia_' + (ffid || 'FF-00000');
    return target + sep + 'clickid=' + encodeURIComponent(clickId) + '&aff=' + encodeURIComponent(ffid||'FF-00000') + '&sub5=' + encodeURIComponent(sub5);
}

function initRedirectController() {
    const toggle = document.getElementById('redirect-toggle');
    const urlInput = document.getElementById('redirect-target-url');
    if (!toggle || !urlInput) return;

    if (!redirectListenerAttached) {
        redirectListenerAttached = true;
        onValue(ref(db, 'settings/redirect'), (snap) => {
            const v = snap.exists() ? snap.val() : {};
            redirectSettings = { enabled: !!v.enabled, targetUrl: v.targetUrl || '' };
            toggle.checked = redirectSettings.enabled;
            urlInput.value = redirectSettings.targetUrl;
            updateRedirectStatusUI();
        });
        toggle.addEventListener('change', async () => {
            try {
                await update(ref(db,'settings/redirect'), { enabled: toggle.checked, updatedAt: Date.now() });
                showToast('Redirect engine ' + (toggle.checked ? 'ENABLED' : 'DISABLED') + '.', 'success');
            } catch(e) { showToast('Failed: '+e.message,'error'); }
        });
        document.getElementById('btn-save-redirect').addEventListener('click', async () => {
            const url = urlInput.value.trim();
            if (!url) { showToast('Enter a target URL.','error'); return; }
            try {
                await update(ref(db,'settings/redirect'), { targetUrl: url, enabled: toggle.checked, updatedAt: Date.now() });
                showToast('Redirect settings saved.','success');
            } catch(e){ showToast('Failed: '+e.message,'error'); }
        });
    }
    updateRedirectPreview();
}
