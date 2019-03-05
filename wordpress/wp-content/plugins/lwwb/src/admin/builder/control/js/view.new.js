var templateSettings = {
    evaluate: /<#([\s\S]+?)#>/g,
    interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
    escape: /\{\{([^\}]+?)\}\}(?!\})/g,
};
var ElmnControlBehavior = Marionette.Behavior.extend({
    onRender() {
        const self = this;
        this.view.$el.find('.customize-control-group').first().show();
        this.view.$el.find('.widget-inside').first().show();
        this.view.$el.find('input#lwwb_search_control').on('keyup search change', function(event) {
            event.preventDefault();
            event.stopPropagation();
            let searchData = $(this).val().trim().toLowerCase();
            if (searchData) {
                let foundControl = self.view.$el.find('.lwwb-control-container[data-keywords*="' + searchData + '"]');
                self.view.$el.find('.lwwb-control-container').not('#customize-control-lwwb-text-lwwb_search_control').hide();
                self.view.$el.find('.customize-control-group').hide();
                foundControl.show();
                foundControl.parents('.customize-control-group').show();
                foundControl.parents('.widget-inside').show();
            } else {
                self.view.$el.find('.lwwb-control-container').show();
                self.view.render();
                self.view.$el.find('input#lwwb_search_control').focus();
            }
        });
    }
})
var ElmnControlView = Marionette.View.extend({
    template: _.template('<div class="lwwb-control-container"></div>', templateSettings),
    regions: {
        listControl: {
            el: '.lwwb-control-container',
            replaceElement: true
        }
    },
    behaviors: [ElmnControlBehavior],
    modelEvents: {
        'change:elmn_data:contenteditable': 'renderEditableContent',
        'change:elmn_data:field': 'updateElmnDataAndOptions'
    },
    childViewTriggers: {
        'list:control:update:data': 'child:list:control:update:data'
    },
    initialize() {
        let elmnType = this.model.get('elmn_type');
        let elmnData = this.model.get('elmn_data');
        if (!_lwwbConfig.elmns[elmnType]) {
            return;
        }
        let elmnControls = JSON.parse(JSON.stringify(_lwwbConfig.elmns[elmnType].controls));
        let controlArr = _.map(elmnControls, function(ctr) {
            if ('lwwb-group' === ctr.type || 'lwwb-repeater' === ctr.type) {
                _.map(ctr.fields, function(field) {
                    let controlData;
                    _.each(elmnData, function(data, key) {
                        if (key === field.id) {
                            controlData = {
                                [key]: data
                            };
                        }
                    });
                    if (controlData) {
                        field['value'] = controlData[field.id];
                    } else {
                        field['value'] = field['default'];
                    }

                    if (field['fields']) {
                        _.each(field['value'], function(value, id) {
                            let f = _.find(field['fields'], function(f, k) {
                                return f.id === id;
                            })
                            if (f) {
                                f['value'] = value;
                            }
                        })
                    }

                    return field;
                })
            }
            let controlData;
            _.each(elmnData, function(data, key) {
                if (key === ctr.id) {
                    controlData = {
                        [key]: data
                    };
                }
            });
            if (controlData) {
                ctr['value'] = controlData[ctr.id];
            } else {
                ctr['value'] = ctr['default'];
            }
            return ctr;
        });
        this.collection = new Backbone.Collection(controlArr);
    },
    renderEditableContent(dataKey, content) {
        _.each(this.getRegion('listControl').currentView.children._views, function(view) {
            if (view.getRegion('controlRegion')) {
                let found = _.find(view.getRegion('controlRegion').currentView.children._views, function(view) {
                    return view.model.get('id') === dataKey;
                })
                if (found) {
                    found.model.set('value', content);
                    found.render();
                    
                }
            }
        })
    },
    updateElmnDataAndOptions(dataKey, data, options) {
        _.each(this.getRegion('listControl').currentView.children._views, function(view) {
            if (view.getRegion('controlRegion')) {
                let found = _.find(view.getRegion('controlRegion').currentView.children._views, function(view) {
                    return view.model.get('id') === dataKey;
                })
                if (found) {

                    found.model.set('value', data).trigger('change:value');
                    if (options) {
                        _.each(options, function(option, key) {
                            found.triggerMethod('update:option:'+key.replace(/-/g, ':').replace(/_/g, ':'), option)
                        })
                    }
                    if (options && options.input_attrs) {
                        found.model.set('input_attrs', options.input_attrs);
                    }
                    if (options && options.unit) {
                        found.model.set('unit', options.unit);
                    }
                    found.render();
                }
            }
        })
    },
    onRender() {
        let listControlView = new lwwb.Control.Mn.Views['control-collection']({
            collection: this.collection,
        });
        this.showChildView('listControl', listControlView);
    },
    onChildListControlUpdateData(childView, data) {
        let dataKey = childView.model.get('id');
        let elmnData = this.model.get('elmn_data');
        this.model.set('elmn_data', _.extend(elmnData, {[dataKey]:data}));
        this.model.trigger('change:elmn_data',dataKey, data, childView);
       
    },
   
});
var BuilderControlView = Marionette.View.extend({
    initialize(options) {
        this.radioChannel = options.radioChannel;
        this.cacheElmn = [];
    },
    template: _.template('<div class="lwwb-control-container"></div>', templateSettings),
    regions: {
        elmnRegion: {
            el: '.lwwb-control-container',
            replaceElement: true
        },
    },
    onRender() {
        const self = this;
        this.listenTo(this.radioChannel, 'active:elmn:control', function(elmnModel) {
            self.activeApiControl();
            self.showElmnView(elmnModel);
        });
    },
    activeApiControl() {
        if (!wp.customize.section('lwwb_section').expanded()) {
            wp.customize.section('lwwb_section').expanded(true);
        }
        if (!wp.customize.control('lwwb_build_panel').active()) {
            wp.customize.control('lwwb_build_panel').active(true);

        }
        wp.customize.control('setting_switcher').container.find('input[value="elmn"]').trigger('click');
    },
    showElmnView(elmnModel) {
        const self = this;
        if (!self.maybeShowCache(elmnModel)) {
            let elmnControlView = new ElmnControlView({
                model: elmnModel
            });
            self.getRegion('elmnRegion').detachView();
            self.showChildView('elmnRegion', elmnControlView);
            self.cacheElmn.push({
                mcid: elmnModel.cid,
                elmn: elmnModel,
                view: elmnControlView
            });
        }
    },
    maybeShowCache(elmnModel) {
        const self = this;
        let cacheView = _.find(self.cacheElmn, function(cv) {
            return (cv.mcid === elmnModel.cid);
        });
        if (cacheView) {

            let elmnRegion = self.getRegion('elmnRegion');

            if (elmnRegion.currentView) {
                if (elmnRegion.currentView.model.cid === cacheView.mcid) {
                    return true;
                }
            }
            
            if (cacheView.view.$el.find('.lwwb-control-lwwb-wysiwyg').length) {
                return false;
            }
            self.getRegion('elmnRegion').detachView();
            self.showChildView('elmnRegion', cacheView.view);
            return true;
        } else {
            return false;
        }
    },
});
module.exports = BuilderControlView;