(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";

wp.customize.controlConstructor['lwwb-checkbox'] = wp.customize.Control.extend({
  ready: function ready() {
    'use strict';

    var control = this;
    var value = control.setting.get();

    if ('string' === typeof value) {
      value = [value];
    }

    var hidden_input = control.container.find('.checkbox-hidden-value');
    control.container.on('change click', 'input.lwwb-input', function (event) {
      var val = $(this).val(),
          exits = value.indexOf(val);

      if ($(this).is(':checked')) {
        if (-1 >= exits) {
          value.push(val);
        }
      } else {
        if (-1 < exits) {
          value.splice(exits, 1);
        }
      }

      hidden_input.val(JSON.stringify(value)).trigger('change');

      if (control.setting.multi) {
        control.setting.set(JSON.stringify(value));
      } else {
        control.setting.set(value);
      }
    });
  }
});

},{}],2:[function(require,module,exports){
"use strict";

wp.customize.controlConstructor['lwwb-code-editor'] = wp.customize.Control.extend({
  ready: function ready() {
    'use strict';

    var control = this;
    lwwb.Control.Wp['code-editor'].init(control.container);
  }
});

},{}],3:[function(require,module,exports){
"use strict";

wp.customize.controlConstructor['lwwb-color-picker'] = wp.customize.Control.extend({
  ready: function ready() {
    'use strict';

    var control = this;
    lwwb.Control.Wp['color-picker'].init(control.container);
  }
});

},{}],4:[function(require,module,exports){
"use strict";

require("./wp.control/responsive-switcher");

require("./wp.control/alpha-color");

require("./wp.control/code-editor");

require("./wp.control/dimensions");

require("./wp.control/date-picker");

require("./wp.control/icon-picker");

require("./wp.control/image-upload");

require("./wp.control/modal");

require("./wp.control/select2");

require("./wp.control/slider");

require("./wp.control/wysiwyg");

},{"./wp.control/alpha-color":24,"./wp.control/code-editor":25,"./wp.control/date-picker":26,"./wp.control/dimensions":27,"./wp.control/icon-picker":28,"./wp.control/image-upload":29,"./wp.control/modal":30,"./wp.control/responsive-switcher":31,"./wp.control/select2":32,"./wp.control/slider":33,"./wp.control/wysiwyg":34}],5:[function(require,module,exports){
"use strict";

require("./mn.control/base");

require("./mn.control/group");

require("./mn.control/modal");

require("./mn.control/repeater-item");

require("./mn.control/repeater");

require("./mn.control/repeater-collection");

require("./mn.control/control-collection");

require("./mn.control/dimensions");

require("./mn.control/media-upload");

},{"./mn.control/base":14,"./mn.control/control-collection":15,"./mn.control/dimensions":16,"./mn.control/group":17,"./mn.control/media-upload":18,"./mn.control/modal":19,"./mn.control/repeater":22,"./mn.control/repeater-collection":20,"./mn.control/repeater-item":21}],6:[function(require,module,exports){
"use strict";

require("./control-libs");

require("./control.mn");

require("./general");

require("./dependencies");

require("./draggable-icon");

require("./code");

require("./color");

require("./dimensions");

require("./checkbox");

require("./icon-picker");

require("./image");

require("./wysiwyg");

require("./slider");

require("./group");

},{"./checkbox":1,"./code":2,"./color":3,"./control-libs":4,"./control.mn":5,"./dependencies":7,"./dimensions":8,"./draggable-icon":9,"./general":10,"./group":11,"./icon-picker":12,"./image":13,"./slider":23,"./wysiwyg":35}],7:[function(require,module,exports){
"use strict";

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

(function (api) {
  api.bind('ready', function () {
    api.previewer.bind('ready', function () {
      var _operators;

      var operators = (_operators = {
        '==': function _(a, b) {
          return a == b;
        },
        '===': function _(a, b) {
          return a === b;
        },
        '!==': function _(a, b) {
          return a !== b;
        },
        '<': function _(a, b) {
          return a < b;
        },
        '>': function _(a, b) {
          return a > b;
        },
        '<=': function _(a, b) {
          return a <= b;
        }
      }, _defineProperty(_operators, "<=", function _(a, b) {
        return a <= b;
      }), _defineProperty(_operators, '>=', function _(a, b) {
        return a >= b;
      }), _defineProperty(_operators, '+', function _(a, b) {
        return a + b;
      }), _defineProperty(_operators, '-', function _(a, b) {
        return a - b;
      }), _defineProperty(_operators, '*', function _(a, b) {
        return a * b;
      }), _defineProperty(_operators, '/', function _(a, b) {
        return a / b;
      }), _defineProperty(_operators, '%', function _(a, b) {
        return a % b;
      }), _operators);
      api.control.each(function (control) {
        if (control.params.dependencies) {
          var is_active = check_active(control.params.dependencies, control);
          control.active.set(is_active);

          _.each(control.params.dependencies, function (dependency, index) {
            api.control(dependency.control).container.on('change', 'input, select, textarea', function (event) {
              event.preventDefault();
              var depend_value = $(this).val();
              var is_active = operators[dependency.operator](depend_value, dependency.value) ? true : false;

              var other_control_dependencies = _.filter(control.params.dependencies, function (d) {
                return d.control !== dependency.control;
              });

              is_active = is_active && check_active(other_control_dependencies, control);
              control.active(is_active);
            });
          });
        }

        function check_active(dependencies, dependency) {
          var is_active = true;
          var check_active = true;

          _.each(dependencies, function (dependency, index) {
            check_active = operators[dependency.operator](api.control(dependency.control).setting.get(), dependency.value) ? true : false;
            is_active = is_active && check_active;
          });

          return is_active;
        }
      });
    });
  });
})(wp.customize);

},{}],8:[function(require,module,exports){
"use strict";

wp.customize.controlConstructor['lwwb-dimensions'] = wp.customize.Control.extend({
  ready: function ready() {
    'use strict';

    var control = this;
    lwwb.Control.Wp['dimensions'].init(control.container);
    control.container.on('change', 'input.lwwb-input', function (event) {
      var data_key = $(this).data('key');
      var val = $(this).val();

      if (data_key) {
        control.setValue(data_key, val);
      }
    });
  },
  setValue: function setValue(property, value) {
    var control = this,
        hidden_input = control.container.find('.dimension-hidden-value'),
        val = control.setting.get();
    val[property] = value;
    hidden_input.val(JSON.stringify(val)).trigger('change');
    control.setting.set(val);
  }
});

},{}],9:[function(require,module,exports){
"use strict";

jQuery(document).ready(function ($) {
  $('.lwwb-control-lwwb-draggable-icon > ul > li').bind('dragstart', function (event) {
    var data = $(this).data('icon');
    event.originalEvent.dataTransfer.setData('text/plain', data);
  });
});

},{}],10:[function(require,module,exports){
"use strict";

jQuery(document).ready(function ($) {
  // lwwb.Control['icon-picker'].init();
  // lwwb.Control['image'].init();
  // lwwb.Control['dimensions'].init();
  // lwwb.Control['responsive-switcher'].init();
  // lwwb.Control['color-picker'].init();
  // lwwb.Control['date-picker'].init();
  // lwwb.Control['select2'].init();
  // lwwb.Control['slider'].init();
  // lwwb.Control['wysiwyg'].init();
  lwwb.Control.Wp['responsive-switcher'].init();
});

(function (api, $) {
  api.bind('ready', function () {
    api.control('setting_switcher', function (control) {
      $(control.selector).on('click', 'input.lwwb-input', function (event) {
        var currentControl = void 0,
            otherControl = void 0;
        currentControl = $(this).val();

        _.map(control.params.choices, function (value, key) {
          if (api.control(key) && key !== currentControl) {
            api.control(key).active(false);
          }
        });

        if (api.control(currentControl)) {
          api.control(currentControl).active(true);
        }
      });
    });
  });
})(wp.customize, jQuery);

},{}],11:[function(require,module,exports){
"use strict";

wp.customize.controlConstructor['lwwb-group'] = wp.customize.Control.extend({
  ready: function ready() {
    var control = this;
    control.groupBehavior();
    control.initGroup();
  },
  initGroup: function initGroup() {
    var control = this,
        dataSetting = control.setting.get(),
        fields = control.params.fields;
    fields = _.map(fields, function (field) {
      var fieldData = _.find(dataSetting, function (dt, key) {
        if (key === field.id) {
          return dt;
        }
      });

      if (fieldData) {
        field['value'] = fieldData;
      }

      return field;
    });
    var dataCollection = new Backbone.Collection(fields);
    var fieldsElmn = '#lwwb-control-' + control.id + ' .widget-content';
    var groupView = new lwwb.Control.Mn.Views['control-collection']({
      collection: dataCollection,
      el: fieldsElmn
    });
    groupView.render();
    groupView.on('list:control:update:data', function (childView, data) {
      var _data = control.setting.get();

      _.extend(_data, data);

      control.setting.set(_data)._dirty = true;
      wp.customize.state('saved').set(false);
    });
  },
  groupBehavior: function groupBehavior() {
    var control = this;
    control.container.find('#lwwb-control-' + control.id + ' > .widget-inside').show();
    control.container.on('click', '#lwwb-control-' + control.id + ' > .widget-top', function (event) {
      event.preventDefault();
      $(this).next('.widget-inside').slideToggle('fast');
    });
  }
});

},{}],12:[function(require,module,exports){
"use strict";

wp.customize.controlConstructor['lwwb-icon-picker'] = wp.customize.Control.extend({
  ready: function ready() {
    'use strict';

    var control = this;
    lwwb.Control.Wp['icon-picker'].init(control.container);
  }
});

},{}],13:[function(require,module,exports){
"use strict";

wp.customize.controlConstructor['lwwb-image'] = wp.customize.Control.extend({
  ready: function ready() {
    'use strict';

    var control = this;
    lwwb.Control.Wp['image'].init(control.container);
    control.container.on('change', 'input[data-key="url"], input[data-key="id"]', function (event) {
      event.preventDefault();
      var data_key = $(this).data('key');
      var val = $(this).val();

      if (data_key) {
        control.setValue(data_key, val);
      }
    });
  },
  setValue: function setValue(property, value) {
    var control = this,
        hidden_input = control.container.find('.image-hidden-value'),
        val = control.setting.get();
    val[property] = value;
    hidden_input.val(JSON.stringify(val)).trigger('change');
    control.setting.set(val);
  }
});

},{}],14:[function(require,module,exports){
(function (global){
"use strict";

var _operators2;

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

global.lwwb = global.lwwb || {};
lwwb.Control = lwwb.Control || {};
lwwb.Control.Mn || {};
lwwb.Control.Mn = lwwb.Control.Mn || {};
lwwb.Control.Mn.Views = lwwb.Control.Mn.Views || {};
lwwb.Control.Mn.Behaviors = lwwb.Control.Mn.Behaviors || {};
lwwb.Control.Mn['templateSettings'] = {
  evaluate: /<#([\s\S]+?)#>/g,
  interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
  escape: /\{\{([^\}]+?)\}\}(?!\})/g
};

var _operators = (_operators2 = {
  '==': function _(a, b) {
    return a == b;
  },
  '===': function _(a, b) {
    return a === b;
  },
  '!==': function (_2) {
    function _(_x, _x2) {
      return _2.apply(this, arguments);
    }

    _.toString = function () {
      return _2.toString();
    };

    return _;
  }(function (a, b) {
    var o1 = _.isArray(a) || _.isObject(a) ? Object.assign({}, a) : false;
    var o2 = _.isArray(b) || _.isObject(b) ? Object.assign({}, b) : false;

    if (o1 && o2) {
      return !_.isEqual(o1, o2);
    } else {
      return a !== b;
    }
  }),
  '<': function _(a, b) {
    return a < b;
  },
  '>': function _(a, b) {
    return a > b;
  },
  '<=': function _(a, b) {
    return a <= b;
  }
}, _defineProperty(_operators2, "<=", function _(a, b) {
  return a <= b;
}), _defineProperty(_operators2, '>=', function _(a, b) {
  return a >= b;
}), _defineProperty(_operators2, '+', function _(a, b) {
  return a + b;
}), _defineProperty(_operators2, '-', function _(a, b) {
  return a - b;
}), _defineProperty(_operators2, '*', function _(a, b) {
  return a * b;
}), _defineProperty(_operators2, '/', function _(a, b) {
  return a / b;
}), _defineProperty(_operators2, '%', function _(a, b) {
  return a % b;
}), _defineProperty(_operators2, 'in', function _in(a, b) {
  var check = a.indexOf(b) > -1 ? true : false;
  return check;
}), _operators2);

lwwb.Control.Mn.Behaviors['base'] = Marionette.Behavior.extend({
  triggers: {
    'change @ui.input': 'update:input:data',
    'change @ui.select': 'update:input:data',
    'change @ui.textarea': 'update:input:data',
    'keyup @ui.input': 'update:input:data',
    'keyup @ui.select': 'update:input:data',
    'keyup @ui.textarea': 'update:input:data'
  },
  onRender: function onRender() {
    var self = this;

    if (self.view.model.get('type')) {
      var controlBehavior = self.view.model.get('type').replace('lwwb-', '');

      if ('undefined' !== typeof lwwb.Control.Wp[controlBehavior]) {
        lwwb.Control.Wp[controlBehavior].init(self.view.$el);
      }
    }
  }
});
lwwb.Control.Mn.Behaviors['reset'] = Marionette.Behavior.extend({
  triggers: {
    'click @ui.reset': 'reset:control'
  },
  onResetControl: function onResetControl() {
    var self = this;
    var defaultValue = self.view.model.get('default');

    var _value = self.view.model.get('value');

    if (_operators['!=='](_value, defaultValue)) {
      self.view.model.set('value', defaultValue);
      self.view.trigger('update:data', self.view, defaultValue);
      self.view.render();
    }
  }
});
lwwb.Control.Mn.Views['base'] = Marionette.View.extend({
  ui: {
    input: 'input.lwwb-input',
    textarea: 'textarea.lwwb-input',
    hiddenInput: 'input[class*="-hidden-value"]',
    select: 'select.lwwb-select',
    reset: '.lwwb-reset-control'
  },
  el: function el() {
    var activeDevice = $('.wp-full-overlay-footer .devices .active').data('device');
    var classes = ['customize-control', 'lwwb-control-container', 'lwwb-control-inner-' + this.model.get('type'), this.model.get('type'), this.model.has('control_layout') ? this.model.get('control_layout') : '', this.model.has('on_device') && this.model.get('on_device') === activeDevice ? 'active' : ''];
    var keywords = this.model.has('keywords') ? 'data-keywords="' + this.model.get('keywords') + '"' : '';
    var onDevice = this.model.has('on_device') ? 'data-on_device="' + this.model.get('on_device') + '"' : '';
    return $('<li id="customize-control-' + this.model.get('type') + '-' + this.model.get('id') + '" ' + onDevice + keywords + ' class="' + classes.join(' ') + '"></li>');
  },
  getTemplate: function getTemplate() {
    var fieldType = this.model.get('type');
    var fieldTmpl = $('#tmpl-customize-control-' + fieldType + '-content');

    if (fieldTmpl.length) {
      return _.template(fieldTmpl.html(), lwwb.Control.Mn['templateSettings']);
    } else {
      return _.template(fieldType + ' template does not exists!');
    }
  },
  templateContext: function templateContext() {
    var data = this.model.toJSON();
    return {
      data: data,
      view: this
    };
  },
  behaviors: function behaviors() {
    var behaviorTypes = ['base', 'reset'];
    var behaviors = [];
    behaviors = _.map(behaviorTypes, function (behavior, index) {
      if (lwwb.Control.Mn.Behaviors[behavior]) {
        return lwwb.Control.Mn.Behaviors[behavior];
      }
    });

    if (this.options.model) {
      var controlType = this.options.model.get('type');

      if (controlType) {
        var controlName = controlType.replace('lwwb-', '');

        if (lwwb.Control.Mn.Behaviors[controlName]) {
          behaviors.push(lwwb.Control.Mn.Behaviors[controlName]);
        }
      }
    } else {
      console.log(this);
    }

    return behaviors;
  },
  onUpdateInputData: function onUpdateInputData(view, event) {
    var fieldTarget = $(event.currentTarget);
    var fieldData = this.model.get('value');

    if ('undefined' === typeof fieldData) {
      fieldData = '';
    }

    if (this.getUI('hiddenInput').length) {
      fieldData[fieldTarget.data('key')] = fieldTarget.val();
    } else {
      if ('checkbox' === fieldTarget.attr('type')) {
        fieldData = fieldTarget.prop('checked') ? 'yes' : 'no';
      } else {
        if (_.isObject(fieldData)) {
          // fieldData = fieldData || {};
          if (fieldData[fieldTarget.data('key')]) {
            fieldData[fieldTarget.data('key')] = fieldTarget.val();
          } else {
            _.extend(fieldData, _defineProperty({}, fieldTarget.data('key'), fieldTarget.val()));

            fieldData[fieldTarget.data('key')] = fieldTarget.val();
          }
        } else {
          fieldData = fieldTarget.val();
        }
      }
    }

    this.model.set('value', fieldData).trigger('change:value');
    this.triggerUpdateData();
  },
  triggerUpdateData: function triggerUpdateData() {
    if (this.model.get('save_on_change') === 'off' || 'lwwb-group' === this.model.get('type')) {
      return;
    }

    this.trigger('update:data', this, this.model.get('value'));
  },
  onRender: function onRender() {
    var self = this;

    if (this.model.has('dependencies')) {
      if (self.isDepend()) {
        self.$el.css('display', '');
      } else {
        self.$el.css('display', 'none');
      }

      self.checkDepend();
    }
  },
  checkDepend: function checkDepend() {
    var self = this;

    _.each(self.getDependModel(), function (md) {
      md.on('change:value', function (model) {
        if (self.isDepend()) {
          self.$el.css('display', '');
        } else {
          self.$el.css('display', 'none');
        }
      });
    });
  },
  isDepend: function isDepend() {
    var self = this;
    var show = true;
    var depends = self.model.get('dependencies');

    _.each(self.getDependModel(), function (md, key) {
      show = _operators[depends[key].operator](depends[key].value, md.get('value')) ? show : false;
    });

    return show;
  },
  getDependModel: function getDependModel() {
    var self = this;
    var depends = self.model.get('dependencies');

    var depenControlIDs = _.map(depends, function (d) {
      return d.control;
    });

    return _.filter(this.model.collection.models, function (md) {
      return $.inArray(md.get('id'), depenControlIDs) > -1;
    });
  }
});

}).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
},{}],15:[function(require,module,exports){
"use strict";

lwwb.Control.Mn.Views['control-collection'] = Marionette.CollectionView.extend({
  el: '<ul class="lwwb-list-controls"></ul>',
  childView: function childView(field) {
    var fieldType = field.get('type');
    var controlName = void 0;

    if (fieldType) {
      controlName = fieldType.replace('lwwb-', '');
    }

    if ('undefined' !== typeof lwwb.Control.Mn.Views[controlName]) {
      return lwwb.Control.Mn.Views[controlName];
    } else {
      return lwwb.Control.Mn.Views['base'];
    }
  },
  childViewTriggers: {
    'update:data': 'child:update:data',
    'group:update:data': 'child:group:update:data',
    'repeat:update:data': 'child:repeat:update:data',
    'repeat:add:new:item': 'child:repeat:add:new:item'
  },
  onChildGroupUpdateData: function onChildGroupUpdateData(childView, data) {
    this.trigger('list:control:update:data', childView, data);
  },
  onChildRepeatAddNewItem: function onChildRepeatAddNewItem(childView, data) {
    this.trigger('list:control:update:data', childView, data);
  },
  onChildRepeatUpdateData: function onChildRepeatUpdateData(childView, data) {
    this.trigger('list:control:update:data', childView, data);
  },
  onChildUpdateData: function onChildUpdateData(childView, data) {
    this.trigger('list:control:update:data', childView, data);
  }
});

},{}],16:[function(require,module,exports){
"use strict";

lwwb.Control.Mn.Behaviors['dimensions'] = Marionette.Behavior.extend({
  onRender: function onRender() {
    var controlData = this.view.model.get('value');

    if (controlData) {
      if (controlData['is_linked'] && controlData['is_linked'] === 'true') {
        this.view.$el.find('.lwwb-unlinked').css('display', 'none');
        this.view.$el.find('.lwwb-linked').css('display', 'block');
      } else {
        this.view.$el.find('.lwwb-unlinked').css('display', 'block');
        this.view.$el.find('.lwwb-linked').css('display', 'none');
      }
    }
  }
});
lwwb.Control.Mn.Views['dimensions'] = lwwb.Control.Mn.Views['base'].extend({
  onUpdateInputData: function onUpdateInputData(view, event) {
    var key = $(event.currentTarget).data('key');
    var val = $(event.currentTarget).val();

    if ('' === val) {
      val = 0;
      $(event.currentTarget).val(0);
    }

    var controlData = this.model.get('value');
    controlData = !Array.isArray(controlData) ? controlData : {};
    controlData = controlData ? controlData : {};
    controlData['unit'] = controlData['unit'] ? controlData['unit'] : Object.keys(this.model.get('unit'))[0];
    controlData[key] = val;
    var parents = $(event.target).parents('.dimension-wrapper.linked');

    if (parents.length) {
      var siblings = parents.siblings().find('input.lwwb-input:not(:disabled)');
      siblings.each(function (index, el) {
        $(el).val(val);

        var _key = $(el).data('key');

        controlData[_key] = val;
      });
      controlData['is_linked'] = 'true';
    } else {
      controlData['is_linked'] = 'false';
    }

    this.model.set('value', controlData);
    this.trigger('update:data', this, controlData);
  }
});

},{}],17:[function(require,module,exports){
"use strict";

lwwb.Control.Mn.Behaviors['group'] = Marionette.Behavior.extend({
  ui: {
    widgetTop: '.lwwb-control >.widget-top',
    widgetInside: '.lwwb-control >.widget-inside'
  },
  triggers: {
    'click @ui.widgetTop': 'toggle:widget'
  },
  onToggleWidget: function onToggleWidget() {
    var siblingGroup = this.view.$el.siblings('li.customize-control-group');
    siblingGroup.each(function (index, group) {
      $(group).find('.widget-inside').slideUp('fast');
    });
    this.getUI('widgetInside').slideToggle('fast');
  }
});
lwwb.Control.Mn.Views['group'] = lwwb.Control.Mn.Views['base'].extend({
  el: function el() {
    var controlID = this.model ? this.model.get('id') : '';
    return '<li id="customize-control-' + controlID + '" class="customize-control customize-control-group customize-control-' + controlID + '"></li>';
  },
  regions: {
    controlRegion: {
      el: '.widget-content'
    }
  },
  childViewTriggers: {
    'update:data': 'child:update:data',
    'list:control:update:data': 'child:list:control:update:data'
  },
  onRender: function onRender() {
    var self = this;
    var fields = self.model.get('fields');
    self.showChildView('controlRegion', new lwwb.Control.Mn.Views['control-collection']({
      collection: new Backbone.Collection(fields)
    }));

    if (this.model.has('dependencies')) {
      if (self.isDepend()) {
        self.$el.show();
      } else {
        self.$el.hide();
      }

      self.checkDepend();
    }
  },
  onChildRepeatUpdateData: function onChildRepeatUpdateData(childView, data) {
    this.trigger('group:update:data', childView, data);
  },
  onChildListControlUpdateData: function onChildListControlUpdateData(childView, data) {
    this.trigger('group:update:data', childView, data);
  },
  onChildUpdateData: function onChildUpdateData(childView, data) {
    this.trigger('group:update:data', childView, data);
  }
});

},{}],18:[function(require,module,exports){
"use strict";

lwwb.Control.Mn.Behaviors['media-upload'] = Marionette.Behavior.extend({
  onRender: function onRender() {
    var self = this;

    if (self.view.model.get('type')) {
      var mediaType = void 0;
      mediaType = self.view.model.get('media_type') ? self.view.model.get('media_type') : 'image';
      var controlBehavior = mediaType + '-upload';

      if ('undefined' !== typeof lwwb.Control.Wp[controlBehavior]) {
        lwwb.Control.Wp[controlBehavior].init(self.view.$el);
      }
    }
  }
});
lwwb.Control.Mn.Views['media-upload'] = lwwb.Control.Mn.Views['base'].extend({});

},{}],19:[function(require,module,exports){
"use strict";

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

lwwb.Control.Mn.Behaviors['modal'] = Marionette.Behavior.extend({
  ui: {
    modalAction: '.modal-action',
    modalContent: '.widget-inside',
    reset: '.lwwb-reset-control'
  },
  triggers: {
    'click @ui.modalAction': 'modal:show:content',
    'click @ui.reset': 'modal:reset'
  },
  behaviors: function behaviors() {
    var behaviorTypes = ['group'];
    var behaviors = [];
    behaviors = _.map(behaviorTypes, function (behavior, index) {
      if (lwwb.Control.Mn.Behaviors[behavior]) {
        return lwwb.Control.Mn.Behaviors[behavior];
      }
    });
    return behaviors;
  },
  onModalShowContent: function onModalShowContent() {
    this.getUI('modalContent').slideToggle('fast');
  }
});
lwwb.Control.Mn.Views['modal'] = lwwb.Control.Mn.Views['group'].extend({
  el: function el() {
    var controlID = this.model ? this.model.get('id') : '';
    return '<li id="customize-control-' + controlID + '" class="customize-control customize-control-modal customize-control-' + controlID + '"></li>';
  },
  regions: {
    controlRegion: {
      el: '.modal-content'
    }
  },
  onChildListControlUpdateData: function onChildListControlUpdateData(childView, dt) {
    var data = this.model.get('value');
    var dataKey = childView.model.get('id');
    data = data || {};

    _.extend(data, _defineProperty({}, dataKey, dt));

    this.model.set('value', data);
    this.trigger('update:data', this, data);
  },
  onModalReset: function onModalReset() {
    this.getRegion('controlRegion').currentView.children.each(function (controlView) {
      controlView.trigger('reset:control');
    });
  }
});

},{}],20:[function(require,module,exports){
"use strict";

lwwb.Control.Mn.Views['repeater-collection'] = Marionette.CollectionView.extend({
  childView: lwwb.Control.Mn.Views['repeater-item'],
  initialize: function initialize(options) {
    var collection = _.map(options.collection.models, function (model, index) {
      model.set('fields', options.fields);
      model.set('label', options.label + ' ' + (index + 1));
      model.set('index', index);
      return model.toJSON();
    });

    this.collection = new Backbone.Collection(collection);
  },
  childViewTriggers: {
    'remove:item': 'child:remove:item',
    'clone:item': 'child:clone:item',
    'moveup:item': 'child:moveup:item',
    'movedown:item': 'child:movedown:item',
    'update:repeat:item': 'child:update:repeat:item'
  },
  onChildRemoveItem: function onChildRemoveItem(childView) {
    this.collection.remove(childView.model);
    this.trigger('repeat:item:collection:update:data', this);
    this.render();
  },
  onChildUpdateRepeatItem: function onChildUpdateRepeatItem(childView) {
    var index = this.collection.findIndex(childView.model.toJSON());
    this.collection.at(index).set(childView.model.toJSON());
    this.trigger('repeat:item:collection:update:data', this);
  },
  onChildCloneItem: function onChildCloneItem(childView, event) {
    var index = this.collection.findIndex(childView.model.toJSON());
    var model = childView.model.clone();
    this.collection.add(model, {
      at: index + 1
    });
    this.trigger('repeat:item:collection:update:data', this);
    this.render();
  },
  onChildMoveupItem: function onChildMoveupItem(childView, event) {},
  onChildMovedownItem: function onChildMovedownItem(childView, event) {}
});

},{}],21:[function(require,module,exports){
"use strict";

lwwb.Control.Mn.Behaviors['repeater-item'] = Marionette.Behavior.extend({
  ui: {
    clone: '.repeater-action-clone',
    remove: '.repeater-action-remove',
    moveup: '.repeater-action-up',
    movedown: '.repeater-action-down'
  },
  triggers: {
    'click @ui.clone': 'clone:item',
    'click @ui.remove': 'remove:item',
    'click @ui.moveup': 'moveup:item',
    'click @ui.movedown': 'movedown:item'
  },
  onRender: function onRender() {
    if (this.view.model.collection.size() === 1) {
      this.getUI('remove').remove();
    }
  }
});
lwwb.Control.Mn.Views['repeater-item'] = lwwb.Control.Mn.Views['base'].extend({
  el: function el() {
    return $('<li  class="lwwb-field-container lwwb-control-lwwb-repeater-item" data-cid="' + this.cid + '"></li>');
  },
  getTemplate: function getTemplate() {
    var fieldTmpl = $('#tmpl-customize-control-lwwb-repeater-item-content');
    return _.template(fieldTmpl.html(), lwwb.Control.Mn['templateSettings']);
  },
  templateContext: function templateContext() {
    var data = this.model.toJSON();
    return {
      data: data
    };
  },
  behaviors: function behaviors() {
    var behaviorTypes = ['group', 'repeater-item'];
    var behaviors = [];
    behaviors = _.map(behaviorTypes, function (behavior, index) {
      if (lwwb.Control.Mn.Behaviors[behavior]) {
        return lwwb.Control.Mn.Behaviors[behavior];
      }
    });
    return behaviors;
  },
  regions: {
    repeatFields: '.widget-content'
  },
  childViewTriggers: {
    'list:control:update:data': 'child:list:control:update:data'
  },
  onRender: function onRender() {
    var fields = this.model.get('fields');
    var data = this.model.toJSON();

    var fieldData = _.map(fields, function (field) {
      field['value'] = data[field.id];
      return field;
    });

    this.showChildView('repeatFields', new lwwb.Control.Mn.Views['control-collection']({
      collection: new Backbone.Collection(fieldData)
    }));
  },
  onChildListControlUpdateData: function onChildListControlUpdateData(childView, data) {
    var dataKey = childView.model.get('id');
    this.model.set(dataKey, data);
    this.trigger('update:repeat:item', this);
  }
});

},{}],22:[function(require,module,exports){
"use strict";

lwwb.Control.Mn.Behaviors['repeater'] = Marionette.Behavior.extend({
  ui: {
    addItemBtn: '.add-new-item',
    repeatItems: '.repeater-items.ui-sortable'
  },
  triggers: {
    'click @ui.addItemBtn': 'add:item'
  },
  onRender: function onRender() {
    var self = this;
    self.view.$el.find('.ui-sortable').sortable({
      items: '.lwwb-control-lwwb-repeater-item',
      helper: 'clone',
      handle: '.widget-title',
      axis: 'y',
      stop: function stop(event, ui) {
        self.view.render();
      },
      update: function update(event, ui) {
        var sortViewCid = ui.item.data('cid'),
            childCollectionView = self.view.getRegion('repeatRegion').currentView,
            sortView = childCollectionView.children.findByCid(sortViewCid),
            sortViewIndex = childCollectionView.children.findIndexByView(sortView),
            nextViewCid = ui.item.next().data('cid'),
            nextView = childCollectionView.children.findByCid(nextViewCid),
            nextViewIndex = childCollectionView.children.findIndexByView(nextView),
            prevViewCid = ui.item.prev().data('cid'),
            prevView = childCollectionView.children.findByCid(prevViewCid),
            prevViewIndex = childCollectionView.children.findIndexByView(prevView);

        if (prevViewCid) {
          childCollectionView.collection.add([sortView.model.clone()], {
            at: prevViewIndex + 1
          });
          childCollectionView.collection.remove([sortView.model]);
          childCollectionView.trigger('repeat:item:collection:sort:update:data', childCollectionView);
        } else if (nextViewCid) {
          childCollectionView.collection.add([sortView.model.clone()], {
            at: nextViewIndex
          });
          childCollectionView.collection.remove([sortView.model]);
          childCollectionView.trigger('repeat:item:collection:sort:update:data', childCollectionView);
        }
      }
    });
  }
});
lwwb.Control.Mn.Views['repeater'] = lwwb.Control.Mn.Views['base'].extend({
  el: function el() {
    return '<div class="repeat-item"></div>';
  },
  regions: {
    repeatRegion: '.repeater-items'
  },
  childViewTriggers: {
    'repeat:item:collection:update:data': 'child:repeat:item:collection:update:data',
    'repeat:item:collection:sort:update:data': 'child:repeat:item:collection:sort:update:data'
  },
  onRender: function onRender() {
    var self = this;
    var data = self.model.get('value');
    var fields = self.model.get('fields');
    self.showChildView('repeatRegion', new lwwb.Control.Mn.Views['repeater-collection']({
      collection: new Backbone.Collection(data),
      fields: fields,
      label: this.model.get('label')
    }));
  },
  onAddItem: function onAddItem() {
    var data = this.model.get('value');

    var newItem = _.clone(JSON.parse(JSON.stringify(data[0])));

    data.push(newItem);
    this.model.set('value', data);
    this.trigger('repeat:add:new:item', this, data);
    this.render();
  },
  onChildRepeatItemCollectionUpdateData: function onChildRepeatItemCollectionUpdateData(childView) {
    var data = [];
    var cloneCollection = childView.collection.clone();
    data = _.map(cloneCollection.models, function (model) {
      var cloneModel = JSON.parse(JSON.stringify(model.toJSON()));
      delete cloneModel['fields'];
      delete cloneModel['label'];
      delete cloneModel['index'];
      return cloneModel;
    });
    this.model.set('value', data);
    this.trigger('repeat:update:data', this, this.model.get('value'));
  },
  onChildRepeatItemCollectionSortUpdateData: function onChildRepeatItemCollectionSortUpdateData(childView) {
    this.onChildRepeatItemCollectionUpdateData(childView);
    this.render();
  }
});

},{}],23:[function(require,module,exports){
"use strict";

wp.customize.controlConstructor['lwwb-slider'] = wp.customize.Control.extend({
  ready: function ready() {
    var control = this;
    var resetBtn = control.container.find('.lwwb-reset-slider'),
        input = control.container.find('input'),
        resetData = control.container.find('input.lwwb-slider').data('reset_value');
    resetBtn.on('click', function (event) {
      event.preventDefault();
      input.val(resetData);
    });
  }
});

},{}],24:[function(require,module,exports){
"use strict";

/**
 * Alpha Color Picker JS
 *
 * This file includes several helper functions and the core control JS.
 */

/**
 * Override the stock color.js toString() method to add support for
 * outputting RGBa or Hex.
 */
Color.prototype.toString = function (flag) {
  // If our no-alpha flag has been passed in, output RGBa value with 100% opacity.
  // This is used to set the background color on the opacity slider during color changes.
  if ('no-alpha' == flag) {
    return this.toCSS('rgba', '1').replace(/\s+/g, '');
  } // If we have a proper opacity value, output RGBa.


  if (1 > this._alpha) {
    return this.toCSS('rgba', this._alpha).replace(/\s+/g, '');
  } // Proceed with stock color.js hex output.


  var hex = parseInt(this._color, 10).toString(16);

  if (this.error) {
    return '';
  }

  if (hex.length < 6) {
    for (var i = 6 - hex.length - 1; i >= 0; i--) {
      hex = '0' + hex;
    }
  }

  return '#' + hex;
};
/**
 * Given an RGBa, RGB, or hex color value, return the alpha channel value.
 */


function lwwb_get_alpha_value_from_color(value) {
  var alphaVal; // Remove all spaces from the passed in value to help our RGBa regex.

  value = value.replace(/ /g, '');

  if (value.match(/rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/)) {
    alphaVal = parseFloat(value.match(/rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/)[1]).toFixed(2) * 100;
    alphaVal = parseInt(alphaVal);
  } else {
    alphaVal = 100;
  }

  return alphaVal;
}
/**
 * Force update the alpha value of the color picker object and maybe the alpha slider.
 */


function lwwb_update_alpha_value_on_color_control(alpha, $control, $alphaSlider, update_slider) {
  var iris, colorPicker, color;
  iris = $control.data('a8cIris');
  colorPicker = $control.data('wpWpColorPicker'); // Set the alpha value on the Iris object.

  iris._color._alpha = alpha; // Store the new color value.

  color = iris._color.toString(); // Set the value of the input.

  $control.val(color); // Update the background color of the color picker.

  colorPicker.toggler.css({
    'background-color': color
  }); // Maybe update the alpha slider itself.

  if (update_slider) {
    lwwb_update_alpha_value_on_alpha_slider(alpha, $alphaSlider);
  } // Update the color value of the color picker object.


  $control.wpColorPicker('color', color);
}
/**
 * Update the slider handle position and label.
 */


function lwwb_update_alpha_value_on_alpha_slider(alpha, $alphaSlider) {
  $alphaSlider.slider('value', alpha);
  $alphaSlider.find('.ui-slider-handle').text(alpha.toString());
}

lwwb.Control.Wp['color-picker'] = {
  $control: null,
  init: function init($ctr) {
    this.$control = $ctr ? $ctr : $(document);
    this.$control.find('.lwwb-control-lwwb-color-picker').each(function () {
      // Scope the vars.
      var $control, startingColor, paletteInput, showOpacity, defaultColor, palette, colorPickerOptions, $container, $alphaSlider, alphaVal, sliderOptions; // Store the control instance.

      $control = $(this).find('.alpha-color-control'); // Get a clean starting value for the option.

      startingColor = $control.val().replace(/\s+/g, ''); // Get some data off the control.

      paletteInput = $control.attr('data-palette');
      showOpacity = $control.attr('data-show-opacity');
      defaultColor = $control.attr('data-default-color'); // Process the palette.

      if (paletteInput.indexOf('|') !== -1) {
        palette = paletteInput.split('|');
      } else if ('false' == paletteInput) {
        palette = false;
      } else {
        palette = true;
      } // Set up the options that we'll pass to wpColorPicker().


      colorPickerOptions = {
        change: function change(event, ui) {
          var key, value, alpha, $transparency;
          key = $control.attr('data-customize-setting-link');
          value = $control.wpColorPicker('color'); // Set the opacity value on the slider handle when the default color button is clicked.

          if (defaultColor == value) {
            alpha = lwwb_get_alpha_value_from_color(value);
            $alphaSlider.find('.ui-slider-handle').text(alpha);
          } // Send ajax request to wp.customize to trigger the Save action.


          wp.customize(key, function (obj) {
            obj.set(value);
          });
          $control.val(value).change();
          $transparency = $container.find('.transparency'); // Always show the background color of the opacity slider at 100% opacity.

          $transparency.css('background-color', ui.color.toString('no-alpha'));
        },
        palettes: palette // Use the passed in palette.

      }; // Create the colorpicker.

      $control.wpColorPicker(colorPickerOptions);
      $container = $control.parents('.wp-picker-container:first'); // Insert our opacity slider.

      $('<div class="alpha-color-picker-container">' + '<div class="min-click-zone click-zone"></div>' + '<div class="max-click-zone click-zone"></div>' + '<div class="alpha-slider"></div>' + '<div class="transparency"></div>' + '</div>').appendTo($container.find('.wp-picker-holder'));
      $alphaSlider = $container.find('.alpha-slider'); // If starting value is in format RGBa, grab the alpha channel.

      alphaVal = lwwb_get_alpha_value_from_color(startingColor); // Set up jQuery UI slider() options.

      sliderOptions = {
        create: function create(event, ui) {
          var value = $(this).slider('value'); // Set up initial values.

          $(this).find('.ui-slider-handle').text(value);
          $(this).siblings('.transparency ').css('background-color', startingColor);
        },
        value: alphaVal,
        range: 'max',
        step: 1,
        min: 0,
        max: 100,
        animate: 300
      }; // Initialize jQuery UI slider with our options.

      $alphaSlider.slider(sliderOptions); // Maybe show the opacity on the handle.

      if ('true' == showOpacity) {
        $alphaSlider.find('.ui-slider-handle').addClass('show-opacity');
      } // Bind event handlers for the click zones.


      $container.find('.min-click-zone').on('click', function () {
        lwwb_update_alpha_value_on_color_control(0, $control, $alphaSlider, true);
      });
      $container.find('.max-click-zone').on('click', function () {
        lwwb_update_alpha_value_on_color_control(100, $control, $alphaSlider, true);
      }); // Bind event handler for clicking on a palette color.

      $container.find('.iris-palette').on('click', function () {
        var color, alpha;
        color = $(this).css('background-color');
        alpha = lwwb_get_alpha_value_from_color(color);
        lwwb_update_alpha_value_on_alpha_slider(alpha, $alphaSlider); // Sometimes Iris doesn't set a perfect background-color on the palette,
        // for example rgba(20, 80, 100, 0.3) becomes rgba(20, 80, 100, 0.298039).
        // To compensante for this we round the opacity value on RGBa colors here
        // and save it a second time to the color picker object.

        if (alpha != 100) {
          color = color.replace(/[^,]+(?=\))/, (alpha / 100).toFixed(2));
        }

        $control.wpColorPicker('color', color);
      }); // Bind event handler for clicking on the 'Clear' button.

      $container.find('.button.wp-picker-clear').on('click', function () {
        var key = $control.attr('data-customize-setting-link'); // The #fff color is delibrate here. This sets the color picker to white instead of the
        // defult black, which puts the color picker in a better place to visually represent empty.

        $control.wpColorPicker('color', '#ffffff'); // Set the actual option value to empty string.

        wp.customize(key, function (obj) {
          obj.set('');
        });
        $control.val('').change();
        lwwb_update_alpha_value_on_alpha_slider(100, $alphaSlider);
      }); // Bind event handler for clicking on the 'Default' button.

      $container.find('.button.wp-picker-default').on('click', function () {
        var alpha = lwwb_get_alpha_value_from_color(defaultColor);
        lwwb_update_alpha_value_on_alpha_slider(alpha, $alphaSlider);
      }); // Bind event handler for typing or pasting into the input.

      $control.on('input', function () {
        var value = $(this).val();
        var alpha = lwwb_get_alpha_value_from_color(value);
        lwwb_update_alpha_value_on_alpha_slider(alpha, $alphaSlider);
      }); // Update all the things when the slider is interacted with.

      $alphaSlider.slider().on('slide', function (event, ui) {
        var alpha = parseFloat(ui.value) / 100.0;
        lwwb_update_alpha_value_on_color_control(alpha, $control, $alphaSlider, false); // Change value shown on slider handle.

        $(this).find('.ui-slider-handle').text(ui.value);
      });
    });
  }
};

},{}],25:[function(require,module,exports){
"use strict";

lwwb.Control.Wp['code-editor'] = {
  $control: null,
  init: function init($ctr) {
    this.$control = $ctr ? $ctr : $(document);
    this.$control.find('textarea.code').each(function () {
      var $this = $(this),
          codeEditor = void 0,
          codeEditorSettings = $this.data('editor_settings');
      codeEditor = wp.codeEditor.initialize($this, codeEditorSettings);
      codeEditor.codemirror.refresh();
      codeEditor.codemirror.on('change', function (cm) {
        cm.save();
        $this.val(cm.getValue()).trigger('change');
      });
    });
  }
};

},{}],26:[function(require,module,exports){
"use strict";

lwwb.Control.Wp['data-picker'] = {
  $control: null,
  init: function init($ctr) {
    var self = this;
    self.$control = $ctr ? $ctr : $(document);
    self.$control.find('.lwwb-control-lwwb-date-picker input.datepicker').each(function () {
      $(this).datepicker();
    });
  }
};

},{}],27:[function(require,module,exports){
"use strict";

lwwb.Control.Wp['dimensions'] = {
  $control: null,
  init: function init($ctr) {
    var self = this;
    self.$control = $ctr ? $ctr : $(document);
    self.$control.on('click', '.lwwb-control-lwwb-dimensions .lwwb-linked', function (event) {
      event.preventDefault();
      var target = $(event.target),
          siblingsLink = target.siblings('.lwwb-unlinked'),
          parent = target.parents('.control-wrapper');
      target.hide();
      siblingsLink.css('display', 'block');
      parent.find('.dimension-wrapper').addClass('unlinked');
      parent.find('.dimension-wrapper').removeClass('linked');
      parent.find('input.lwwb-input').each(function () {
        var $input = $(this);

        if ($input.val() === '') {
          $input.val('0');
        }
      });
    });
    self.$control.on('click', '.lwwb-control-lwwb-dimensions .lwwb-unlinked', function (event) {
      event.preventDefault();
      var target = $(event.target),
          siblingsLink = target.siblings('.lwwb-linked'),
          parent = target.parents('.control-wrapper');
      target.hide();
      siblingsLink.css('display', 'block');
      parent.find('.dimension-wrapper').addClass('linked');
      parent.find('.dimension-wrapper').removeClass('unlinked');
    });
    self.$control.on('click', '.lwwb-control-lwwb-unit input.lwwb-input', function (event) {
      var unit = $(this).val();
      var min = $(this).data('min');
      var max = $(this).data('max');
      var step = $(this).data('step');
      var dimensionInputs = self.$control.find('.dimension-wrapper input.lwwb-input');
      dimensionInputs.each(function (key, input) {
        $(input).attr('min', min);
        $(input).attr('max', max);
        $(input).attr('step', step);
      });
    });
  }
};

},{}],28:[function(require,module,exports){
"use strict";

lwwb.Control.Wp['icon-picker'] = {
  $control: null,
  $iconSidebar: null,
  $customizerEl: null,
  customizerWidth: null,
  init: function init($ctr) {
    var $document = $ctr ? $ctr : $(document);
    var self = this;
    self.$iconSidebar = $('#lwwb-sidebar-icons').first();
    self.$customizerEl = $('#customize-controls');
    self.customizerWidth = $('#customize-controls').width();
    $document.on('click', '.lwwb-control-lwwb-icon-picker input.pick-icon', function (e) {
      e.preventDefault();
      self.$control = $(this).parents('.lwwb-control-lwwb-icon-picker').first();
      self.openIconSidebar();
    });
    $document.on('click', '.lwwb-control-lwwb-icon-picker .remove-icon', function (e) {
      e.preventDefault();
      self.$control = $(this).parents('.lwwb-control-lwwb-icon-picker').first();
      self.removeIcon();
    });
  },
  openIconSidebar: function openIconSidebar() {
    var self = this;
    self.$iconSidebar.css('left', self.customizerWidth + 1).addClass('lwwb-active');
    self.searchIcon();
    self.pickIcon();
    self.$iconSidebar.on('click', '.customize-controls-icon-close', function (event) {
      event.preventDefault();
      self.closeIconSidebar();
    });
  },
  pickIcon: function pickIcon() {
    var self = this;
    self.$iconSidebar.on('click', '#lwwb-icon-browser li', function (e) {
      e.preventDefault();
      e.stopPropagation();
      var icon = $(e.currentTarget).data('icon');
      self.$control.find('.preview-icon-icon i').attr('class', '').addClass(icon);
      self.$control.find('input.pick-icon').attr('value', icon).change();
      self.closeIconSidebar();
    });
  },
  removeIcon: function removeIcon() {
    this.$control.find('.preview-icon-icon i').attr('class', '').addClass('');
    this.$control.find('input.pick-icon').attr('value', '').change();
  },
  closeIconSidebar: function closeIconSidebar() {
    var self = this;
    self.$iconSidebar.css('left', -self.customizerWidth).removeClass('lwwb-active'); // self.$control = null;
  },
  searchIcon: function searchIcon() {
    var self = this;
    self.$iconSidebar.find('#lwwb-icon-search').on('keyup', function (e) {
      e.preventDefault();
      e.stopPropagation();
      var searchData = $(this).val().trim();

      if (searchData) {
        self.$iconSidebar.find('.lwwb-list-icons > li').hide();
        self.$iconSidebar.find('.lwwb-list-icons').find(" > li[data-icon*='" + searchData + "']").show();
      } else {
        self.$iconSidebar.find('.lwwb-list-icons > li').show();
      }
    });
  }
};

},{}],29:[function(require,module,exports){
"use strict";

lwwb.Control.Wp['image-upload'] = {
  $control: null,
  init: function init($ctr) {
    var $document = $ctr ? $ctr : $(document);
    var self = this;
    $document.on('click', '.lwwb-control-lwwb-media-upload .image-upload-button, .lwwb-control-lwwb-media-upload .thumbnail, .lwwb-control-lwwb-media-upload .placeholder', function (event) {
      event.preventDefault();
      self.$control = $(this).parents('.lwwb-control-lwwb-media-upload').first();
      var image = wp.media({
        multiple: false
      }).open().on('select', function () {
        // This will return the selected image from the Media Uploader, the result is an object.
        var uploadedImage = image.state().get('selection').first(),
            previewImage = uploadedImage.toJSON().sizes.full.url,
            imageUrl,
            imageID,
            imageWidth,
            imageHeight,
            preview,
            removeButton;

        if (!_.isUndefined(uploadedImage.toJSON().sizes.medium)) {
          previewImage = uploadedImage.toJSON().sizes.medium.url;
        } else if (!_.isUndefined(uploadedImage.toJSON().sizes.thumbnail)) {
          previewImage = uploadedImage.toJSON().sizes.thumbnail.url;
        }

        imageUrl = uploadedImage.toJSON().sizes.full.url;
        imageID = uploadedImage.toJSON().id;
        imageWidth = uploadedImage.toJSON().width;
        imageHeight = uploadedImage.toJSON().height;
        preview = self.$control.find('.placeholder, .thumbnail');
        removeButton = self.$control.find('.image-upload-remove-button');

        if (preview.length) {
          preview.removeClass().addClass('thumbnail thumbnail-image').html('<img src="' + previewImage + '" alt="" />');
        }

        if (removeButton.length) {
          removeButton.show();
        }

        self.$control.find('input[data-key="url"]').val(imageUrl).change();
        self.$control.find('input[data-key="id"]').val(imageID).change();
      });
    });
    $document.on('click', '.image-upload-remove-button', function (e) {
      e.preventDefault();
      self.$control = $(this).parents('.lwwb-control-lwwb-media-upload').first();
      var preview, removeButton;
      preview = self.$control.find('.placeholder, .thumbnail');
      removeButton = self.$control.find('.image-upload-remove-button');
      self.$control.find('> .image-field-control').hide();

      if (preview.length) {
        preview.removeClass().addClass('placeholder').html('<i class="fa fa-2x fa-image"></i>');
      }

      if (removeButton.length) {
        removeButton.hide();
      }

      self.$control.find('input[data-key="url"]').val('').change();
      self.$control.find('input[data-key="id"]').val('').change();
    });
  }
};

},{}],30:[function(require,module,exports){
"use strict";

lwwb.Control.Wp['slider'] = {
  $control: null,
  init: function init($ctr) {
    var self = this;
    self.$control = $ctr ? $ctr : $(document);
    self.$control.find('.lwwb-control-lwwb-modal').each(function () {
      var reset = $(this).find('.lwwb-reset-control');
      reset.on('click', function (event) {
        event.preventDefault();
        input.val(resetData);
        slider.val(resetData);
      });
    });
  }
};

},{}],31:[function(require,module,exports){
(function (global){
"use strict";

global.lwwb = global.lwwb || {};
global.lwwb.Control = global.lwwb.Control || {};
global.lwwb.Control.Wp = global.lwwb.Control.Wp || {};
lwwb.Control.Wp['responsive-switcher'] = {
  $controls: null,
  $body: $('.wp-full-overlay'),
  $footerDevices: $('.wp-full-overlay-footer .devices'),
  init: function init() {
    var $document = $(document);
    var self = this;
    $document.on('click', '.lwwb-control-lwwb-responsive-switcher button', function (event) {
      var device = $(event.currentTarget).data('device');
      self.responsiveControl(device);
      self.wpResponsiveControl(device);
    });
    self.$footerDevices.on('click', 'button', function (event) {
      var device = $(event.currentTarget).data('device');
      self.responsiveControl(device);
    });
  },
  responsiveControl: function responsiveControl(device) {
    var $document = $(document);
    var self = this;
    $document.find('.lwwb-control-lwwb-responsive-switcher button').removeClass('active');
    $document.find('.lwwb-control-lwwb-responsive-switcher button[data-device="' + device + '"]').addClass('active');
    $document.find('.lwwb-control-container[data-on_device]').removeClass('active');
    $document.find('.lwwb-control-container[data-on_device="' + device + '"]').addClass('active');
  },
  wpResponsiveControl: function wpResponsiveControl(device) {
    var self = this;
    self.$footerDevices.find('.preview-' + device).addClass('active').attr('aria-pressed', true).trigger('click');
  }
};

}).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
},{}],32:[function(require,module,exports){
"use strict";

lwwb.Control.Wp['select2'] = {
  $control: null,
  init: function init($ctr) {
    var self = this;
    self.$control = $ctr ? $ctr : $(document);
    self.$control.find('.lwwb-control-lwwb-select2 select').each(function () {
      $(this).select2();
    });
  }
};

},{}],33:[function(require,module,exports){
"use strict";

lwwb.Control.Wp['slider'] = {
  $control: null,
  init: function init($ctr) {
    var self = this;
    self.$control = $ctr ? $ctr : $(document);
    self.$control.find('.lwwb-control-lwwb-slider .control-wrapper').each(function () {
      var slider = $(this).find('input.lwwb-slider');
      var input = $(this).find('input.lwwb-input');
      var reset = $(this).find('.lwwb-reset-control');
      var resetData = input.data('reset_value');
      slider.bind('input', function (event) {
        input.val($(event.currentTarget).val()).change();
        slider.val($(event.currentTarget).val()).change();
      });
      reset.on('click', function (event) {
        event.preventDefault();
        input.val(resetData).change();
        slider.val(resetData).change();
      });
    });
    self.$control.on('click', '.lwwb-control-lwwb-unit input.lwwb-input', function (event) {
      var unit = $(this).val();
      var device = $(this).data('device');
      var min = $(this).data('min');
      var max = $(this).data('max');
      var step = $(this).data('step');
      var sliderInputs = $(this).parents('.lwwb-control-header').first().next().find('.device-wrapper.' + device + ' input');
      sliderInputs.each(function (key, input) {
        $(input).attr('min', min);
        $(input).attr('max', max);
        $(input).attr('step', step);
      });
    });
  }
};

},{}],34:[function(require,module,exports){
"use strict";

lwwb.Control.Wp['wysiwyg'] = {
  $control: null,
  init: function init($ctr) {
    var self = this;
    self.$control = $ctr ? $ctr : $(document);
    self.$control.find('.lwwb-control-lwwb-wysiwyg > textarea').each(function () {
      var $this = $(this),
          editorID = $this.attr('id'),
          editor,
          setChange,
          content;
      setTimeout(function () {
        var editorConfig = window.wp.editor.getDefaultSettings();

        _.extend(editorConfig, {
          mediaButtons: true
        });

        _.extend(editorConfig.tinymce, {
          height: 250
        });

        wp.editor.initialize(editorID, editorConfig);
        editor = window.tinyMCE.get(editorID);

        if (editor) {
          editor.on('change', function (e) {
            editor.save();
            content = editor.getContent();
            clearTimeout(setChange);
            setChange = setTimeout(function () {
              $this.val(content).trigger('change');
            }, 50);
          });
        }
      }, 50);
    });
  }
};

},{}],35:[function(require,module,exports){
"use strict";

wp.customize.controlConstructor['lwwb-wysiwyg'] = wp.customize.Control.extend({
  ready: function ready() {
    'use strict';

    var control = this;
    control.init();
  },
  init: function init() {
    var control = this,
        editorSettings = control.params.editor_settings;
    control.container.find('textarea').each(function () {
      var editorID = $(this).attr('id'),
          editor = void 0,
          setChange = void 0,
          content = void 0;
      setTimeout(function () {
        wp.editor.initialize(editorID, editorSettings);
        editor = window.tinyMCE.get(editorID);

        if (editor) {
          editor.on('change', function (e) {
            editor.save();
            content = editor.getContent();
            clearTimeout(setChange);
            setChange = setTimeout(function () {
              control.setting.set(content);
            }, 50);
          });
        }
      });
    });
  }
});

},{}]},{},[6]);
