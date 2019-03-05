(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";

var _view = require("./view.new");

var _view2 = _interopRequireDefault(_view);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

(function (api) {
  var previewerIframe = void 0,
      builderControls = void 0;
  api.bind('ready', function () {
    api.previewer.bind('ready', function (previewData) {
      api.previewer.send('lwwb_config', _lwwbConfig);
      previewerIframe = $('#customize-preview iframe').get($('#customize-preview iframe').length - 1).contentWindow;
      api.section('lwwb_section').expand(true);
      var builderView = new _view2.default({
        el: '#lwwb-control-container',
        radioChannel: previewerIframe.lwwb.Radio.channel
      });
      builderView.render();
    });
    builderControls = {
      current_page: [],
      elmn_picker: [],
      elmn: [],
      global_setting: []
    };
    api.previewer.bind('preview_data', function (previewData) {
      setupBuilder(previewData);
      setupCurrentPageControl(previewData);
      setupElmnPickerControl(previewData);
    });
    setupActiveControl();
    api.previewer.bind('active_group_control', function (groupControl) {
      api.control('setting_switcher').container.find('.lwwb-input[value="' + groupControl + '"]').trigger('click');
    });
  });

  var setupActiveControl = function setupActiveControl() {
    api.control('setting_switcher').container.on('click', '.lwwb-input', function (event) {
      var groupControl = $(event.currentTarget).val();
      activeGroupControls(groupControl);
    });
  };

  var activeGroupControls = function activeGroupControls(groupControl) {
    var unActiveControls = _.clone(builderControls);

    delete unActiveControls[groupControl];

    _.each(unActiveControls, function (controls, group) {
      deactiveGroupControls(controls);
    });

    _.each(builderControls[groupControl], function (control, index) {
      if (control.active()) {
        return;
      }

      control.active(true);
    });
  };

  var deactiveGroupControls = function deactiveGroupControls(groupControls) {
    _.each(groupControls, function (control) {
      control.active(false);
    });
  };

  var setupBuilder = function setupBuilder(previewData) {
    var Setting = api.Setting.extend({});
    var settingID = 'lwwb_data[' + previewData.page.id + '][data]';

    var _setting = api(settingID);

    if (!_setting) {
      var data = void 0;
      _setting = new Setting(settingID, data, {
        transport: 'postMessage',
        previewer: api.previewer,
        dirty: true
      });
      api.add(settingID, _setting);
    }

    var elmnBuilderControl = api.control('lwwb_build_panel');

    if (elmnBuilderControl && !builderControls.elmn.length) {
      builderControls.elmn.push(elmnBuilderControl);
    }

    api.previewer.bind('collection_data' + previewData.page.id, function (dataBuilder) {
      var _configData = {
        header: previewData.header.id,
        footer: previewData.footer.id,
        content: dataBuilder
      };

      _setting.set(JSON.stringify(_configData));
    });
  };

  var setupCurrentPageControl = function setupCurrentPageControl(previewData) {
    var Setting = api.Setting.extend({});
    var headerSettingID = 'lwwb_data[' + previewData.page.id + '][header]';
    var footerSettingID = 'lwwb_data[' + previewData.page.id + '][footer]';
    var hooksID = 'lwwb_data[' + previewData.page.id + '][hooks]';
    var headerSetting = api(headerSettingID);
    var footerSetting = api(footerSettingID);
    var hooksSetting = api(hooksID); // Header Settings

    if (!headerSetting) {
      headerSetting = new Setting(headerSettingID, previewData.header.id, {
        transport: 'refresh',
        default: '',
        previewer: wp.customize.previewer
      });
      api.add(headerSettingID, headerSetting);
    } else {}

    if (!api.control(headerSettingID)) {
      var control = new api.Control(headerSettingID, {
        section: 'lwwb_section',
        label: 'Header Config',
        type: 'select',
        setting: headerSettingID,
        priority: 12,
        // choices: pageHeaderId
        choices: _lwwb_tmplCustomize.header,
        active: false
      });
      api.control.add(control);

      if (_.indexOf(builderControls.current_page, control) == -1) {
        builderControls.current_page.push(control);
      }
    } else {
      if (isActiveCurrentPageControl()) {
        api.control(headerSettingID).active(true);
      }
    } // Footer Settings


    if (!footerSetting) {
      footerSetting = new Setting(footerSettingID, previewData.footer.id, {
        transport: 'refresh',
        default: '',
        previewer: api.previewer
      });
      api.add(footerSettingID, footerSetting);
    } else {}

    if (!api.control(footerSettingID)) {
      var control = new api.Control(footerSettingID, {
        section: 'lwwb_section',
        label: 'Footer Config',
        type: 'select',
        setting: footerSettingID,
        priority: 12,
        choices: _lwwb_tmplCustomize.footer,
        active: false
      });
      api.control.add(control);

      if (_.indexOf(builderControls.current_page, control) == -1) {
        builderControls.current_page.push(control);
      }
    } else {
      if (isActiveCurrentPageControl()) {
        api.control(footerSettingID).active(true);
      }
    } // Builder Hooks


    if (!hooksSetting) {
      hooksSetting = new Setting(hooksID, previewData.hooks, {
        transport: 'refresh',
        default: previewData.hooks,
        multi: true,
        previewer: api.previewer
      });
      api.add(hooksID, hooksSetting);
    } else {}

    if (!api.control(hooksID)) {
      var controlHooks = new api.controlConstructor['lwwb-checkbox'](hooksID, {
        section: 'lwwb_section',
        label: 'Hide Hooks Builder',
        type: 'lwwb-checkbox',
        settings: {
          'default': hooksID
        },
        value: previewData.hooks,
        priority: 12,
        choices: _lwwb_tmplCustomize.hooks,
        active: false
      });
      api.control.add(controlHooks);

      if (_.indexOf(builderControls.current_page, controlHooks) == -1) {
        builderControls.current_page.push(controlHooks);
      }
    } else {
      if (isActiveCurrentPageControl()) {
        api.control(hooksID).active(true);
      }
    }
  };

  var isActiveCurrentPageControl = function isActiveCurrentPageControl() {
    var currentPageCheck = api.control('setting_switcher').container.find('.lwwb-input[value="current_page"]');
    return currentPageCheck.prop("checked");
  };

  var setupElmnPickerControl = function setupElmnPickerControl(previewData) {
    if (isActiveCurrentPageControl()) {
      deactiveGroupControls(builderControls.elmn_picker);
      return;
    }

    if (builderControls.elmn_picker.length) {
      return;
    }

    _.each(previewData.config.elmnGroups, function (val, key) {
      if (api.control(key)) {
        builderControls.elmn_picker.push(api.control(key));
      }

      ;
    });
  };
})(wp.customize);

},{"./view.new":2}],2:[function(require,module,exports){
"use strict";

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

var templateSettings = {
  evaluate: /<#([\s\S]+?)#>/g,
  interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
  escape: /\{\{([^\}]+?)\}\}(?!\})/g
};
var ElmnControlBehavior = Marionette.Behavior.extend({
  onRender: function onRender() {
    var self = this;
    this.view.$el.find('.customize-control-group').first().show();
    this.view.$el.find('.widget-inside').first().show();
    this.view.$el.find('input#lwwb_search_control').on('keyup search change', function (event) {
      event.preventDefault();
      event.stopPropagation();
      var searchData = $(this).val().trim().toLowerCase();

      if (searchData) {
        var foundControl = self.view.$el.find('.lwwb-control-container[data-keywords*="' + searchData + '"]');
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
});
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
  initialize: function initialize() {
    var elmnType = this.model.get('elmn_type');
    var elmnData = this.model.get('elmn_data');

    if (!_lwwbConfig.elmns[elmnType]) {
      return;
    }

    var elmnControls = JSON.parse(JSON.stringify(_lwwbConfig.elmns[elmnType].controls));

    var controlArr = _.map(elmnControls, function (ctr) {
      if ('lwwb-group' === ctr.type || 'lwwb-repeater' === ctr.type) {
        _.map(ctr.fields, function (field) {
          var controlData = void 0;

          _.each(elmnData, function (data, key) {
            if (key === field.id) {
              controlData = _defineProperty({}, key, data);
            }
          });

          if (controlData) {
            field['value'] = controlData[field.id];
          } else {
            field['value'] = field['default'];
          }

          if (field['fields']) {
            _.each(field['value'], function (value, id) {
              var f = _.find(field['fields'], function (f, k) {
                return f.id === id;
              });

              if (f) {
                f['value'] = value;
              }
            });
          }

          return field;
        });
      }

      var controlData = void 0;

      _.each(elmnData, function (data, key) {
        if (key === ctr.id) {
          controlData = _defineProperty({}, key, data);
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
  renderEditableContent: function renderEditableContent(dataKey, content) {
    _.each(this.getRegion('listControl').currentView.children._views, function (view) {
      if (view.getRegion('controlRegion')) {
        var found = _.find(view.getRegion('controlRegion').currentView.children._views, function (view) {
          return view.model.get('id') === dataKey;
        });

        if (found) {
          found.model.set('value', content);
          found.render();
        }
      }
    });
  },
  updateElmnDataAndOptions: function updateElmnDataAndOptions(dataKey, data, options) {
    _.each(this.getRegion('listControl').currentView.children._views, function (view) {
      if (view.getRegion('controlRegion')) {
        var found = _.find(view.getRegion('controlRegion').currentView.children._views, function (view) {
          return view.model.get('id') === dataKey;
        });

        if (found) {
          found.model.set('value', data).trigger('change:value');

          if (options) {
            _.each(options, function (option, key) {
              found.triggerMethod('update:option:' + key.replace(/-/g, ':').replace(/_/g, ':'), option);
            });
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
    });
  },
  onRender: function onRender() {
    var listControlView = new lwwb.Control.Mn.Views['control-collection']({
      collection: this.collection
    });
    this.showChildView('listControl', listControlView);
  },
  onChildListControlUpdateData: function onChildListControlUpdateData(childView, data) {
    var dataKey = childView.model.get('id');
    var elmnData = this.model.get('elmn_data');
    this.model.set('elmn_data', _.extend(elmnData, _defineProperty({}, dataKey, data)));
    this.model.trigger('change:elmn_data', dataKey, data, childView);
  }
});
var BuilderControlView = Marionette.View.extend({
  initialize: function initialize(options) {
    this.radioChannel = options.radioChannel;
    this.cacheElmn = [];
  },
  template: _.template('<div class="lwwb-control-container"></div>', templateSettings),
  regions: {
    elmnRegion: {
      el: '.lwwb-control-container',
      replaceElement: true
    }
  },
  onRender: function onRender() {
    var self = this;
    this.listenTo(this.radioChannel, 'active:elmn:control', function (elmnModel) {
      self.activeApiControl();
      self.showElmnView(elmnModel);
    });
  },
  activeApiControl: function activeApiControl() {
    if (!wp.customize.section('lwwb_section').expanded()) {
      wp.customize.section('lwwb_section').expanded(true);
    }

    if (!wp.customize.control('lwwb_build_panel').active()) {
      wp.customize.control('lwwb_build_panel').active(true);
    }

    wp.customize.control('setting_switcher').container.find('input[value="elmn"]').trigger('click');
  },
  showElmnView: function showElmnView(elmnModel) {
    var self = this;

    if (!self.maybeShowCache(elmnModel)) {
      var elmnControlView = new ElmnControlView({
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
  maybeShowCache: function maybeShowCache(elmnModel) {
    var self = this;

    var cacheView = _.find(self.cacheElmn, function (cv) {
      return cv.mcid === elmnModel.cid;
    });

    if (cacheView) {
      var elmnRegion = self.getRegion('elmnRegion');

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
  }
});
module.exports = BuilderControlView;

},{}]},{},[1]);
