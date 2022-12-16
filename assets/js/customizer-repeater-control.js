/* global jQuery */
/* global wp */
/**
 *  jQuery fontIconPicker - 3.1.1
 *
 *  An icon picker built on top of font icons and jQuery
 *
 *  http://codeb.it/fontIconPicker
 *
 *  @author Alessandro Benoit & Swashata Ghosh
 *  @license MIT License
 *
 * {@link https://github.com/micc83/fontIconPicker}
 */
!function(t,e){"object"==typeof exports&&"undefined"!=typeof module?module.exports=e(require("jquery")):"function"==typeof define&&define.amd?define(["jquery"],e):t.initFontIconPickerNode=e(t.jQuery)}(this,function(t){"use strict";function e(t){return(e="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}function i(t){return function(t){if(Array.isArray(t)){for(var e=0,i=new Array(t.length);e<t.length;e++)i[e]=t[e];return i}}(t)||function(t){if(Symbol.iterator in Object(t)||"[object Arguments]"===Object.prototype.toString.call(t))return Array.from(t)}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance")}()}var s={theme:"fip-grey",source:!1,emptyIcon:!0,emptyIconValue:"",autoClose:!0,iconsPerPage:20,hasSearch:!0,searchSource:!1,appendTo:"self",useAttribute:!1,attributeName:"data-icon",convertToHex:!0,allCategoryText:"From all categories",unCategorizedText:"Uncategorized",iconGenerator:null,windowDebounceDelay:150,searchPlaceholder:"Search Icons"},n=t=t&&t.hasOwnProperty("default")?t.default:t,o=0;function r(t,e){this.element=n(t),this.settings=n.extend({},s,e),this.settings.emptyIcon&&this.settings.iconsPerPage--,this.iconPicker=n("<div/>",{class:"icons-selector",style:"position: relative",html:this._getPickerTemplate(),attr:{"data-fip-origin":this.element.attr("id")}}),this.iconContainer=this.iconPicker.find(".fip-icons-container"),this.searchIcon=this.iconPicker.find(".selector-search i"),this.selectorPopup=this.iconPicker.find(".selector-popup-wrap"),this.selectorButton=this.iconPicker.find(".selector-button"),this.iconsSearched=[],this.isSearch=!1,this.totalPage=1,this.currentPage=1,this.currentIcon=!1,this.iconsCount=0,this.open=!1,this.guid=o++,this.eventNameSpace=".fontIconPicker".concat(o),this.searchValues=[],this.availableCategoriesSearch=[],this.triggerEvent=null,this.backupSource=[],this.backupSearch=[],this.isCategorized=!1,this.selectCategory=this.iconPicker.find(".icon-category-select"),this.selectedCategory=!1,this.availableCategories=[],this.unCategorizedKey=null,this.init()}function c(t){return!(!(e=t).fn||(!e.fn||!e.fn.fontIconPicker)&&(e.fn.fontIconPicker=function(t){var i=this;return this.each(function(){e.data(this,"fontIconPicker")||e.data(this,"fontIconPicker",new r(this,t))}),this.setIcons=function(){var t=arguments.length>0&&void 0!==arguments[0]&&arguments[0],s=arguments.length>1&&void 0!==arguments[1]&&arguments[1];i.each(function(){e.data(this,"fontIconPicker").setIcons(t,s)})},this.setIcon=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"";i.each(function(){e.data(this,"fontIconPicker").setIcon(t)})},this.destroyPicker=function(){i.each(function(){e.data(this,"fontIconPicker")&&(e.data(this,"fontIconPicker").destroy(),e.removeData(this,"fontIconPicker"))})},this.refreshPicker=function(s){s||(s=t),i.destroyPicker(),i.each(function(){e.data(this,"fontIconPicker")||e.data(this,"fontIconPicker",new r(this,s))})},this.repositionPicker=function(){i.each(function(){e.data(this,"fontIconPicker").resetPosition()})},this.setPage=function(t){i.each(function(){e.data(this,"fontIconPicker").setPage(t)})},this},0));var e}r.prototype={init:function(){this.iconPicker.addClass(this.settings.theme),this.iconPicker.css({left:-9999}).appendTo("body");var t=this.iconPicker.outerHeight(),e=this.iconPicker.outerWidth();this.iconPicker.css({left:""}),this.element.before(this.iconPicker),this.element.css({visibility:"hidden",top:0,position:"relative",zIndex:"-1",left:"-"+e+"px",display:"inline-block",height:t+"px",width:e+"px",padding:"0",margin:"0 -"+e+"px 0 0",border:"0 none",verticalAlign:"top",float:"none"}),this.element.is("select")||(this.triggerEvent="input"),!this.settings.source&&this.element.is("select")?this._populateSourceFromSelect():this._initSourceIndex(),this._loadCategories(),this._loadIcons(),this._initDropDown(),this._initCategoryChanger(),this._initPagination(),this._initIconSearch(),this._initIconSelect(),this._initAutoClose(),this._initFixOnResize()},setIcons:function(t,e){this.settings.source=Array.isArray(t)?i(t):n.extend({},t),this.settings.searchSource=Array.isArray(e)?i(e):n.extend({},e),this._initSourceIndex(),this._loadCategories(),this._resetSearch(),this._loadIcons()},setIcon:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"";this._setSelectedIcon(t)},destroy:function(){this.iconPicker.off().remove(),this.element.css({visibility:"",top:"",position:"",zIndex:"",left:"",display:"",height:"",width:"",padding:"",margin:"",border:"",verticalAlign:"",float:""}),n(window).off("resize"+this.eventNameSpace),n("html").off("click"+this.eventNameSpace)},resetPosition:function(){this._fixOnResize()},setPage:function(t){"first"==t&&(t=1),"last"==t&&(t=this.totalPage),t=parseInt(t,10),isNaN(t)&&(t=1),t>this.totalPage&&(t=this.totalPage),1>t&&(t=1),this.currentPage=t,this._renderIconContainer()},_initFixOnResize:function(){var t,e,i,s=this;n(window).on("resize"+this.eventNameSpace,(t=function(){s._fixOnResize()},e=this.settings.windowDebounceDelay,function(){var s=this,n=arguments;clearTimeout(i),i=setTimeout(function(){return t.apply(s,n)},e)}))},_initAutoClose:function(){var t=this;this.settings.autoClose&&n("html").on("click"+this.eventNameSpace,function(e){var i=e.target;t.selectorPopup.has(i).length||t.selectorPopup.is(i)||t.iconPicker.has(i).length||t.iconPicker.is(i)||t.open&&t._toggleIconSelector()})},_initIconSelect:function(){var t=this;this.selectorPopup.on("click",".fip-box",function(e){var i=n(e.currentTarget);t._setSelectedIcon(i.attr("data-fip-value")),t._toggleIconSelector()})},_initIconSearch:function(){var t=this;this.selectorPopup.on("input",".icons-search-input",function(e){var i=n(e.currentTarget).val();""!==i?(t.searchIcon.removeClass("fip-icon-search"),t.searchIcon.addClass("fip-icon-cancel"),t.isSearch=!0,t.currentPage=1,t.iconsSearched=[],n.grep(t.searchValues,function(e,s){if(0<=e.toLowerCase().search(i.toLowerCase()))return t.iconsSearched[t.iconsSearched.length]=t.settings.source[s],!0}),t._renderIconContainer()):t._resetSearch()}),this.selectorPopup.on("click",".selector-search .fip-icon-cancel",function(){t.selectorPopup.find(".icons-search-input").focus(),t._resetSearch()})},_initPagination:function(){var t=this;this.selectorPopup.on("click",".selector-arrow-right",function(e){t.currentPage<t.totalPage&&(t.currentPage=t.currentPage+1,t._renderIconContainer())}),this.selectorPopup.on("click",".selector-arrow-left",function(e){1<t.currentPage&&(t.currentPage=t.currentPage-1,t._renderIconContainer())})},_initCategoryChanger:function(){var t=this;this.selectorPopup.on("change keyup",".icon-category-select",function(e){if(!1===t.isCategorized)return!1;var i=n(e.currentTarget),s=i.val();if("all"===i.val())t.settings.source=t.backupSource,t.searchValues=t.backupSearch;else{var o=parseInt(s,10);t.availableCategories[o]&&(t.settings.source=t.availableCategories[o],t.searchValues=t.availableCategoriesSearch[o])}t._resetSearch(),t._loadIcons()})},_initDropDown:function(){var t=this;this.selectorButton.on("click",function(e){t._toggleIconSelector()})},_getPickerTemplate:function(){return'\n<div class="selector" data-fip-origin="'.concat(this.element.attr("id"),'">\n\t<span class="selected-icon">\n\t\t<i class="fip-icon-block"></i>\n\t</span>\n\t<span class="selector-button">\n\t\t<i class="fip-icon-down-dir"></i>\n\t</span>\n</div>\n<div class="selector-popup-wrap" data-fip-origin="').concat(this.element.attr("id"),'">\n\t<div class="selector-popup" style="display: none;"> ').concat(this.settings.hasSearch?'<div class="selector-search">\n\t\t\t<input type="text" name="" value="" placeholder="'.concat(this.settings.searchPlaceholder,'" class="icons-search-input"/>\n\t\t\t<i class="fip-icon-search"></i>\n\t\t</div>'):"",'\n\t\t<div class="selector-category">\n\t\t\t<select name="" class="icon-category-select" style="display: none"></select>\n\t\t</div>\n\t\t<div class="fip-icons-container"></div>\n\t\t<div class="selector-footer" style="display:none;">\n\t\t\t<span class="selector-pages">1/2</span>\n\t\t\t<span class="selector-arrows">\n\t\t\t\t<span class="selector-arrow-left" style="display:none;">\n\t\t\t\t\t<i class="fip-icon-left-dir"></i>\n\t\t\t\t</span>\n\t\t\t\t<span class="selector-arrow-right">\n\t\t\t\t\t<i class="fip-icon-right-dir"></i>\n\t\t\t\t</span>\n\t\t\t</span>\n\t\t</div>\n\t</div>\n</div>')},_initSourceIndex:function(){if("object"===e(this.settings.source)){if(Array.isArray(this.settings.source))this.isCategorized=!1,this.selectCategory.html("").hide(),this.settings.source=n.map(this.settings.source,function(t,e){return"function"==typeof t.toString?t.toString():t}),Array.isArray(this.settings.searchSource)?this.searchValues=n.map(this.settings.searchSource,function(t,e){return"function"==typeof t.toString?t.toString():t}):this.searchValues=this.settings.source.slice(0);else{var t=n.extend(!0,{},this.settings.source);for(var i in this.settings.source=[],this.searchValues=[],this.availableCategoriesSearch=[],this.selectedCategory=!1,this.availableCategories=[],this.unCategorizedKey=null,this.isCategorized=!0,this.selectCategory.html(""),t){var s=this.availableCategories.length,o=n("<option />");for(var r in o.attr("value",s),o.html(i),this.selectCategory.append(o),this.availableCategories[s]=[],this.availableCategoriesSearch[s]=[],t[i]){var c=t[i][r],a=this.settings.searchSource&&this.settings.searchSource[i]&&this.settings.searchSource[i][r]?this.settings.searchSource[i][r]:c;"function"==typeof c.toString&&(c=c.toString()),c&&c!==this.settings.emptyIconValue&&(this.settings.source.push(c),this.availableCategories[s].push(c),this.searchValues.push(a),this.availableCategoriesSearch[s].push(a))}}}this.backupSource=this.settings.source.slice(0),this.backupSearch=this.searchValues.slice(0)}},_populateSourceFromSelect:function(){var t=this;this.settings.source=[],this.settings.searchSource=[],this.element.find("optgroup").length?(this.isCategorized=!0,this.element.find("optgroup").each(function(e,i){var s=t.availableCategories.length,o=n("<option />");o.attr("value",s),o.html(n(i).attr("label")),t.selectCategory.append(o),t.availableCategories[s]=[],t.availableCategoriesSearch[s]=[],n(i).find("option").each(function(e,i){var o=n(i).val(),r=n(i).html();o&&o!==t.settings.emptyIconValue&&(t.settings.source.push(o),t.availableCategories[s].push(o),t.searchValues.push(r),t.availableCategoriesSearch[s].push(r))})}),this.element.find("> option").length&&this.element.find("> option").each(function(e,i){var s=n(i).val(),o=n(i).html();if(!s||""===s||s==t.settings.emptyIconValue)return!0;null===t.unCategorizedKey&&(t.unCategorizedKey=t.availableCategories.length,t.availableCategories[t.unCategorizedKey]=[],t.availableCategoriesSearch[t.unCategorizedKey]=[],n("<option />").attr("value",t.unCategorizedKey).html(t.settings.unCategorizedText).appendTo(t.selectCategory)),t.settings.source.push(s),t.availableCategories[t.unCategorizedKey].push(s),t.searchValues.push(o),t.availableCategoriesSearch[t.unCategorizedKey].push(o)})):this.element.find("option").each(function(e,i){var s=n(i).val(),o=n(i).html();s&&(t.settings.source.push(s),t.searchValues.push(o))}),this.backupSource=this.settings.source.slice(0),this.backupSearch=this.searchValues.slice(0)},_loadCategories:function(){!1!==this.isCategorized&&(n('<option value="all">'+this.settings.allCategoryText+"</option>").prependTo(this.selectCategory),this.selectCategory.show().val("all").trigger("change"))},_loadIcons:function(){this.iconContainer.html('<i class="fip-icon-spin3 animate-spin loading"></i>'),Array.isArray(this.settings.source)&&this._renderIconContainer()},_iconGenerator:function(t){return"function"==typeof this.settings.iconGenerator?this.settings.iconGenerator(t):"<i "+(this.settings.useAttribute?this.settings.attributeName+'="'+(this.settings.convertToHex?"&#x"+parseInt(t,10).toString(16)+";":t)+'"':'class="'+t+'"')+"></i>"},_renderIconContainer:function(){var t,e=this,i=[];if(i=this.isSearch?this.iconsSearched:this.settings.source,this.iconsCount=i.length,this.totalPage=Math.ceil(this.iconsCount/this.settings.iconsPerPage),1<this.totalPage?(this.selectorPopup.find(".selector-footer").show(),this.currentPage<this.totalPage?this.selectorPopup.find(".selector-arrow-right").show():this.selectorPopup.find(".selector-arrow-right").hide(),1<this.currentPage?this.selectorPopup.find(".selector-arrow-left").show():this.selectorPopup.find(".selector-arrow-left").hide()):this.selectorPopup.find(".selector-footer").hide(),this.selectorPopup.find(".selector-pages").html(this.currentPage+"/"+this.totalPage+" <em>("+this.iconsCount+")</em>"),t=(this.currentPage-1)*this.settings.iconsPerPage,this.settings.emptyIcon)this.iconContainer.html('<span class="fip-box" data-fip-value="fip-icon-block"><i class="fip-icon-block"></i></span>');else{if(1>i.length)return void this.iconContainer.html('<span class="icons-picker-error" data-fip-value="fip-icon-block"><i class="fip-icon-block"></i></span>');this.iconContainer.html("")}i=i.slice(t,t+this.settings.iconsPerPage);for(var s,o=function(t,i){var s=i;n.grep(e.settings.source,n.proxy(function(t,e){return t===i&&(s=this.searchValues[e],!0)},e)),n("<span/>",{html:e._iconGenerator(i),attr:{"data-fip-value":i},class:"fip-box",title:s}).appendTo(e.iconContainer)},r=0;s=i[r++];)o(0,s);if(this.settings.emptyIcon||this.element.val()&&-1!==n.inArray(this.element.val(),this.settings.source))if(-1===n.inArray(this.element.val(),this.settings.source))this._setSelectedIcon("");else{var c=this.element.val();c===this.settings.emptyIconValue&&(c="fip-icon-block"),this._setSelectedIcon(c)}else this._setSelectedIcon(i[0])},_setHighlightedIcon:function(){this.iconContainer.find(".current-icon").removeClass("current-icon"),this.currentIcon&&this.iconContainer.find('[data-fip-value="'+this.currentIcon+'"]').addClass("current-icon")},_setSelectedIcon:function(t){"fip-icon-block"===t&&(t="");var e=this.iconPicker.find(".selected-icon");""===t?e.html('<i class="fip-icon-block"></i>'):e.html(this._iconGenerator(t));var i=this.element.val();this.element.val(""===t?this.settings.emptyIconValue:t),i!==t&&(this.element.trigger("change"),null!==this.triggerEvent&&this.element.trigger(this.triggerEvent)),this.currentIcon=t,this._setHighlightedIcon()},_repositionIconSelector:function(){var t=this.iconPicker.offset(),e=t.top+this.iconPicker.outerHeight(!0),i=t.left;this.selectorPopup.css({left:i,top:e})},_fixWindowOverflow:function(){var t=this.selectorPopup.find(".selector-popup").is(":visible");t||this.selectorPopup.find(".selector-popup").show();var e=this.selectorPopup.outerWidth(),i=n(window).width(),s=this.selectorPopup.offset().left,o="self"==this.settings.appendTo?this.selectorPopup.parent().offset():n(this.settings.appendTo).offset();if(t||this.selectorPopup.find(".selector-popup").hide(),s+e>i-20){var r=this.selectorButton.offset().left+this.selectorButton.outerWidth(),c=Math.floor(r-e-1);0>c?this.selectorPopup.css({left:i-20-e-o.left}):this.selectorPopup.css({left:c})}},_fixOnResize:function(){"self"!==this.settings.appendTo&&this._repositionIconSelector(),this._fixWindowOverflow()},_toggleIconSelector:function(){this.open=this.open?0:1,this.open&&("self"!==this.settings.appendTo&&(this.selectorPopup.appendTo(this.settings.appendTo).css({zIndex:1e3}).addClass("icons-selector "+this.settings.theme),this._repositionIconSelector()),this._fixWindowOverflow()),this.selectorPopup.find(".selector-popup").slideToggle(300,n.proxy(function(){this.iconPicker.find(".selector-button i").toggleClass("fip-icon-down-dir"),this.iconPicker.find(".selector-button i").toggleClass("fip-icon-up-dir"),this.open?this.selectorPopup.find(".icons-search-input").trigger("focus").trigger("select"):this.selectorPopup.appendTo(this.iconPicker).css({left:"",top:"",zIndex:""}).removeClass("icons-selector "+this.settings.theme)},this))},_resetSearch:function(){this.selectorPopup.find(".icons-search-input").val(""),this.searchIcon.removeClass("fip-icon-cancel"),this.searchIcon.addClass("fip-icon-search"),this.currentPage=1,this.isSearch=!1,this._renderIconContainer()}},t&&t.fn&&c(t);return function(t){return c(t)}});

