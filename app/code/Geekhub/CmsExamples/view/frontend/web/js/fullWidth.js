
define([
    'jquery',
    'underscore'
], function ($, _) {
    "use strict";

    $.widget('mageside.ImageFullWidth', {
        options: {
            elementImg: 'elementImg'
        },

        _create: function () {
            this._bind();
        },

        _bind: function () {
            var self = this;
            if (this.options.elementImg) {
                this.parentElems = $('.' + this.options.elementImg);
                if(this.parentElems.length) {
                    $(this.parentElems[0].parentElement).css('overflow','initial');
                    _.each(this.parentElems, function (parentElem) {
                        self._resizeImage(parentElem);
                        $(window).resize(function() {
                            self._resizeImage(parentElem);
                        }.bind(this));
                    });
                }
            }
        },
        _resizeImage: function (el) {
                var position = $(el).offset();
                var marginReal = $(el).css('margin-left');
                $(el).css({
                    'width': window.innerWidth,
                    'margin-left': parseInt(marginReal, 10) - Math.ceil(position.left)
                });
                $(el).css({
                    'height': $(el.children).outerHeight()
                });

        }
    });
    return $.mageside.ImageFullWidth;
});