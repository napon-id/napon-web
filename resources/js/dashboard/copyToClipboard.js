(function ($) {
    $(function () {
        window.copyToClipboard = function (elementId) {
            var aux = document.createElement("input");
            aux.setAttribute("value", document.getElementById(elementId).innerHTML);
            document.body.appendChild(aux);
            aux.select();
            document.execCommand("copy");
            document.body.removeChild(aux);
        }
    })
}) ( jQuery );