function media_upload(button_class) {
    'use strict';
    jQuery('body').on('click', button_class, function () {
        var button_id = '#' + jQuery(this).attr('id');
        var display_field = jQuery(this).parent().children('input:text');
        var _custom_media = true;

        wp.media.editor.send.attachment = function (props, attachment) {

            if (_custom_media) {
                if (typeof display_field !== 'undefined') {
                    switch (props.size) {
                        case 'full':
                            display_field.val(attachment.sizes.full.url);
                            display_field.trigger('change');
                            break;
                        case 'medium':
                            display_field.val(attachment.sizes.medium.url);
                            display_field.trigger('change');
                            break;
                        case 'thumbnail':
                            display_field.val(attachment.sizes.thumbnail.url);
                            display_field.trigger('change');
                            break;
                        default:
                            display_field.val(attachment.url);
                            display_field.trigger('change');
                    }
                }
                _custom_media = false;
            } else {
                return wp.media.editor.send.attachment(button_id, [props, attachment]);
            }
        };
        wp.media.editor.open(button_class);
        window.send_to_editor = function (html) {

        };
        return false;
    });
}

/********************************************
 *** Generate unique id ***
 *********************************************/
function customizer_repeater_uniqid(prefix, more_entropy) {
    'use strict';
    if (typeof prefix === 'undefined') {
        prefix = '';
    }

    var retId;
    var php_js;
    var formatSeed = function (seed, reqWidth) {
        seed = parseInt(seed, 10)
            .toString(16); // to hex str
        if (reqWidth < seed.length) { // so long we split
            return seed.slice(seed.length - reqWidth);
        }
        if (reqWidth > seed.length) { // so short we pad
            return new Array(1 + (reqWidth - seed.length))
                .join('0') + seed;
        }
        return seed;
    };

    // BEGIN REDUNDANT
    if (!php_js) {
        php_js = {};
    }
    // END REDUNDANT
    if (!php_js.uniqidSeed) { // init seed with big random int
        php_js.uniqidSeed = Math.floor(Math.random() * 0x75bcd15);
    }
    php_js.uniqidSeed++;

    retId = prefix; // start with prefix, add current milliseconds hex string
    retId += formatSeed(parseInt(new Date()
        .getTime() / 1000, 10), 8);
    retId += formatSeed(php_js.uniqidSeed, 5); // add seed hex string
    if (more_entropy) {
        // for more entropy we add a float lower to 10
        retId += (Math.random() * 10)
            .toFixed(8)
            .toString();
    }

    return retId;
}


