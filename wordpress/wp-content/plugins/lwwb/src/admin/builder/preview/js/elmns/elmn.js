import HelperFn from './helper.functions';
'use strict';
global.lwwb = global.lwwb || {};
lwwb.Builder = lwwb.Builder || {};
lwwb.Builder.HelperFn = lwwb.Builder.HelperFn || HelperFn;
import ElmnSortable from './behaviors/sortable';
import ElmnResizable from './behaviors/resizable';
import ElmnDraggable from './behaviors/draggable';
import Animation from './behaviors/animation';
lwwb.Builder.Mn = lwwb.Builder.Mn || {};
lwwb.Builder.Mn.Views = lwwb.Builder.Mn.Views || {};
lwwb.Builder.Mn.Behaviors = lwwb.Builder.Mn.Behaviors || {};
lwwb.Builder.Mn.Behaviors['sortable'] = ElmnSortable;
lwwb.Builder.Mn.Behaviors['resizable'] = ElmnResizable;
lwwb.Builder.Mn.Behaviors['draggable'] = ElmnDraggable;
lwwb.Builder.Mn.Behaviors['animation'] = Animation;
lwwb.Builder.Mn['templateSettings'] = {
    evaluate: /<#([\s\S]+?)#>/g,
    interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
    escape: /\{\{([^\}]+?)\}\}(?!\})/g,
};
var _operators = {
    '==': function(a, b) {
        return a == b
    },
    '===': function(a, b) {
        return a === b
    },
    '!==': function(a, b) {
        let o1 = _.isArray(a) || _.isObject(a) ? Object.assign({}, a) : false;
        let o2 = _.isArray(b) || _.isObject(b) ? Object.assign({}, b) : false;
        if (o1 && o2) {
            return !_.isEqual(o1, o2);
        } else {
            return (a !== b);
        }
    },
    '<': function(a, b) {
        return a < b
    },
    '>': function(a, b) {
        return a > b
    },
    '<=': function(a, b) {
        return a <= b
    },
    '>=': function(a, b) {
        return a >= b
    },
    '+': function(a, b) {
        return a + b
    },
    '-': function(a, b) {
        return a - b
    },
    '*': function(a, b) {
        return a * b
    },
    '/': function(a, b) {
        return a / b
    },
    '%': function(a, b) {
        return a % b
    },
    'in': function(a, b) {
        let check = (a.indexOf(b) > -1) ? true : false;
        return check;
    },
};
lwwb.Builder.Mn.Behaviors['elmn'] = Marionette.Behavior.extend({
    triggers: {
        'click @ui.edit': 'edit:elmn',
        'click @ui.clone': 'clone:elmn',
        'click @ui.remove': 'remove:elmn',
        'click @ui.up': 'up:elmn',
        'click @ui.down': 'down:elmn',
        'click @ui.me': 'edit:elmn',
        'click @ui.contentEditable': 'enable:editable',
        'keyup @ui.contentEditable': 'edit:content:editable:elmn',
        'keyup @ui.placeholder': 'add:elmn',
    },
    onEnableEditable() {
        this.view.onEditElmn()
        this.view.getUI('contentEditable').attr('contenteditable', true).focus();
    },
    onRender() {
        const self = this;
        self.view.$el.on('click', function(event) {
            event.preventDefault();
            if ('section' === self.view.model.get('elmn_type')) {
                // lwwb.Radio.channel.trigger('active:elmn:control', self.view.model);
            }
        });
        self.view.triggerMethod('render:style', self);
    },
});
lwwb.Builder.Mn.Views['elmn'] = Marionette.View.extend({
    el() {
        let tmpl = [];
        if ('undefined' !== typeof this.model) {
            let eID = this.model.get('elmn_id'),
                eType = this.model.get('elmn_type'),
                cID = this.model.cid;
            tmpl = ['<div class="lwwb-elmn lwwb-elmn-' + eID + ' lwwb-elmn-' + eType + '" data-model-cid="' + cID + '" data-elmn_type="' + eType + '"></div>', ];
        }
        return tmpl.join('');
    },
    templateContext() {
        var data = this.model.toJSON();
        return {
            data: data,
            view: this
        };
    },
    getTemplate() {
        let eType = this.model.get('elmn_type');
        let elmnTmpl = $(window.parent.document).find('#tmpl-lwwb-elmn-' + eType + '-content');
        let elmnTmplHtml = ((elmnTmpl.length > 0) && (elmnTmpl.html().trim() !== '')) ? elmnTmpl.html() : '';
        const tmpl = [
            elmnTmplHtml,
        ].join('');
        return _.template(tmpl, lwwb.Builder.Mn.templateSettings);
    },
    ui: {
        edit: '.lwwb-elmn-edit',
        add: '.lwwb-elmn-add',
        clone: '.lwwb-elmn-clone',
        remove: '.lwwb-elmn-remove',
        up: '.lwwb-elmn-up',
        down: '.lwwb-elmn-down',
        me: '.lwwb-elmn-content:not(.elmn-is-empty)',
        contentEditable: '.lwwb-content-editable',
        placeholder: '.placeholder',
    },
    behaviors() {
        let behaviorTypes = this._getBehaviors();
        let behaviors = [];
        behaviors = _.map(behaviorTypes, function(behavior, index) {
            if (lwwb.Builder.Mn.Behaviors[behavior]) {
                return lwwb.Builder.Mn.Behaviors[behavior];
            } else {
                return false;
            }
        });
        if (this.options.model) {
            let controlName = this.options.model.get('elmn_type');
            if (controlName) {
                if (lwwb.Builder.Mn.Behaviors[controlName]) {
                    behaviors.push(lwwb.Builder.Mn.Behaviors[controlName])
                }
            }
        }
        behaviors = _.filter(behaviors, function(bh, index) {
            return bh;
        })
        return behaviors;
    },
    _getBehaviors() {
        return ['elmn', 'animation'];
    },
    modelEvents: {
        'change:elmn_data': 'updateElmnData',
    },
    updateElmnData(dataKey, data, childView) {
        this.triggerMethod('update:' + this._dataKeyToEvent(dataKey), childView, dataKey, data);
        this.trigger('update:elmn', this);
        this.triggerMethod('render:style', this);
    },
    _dataKeyToEvent(dataKey){
        if (dataKey[0] == '_') { 
          dataKey = dataKey.substring(1);
        }
        dataKey = dataKey.replace(/-/g, ':');
        dataKey = dataKey.replace(/_/g, ':');
        dataKey = dataKey.replace(/:{1,}/g, ':');
        return dataKey;
    },
    onRenderStyle() {
        const self = this;
        let elmnData = this.model.get('elmn_data');
        let css = '';
        let styleControls = self.styleConfig();
        let elmnID = self.model.get('elmn_id');
        _.each(elmnData, function(val, key) {
            if (styleControls[key] && val) {
                css += self.renderStyle(styleControls[key], val);
            }
        })
        css = css.replace(/ELMN_WRAPPER/g, '.lwwb_page_' + _lwwbData.page.id + ' .lwwb-elmn-' + elmnID);
        let headerStyle = $('#elmn-style-' + elmnID);
        if (headerStyle.length) {
            headerStyle.html(css);
        } else {
            headerStyle = '<style type="text/css" id="elmn-style-' + elmnID + '"> ' + css + '</style>';
            $('head').append(headerStyle);
        }
    },
    renderStyle(control, data) {
        if (this.checkForRenderStyle(control) === false) {
            return '';
        }
        let styleTmpl = this.getStyleTemplate(control, data);
        return styleTmpl({
            data: data
        });
    },
    checkForRenderStyle(control) {
        let dp = control.dependencies;
        if (!dp) {
            return true;
        }
        let checkDp = _.filter(dp, function(d, index) {
            return d.check_for_render_style;
        })
        if (!checkDp) {
            return true;
        }
        let elmnData = this.model.get('elmn_data');
        let shouldRender = true;
        _.each(checkDp, function(dp, index) {
            shouldRender = !_operators[dp.operator](dp['value'], elmnData[dp.control]) ? false : shouldRender;
        })
        return shouldRender;
    },
    getStyleTemplate(control, data) {
        let cssFormat = control.css_format;
        if (cssFormat.indexOf('font-family') !== -1) {
            this.addFont(data);
        }
        if (control.on_device) {
            cssFormat =  this.getResponsiveTemplate(control, data);
        } 
        if ('string' === typeof data) {
            cssFormat = cssFormat.replace(new RegExp('VALUE', 'g'), 'data'), lwwb.Builder.Mn.templateSettings;

        } else {
            let matches = cssFormat.match(/{{(.+?)}}/g);
            if (matches.length > 0 ) {
                _.each(matches, function(match, index) {
                    let dataKey = match.replace('{{', '').replace('}}', '');
                    dataKey = dataKey.trim().toLowerCase();
                    cssFormat = data[dataKey]? cssFormat.replace(match, data[dataKey]): cssFormat.replace(match, '0')
                })
            }
        }

        return _.template(cssFormat, lwwb.Builder.Mn.templateSettings);
    },
    getResponsiveTemplate(control, data) {
        let tabletMaxWidth = _lwwbData.config.responsiveBreakpoints['tablet'];
        let mobileMaxWidth = _lwwbData.config.responsiveBreakpoints['mobile'];
        let device = control.on_device;
        let cssFormat = control.css_format;
        if ('mobile' === device) {
            cssFormat = '@media screen and (max-width: ' + parseInt(mobileMaxWidth - 1) + 'px){ ' + cssFormat + '}';
        } else if ('tablet' === device) {
            cssFormat = '@media screen and (min-width: ' + mobileMaxWidth + 'px) and (max-width: ' + parseInt(tabletMaxWidth - 1) + 'px){ ' + cssFormat + '}';
        } else {
            cssFormat = '@media screen and (min-width: ' + tabletMaxWidth + 'px){ ' + cssFormat + '}';
        }
        return cssFormat;
    },
    
    styleConfig() {
        const self = this;
        let type = this.model.get('elmn_type');
        let elmnConfig = _lwwbData.config.elmns[type];
        if (!elmnConfig) {
            return
        }
        let styleConfig = {};
        _.each(elmnConfig.controls, function(control, index) {
            _.extend(styleConfig, self.getStyleConfig(control));
        })
        return styleConfig;
    },
    getStyleConfig(control) {
        const self = this;
        let scf = {};
        if (control.css_format) {
            _.extend(scf, {
                [control.id]: control
            })
        }
        if (control.fields) {
            _.each(control.fields, function(ctr, index) {
                _.extend(scf, self.getStyleConfig(ctr))
            })
        }
        return scf;
    },
    onEditElmn(view) {
        lwwb.Radio.channel.trigger('active:elmn:control', this.model);
    },
    addFont(font) {
        let fontID = font.trim().replace(" ", "_");
        let existingFontLink = $('#google-fonts-' + fontID);
        if (existingFontLink.length) {
            return;
        }
        if (!_lwwbData.config.googleFonts[font]) {
            return;
        }
        let fontLink = "<link rel='stylesheet' id='google-fonts-" + fontID + "'  href='//fonts.googleapis.com/css?family=" + font + "' type='text/css' media='all' />";
        $('head').append(fontLink);
    },
    onUpdateEntranceAnimation(childView, dataKey, data) {
        let self = this;
        self.removeAnimateClasses();
        if (!self.$el.hasClass('animated')) {
            self.$el.addClass('animated')
        }
        self.$el.addClass(data)
    },
    onUpdateAnimationDuration(childView, dataKey, data) {
        let self = this;
        self.removeAnimateDurationClasses();
        self.$el.addClass(data)
        self.$el.removeClass('animated').addClass('animated');
    },
    removeAnimateClasses() {
        const self = this;
        _.each(_lwwbData.config.animationConfig, function(index, animate) {
            self.$el.removeClass(animate);
        })
    },
    removeAnimateDurationClasses() {
        const self = this;
        let animageDurations = {
            slow: 'slow',
            slower: 'slower',
            fast: 'fast',
            faster: 'faster',
        }
        _.each(animageDurations, function(key, duration) {
            self.$el.removeClass(duration);
        })
    },
    onEditContentEditableElmn(view, event) {
        let content = $(event.currentTarget).html().trim();
        let dataKey = $(event.currentTarget).data('key');
        let data = this.model.get('elmn_data');
        _.extend(data, {
            [dataKey]: content
        })
        this.trigger('update:elmn', this);
        this.model.set('elmn_data', data).trigger('change:elmn_data:contenteditable', dataKey, content);
    },
    onUpdateHideDesktop(childView, dataKey, data) {
        if ('yes' === data) {
            this.$el.addClass('is-hidden-desktop');
        } else {
            this.$el.removeClass('is-hidden-desktop');
        }
    },
    onUpdateHideTablet(childView, dataKey, data) {
        if ('yes' === data) {
            this.$el.addClass('is-hidden-tablet-only');
        } else {
            this.$el.removeClass('is-hidden-tablet-only');
        }
    },
    onUpdateHideMobile(childView, dataKey, data) {
        if ('yes' === data) {
            this.$el.addClass('is-hidden-mobile');
        } else {
            this.$el.removeClass('is-hidden-mobile');
        }
    },
    onUpdateBgOverlayState(childView, dataKey, data) {
        this.render();
    },
});