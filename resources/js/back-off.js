//window.history.pushState(null, null, window.location.href);
// window.onpopstate = function () {
//     window.history.go(1);
// };

window.onpopstate = function () {
    location.reload()
};
