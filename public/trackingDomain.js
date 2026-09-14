// public/trackingDomain.js
// Single source of truth for the tracking host and link format.
// Copied affiliate links must go through this host so the server
// (server.js /go/:clickId) records the real visitor IP before
// redirecting to the network.

window.ADMADIA_TRACKING = Object.freeze({
    // Your real tracker host — no path, no trailing slash.
    domain: "https://admadia.site",

    // The network URL suffix that must be preserved byte-for-byte.
    // The generated link appends: sub5=s1admedia_<cid>_admedia_<ffid>
    networkSuffixMarker: "sub5=s1",

    // Example of a fully formed tracking link (documentation only):
    //   https://admadia.site/go/CID-xxxxxxxxx?aff=FF-00000
    //     &dest=https%3A%2F%2Fapp.trcefy.com%2Fclick%3F...%26sub5%3Ds1admedia_CID-xxxxxxxxx_admedia_FF-00000
    exampleLink:
        "https://admadia.site/go/CID-xxxxxxxxx?aff=FF-00000&dest=" +
        encodeURIComponent(
            "https://app.trcefy.com/click?pid=2&offer_id=23972&sub2=u814724" +
            "&sub5=s1admedia_CID-xxxxxxxxx_admedia_FF-00000"
        ),

    // Builds the final tracking link an affiliate copies.
    build(baseUrl, ffid, cid) {
        const marker = this.networkSuffixMarker;
        const idx = baseUrl.indexOf(marker);
        let base = baseUrl;
        if (idx !== -1) base = baseUrl.substring(0, idx + marker.length);

        const clean = String(base);
        const dest = clean + "admedia_" + cid + "_admedia_" + ffid;

        return (
            this.domain + "/go/" + encodeURIComponent(cid) +
            "?aff=" + encodeURIComponent(ffid) +
            "&dest=" + encodeURIComponent(dest)
        );
    }
});
