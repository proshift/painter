/* =============================================================
 * bootstrap-Galleway.js v2.0.4
 * http://twitter.github.com/bootstrap/javascript.html#Galleway
 * =============================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================ */


!function($){

  "use strict"; // jshint ;_;


 /* Galleway PUBLIC CLASS DEFINITION
  * ================================= */

  var Galleway = function (element, options) {
    this.$element = $(element)
    this.options = $.extend({}, $.fn.galleway.defaults, options)
    this.matcher = this.options.matcher || this.matcher
    this.sorter = this.options.sorter || this.sorter
    this.highlighter = this.options.highlighter || this.highlighter
    this.updater = this.options.updater || this.updater
    this.$menu = $(this.options.menu).appendTo('body')
    this.source = this.options.source
    this.shown = false
    this.$element.append('<div id="galleway-show" class="gallewayscreen"></div>')
    this.$element.append('<div id="galleway-menu" class="gallewaydiv"></div>')
    this.show()
  }

  Galleway.prototype = {

    constructor: Galleway

  , show: function() {
      var obj = document.createElement('div')
        , $obj = $(obj)
        , a = document.createElement('a')
      $obj.addClass('gallewayitem')
      $obj.css({
        'background' : 'url(../..'+this.source[0]+')'
      })
      a.onclick = function() {

      }
      this.$element.append($obj)
    }
  }


  /* Galleway PLUGIN DEFINITION
   * =========================== */

  $.fn.galleway = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('Galleway')
        , options = typeof option == 'object' && option
      $this.addClass('galleway')
      if (!data) $this.data('Galleway', (data = new Galleway(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  $.fn.galleway.defaults = {
    source: ['/images/1.jpg']
  , items: 8
  , menu: '<ul class="Galleway dropdown-menu"></ul>'
  , item: '<div></div>'
  , onselect: function(Galleway) {}
  }

  $.fn.galleway.Constructor = Galleway


 /* Galleway DATA-API
  * ================== */

  $(function () {
      $("#galleway").galleway()
      $("#galleway-show").addClass("gallewayscreen")
  })

}(window.jQuery);