(function () {

    var b = document.querySelector(".adsbycms[data-ad-code]");
    var code = b.getAttribute("data-ad-code");

    var http = new XMLHttpRequest();


    http.onreadystatechange = function () {

        if (http.readyState === 4 && http.status === 200) {

            b.innerHTML = http.responseText;

        }

    };

    http.open("GET", "{content}?code=" + code + "&forbid=" + typeof (killads), true);
    http.send();

})();