/********************************************
 *** General Repeater ***
 *********************************************/
// function customizer_repeater_refresh_social_icons(th) {
//     'use strict';
//     var icons_repeater_values = [];
//     th.find('.customizer-repeater-social-repeater-container').each(function () {
//         var icon = jQuery(this).find('.icp').val();
//         var link = jQuery(this).find('.customizer-repeater-social-repeater-link').val();
//         var id = jQuery(this).find('.customizer-repeater-social-repeater-id').val();

//         if (!id) {
//             id = 'customizer-repeater-social-repeater-' + customizer_repeater_uniqid();
//             jQuery(this).find('.customizer-repeater-social-repeater-id').val(id);
//         }

//         if (icon !== '' && link !== '') {
//             icons_repeater_values.push({
//                 'icon': icon,
//                 'link': link,
//                 'id': id
//             });
//         }
//     });

//     th.find('.social-repeater-socials-repeater-colector').val(JSON.stringify(icons_repeater_values));
//     customizer_repeater_refresh_general_control_values();
// }


function customizer_repeater_refresh_general_control_values() {
    'use strict';
    jQuery('.customizer-repeater-general-control-repeater').each(function () {
        var values = [];
        var th = jQuery(this);
        th.find('.customizer-repeater-general-control-repeater-container').each(function () {

            var icon_value = jQuery(this).find('.mailtpl-icon-select').val();
            var icon_color = jQuery(this).find('.customizer-repeater-icon-color').val();
            var text = jQuery(this).find('.customizer-repeater-text-control').val();
            var link = jQuery(this).find('.customizer-repeater-link-control').val();
            var text2 = jQuery(this).find('.customizer-repeater-text2-control').val();
            var link2 = jQuery(this).find('.customizer-repeater-link2-control').val();
            var color = jQuery(this).find('input.customizer-repeater-color-control').val();
            var color2 = jQuery(this).find('input.customizer-repeater-color2-control').val();
            var image_url = jQuery(this).find('.custom-media-url').val();
            var choice = jQuery(this).find('.customizer-repeater-image-choice').val();
            var title = jQuery(this).find('.customizer-repeater-title-control').val();
            var subtitle = jQuery(this).find('.customizer-repeater-subtitle-control').val();
            var id = jQuery(this).find('.social-repeater-box-id').val();
            if (!id) {
                id = 'social-repeater-' + customizer_repeater_uniqid();
                jQuery(this).find('.social-repeater-box-id').val(id);
            }
            var shortcode = jQuery(this).find('.customizer-repeater-shortcode-control').val();

            if (text !== '' || image_url !== '' || title !== '' || subtitle !== '' || icon_value !== '' || icon_color !== '' || link !== '' || choice !== '' || shortcode !== '' || color !== '') {
                values.push({
                    'icon_value': (choice === 'customizer_repeater_none' ? '' : icon_value),
                    'icon_color': icon_color,
                    'color': color,
                    'color2': color2,
                    'text': escapeHtml(text),
                    'link': link,
                    'text2': escapeHtml(text2),
                    'link2': link2,
                    'image_url': (choice === 'customizer_repeater_none' ? '' : image_url),
                    'choice': choice,
                    'title': escapeHtml(title),
                    'subtitle': escapeHtml(subtitle),
                    'id': id,
                    'shortcode': escapeHtml(shortcode)
                });
            }

        });
        th.find('.customizer-repeater-colector').val(JSON.stringify(values));
        th.find('.customizer-repeater-colector').trigger('change');
    });
}

