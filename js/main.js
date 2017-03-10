(function () {
    var parallax = document.querySelectorAll(".parallax"),
        speed = 0.5;

    window.onscroll = function () {
        [].slice.call(parallax).forEach(function (el,i) {
            var windowYoffset = window.pageYOffset, elBackgrounpos = "50%" + (windowYoffset*speed) + "px"
            el.style.backgroundPosition =elBackgrounpos;
        });
    };
})();