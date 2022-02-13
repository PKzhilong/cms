(function () {

    forbid();
    adv();

    function forbid()
    {
        var fb = ce("script");
        fb.src = "/mycms/addons/ads/js/adview_pic_cpc_cpm_cpa_guanggao_gg_ads_300x250.js";
        ac(fb);
    }

    function adv()
    {
        var fb = ce("script");
        fb.src = "{advert}";
        ac(fb);
    }

    function ce(a) {
        return document.createElement(String(a).toLowerCase())
    }

    function ac(a) {
        document.getElementsByTagName('head')[0].appendChild(a);
    }
})();