jQuery(document).ready(function ($) {
	mailtpl_icon_picker_init();
	function mailtpl_icon_picker_init(){
		icon_picker = jQuery('select.mailtpl-icon-select').fontIconPicker({
			emptyIcon:false,
			iconsPerPage:25,
		});
	}
    var theme_conrols = jQuery('#customize-theme-controls');
    theme_conrols.on('click', '.customizer-repeater-customize-control-title-box', function () {
        jQuery(this).next().slideToggle('medium', function () {
            if (jQuery(this).is(':visible')){
                jQuery(this).prev().addClass('repeater-expanded');
                jQuery(this).css('display', 'block');
            } else {
                jQuery(this).prev().removeClass('repeater-expanded');
            }
        });
    });

    theme_conrols.on('change', '.mailtpl-icon-select',function(){
        customizer_repeater_refresh_general_control_values();
        return false;
    });
    theme_conrols.on('change', '.customizer-repeater-icon-color',function(){
        customizer_repeater_refresh_general_control_values();
        return false;
    });

    theme_conrols.on('change', '.customizer-repeater-image-choice', function () {
        if (jQuery(this).val() === 'customizer_repeater_image') {
            jQuery(this).parent().parent().find('.social-repeater-general-control-icon').hide();
            jQuery(this).parent().parent().find('.customizer-repeater-image-control').show();
            jQuery(this).parent().parent().find('.customizer-repeater-color-control').prev().prev().hide();
            jQuery(this).parent().parent().find('.customizer-repeater-color-control').hide();
            jQuery(this).parent().parent().find('.customizer-repeater-icon-color-control').hide();

        }
        if (jQuery(this).val() === 'customizer_repeater_icon') {
            jQuery(this).parent().parent().find('.social-repeater-general-control-icon').show();
            jQuery(this).parent().parent().find('.customizer-repeater-image-control').hide();
            jQuery(this).parent().parent().find('.customizer-repeater-color-control').prev().prev().show();
            jQuery(this).parent().parent().find('.customizer-repeater-color-control').show();
            jQuery(this).parent().parent().find('.customizer-repeater-icon-color-control').show();
        }
        if (jQuery(this).val() === 'customizer_repeater_none') {
            jQuery(this).parent().parent().find('.social-repeater-general-control-icon').hide();
            jQuery(this).parent().parent().find('.customizer-repeater-image-control').hide();
            jQuery(this).parent().parent().find('.customizer-repeater-color-control').prev().prev().hide();
            jQuery(this).parent().parent().find('.customizer-repeater-color-control').hide();
            jQuery(this).parent().parent().find('.customizer-repeater-icon-color-control').hide();
        }

        customizer_repeater_refresh_general_control_values();
        return false;
    });
    media_upload('.customizer-repeater-custom-media-button');
    jQuery('.custom-media-url').on('change', function () {
        customizer_repeater_refresh_general_control_values();
        return false;
    });

    var color_options = {
        change: function(event, ui){
            customizer_repeater_refresh_general_control_values();
        }
    };

    /**
     * This adds a new box to repeater
     *
     */
    theme_conrols.on('click', '.customizer-repeater-new-field', function () {
        var th = jQuery(this).parent();
        var id = 'customizer-repeater-' + customizer_repeater_uniqid();
        if (typeof th !== 'undefined') {
        	icon_picker.destroyPicker();
            /* Clone the first box*/
            var field = th.find('.customizer-repeater-general-control-repeater-container:first').clone( true, true );

            if (typeof field !== 'undefined') {
                /*Set the default value for choice between image and icon to icon*/
                field.find('.customizer-repeater-image-choice').val('customizer_repeater_icon');

                /*Show icon selector*/
                field.find('.social-repeater-general-control-icon').show();

                /*Hide image selector*/
                if (field.find('.social-repeater-general-control-icon').length > 0) {
                    field.find('.customizer-repeater-image-control').hide();
                }

                /*Show delete box button because it's not the first box*/
                field.find('.social-repeater-general-control-remove-field').show();

                /*Remove value from icon field*/
                field.find('.mailtpl-icon-select').val('');
              

                /*Remove value from text field*/
                field.find('.customizer-repeater-text-control').val('');

                /*Remove value from link field*/
                field.find('.customizer-repeater-link-control').val('');

                /*Remove value from text field*/
                field.find('.customizer-repeater-text2-control').val('');

                /*Remove value from link field*/
                field.find('.customizer-repeater-link2-control').val('');

                /*Set box id*/
                field.find('.social-repeater-box-id').val(id);

                /*Remove value from media field*/
                field.find('.custom-media-url').val('');

                /*Remove value from title field*/
                field.find('.customizer-repeater-title-control').val('');


                /*Remove value from color field*/
                field.find('div.customizer-repeater-color-control .wp-picker-container').replaceWith('<input type="text" class="customizer-repeater-color-control ' + id + '">');
                field.find('input.customizer-repeater-color-control').wpColorPicker(color_options);


                field.find('div.customizer-repeater-color2-control .wp-picker-container').replaceWith('<input type="text" class="customizer-repeater-color2-control ' + id + '">');
                field.find('input.customizer-repeater-color2-control').wpColorPicker(color_options);

                // field.find('.customize-control-notifications-container').remove();


                /*Remove value from subtitle field*/
                field.find('.customizer-repeater-subtitle-control').val('');

                /*Remove value from shortcode field*/
                field.find('.customizer-repeater-shortcode-control').val('');

                /*Append new box*/
                th.find('.customizer-repeater-general-control-repeater-container:first').parent().append(field);

                /*Refresh values*/
                customizer_repeater_refresh_general_control_values();
            }
            mailtpl_icon_picker_init();
        }
        return false;
    });


    theme_conrols.on('click', '.social-repeater-general-control-remove-field', function () {
        if (typeof    jQuery(this).parent() !== 'undefined') {
            jQuery(this).parent().hide(500, function(){
                jQuery(this).parent().remove();
                customizer_repeater_refresh_general_control_values();

            });
        }
        return false;
    });


    theme_conrols.on('keyup', '.customizer-repeater-title-control', function () {
        customizer_repeater_refresh_general_control_values();
    });

    jQuery('input.customizer-repeater-color-control').wpColorPicker(color_options);
    jQuery('input.customizer-repeater-color2-control').wpColorPicker(color_options);

    theme_conrols.on('keyup', '.customizer-repeater-subtitle-control', function () {
        customizer_repeater_refresh_general_control_values();
    });

    theme_conrols.on('keyup', '.customizer-repeater-shortcode-control', function () {
        customizer_repeater_refresh_general_control_values();
    });

    theme_conrols.on('keyup', '.customizer-repeater-text-control', function () {
        customizer_repeater_refresh_general_control_values();
    });

    theme_conrols.on('keyup', '.customizer-repeater-link-control', function () {
        customizer_repeater_refresh_general_control_values();
    });

    theme_conrols.on('keyup', '.customizer-repeater-text2-control', function () {
        customizer_repeater_refresh_general_control_values();
    });

    theme_conrols.on('keyup', '.customizer-repeater-link2-control', function () {
        customizer_repeater_refresh_general_control_values();
    });

    /*Drag and drop to change icons order*/

    jQuery('.customizer-repeater-general-control-droppable').sortable({
        axis: 'y',
        update: function () {
            customizer_repeater_refresh_general_control_values();
        }
    });

});

var entityMap = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    '\'': '&#39;',
    '/': '&#x2F;'
};

function escapeHtml(string) {
    'use strict';
    //noinspection JSUnresolvedFunction
    string = String(string).replace(new RegExp('\r?\n', 'g'), '<br />');
    string = String(string).replace(/\\/g, '&#92;');
    return String(string).replace(/[&<>"'\/]/g, function (s) {
        return entityMap[s];
    });

}