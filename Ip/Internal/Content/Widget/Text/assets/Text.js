/**
 * @package ImpressPages
 *
 */
var IpWidget_Text;

(function($){
    "use strict";

    IpWidget_Text = function() {
        this.$widgetObject = null;

        this.init = function($widgetObject, data) {
            var customTinyMceConfig = ipTinyMceConfig();
            this.$widgetObject = $widgetObject;
            customTinyMceConfig.setup = function(ed, l) {ed.on('change', function(e) {
                $widgetObject.save({text: $widgetObject.find('.ipsContent').html()});
            })};

            $widgetObject.find('.ipsContent').tinymce(customTinyMceConfig);
        };

        this.onAdd = function () {
            this.$widgetObject.find('.ipsContent').focus();
        }

        this.splitParts = function () {
            return this.$widgetObject.find('.ipsContent > *');
        }

        this.splitData = function (curData, position) {
            //we ignore curData value as it holds data from the database. While actual data in editor might be already changed
            var recentData = {text: this.$widgetObject.find('.ipsContent').html()};
            var paragraphs = this.splitParts();

            var text1 = '';
            var text2 = '';
            $.each(paragraphs, function(key, paragraph) {
                var $paragraph = $(paragraph);
                var $div = $('<div></div>').append($paragraph);
                if (key < position - 1) {
                    text1 = text1 + $div.html();
                } else {
                    text2 = text2 + $div.html();
                }
            });

            return [{text: text1}, {text: text2}];
        }


    };

})(ip.jQuery);