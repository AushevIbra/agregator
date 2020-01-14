window.onload =  function () {
    var fixedActionelem = document.querySelectorAll('.fixed-action-btn');
    M.FloatingActionButton.init(fixedActionelem, {
        direction: 'left',
        hoverEnabled: false
    });

    // setTimeout(() => {
    //     window.scrollSpy();
    //     window.initLazyLoad();
    // }, 2000);

    //M.Carousel.init(document.querySelectorAll('.carousel'));
};

document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function () {
        var elems = document.querySelectorAll('.pushpin');

        // Pushpin Demo Init
        if (elems.length) {
            elems.forEach(function(item, key) {
                var $this = item;
                var $target = document.querySelector('#' + $this.getAttribute('data-target'));

                M.Pushpin.init($this, {
                    top: $target.offsetTop,
                    bottom: $target.offsetTop + $target.offsetHeight - $this.clientHeight

                })

                // $this.pushpin({
                //    top: $target.offsetTop,
                //   bottom: $target.offsetTop + $target.outerHeight - $this.clientHeight
                // });
            });
        }
    }, 2000)



});
// window.onscroll = function () {
//     const navBlock = document.querySelector('div#nav-categories');
//     const navElementDesktop = document.querySelector('ul.categories');
//     const navElementMobile = document.querySelector('.mobile-categories');
//     if (null !== navElementDesktop) { // Desktop Menu
//         if (window.pageYOffset >= navBlock.offsetTop) {
//             navElementDesktop.classList.add('categories-fixed');
//             navElementDesktop.classList.add('categories-fixed-position');
//         }
//
//         if(window.pageYOffset === 0) {
//             navElementDesktop.classList.remove('categories-fixed');
//             navElementDesktop.classList.remove('categories-fixed-position');
//         }
//     }
//
//     if (null !== navElementMobile) {
//         if (window.pageYOffset >= navBlock.offsetTop) {
//             navElementMobile.classList.add('categories-fixed');
//             navElementMobile.classList.add('categories-fixed-position');
//         }
//
//         else {
//             navElementMobile.classList.remove('categories-fixed');
//             navElementMobile.classList.remove('categories-fixed-position');
//         }
//
//     }
//
// }



window.initLazyLoad = function () {
    let images = document.querySelectorAll(".lazyload");
    new LazyLoad(images, {
        root: null,
        rootMargin: "400px",
        threshold: 0
    });
}

window.sidenav = function () {
    var elems = document.querySelectorAll('.sidenav');
    M.Sidenav.init(elems);
};

window.scrollSpy = function () {
    var scrollSpyElems = document.querySelectorAll('.scrollspy');

    M.ScrollSpy.init(scrollSpyElems);
}