const copyToClipboardX = str => {
    const el = document.createElement('textarea');
    el.value = str;
    document.body.appendChild(el);
    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);
};

function copyToClipboard(e) {
    var ip_key = e.getAttribute("data-ip-key")

    if (typeof ip_key != "undefined") {
        copyToClipboardX(ip_key);

        UIkit.notification({
            message: '<span>Api Key copied to clipboard.</span>',
            status: 'success',
            pos: 'top-left',
            timeout: 2000
        });
    }
}
