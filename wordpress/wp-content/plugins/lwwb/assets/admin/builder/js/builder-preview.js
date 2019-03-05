(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";

var _views = require("./views");

var _views2 = _interopRequireDefault(_views);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

(function (api) {
  api.bind('preview-ready', function () {
    api.preview.bind('active', function () {
      api.preview.send('preview_data', _lwwbData);
    });
    var _data = _lwwbData.page.content;
    var collection = new Backbone.Collection(_data);
    var hooks = [];

    _.each(_lwwbData.config.builderHooks, function (val, key) {
      if (val) {
        hooks.push(key);
      }
    });

    var lwwbViewContent = new _views2.default.LWWB({
      collection: new Backbone.Collection(_data),
      hooks: hooks
    });

    _.each(_lwwbData.config.builderHooks, function (value, hook) {
      var hookEl = $('#lwwb-content-wrapper-' + hook);

      if (hookEl.length) {
        lwwbViewContent.addRegion(hook, {
          el: hookEl
        });
      }
    });

    var hfHooks = ['lwwb_theme_header', 'lwwb_theme_footer'];
    var headerFooterData = _lwwbData.page.content;
    var headerFooterCollection = new Backbone.Collection(headerFooterData);
    var lwwbViewHeaderFooter = new _views2.default.LWWB({
      collection: headerFooterCollection,
      hooks: hfHooks
    });

    _.each(hfHooks, function (hook) {
      var hookEl = $('#lwwb-content-wrapper-' + hook);

      if (hookEl.length) {
        lwwbViewHeaderFooter.addRegion(hook, {
          el: hookEl
        });
      }
    });

    lwwbViewContent.on('update:region:data', function () {
      api.preview.send('collection_data' + _lwwbData.page.id, this.collection.toJSON());
    });
    lwwbViewHeaderFooter.on('update:region:data', function () {
      api.preview.send('collection_data' + _lwwbData.page.id, this.collection.toJSON());
    });
    lwwbViewContent.render();
    lwwbViewHeaderFooter.render();
  });
})(wp.customize);

},{"./views":23}],2:[function(require,module,exports){
"use strict";

lwwb.Builder.Mn.Behaviors['accordion'] = Marionette.Behavior.extend({
  ui: {
    accordionHeader: '.accordion-header'
  },
  triggers: {
    'click @ui.accordionHeader': 'toggle:accordion'
  },
  onToggleAccordion: function onToggleAccordion(view, event) {
    var $header = $(event.currentTarget);
    var $panel = $header.next();
    $header.toggleClass('active');
    $panel.slideToggle();
  }
});
lwwb.Builder.Mn.Views['accordion'] = lwwb.Builder.Mn.Views['elmn'].extend({
  onRender: function onRender() {
    var self = this;
    var eData = this.model.get('elmn_data');

    if (eData['accordion']) {
      this.updateAjaxAccordion(eData['accordion']);
    }
  },
  onUpdateAccordion: function onUpdateAccordion(childView, dataKey, accordion) {
    this.updateAjaxAccordion(accordion);
  },
  updateAjaxAccordion: function updateAjaxAccordion(accordion) {
    var self = this;
    $.ajax({
      type: "post",
      url: _lwwbData.config.ajaxUrl,
      data: {
        action: 'get_accordion_via_ajax',
        accordion: accordion
      },
      success: function success(data) {
        self.$el.find('.lwwb-elmn-content').html(data);
      }
    });
  }
});

},{}],3:[function(require,module,exports){
"use strict";

var AnimationBehavior = Marionette.Behavior.extend({
  onRender: function onRender() {
    var elmnData = this.view.model.get('elmn_data');

    if (!elmnData) {
      return;
    }

    if (elmnData['entrance_animation']) {
      this.view.$el.addClass('wow');
      this.view.$el.addClass(elmnData['entrance_animation']);

      if (elmnData['animation_duration']) {
        this.view.$el.addClass(elmnData['animation_duration']);
      }
    }
  }
});
module.exports = AnimationBehavior;

},{}],4:[function(require,module,exports){
"use strict";

// import HelperFn from './helper.functions';
var DraggableBehavior = Marionette.Behavior.extend({
  onRender: function onRender() {
    var self = this;
    self.view.$el.on('dragenter', function (event) {
      self.onDragEnter(event);
    });
    self.view.$el.on('dragover', function (event) {
      self.onDragOver(event);
    });
    self.view.$el.on('dragleave', function (event) {
      self.onDragLeave(event);
    });
    self.view.$el.on('drop', function (event) {
      self.onDrop(event);
    });
  },
  onDragEnter: function onDragEnter(event) {
    event.preventDefault();
    event.stopPropagation();
    this.view.$el.addClass('lwwb-is-dragover');
  },
  onDragOver: function onDragOver(event) {
    event.preventDefault();
    event.stopPropagation();
    var self = this;

    if (self.isEmptyChild()) {
      self.onDragOverEmpty(event);
      return;
    }

    var mousePrecentage = self.getMousePercentage(event);
    var lwwbElmn = $(event.target).closest('.lwwb-elmn');
    var elmnHasHighLight = lwwbElmn.find('.ui-state-highlight').length ? true : false;

    if (mousePrecentage.y < 50) {
      if (!elmnHasHighLight) {
        lwwbElmn.prepend($('<div style="display:none;" class="ui-state-highlight">&nbsp;</div>').fadeIn('slow'));
      }
    } else {
      if (!elmnHasHighLight) {
        lwwbElmn.append($('<div style="display:none;" class="ui-state-highlight">&nbsp;</div>').fadeIn('slow'));
      }
    }

    mousePrecentage = self.getMousePercentage(event);

    if (mousePrecentage.y > 40 && mousePrecentage.y < 60) {
      self.view.$el.find('.ui-state-highlight').remove();
    }
  },
  onDragOverEmpty: function onDragOverEmpty(event) {
    var self = this;

    if (self.isHighLight()) {
      return;
    }

    self.view.$el.find('.placeholder').html('<div style="display:none;" class="ui-state-highlight">&nbsp;</div>');
    self.view.$el.find('.ui-state-highlight').fadeIn('slow').css('height', '100%');
  },
  onDragLeave: function onDragLeave(event) {
    event.preventDefault();
    event.stopPropagation();
    var self = this;
    var currentViewModelCid = $(event.currentTarget).data('model-cid');
    var relatedModelCid = $(event.relatedTarget).parents('.lwwb-elmn-column').first().data('model-cid');

    if (!relatedModelCid || relatedModelCid !== currentViewModelCid) {
      self.view.$el.removeClass('lwwb-is-dragover');
      self.view.$el.find('.ui-state-highlight').remove();
      self.view.$el.find('.elmn-is-empty .placeholder').html('<i class="fa fa-plus"></i>');
    }
  },
  onDrop: function onDrop(event) {
    event.preventDefault();
    event.stopPropagation();
    var self = this;
    self.view.$el.find('.placeholder').html('<i class="fa fa-plus"></i>');
    var dataElmnType = event.originalEvent.dataTransfer.getData('text/plain'),
        dataModel = lwwb.Builder.HelperFn.getDefaultElmn(dataElmnType),
        currentChildView = self.view.getRegion('childRegion').currentView,
        targetElmn = $(event.target).closest('.lwwb-elmn'),
        isInner = $(event.target).parents('.is_inner').length ? true : false;

    if (dataModel) {
      if ('section' === dataElmnType) {
        if (isInner) {
          return;
        } else {
          dataModel.elmn_data['is_inner'] = true;
          dataModel.elmn_child = [lwwb.Builder.HelperFn.getDefaultElmn('column')];
        }
      }

      if (currentChildView) {
        var elmnView = self.view.getRegion('childRegion').currentView.children.findByModelCid(targetElmn.data('model-cid')),
            mousePrecentage = self.getMousePercentage(event);

        if (elmnView) {
          if (mousePrecentage.y < 50) {
            elmnView.trigger('add:elmn', elmnView, dataModel, 'before');
            self.view.render();
          } else {
            elmnView.trigger('add:elmn', elmnView, dataModel, 'after');
            self.view.render();
          }
        }
      } else {
        self.view.model.set('elmn_child', [dataModel]);
        self.view.trigger('update:elmn', self.view);
        self.view.render();
      }
    }
  },
  isEmptyChild: function isEmptyChild() {
    var emptyChild = this.view.model.get('elmn_child').length ? false : true;
    return emptyChild;
  },
  isHighLight: function isHighLight() {
    var highLight = this.view.$el.find('.ui-state-highlight').length ? true : false;
    return highLight;
  },
  getMousePercentage: function getMousePercentage(event) {
    var target = $(event.target);
    var x = event.originalEvent.clientX;
    var y = event.originalEvent.clientY;
    var mousePosition = {
      x: x,
      y: y
    };
    return this.getMouseBearingsPercentage(target, null, mousePosition);
  },
  getMouseBearingsPercentage: function getMouseBearingsPercentage(elmn, elmnRect, mousePos) {
    if (!elmnRect) elmnRect = elmn.get(0).getBoundingClientRect();
    var mousePosPercent_X = (mousePos.x - elmnRect.left) / (elmnRect.right - elmnRect.left) * 100;
    var mousePosPercent_Y = (mousePos.y - elmnRect.top) / (elmnRect.bottom - elmnRect.top) * 100;
    return {
      x: mousePosPercent_X,
      y: mousePosPercent_Y
    };
  }
});
module.exports = DraggableBehavior;

},{}],5:[function(require,module,exports){
"use strict";

var ElmnResizable = Marionette.Behavior.extend({
  onRender: function onRender() {
    if (12 <= this.view.model.collection.size()) {
      return;
    }

    this.view.resize();
  }
});
module.exports = ElmnResizable;

},{}],6:[function(require,module,exports){
"use strict";

var SortableElmn = Marionette.Behavior.extend({
  onRender: function onRender() {
    var self = this,
        eType = this.view.model.get('elmn_type'),
        eChilds = this.view.model.get('elmn_childs'),
        connectWith = '.' + eType + ' .lwwb-elmn-content > .ui-sortable',
        sortableElm = this.view.$el.find(' > .lwwb-elmn-content >.ui-sortable');
    var elmnConfig = window.parent._lwwbConfig.elmns;
    var forcePlaceholderSize = false,
        elmnItem = '> .lwwb-elmn',
        axis = false;

    if (eType === 'section') {
      var eData = this.view.model.get('elmn_data');
      forcePlaceholderSize = true;
      elmnItem = '> .lwwb-elmn-column';

      if (eData['in_container'] && 'yes' === eData['in_container']) {
        sortableElm = this.view.$el.find('> .container > .lwwb-elmn-content >.ui-sortable');
      } else {
        sortableElm = this.view.$el.find('>.lwwb-elmn-content >.ui-sortable');
      }

      connectWith = '.' + eType + ' .columns.ui-sortable';
    } else if ('column' !== eType) {
      axis = 'y';
      elmnItem = '.lwwb-elmn-section';
    }

    sortableElm.sortable({
      axis: axis,
      cancel: '',
      classes: {},
      connectWith: connectWith,
      cursor: 'move',
      cursorAt: {
        top: 20,
        left: 25
      },
      delay: 150,
      // disabled: true,
      // distance: 5,
      // dropOnEmpty: false,
      forcePlaceholderSize: forcePlaceholderSize,
      // forceHelperSize: true,
      // // grid: [ 20, 10 ],
      handle: '.lwwb-elmn-move, img',
      // helper: 'clone',
      helper: function helper(event, ui) {
        var eType = void 0,
            icon = void 0;
        eType = ui.closest('.lwwb-elmn').data('elmn_type').trim();
        icon = elmnConfig[eType] ? elmnConfig[eType].metas.icon : 'fa fa-arrows';
        var helper = $('<div class="lwwb-sortable-helper" style="width:90px; height:60px;" title="' + eType + '" draggable="true">\
                        <span class="icon"><i class="' + icon + '"></i></span>\
                        <span class="icon-title">' + eType + '</span>\
                    </div>');
        helper.css('position', 'absolute');
        return helper;
      },
      items: elmnItem,
      opacity: 1,
      placeholder: 'ui-state-highlight',
      // revert: true,
      scroll: false,
      // scrollSensitivity: 10,
      // scrollSpeed: 40,
      tolerance: 'pointer',
      zIndex: 9999,
      activate: function activate(event, ui) {},
      beforeStop: function beforeStop(event, ui) {},
      change: function change(event, ui) {
        $(ui.placeholder).hide().fadeIn('400');
      },
      create: function create(event, ui) {},
      deactivate: function deactivate(event, ui) {},
      out: function out(event, ui) {
        sortableElm.removeClass('lwwb-is-sortable');
        sortableElm.find('.placeholder').html('<i class="fa fa-plus"></i>');
        sortableElm.find('>.ui-state-highlight').hide();
      },
      over: function over(event, ui) {
        sortableElm.addClass('lwwb-is-sortable');

        if (!sortableElm.find('>.placeholder >.ui-state-highlight').length) {
          sortableElm.find('.placeholder').html('<div style="display:none;" class="ui-state-highlight">&nbsp;</div>');
          sortableElm.find('>.placeholder >.ui-state-highlight').fadeIn('slow').css('height', '100%');
        } else {
          sortableElm.find('>.ui-state-highlight').fadeIn('slow');
        }
      },
      receive: function receive(event, ui) {
        $(ui.placeholder).hide().fadeIn('400');
      },
      remove: function remove(event, ui) {},
      sort: function sort(event, ui) {},
      start: function start(event, ui) {
        $(ui.placeholder).hide().fadeIn('400');
      },
      stop: function stop(event, ui) {},
      update: function update(event, ui) {
        var modelCid = ui.item.data('model-cid'),
            destinationSortableModelCid = ui.item.parents('.lwwb-elmn').first().data('model-cid'),
            sourceSortableModelCid = self.view.model.cid,
            childCollectionView = self.view.getRegion('childRegion').currentView;

        if (!childCollectionView) {
          return;
        }

        var prevModelCid = ui.item.prev().data('model-cid'),
            nextModelCid = ui.item.next().data('model-cid'),
            childView = childCollectionView.children.findByModelCid(modelCid),
            prevView = childCollectionView.children.findByModelCid(prevModelCid),
            nextView = childCollectionView.children.findByModelCid(nextModelCid);

        if (ui.sender === null) {
          if (destinationSortableModelCid === sourceSortableModelCid && childView) {
            if (prevView) {
              prevView.trigger('sort:elmn', prevView, childView.model, 'after');
              childView.trigger('remove:elmn', childView);
            } else if (nextView) {
              nextView.trigger('sort:elmn', nextView, childView.model, 'before');
              childView.trigger('remove:elmn', childView);
            }
          } else {
            lwwb.Radio.channel.trigger('move:elmn:by:model:cid', destinationSortableModelCid, childView, prevModelCid, nextModelCid);
          }
        }
      }
    });
  }
});
module.exports = SortableElmn;

},{}],7:[function(require,module,exports){
"use strict";

lwwb.Builder.Mn.Views['block'] = lwwb.Builder.Mn.Views['parent-elmn'].extend({
  getTemplate: function getTemplate() {
    return _.template('<div class="lwwb-elmn-content"><div class="ui-sortable" ><div class="ui-droppable placeholder" ></div></div></div>');
  },
  regions: {
    childRegion: {
      el: '.ui-sortable'
    }
  },
  _getBehaviors: function _getBehaviors() {
    return ['elmn', 'sortable'];
  },
  onRender: function onRender() {
    var self = this,
        childs = this.model.get('elmn_child');

    if (childs.length < 1) {
      var section = lwwb.Builder.HelperFn.getDefaultElmn('section');
      childs.push(section);
      this.model.set('elmn_child', childs);
    }

    this.showChildView('childRegion', new lwwb.Builder.Mn.Views['elmn-collection']({
      el: this.$el.find('.ui-sortable'),
      collection: new Backbone.Collection(childs)
    }));
  }
});

},{}],8:[function(require,module,exports){
"use strict";

lwwb.Builder.Mn.Views['button'] = lwwb.Builder.Mn.Views['elmn'].extend({
  onUpdateType: function onUpdateType(childView, dataKey, data) {
    this.render();
  },
  onUpdateLabel: function onUpdateLabel(childView, dataKey, data) {
    this.render();
  },
  onUpdateButtonSize: function onUpdateButtonSize(childView, dataKey, data) {
    this.render();
  },
  onUpdateButtonStyle: function onUpdateButtonStyle(childView, dataKey, data) {
    this.render();
  },
  onUpdateAlign: function onUpdateAlign(childView, dataKey, data) {
    this.render();
  },
  onUpdateFontIcon: function onUpdateFontIcon(childView, dataKey, data) {
    this.render();
  },
  onUpdateIconSize: function onUpdateIconSize(childView, dataKey, data) {
    this.render();
  },
  onUpdateIconPosition: function onUpdateIconPosition(childView, dataKey, data) {
    this.render();
  }
});

},{}],9:[function(require,module,exports){
"use strict";

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

lwwb.Builder.Mn.Behaviors['column'] = Marionette.Behavior.extend({
  ui: {
    addColumn: '.lwwb-elmn-add',
    empty: '.lwwb-elmn-content.elmn-is-empty'
  },
  triggers: {
    'click @ui.add': 'add:column',
    'click @ui.empty': 'active:elmn:picker'
  },
  onAddColumn: function onAddColumn() {
    var model = new Backbone.Model(lwwb.Builder.HelperFn.getDefaultElmn('column'));
    this.view.trigger('add:elmn', this.view, model, 'after');
  },
  onActiveElmnPicker: function onActiveElmnPicker() {
    wp.customize.preview.send('active_group_control', 'elmn_picker');
  }
});
lwwb.Builder.Mn.Views['column'] = lwwb.Builder.Mn.Views['parent-elmn'].extend({
  el: function el() {
    var tmpl = [],
        eID = void 0,
        cID = void 0,
        width = void 0,
        gridClass = void 0,
        styles = void 0,
        animated_class = void 0;

    if ('undefined' !== typeof this.model) {
      eID = this.model.get('elmn_id');
      cID = this.model.cid;
      gridClass = ' column ui-resizable ' + this.model.get('elmn_data').classes;
      gridClass += width ? ' is-narrow' : '';
      tmpl = ['<div class="lwwb-elmn lwwb-elmn-' + eID + ' lwwb-elmn-column' + gridClass + '" data-model-cid="' + cID + '" data-elmn_type="column"></div>'];
    }

    return tmpl.join('');
  },
  _getBehaviors: function _getBehaviors() {
    return ['elmn', 'parent-elmn', 'sortable', 'resizable', 'draggable'];
  },
  onUpdateWidth: function onUpdateWidth(childView, dataKey, data) {
    this.trigger('update:width', this, dataKey, data);
  },
  onUpdateTabletWidth: function onUpdateTabletWidth(childView, dataKey, data) {},
  onUpdateMobileWidth: function onUpdateMobileWidth(childView, dataKey, data) {},
  onEditElmn: function onEditElmn() {
    lwwb.Radio.channel.trigger('active:elmn:control', this.model);
    this.model.trigger('change:elmn_data:field', 'width', this.model.get('elmn_data').width, this.getColumnInputAttrs());
  },
  resize: function resize() {
    var self = this;
    var colData = this.model.get('elmn_data');
    var fullwidth = void 0,
        totalWidth = void 0,
        gapWidth = void 0;
    var resizableElmn = this.$el;
    var elmnID = this.model.get('elmn_id');
    resizableElmn.resizable({
      autoHide: true,
      classes: {
        "ui-resizable": "highlight"
      },
      handles: 'e',
      create: function create(event, ui) {
        var lastModel = self.model.collection.last();

        if (lastModel.cid === self.model.cid) {
          resizableElmn.resizable("option", "disabled", 'true');
        }
      },
      start: function start(event, ui) {
        fullwidth = $('.lwwb-elmn.lwwb-elmn-' + elmnID).parents('.lwwb-elmn-section').first().width();
        var singleColWidth = fullwidth / 12;
        var targetCol = ui.element,
            nextCol = targetCol.next();
        gapWidth = targetCol.outerWidth() - targetCol.width();
        totalWidth = targetCol.width() + nextCol.width();
        resizableElmn.resizable("option", "minWidth", singleColWidth - gapWidth);
        resizableElmn.resizable("option", "maxWidth", totalWidth - singleColWidth + gapWidth);
        nextCol.removeClass(function (index, css) {
          return (css.match(/\bis-\S+/g) || []).join(' ');
        });
        targetCol.addClass('is-narrow');
        nextCol.addClass('is-narrow');
      },
      resize: function resize(event, ui) {
        var targetCol = ui.element,
            nextCol = targetCol.next();
        targetCol.width(ui.size.width);
        nextCol.width(totalWidth - ui.size.width);
      },
      stop: function stop(event, ui) {
        var singleColWidth = fullwidth / 12;
        var nextCell = ui.originalElement.next();
        var totalPercentWidth = 100 * (ui.originalElement.outerWidth() + nextCell.outerWidth()) / (fullwidth + gapWidth);
        var targetColPercentWidth = 100 * ui.originalElement.outerWidth() / (fullwidth + gapWidth);
        targetColPercentWidth = (Math.floor(parseFloat(targetColPercentWidth) * 100) / 100).toFixed(2);
        var nextColPercentWidth = totalPercentWidth - targetColPercentWidth;
        nextColPercentWidth = (Math.floor(parseFloat(nextColPercentWidth) * 100) / 100).toFixed(2);
        ui.originalElement.css('width', targetColPercentWidth + '%');
        nextCell.css('width', nextColPercentWidth + '%');
        var min = singleColWidth / fullwidth * 100;
        var options = {
          input_attrs: {
            min: min.toFixed(2),
            max: totalPercentWidth - min,
            step: 0.01
          }
        };
        var activeDevice = $(window.parent.document.body).find('.wp-full-overlay-footer .devices .active').data('device');
        var deviceKey = activeDevice === 'desktop' ? 'width' : '_' + activeDevice + '_width';
        var columnClasses = colData['classes'] ? colData['classes'] : '';
        columnClasses += columnClasses.indexOf('is-narrow') == -1 ? ' is-narrow' : '';

        _.extend(colData, _defineProperty({
          classes: columnClasses
        }, deviceKey, targetColPercentWidth));

        self.model.set('elmn_data', colData);
        self.model.trigger('change:elmn_data:field', 'width', targetColPercentWidth, options);
        self.trigger('update:elmn', self);

        if (activeDevice === 'desktop') {
          self.trigger('update:next:column', self, _defineProperty({
            classes: 'is-narrow'
          }, deviceKey, nextColPercentWidth));
        }
      }
    });
  },
  widthToClass: function widthToClass(width, singleColWidth) {
    var multiCol = Math.round(width / singleColWidth);

    if (multiCol < 1) {
      return 'is-' + '1';
    } else {
      return 'is-' + multiCol;
    }
  },
  getColumnInputAttrs: function getColumnInputAttrs() {
    var modelIndex = void 0,
        nextModel = void 0,
        currentWidth = void 0,
        nextWidth = void 0,
        maxPercentAvailale = void 0,
        minPercentAvailable = void 0,
        stepPercent = void 0,
        totalWidth = void 0,
        totalAvailableWidth = void 0,
        singleColWidth = void 0,
        prevModel = void 0;
    minPercentAvailable = 8.33;
    stepPercent = 0.01;

    if (!this.model.collection) {
      return;
    }

    modelIndex = this.model.collection.findIndex(this.model);
    nextModel = this.model.collection.at(modelIndex + 1);
    prevModel = this.model.collection.at(modelIndex - 1);
    nextModel = nextModel || prevModel;
    currentWidth = this.$el.width();

    if (nextModel) {
      nextWidth = this.$el.next().width();
    } else {
      return;
    }

    totalWidth = this.getSectionWidth();
    totalAvailableWidth = nextWidth + currentWidth;
    singleColWidth = minPercentAvailable * totalWidth / 100;
    maxPercentAvailale = (totalAvailableWidth - singleColWidth) * 100 / totalWidth;
    return {
      input_attrs: {
        min: (Math.floor(parseFloat(minPercentAvailable) * 100) / 100).toFixed(2),
        step: stepPercent,
        max: (Math.floor(parseFloat(maxPercentAvailale) * 100) / 100).toFixed(2)
      }
    };
  },
  onRender: function onRender() {
    var self = this,
        childs = this.model.get('elmn_child');

    if (childs.length > 0) {
      this.showChildView('childRegion', new lwwb.Builder.Mn.Views['elmn-collection']({
        el: this.$el.find('.ui-sortable'),
        collection: new Backbone.Collection(childs)
      }));
    } else {
      this.$el.find('.lwwb-elmn-content').addClass('elmn-is-empty');
      this.$el.find('.ui-sortable').html('<div class="placeholder"><i class="fa fa-plus"></i></div>');
    }
  },
  getSectionWidth: function getSectionWidth() {
    var sectionWrapper = $('.lwwb-elmn.lwwb-elmn-' + this.model.get('elmn_id')).parents('.lwwb-elmn-section').first();

    if (sectionWrapper.length) {
      return sectionWrapper.width();
    } else {
      return false;
    }
  }
});

},{}],10:[function(require,module,exports){
"use strict";

lwwb.Builder.Mn.Views['elmn-collection'] = Marionette.CollectionView.extend({
  onAddElmnByModelCid: function onAddElmnByModelCid(childView, prevCid, nextCid) {
    var prevView = this.children.findByModelCid(prevCid),
        nextView = this.children.findByModelCid(nextCid);

    if (prevView) {
      prevView.trigger('add:elmn', prevView, childView.model, 'after');
      childView.trigger('remove:elmn', childView);
      return;
    } else if (nextView) {
      nextView.trigger('add:elmn', nextView, childView.model, 'before');
      childView.trigger('remove:elmn', childView);
      return;
    }
  },
  childView: function childView(elmn) {
    var eType = elmn.get('elmn_type');
    var elmnView = lwwb.Builder.Mn.Views[eType];
    var baseElmnView = lwwb.Builder.Mn.Views['elmn'];

    if (elmnView) {
      return elmnView;
    } else {
      return baseElmnView;
    }
  },
  childViewTriggers: {
    'add:elmn': 'child:add:elmn',
    'sort:elmn': 'child:sort:elmn',
    'edit:elmn': 'child:edit:elmn',
    'clone:elmn': 'child:clone:elmn',
    'remove:elmn': 'child:remove:elmn',
    'update:elmn': 'child:update:elmn',
    'sort:elmn:by:model:cid': 'child:sort:elmn:by:model:cid',
    'update:next:column': 'child:update:next:column',
    'move:up': 'child:move:up',
    'move:down': 'child:move:down',
    'update:width': 'child:update:width'
  },
  collectionEvents: {
    'update': 'onCollectionUpdate'
  },
  onChildCollectionUpdate: function onChildCollectionUpdate() {
    this.trigger('update:collection', this);
  },
  onChildCloneElmn: function onChildCloneElmn(childView, event) {
    var elmnType = childView.model.get('elmn_type'),
        cloneElmn = this.cloneRecursiveElmn(childView.model),
        index = this.collection.findIndex(childView.model.toJSON());
    this.collection.add(cloneElmn, {
      at: index + 1
    });

    if ('column' === elmnType) {
      this.resetColumWidth();
      return;
    }

    this.trigger('update:collection', this);
  },
  resetColumWidth: function resetColumWidth() {
    var self = this;

    _.each(this.collection.models, function (column) {
      var columnData = column.get('elmn_data'),
          columnClasses = 0 == 12 % self.collection.size() ? 'is-' + 12 / self.collection.size() : '';
      var width = self.collection.size() <= 12 ? 100 / self.collection.size().toFixed(4) : '';

      _.extend(columnData, {
        classes: columnClasses,
        width: ''
      });

      column.set('elmn_data', columnData);
      self.collection.add(column, {
        merge: true
      });
    });

    this.trigger('update:collection', this);
    this.render();
  },
  cloneRecursiveElmn: function cloneRecursiveElmn(elmn) {
    var cloneData = lwwb.Builder.HelperFn.cloneRecursiveElmn(elmn.toJSON());
    return new Backbone.Model(cloneData);
  },
  onChildUpdateElmn: function onChildUpdateElmn(childView) {
    var index = this.collection.findIndex(childView.model.toJSON());
    this.collection.at(index).set(childView.model.toJSON());
    this.trigger('update:collection', this);
  },
  onChildRemoveElmn: function onChildRemoveElmn(childView) {
    this.collection.remove(childView.model.toJSON());
    childView.model.destroy();
    childView.destroy();
    this.trigger('update:collection', this);

    if (this.collection.size() === 0) {
      this.trigger('empty', this);
    }

    if ('column' === childView.model.get('elmn_type')) {
      this.resetColumWidth();
    }
  },
  onChildAddElmn: function onChildAddElmn(elmnView, model, addPosition) {
    var index = this.collection.findIndex(elmnView.model.toJSON());

    if ('before' == addPosition) {
      index = index;
    } else {
      index = index + 1;
    }

    if (!(model instanceof Backbone.Model)) {
      model = new Backbone.Model(model);
    }

    this.collection.add(model.toJSON(), {
      at: index
    });

    if ('column' === model.get('elmn_type')) {
      this.resetColumWidth();
    }

    this.trigger('update:collection', this);
  },
  onChildSortElmn: function onChildSortElmn(elmnView, model, addPosition) {
    var index = this.collection.findIndex(elmnView.model.toJSON());

    if ('before' == addPosition) {
      index = index;
    } else {
      index = index + 1;
    }

    if (!(model instanceof Backbone.Model)) {
      model = new Backbone.Model(model);
    }

    this.collection.add(model.toJSON(), {
      at: index
    });
    this.trigger('update:collection', this);
  },
  onChildUpdateNextColumn: function onChildUpdateNextColumn(colView, data) {
    var index = this.collection.findIndex(colView.model.toJSON());
    var nextColData = this.collection.at(index + 1).get('elmn_data');
    nextColData['width'] = data['width'];
    nextColData['classes'] += nextColData['classes'].indexOf(data['classes']) > -1 ? ' ' + data['classes'] : '';
    this.collection.at(index + 1).set('elmn_data', nextColData);
    this.trigger('update:collection', this);
    this.render();
  },
  onChildMoveUp: function onChildMoveUp(childView) {
    var eType = childView.model.get('elmn_type');
    var index = this.collection.findIndex(childView.model.toJSON());

    if (index < 1) {
      return;
    }

    var elmnBefore = this.collection.at(index - 1).clone();
    this.collection.remove(this.collection.at(index - 1));
    this.collection.add(elmnBefore.toJSON(), {
      at: index
    });
    this.collection.add(childView.model.toJSON(), {
      at: index - 1
    });
    elmnBefore.destroy();
    childView.model.destroy();
    childView.destroy();
    this.trigger('update:collection', this);
  },
  onChildMoveDown: function onChildMoveDown(childView) {
    var eType = childView.model.get('elmn_type');
    var index = this.collection.findIndex(childView.model.toJSON());

    if (index === this.collection.size() - 1) {
      return;
    }

    var elmnBefore = this.collection.at(index + 1).clone();
    this.collection.remove(this.collection.at(index + 1));
    this.collection.add(elmnBefore.toJSON(), {
      at: index
    });
    this.collection.add(childView.model.toJSON(), {
      at: index + 1
    });
    elmnBefore.destroy();
    childView.model.destroy();
    childView.destroy();
    this.trigger('update:collection', this);
  },
  onChildUpdateWidth: function onChildUpdateWidth(childView, dataKey, data) {
    var childViewIndex = this.children.findIndexByView(childView);
    var nextView = this.children.findByIndex(childViewIndex + 1);
    var prevView = this.children.findByIndex(childViewIndex - 1);
    nextView = nextView || prevView;

    if (!nextView || childViewIndex === -1) {
      return;
    }

    var fullwidth = childView.getSectionWidth();
    var gapWidth = childView.$el.outerWidth() - childView.$el.width();
    var totalPercentWidth = 100 * (childView.$el.outerWidth() + nextView.$el.outerWidth()) / (fullwidth + gapWidth);
    totalPercentWidth = (Math.floor(parseFloat(totalPercentWidth) * 100) / 100).toFixed(2);
    var targetColPercentWidth = 100 * childView.$el.outerWidth() / (fullwidth + gapWidth);
    var nextColPercentWidth = data !== '' ? (totalPercentWidth - data).toFixed(2) : '';
    var nextData = nextView.model.get('elmn_data');
    nextData[dataKey] = nextColPercentWidth;
    nextView.model.set('elmn_data', nextData);
    this.trigger('update:collection', this);
    this.render();
  }
});

},{}],11:[function(require,module,exports){
(function (global){
"use strict";

var _helper = require("./helper.functions");

var _helper2 = _interopRequireDefault(_helper);

var _sortable = require("./behaviors/sortable");

var _sortable2 = _interopRequireDefault(_sortable);

var _resizable = require("./behaviors/resizable");

var _resizable2 = _interopRequireDefault(_resizable);

var _draggable = require("./behaviors/draggable");

var _draggable2 = _interopRequireDefault(_draggable);

var _animation = require("./behaviors/animation");

var _animation2 = _interopRequireDefault(_animation);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

'use strict';

global.lwwb = global.lwwb || {};
lwwb.Builder = lwwb.Builder || {};
lwwb.Builder.HelperFn = lwwb.Builder.HelperFn || _helper2.default;
lwwb.Builder.Mn = lwwb.Builder.Mn || {};
lwwb.Builder.Mn.Views = lwwb.Builder.Mn.Views || {};
lwwb.Builder.Mn.Behaviors = lwwb.Builder.Mn.Behaviors || {};
lwwb.Builder.Mn.Behaviors['sortable'] = _sortable2.default;
lwwb.Builder.Mn.Behaviors['resizable'] = _resizable2.default;
lwwb.Builder.Mn.Behaviors['draggable'] = _draggable2.default;
lwwb.Builder.Mn.Behaviors['animation'] = _animation2.default;
lwwb.Builder.Mn['templateSettings'] = {
  evaluate: /<#([\s\S]+?)#>/g,
  interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
  escape: /\{\{([^\}]+?)\}\}(?!\})/g
};
var _operators = {
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
  },
  '>=': function _(a, b) {
    return a >= b;
  },
  '+': function _(a, b) {
    return a + b;
  },
  '-': function _(a, b) {
    return a - b;
  },
  '*': function _(a, b) {
    return a * b;
  },
  '/': function _(a, b) {
    return a / b;
  },
  '%': function _(a, b) {
    return a % b;
  },
  'in': function _in(a, b) {
    var check = a.indexOf(b) > -1 ? true : false;
    return check;
  }
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
    'keyup @ui.placeholder': 'add:elmn'
  },
  onEnableEditable: function onEnableEditable() {
    this.view.onEditElmn();
    this.view.getUI('contentEditable').attr('contenteditable', true).focus();
  },
  onRender: function onRender() {
    var self = this;
    self.view.$el.on('click', function (event) {
      event.preventDefault();

      if ('section' === self.view.model.get('elmn_type')) {// lwwb.Radio.channel.trigger('active:elmn:control', self.view.model);
      }
    });
    self.view.triggerMethod('render:style', self);
  }
});
lwwb.Builder.Mn.Views['elmn'] = Marionette.View.extend({
  el: function el() {
    var tmpl = [];

    if ('undefined' !== typeof this.model) {
      var eID = this.model.get('elmn_id'),
          eType = this.model.get('elmn_type'),
          cID = this.model.cid;
      tmpl = ['<div class="lwwb-elmn lwwb-elmn-' + eID + ' lwwb-elmn-' + eType + '" data-model-cid="' + cID + '" data-elmn_type="' + eType + '"></div>'];
    }

    return tmpl.join('');
  },
  templateContext: function templateContext() {
    var data = this.model.toJSON();
    return {
      data: data,
      view: this
    };
  },
  getTemplate: function getTemplate() {
    var eType = this.model.get('elmn_type');
    var elmnTmpl = $(window.parent.document).find('#tmpl-lwwb-elmn-' + eType + '-content');
    var elmnTmplHtml = elmnTmpl.length > 0 && elmnTmpl.html().trim() !== '' ? elmnTmpl.html() : '';
    var tmpl = [elmnTmplHtml].join('');
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
    placeholder: '.placeholder'
  },
  behaviors: function behaviors() {
    var behaviorTypes = this._getBehaviors();

    var behaviors = [];
    behaviors = _.map(behaviorTypes, function (behavior, index) {
      if (lwwb.Builder.Mn.Behaviors[behavior]) {
        return lwwb.Builder.Mn.Behaviors[behavior];
      } else {
        return false;
      }
    });

    if (this.options.model) {
      var controlName = this.options.model.get('elmn_type');

      if (controlName) {
        if (lwwb.Builder.Mn.Behaviors[controlName]) {
          behaviors.push(lwwb.Builder.Mn.Behaviors[controlName]);
        }
      }
    }

    behaviors = _.filter(behaviors, function (bh, index) {
      return bh;
    });
    return behaviors;
  },
  _getBehaviors: function _getBehaviors() {
    return ['elmn', 'animation'];
  },
  modelEvents: {
    'change:elmn_data': 'updateElmnData'
  },
  updateElmnData: function updateElmnData(dataKey, data, childView) {
    this.triggerMethod('update:' + this._dataKeyToEvent(dataKey), childView, dataKey, data);
    this.trigger('update:elmn', this);
    this.triggerMethod('render:style', this);
  },
  _dataKeyToEvent: function _dataKeyToEvent(dataKey) {
    if (dataKey[0] == '_') {
      dataKey = dataKey.substring(1);
    }

    dataKey = dataKey.replace(/-/g, ':');
    dataKey = dataKey.replace(/_/g, ':');
    dataKey = dataKey.replace(/:{1,}/g, ':');
    return dataKey;
  },
  onRenderStyle: function onRenderStyle() {
    var self = this;
    var elmnData = this.model.get('elmn_data');
    var css = '';
    var styleControls = self.styleConfig();
    var elmnID = self.model.get('elmn_id');

    _.each(elmnData, function (val, key) {
      if (styleControls[key] && val) {
        css += self.renderStyle(styleControls[key], val);
      }
    });

    css = css.replace(/ELMN_WRAPPER/g, '.lwwb_page_' + _lwwbData.page.id + ' .lwwb-elmn-' + elmnID);
    var headerStyle = $('#elmn-style-' + elmnID);

    if (headerStyle.length) {
      headerStyle.html(css);
    } else {
      headerStyle = '<style type="text/css" id="elmn-style-' + elmnID + '"> ' + css + '</style>';
      $('head').append(headerStyle);
    }
  },
  renderStyle: function renderStyle(control, data) {
    if (this.checkForRenderStyle(control) === false) {
      return '';
    }

    var styleTmpl = this.getStyleTemplate(control, data);
    return styleTmpl({
      data: data
    });
  },
  checkForRenderStyle: function checkForRenderStyle(control) {
    var dp = control.dependencies;

    if (!dp) {
      return true;
    }

    var checkDp = _.filter(dp, function (d, index) {
      return d.check_for_render_style;
    });

    if (!checkDp) {
      return true;
    }

    var elmnData = this.model.get('elmn_data');
    var shouldRender = true;

    _.each(checkDp, function (dp, index) {
      shouldRender = !_operators[dp.operator](dp['value'], elmnData[dp.control]) ? false : shouldRender;
    });

    return shouldRender;
  },
  getStyleTemplate: function getStyleTemplate(control, data) {
    var cssFormat = control.css_format;

    if (cssFormat.indexOf('font-family') !== -1) {
      this.addFont(data);
    }

    if (control.on_device) {
      cssFormat = this.getResponsiveTemplate(control, data);
    }

    if ('string' === typeof data) {
      cssFormat = cssFormat.replace(new RegExp('VALUE', 'g'), 'data'), lwwb.Builder.Mn.templateSettings;
    } else {
      var matches = cssFormat.match(/{{(.+?)}}/g);

      if (matches.length > 0) {
        _.each(matches, function (match, index) {
          var dataKey = match.replace('{{', '').replace('}}', '');
          dataKey = dataKey.trim().toLowerCase();
          cssFormat = data[dataKey] ? cssFormat.replace(match, data[dataKey]) : cssFormat.replace(match, '0');
        });
      }
    }

    return _.template(cssFormat, lwwb.Builder.Mn.templateSettings);
  },
  getResponsiveTemplate: function getResponsiveTemplate(control, data) {
    var tabletMaxWidth = _lwwbData.config.responsiveBreakpoints['tablet'];
    var mobileMaxWidth = _lwwbData.config.responsiveBreakpoints['mobile'];
    var device = control.on_device;
    var cssFormat = control.css_format;

    if ('mobile' === device) {
      cssFormat = '@media screen and (max-width: ' + parseInt(mobileMaxWidth - 1) + 'px){ ' + cssFormat + '}';
    } else if ('tablet' === device) {
      cssFormat = '@media screen and (min-width: ' + mobileMaxWidth + 'px) and (max-width: ' + parseInt(tabletMaxWidth - 1) + 'px){ ' + cssFormat + '}';
    } else {
      cssFormat = '@media screen and (min-width: ' + tabletMaxWidth + 'px){ ' + cssFormat + '}';
    }

    return cssFormat;
  },
  styleConfig: function styleConfig() {
    var self = this;
    var type = this.model.get('elmn_type');
    var elmnConfig = _lwwbData.config.elmns[type];

    if (!elmnConfig) {
      return;
    }

    var styleConfig = {};

    _.each(elmnConfig.controls, function (control, index) {
      _.extend(styleConfig, self.getStyleConfig(control));
    });

    return styleConfig;
  },
  getStyleConfig: function getStyleConfig(control) {
    var self = this;
    var scf = {};

    if (control.css_format) {
      _.extend(scf, _defineProperty({}, control.id, control));
    }

    if (control.fields) {
      _.each(control.fields, function (ctr, index) {
        _.extend(scf, self.getStyleConfig(ctr));
      });
    }

    return scf;
  },
  onEditElmn: function onEditElmn(view) {
    lwwb.Radio.channel.trigger('active:elmn:control', this.model);
  },
  addFont: function addFont(font) {
    var fontID = font.trim().replace(" ", "_");
    var existingFontLink = $('#google-fonts-' + fontID);

    if (existingFontLink.length) {
      return;
    }

    if (!_lwwbData.config.googleFonts[font]) {
      return;
    }

    var fontLink = "<link rel='stylesheet' id='google-fonts-" + fontID + "'  href='//fonts.googleapis.com/css?family=" + font + "' type='text/css' media='all' />";
    $('head').append(fontLink);
  },
  onUpdateEntranceAnimation: function onUpdateEntranceAnimation(childView, dataKey, data) {
    var self = this;
    self.removeAnimateClasses();

    if (!self.$el.hasClass('animated')) {
      self.$el.addClass('animated');
    }

    self.$el.addClass(data);
  },
  onUpdateAnimationDuration: function onUpdateAnimationDuration(childView, dataKey, data) {
    var self = this;
    self.removeAnimateDurationClasses();
    self.$el.addClass(data);
    self.$el.removeClass('animated').addClass('animated');
  },
  removeAnimateClasses: function removeAnimateClasses() {
    var self = this;

    _.each(_lwwbData.config.animationConfig, function (index, animate) {
      self.$el.removeClass(animate);
    });
  },
  removeAnimateDurationClasses: function removeAnimateDurationClasses() {
    var self = this;
    var animageDurations = {
      slow: 'slow',
      slower: 'slower',
      fast: 'fast',
      faster: 'faster'
    };

    _.each(animageDurations, function (key, duration) {
      self.$el.removeClass(duration);
    });
  },
  onEditContentEditableElmn: function onEditContentEditableElmn(view, event) {
    var content = $(event.currentTarget).html().trim();
    var dataKey = $(event.currentTarget).data('key');
    var data = this.model.get('elmn_data');

    _.extend(data, _defineProperty({}, dataKey, content));

    this.trigger('update:elmn', this);
    this.model.set('elmn_data', data).trigger('change:elmn_data:contenteditable', dataKey, content);
  },
  onUpdateHideDesktop: function onUpdateHideDesktop(childView, dataKey, data) {
    if ('yes' === data) {
      this.$el.addClass('is-hidden-desktop');
    } else {
      this.$el.removeClass('is-hidden-desktop');
    }
  },
  onUpdateHideTablet: function onUpdateHideTablet(childView, dataKey, data) {
    if ('yes' === data) {
      this.$el.addClass('is-hidden-tablet-only');
    } else {
      this.$el.removeClass('is-hidden-tablet-only');
    }
  },
  onUpdateHideMobile: function onUpdateHideMobile(childView, dataKey, data) {
    if ('yes' === data) {
      this.$el.addClass('is-hidden-mobile');
    } else {
      this.$el.removeClass('is-hidden-mobile');
    }
  },
  onUpdateBgOverlayState: function onUpdateBgOverlayState(childView, dataKey, data) {
    this.render();
  }
});

}).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
},{"./behaviors/animation":3,"./behaviors/draggable":4,"./behaviors/resizable":5,"./behaviors/sortable":6,"./helper.functions":14}],12:[function(require,module,exports){
"use strict";

lwwb.Builder.Mn.Views['google_map'] = lwwb.Builder.Mn.Views['elmn'].extend({
  onUpdateAddress: function onUpdateAddress(childView, dataKey, data) {
    this.render();
  },
  onUpdateZoom: function onUpdateZoom(childView, dataKey, data) {
    this.render();
  }
});

},{}],13:[function(require,module,exports){
"use strict";

lwwb.Builder.Mn.Views['heading'] = lwwb.Builder.Mn.Views['elmn'].extend({
  onUpdateTitle: function onUpdateTitle(childView, dataKey, data) {
    this.render();
  },
  onUpdateLinkUrl: function onUpdateLinkUrl(childView, dataKey, data) {
    this.render();
  },
  onUpdateLinkTarget: function onUpdateLinkTarget(childView, dataKey, data) {
    this.render();
  },
  onUpdateHtmlTag: function onUpdateHtmlTag(childView, dataKey, data) {
    this.render();
  },
  onUpdateAlign: function onUpdateAlign(childView, dataKey, data) {
    $(this.$el.find('.lwwb-elmn-content')).removeClass(function (index, css) {
      return (css.match(/\bhas-text-\S+/g) || []).join(' ');
    }).addClass('has-text-' + data);
  }
});

},{}],14:[function(require,module,exports){
"use strict";

var generateGUID = function generateGUID() {
  function s4() {
    return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
  }

  return s4() + s4() + s4() + s4();
};

var getDefaultElmnData = function getDefaultElmnData() {
  var elmn_type = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'section';
  var data = {};

  switch (elmn_type) {
    case 'section':
      break;

    case 'column':
      break;

    case 'image':
      _.extend(data, {
        image: {
          image_url: 'https://www.google.com.vn/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png',
          image_repeat: '',
          image_position: '',
          image_size: '',
          image_attachment: ''
        }
      });

      break;

    case 'video':
      _.extend(data, {});

      break;

    case 'text':
      _.extend(data, {});

      break;

    default:
      break;
  }

  return data;
};

var getDefaultElmn = function getDefaultElmn() {
  var elmn_type = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'section';

  if (!window.parent._lwwbConfig.elmns[elmn_type]) {
    return false;
  }

  var data = {};
  var defaultData = window.parent._lwwbConfig.elmns[elmn_type].default;
  data = _.extend(data, JSON.parse(JSON.stringify(defaultData)));

  if (Array.isArray(data) && data.length === 0) {
    data = {};
  }

  var elmn = {
    elmn_id: generateGUID(),
    elmn_type: elmn_type,
    elmn_child: [],
    elmn_data: data
  };
  return elmn;
};

var getDefaultColumnElmn = function getDefaultColumnElmn() {
  var width = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 3;
  var columnElmn = getDefaultElmn('column');
  var columClass = '';
  columClass = 'is-' + width;

  if ('' === width) {
    columClass = '';
  }

  columnElmn.elmn_data = {
    classes: columClass // width:{},

  };
  return columnElmn;
};

var getDefaultSectionElmn = function getDefaultSectionElmn() {
  var columnPreset = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [1];
  var sectionElmn = getDefaultElmn();

  _.each(columnPreset, function (col) {
    sectionElmn.elmn_child.push(getDefaultColumnElmn(col));
  });

  return sectionElmn;
};

var sectionPresets = {
  _12: [12],
  _2_cols: [6, 6],
  _3_cols: [4, 4, 4],
  _4_cols: [3, 3, 3, 3],
  _5_cols: ['', '', '', '', ''],
  _6_cols: [2, 2, 2, 2, 2, 2],
  _2_4_6: [2, 4, 6],
  _2_8_2: [2, 8, 2],
  _2_4_4_2: [2, 4, 4, 2],
  _2_6_2_2: [2, 6, 2, 2],
  _3_2_7: [3, 2, 7],
  _3_4_5: [3, 4, 5],
  _3_5_4: [3, 5, 4],
  _3_6_3: [3, 6, 3],
  _6_3_3: [6, 3, 3],
  _3_7_2: [3, 7, 2],
  _3_9: [3, 9],
  _3_3_6: [3, 3, 6],
  _4_8: [4, 8],
  _4_6_2: [4, 6, 2],
  _4_5_3: [4, 5, 3],
  _4_3_5: [4, 3, 5],
  _4_2_6: [4, 2, 6],
  _5_7: [5, 7],
  _8_4: [8, 4]
};

var getSectionPresets = function getSectionPresets(preset) {
  return getDefaultSectionElmn(preset);
};

var cloneRecursiveElmn = function cloneRecursiveElmn(elmnData) {
  var cloneData = JSON.parse(JSON.stringify(elmnData));
  cloneData.elmn_id = generateGUID();
  cloneData.elmn_child = _.map(elmnData.elmn_child, function (childData) {
    return cloneRecursiveElmn(JSON.parse(JSON.stringify(childData)));
  });
  return cloneData;
};

module.exports = {
  generateElmnID: generateGUID,
  getDefaultElmn: getDefaultElmn,
  sectionPresets: sectionPresets,
  getSectionPresets: getSectionPresets,
  cloneRecursiveElmn: cloneRecursiveElmn
};

},{}],15:[function(require,module,exports){
"use strict";

lwwb.Builder.Mn.Views['icon'] = lwwb.Builder.Mn.Views['elmn'].extend({
  onRender: function onRender() {
    var eData = this.model.get('elmn_data');

    if (eData['icon_view']) {
      this.$el.find('.lwwb-elmn-content').addClass('icon-view--' + eData['icon_view']);
    }

    if (eData['icon_shape']) {
      this.$el.find('.lwwb-elmn-content').addClass('icon-shape--' + eData['icon_shape']);
    }

    if (eData['icon_hover_animation']) {
      this.$el.find('.lwwb-icon').addClass('lwwb-animation-' + eData['icon_hover_animation']);
    }
  },
  onUpdateIcon: function onUpdateIcon(childView, dataKey, data) {
    this.render();
  },
  onUpdateIconView: function onUpdateIconView(childView, dataKey, data) {
    $(this.$el.find('.lwwb-elmn-content')).removeClass(function (index, css) {
      return (css.match(/\bicon-view--\S+/g) || []).join(' ');
    }).addClass('icon-view--' + data);

    if ('default' === data) {
      $(this.$el.find('.lwwb-elmn-content')).removeClass(function (index, css) {
        return (css.match(/\bicon-shape--\S+/g) || []).join(' ');
      });
    }
  },
  onUpdateIconShape: function onUpdateIconShape(childView, dataKey, data) {
    $(this.$el.find('.lwwb-elmn-content')).removeClass(function (index, css) {
      return (css.match(/\bicon-shape--\S+/g) || []).join(' ');
    }).addClass('icon-shape--' + data);
  },
  onUpdateIconHoverAnimation: function onUpdateIconHoverAnimation(childView, dataKey, data) {
    $(this.$el.find('.lwwb-icon')).removeClass(function (index, css) {
      return (css.match(/\blwwb-animation-\S+/g) || []).join(' ');
    }).addClass('lwwb-animation-' + data);
  }
});

},{}],16:[function(require,module,exports){
"use strict";

var _lwwb$Builder$Mn$View;

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

lwwb.Builder.Mn.Views['image'] = lwwb.Builder.Mn.Views['elmn'].extend((_lwwb$Builder$Mn$View = {
  onRender: function onRender() {
    var eData = this.model.get('elmn_data');

    if (eData['image_lightbox'] === 'yes' && eData['link_to'] === 'media_file') {
      $(this.$el.find('a')).addClass('lwwb-image');
      $('.lwwb-image').magnificPopup({
        type: 'image'
      });
    }

    if (eData['image_hover_animation']) {
      this.$el.find('.lwwb-elmn-content img').addClass('lwwb-animation-' + eData['image_hover_animation']);
    }
  },
  onUpdateImage: function onUpdateImage(childView, dataKey, data) {
    this.render();
  },
  onUpdateImageSize: function onUpdateImageSize(childView, dataKey, data) {
    this.render();
  },
  onUpdateCaptionType: function onUpdateCaptionType(childView, dataKey, data) {
    this.render();
  },
  onUpdateLinkTo: function onUpdateLinkTo(childView, dataKey, data) {
    this.render();
  },
  onUpdateCustomImageLinkTo: function onUpdateCustomImageLinkTo(childView, dataKey, data) {
    this.render();
  },
  onUpdateImageCustomCaption: function onUpdateImageCustomCaption(childView, dataKey, data) {
    this.render();
  }
}, _defineProperty(_lwwb$Builder$Mn$View, "onUpdateImageCustomCaption", function onUpdateImageCustomCaption(childView, dataKey, data) {
  this.render();
}), _defineProperty(_lwwb$Builder$Mn$View, "onUpdateImageHoverAnimation", function onUpdateImageHoverAnimation(childView, dataKey, data) {
  $(this.$el.find('.lwwb-elmn-content img')).removeClass(function (index, css) {
    return (css.match(/\blwwb-animation-\S+/g) || []).join(' ');
  }).addClass('lwwb-animation-' + data);
}), _defineProperty(_lwwb$Builder$Mn$View, "onUpdateImageLightbox", function onUpdateImageLightbox(childView, dataKey, data) {
  this.render();

  if ('yes' === data) {
    $('.lwwb-image').magnificPopup({
      type: 'image'
    });
  }
}), _defineProperty(_lwwb$Builder$Mn$View, "_getAttachmentData", function _getAttachmentData() {
  var eData = this.model.get('elmn_data');
  var id = eData.image.id;
  var url = eData.image.url;
  var self = this;

  if ('undefined' === typeof wp.media.attachment(id).get('caption')) {
    wp.media.attachment(id).fetch().then(function (data) {
      self.render();
    });
  }

  return {
    caption: wp.media.attachment(id).get('caption'),
    alt: wp.media.attachment(id).get('alt'),
    title: wp.media.attachment(id).get('title'),
    sizes: wp.media.attachment(id).get('sizes')
  };
}), _lwwb$Builder$Mn$View));

},{}],17:[function(require,module,exports){
"use strict";

lwwb.Builder.Mn.Views['menu'] = lwwb.Builder.Mn.Views['wp_menu'].extend({
  onRender: function onRender() {
    var eData = this.model.get('elmn_data');

    if (eData['menu_id']) {
      this.getMenuAjax(eData['menu_id']);
    }

    if (eData['menu_layout']) {
      this.$el.find('.lwwb-navigation').addClass('lwwb-navigation--' + eData['menu_layout']);
    }

    if (eData['pointer']) {
      this.$el.find('.lwwb-navigation').addClass('lwwb-pointer--' + eData['pointer']);
    }
  },
  getMenuAjax: function getMenuAjax(data) {
    var self = this;
    $.ajax({
      type: "post",
      url: _lwwbData.config.ajaxUrl,
      data: {
        action: 'get_menu_html_via_ajax',
        id: data
      },
      success: function success(data) {
        if (data.success) {
          self.$el.find('.lwwb-navigation').html(data.html);
          self.$el.find('.lwwb-navigation').removeClass('lwwb-nav-empty');
        } else {
          self.$el.find('.lwwb-navigation').html('<div class="lwwb-empty-image"></div>');
          self.$el.find('.lwwb-navigation').addClass('lwwb-nav-empty');
        }
      }
    });
  },
  onUpdateLogoImg: function onUpdateLogoImg(childView, dataKey, data) {
    this.render();
  },
  onUpdateAlign: function onUpdateAlign(childView, dataKey, data) {
    $(this.$el.find('.lwwb-navigation')).removeClass(function (index, css) {
      return (css.match(/\bnavbar-\S+/g) || []).join(' ');
    }).addClass('navbar-' + data);
  },
  onUpdateMenuLayout: function onUpdateMenuLayout(childView, dataKey, data) {
    $(this.$el.find('.lwwb-navigation')).removeClass(function (index, css) {
      return (css.match(/\blwwb-navigation--\S+/g) || []).join(' ');
    }).addClass('lwwb-navigation--' + data);
  },
  onUpdatePointer: function onUpdatePointer(childView, dataKey, data) {
    $(this.$el.find('.lwwb-navigation')).removeClass(function (index, css) {
      return (css.match(/\blwwb-pointer--\S+/g) || []).join(' ');
    }).addClass('lwwb-pointer--' + data);
  },
  onUpdateSticky: function onUpdateSticky(childView, dataKey, data) {
    $(this.$el.find('.navbar')).removeClass(function (index, css) {
      return (css.match(/\bis-fixed-\S+/g) || []).join(' ');
    }).addClass(data);
  },
  onUpdateTransparent: function onUpdateTransparent(childView, dataKey, data) {
    if ('is-transparent' === data) {
      $(this.$el.find('.navbar')).removeClass('none').addClass('is-transparent');
    } else {
      $(this.$el.find('.navbar')).removeClass('is-transparent').addClass('none');
    }
  }
});

},{}],18:[function(require,module,exports){
"use strict";

lwwb.Builder.Mn.Behaviors['parent-elmn'] = Marionette.Behavior.extend({
  onRender: function onRender() {
    var self = this;
    var elmnIndex = this.view.model.collection.findIndex(this.view.model);

    if (0 === elmnIndex) {
      if (self.view.getUI('up').length) {
        self.view.getUI('up').hide();
      }
    }

    if (self.view.model.collection.size() - 1 === elmnIndex) {
      if (self.view.getUI('down').length) {
        self.view.getUI('down').hide();
      }
    }

    self.view.renderShapeTop();
    self.view.renderShapeBottom();
  }
});
lwwb.Builder.Mn.Views['parent-elmn'] = lwwb.Builder.Mn.Views['elmn'].extend({
  initialize: function initialize() {
    var self = this;
    this.listenTo(lwwb.Radio.channel, 'move:elmn:by:model:cid', function (parentCid, childView, prevCid, nextCid) {
      var prCid = self.$el.data('model-cid');
      var childRegion = self.getRegion('childRegion');

      if (!childRegion) {
        return;
      }

      var childRegionView = childRegion.currentView;

      if (prCid === parentCid) {
        if ('undefined' !== typeof childRegionView) {
          childRegionView.onAddElmnByModelCid(childView, prevCid, nextCid);
        } else {
          var currentChilds = self.model.get('elmn_child');

          if (_.isEmpty(currentChilds)) {
            currentChilds.push(childView.model.clone().toJSON());
            self.model.set('elmn_child', currentChilds);
            self.trigger('update:elmn', self);
            childView.trigger('remove:elmn', childView);
            self.render();
          }
        }
      }
    });
  },
  getTemplate: function getTemplate() {
    var eType = this.model.get('elmn_type');
    var elmnTmpl = $(window.parent.document).find('#tmpl-lwwb-elmn-' + eType + '-content');
    var elmnTmplHtml = elmnTmpl.length > 0 && elmnTmpl.html().trim() !== '' ? elmnTmpl.html() : '';
    var tmpl = [elmnTmplHtml].join('');
    return _.template(tmpl, lwwb.Builder.Mn.templateSettings);
  },
  onUpElmn: function onUpElmn() {
    this.trigger('move:up', this);
  },
  onDownElmn: function onDownElmn() {
    this.trigger('move:down', this);
  },
  _getBehaviors: function _getBehaviors() {
    return ['sortable'];
  },
  childViewTriggers: {
    'update:collection': 'child:update:collection',
    'empty': 'child:empty'
  },
  onChildEmpty: function onChildEmpty() {
    this.render();
  },
  triggers: {
    'sort:elmn:by:model:cid': 'sort:elmn:by:model:cid'
  },
  onChildUpdateCollection: function onChildUpdateCollection(childView) {
    this.model.set('elmn_child', childView.collection.toJSON());
    this.trigger('update:elmn', this);
  },
  regions: {
    childRegion: {
      el: '.ui-sortable'
    }
  },
  onUpdateShapeTopSwitch: function onUpdateShapeTopSwitch(childView, dataKey, data) {
    this.renderShapeTop();
  },
  onUpdateShapeTop: function onUpdateShapeTop(childView, dataKey, data) {
    this.renderShapeTop();
  },
  onUpdateShapeBottomSwitch: function onUpdateShapeBottomSwitch(childView, dataKey, data) {
    this.renderShapeBottom();
  },
  onUpdateShapeBottom: function onUpdateShapeBottom(childView, dataKey, data) {
    this.renderShapeBottom();
  },
  renderShapeTop: function renderShapeTop() {
    var self = this;
    var sectionData = this.model.get('elmn_data');

    if (sectionData.shape_top_switch === 'yes' && sectionData.shape_top) {
      var shapeUrl = _lwwbData.config.assetsUrl + '/shapes/' + sectionData.shape_top + '.svg';
      $.get(shapeUrl, function (data) {
        self.$el.find('.lwwb-elmn-shape-top').html(data.childNodes[0]);
      });
    } else {
      self.$el.find('.lwwb-elmn-shape-top').html('');
    }
  },
  renderShapeBottom: function renderShapeBottom() {
    var self = this;
    var sectionData = this.model.get('elmn_data');

    if (sectionData.shape_bottom_switch === 'yes' && sectionData.shape_bottom) {
      var shapeUrl = _lwwbData.config.assetsUrl + '/shapes/' + sectionData.shape_bottom + '.svg';
      $.get(shapeUrl, function (data) {
        self.$el.find('.lwwb-elmn-shape-bottom').html(data.childNodes[0]);
      });
    } else {
      self.$el.find('.lwwb-elmn-shape-bottom').html('');
    }
  }
});

},{}],19:[function(require,module,exports){
"use strict";

lwwb.Builder.Mn.Behaviors['section'] = Marionette.Behavior.extend({
  ui: {
    toggleSectionHelper: '.lwwb-elmn-add',
    sectionPreset: '.lwwb-preset-item'
  },
  triggers: {
    'click @ui.toggleSectionHelper': 'toggle:section:helper',
    'click @ui.sectionPreset': 'add:section:preset'
  },
  onToggleSectionHelper: function onToggleSectionHelper() {
    this.view.showHelperView = !this.view.showHelperView;
    this.view.render();
  },
  onAddSectionPreset: function onAddSectionPreset(view, event) {
    var sectionPreset = lwwb.Builder.HelperFn.sectionPresets;
    var preset = $(event.currentTarget).data('section_preset');

    if (preset) {
      var model = new Backbone.Model(lwwb.Builder.HelperFn.getSectionPresets(sectionPreset[preset]));
      this.view.trigger('add:elmn', this.view, model, 'after');
    }

    this.onToggleSectionHelper();
  }
});
lwwb.Builder.Mn.Views['section'] = lwwb.Builder.Mn.Views['parent-elmn'].extend({
  el: function el() {
    var tmpl = [],
        eType = '',
        eID = void 0,
        cID = void 0,
        elmnData = void 0,
        isInner = void 0;

    if ('undefined' !== typeof this.model) {
      eType = this.model.get('elmn_type');
      elmnData = this.model.get('elmn_data');
      isInner = elmnData['is_inner'] ? 'is_inner' : '';
      eID = this.model.get('elmn_id');
      cID = this.model.cid;
      tmpl = ['<section' + ' class="lwwb-elmn lwwb-elmn-' + eID + ' lwwb-elmn-section' + ' section ' + isInner + '" ', 'data-model-cid="' + cID + '"', 'data-elmn_type="section"></section>'];
    }

    return tmpl.join('');
  },
  getTemplate: function getTemplate() {
    var elmnTmpl = $(window.parent.document).find('#tmpl-lwwb-elmn-section-content');
    var sectionPreset = $(window.parent.document).find('#tmpl-lwwb-elmn-section-preset-content');
    var elmnTmplHtml = elmnTmpl.length > 0 && elmnTmpl.html().trim() !== '' ? elmnTmpl.html() : '';
    var tmpl = [elmnTmplHtml, this.showHelperView ? sectionPreset.html().trim() : ''].join('');
    return _.template(tmpl, lwwb.Builder.Mn['templateSettings']);
  },
  _getBehaviors: function _getBehaviors() {
    return ['elmn', 'parent-elmn', 'sortable'];
  },
  onRender: function onRender() {
    var self = this,
        childs = this.model.get('elmn_child');

    if (childs.length < 1) {
      var column = lwwb.Builder.HelperFn.getDefaultElmn('column');
      childs.push(column);
      this.model.set('elmn_child', childs);
    }

    this.showChildView('childRegion', new lwwb.Builder.Mn.Views['elmn-collection']({
      el: this.$el.find('.ui-sortable'),
      collection: new Backbone.Collection(childs)
    }));
  },
  onUpdateContainerWidth: function onUpdateContainerWidth(childView, dataKey, data) {
    var self = this;
    var elmnData = this.model.get('elmn_data');
    var $containerEl = self.$el.find('.container');

    if ($containerEl.length) {
      if (elmnData['in_container'] === 'yes') {
        self.removeContainerWidth();
        $containerEl.addClass(data);
      } else {
        self.render();
      }
    }
  },
  onUpdateInContainer: function onUpdateInContainer(childView, dataKey, data) {
    this.render();
  },
  onUpdateSectionHeight: function onUpdateSectionHeight(childView, dataKey, data) {
    var $contentEl = this.$el.find('>.lwwb-elmn-content');
    $contentEl = $contentEl.length ? $contentEl : this.$el.find('>.container > .lwwb-elmn-content');

    if ('hero is-fullheight' === data) {
      $contentEl.addClass('hero is-fullheight');
    } else {
      $contentEl.removeClass('hero is-fullheight');
    }
  },
  removeContainerWidth: function removeContainerWidth() {
    var self = this;
    var containerClasses = ['is-fluid', 'is-widescreen', 'is-fullhd'];
    var $containerEl = self.$el.find('.container');

    _.each(containerClasses, function (classWidth) {
      $containerEl.removeClass(classWidth);
    });
  }
});

},{}],20:[function(require,module,exports){
"use strict";

lwwb.Builder.Mn.Views['text'] = lwwb.Builder.Mn.Views['elmn'].extend({
  onRender: function onRender() {
    var self = this;
    var eData = this.model.get('elmn_data');

    if (eData['content']) {
      this.updateAjaxContent(eData['content']);
    }
  },
  onUpdateContent: function onUpdateContent(childView, dataKey, content) {
    this.updateAjaxContent(content);
  },
  updateAjaxContent: function updateAjaxContent(content) {
    var self = this;

    if (-1 === content.indexOf(']') && -1 === content.indexOf(']')) {
      self.$el.find('.lwwb-elmn-content').html(content);
      return;
    }

    $.ajax({
      type: "post",
      url: _lwwbData.config.ajaxUrl,
      data: {
        action: 'get_content_via_ajax',
        content: content
      },
      success: function success(data) {
        self.$el.find('.lwwb-elmn-content').html(data);
      }
    });
  }
});

},{}],21:[function(require,module,exports){
"use strict";

lwwb.Builder.Mn.Views['video'] = lwwb.Builder.Mn.Views['elmn'].extend({
  onRender: function onRender() {
    this.renderVideo();
    this.renderOverlay();
    this.renderLightbox();
    this.renderPlayIcon();
  },
  renderVideo: function renderVideo() {
    var eData = this.model.get('elmn_data');
    var sourceType = eData['source_type'];
    var linkVideo = eData[sourceType + '_link'];

    if (!linkVideo) {
      this.$el.find('.lwwb-video-wrapper').html('<div class="lwwb-image-placeholder"><i class="fa fa-2x fa-video-camera" aria-hidden="true"></i></div>');
    } else {
      this.renderVideoAjax(linkVideo);
    }
  },
  renderOverlay: function renderOverlay() {
    var eData = this.model.get('elmn_data');
    var $bgOverlayEl = this.$el.find('.lwwb-video-bg-overlay');

    if ('yes' !== eData['image_overlay_switch']) {
      $bgOverlayEl.hide();
    } else {
      $bgOverlayEl.show();

      if (!eData['bg_overlay_img']['url']) {
        $bgOverlayEl.css('background-color', '#dedede');
      }
    }
  },
  renderLightbox: function renderLightbox() {
    var eData = this.model.get('elmn_data');
    var $btnPlay = this.$el.find('.lwwb-play-icon');
    var $bgover = this.$el.find('.lwwb-video-bg-overlay');
    var self = this;

    if ('yes' === eData['video_lightbox']) {
      self.showVideoLightbox();
    } else {
      $(document).on('click', $btnPlay, function (e) {
        $('.lwwb-video-bg-overlay').hide();
        e.preventDefault();
      });
      $bgover.on('click', function (e) {
        $('.lwwb-video-bg-overlay').hide();
        e.preventDefault();
      });
    }
  },
  renderPlayIcon: function renderPlayIcon() {
    var eData = this.model.get('elmn_data');
    var $playIconEl = this.$el.find('.lwwb-play-icon');

    if ('yes' === eData['switch_play_icon']) {
      $playIconEl.show();
    } else {
      $playIconEl.hide();
    }
  },
  onUpdateSourceType: function onUpdateSourceType(childView, dataKey, data) {
    this.renderVideo();
  },
  onUpdateYoutubeLink: function onUpdateYoutubeLink(childView, dataKey, data) {
    if (data) {
      this.renderVideoAjax(data);
    }
  },
  onUpdateVimeoLink: function onUpdateVimeoLink(childView, dataKey, data) {
    if (data) {
      this.renderVideoAjax(data);
    }
  },
  onUpdateDailymotionLink: function onUpdateDailymotionLink(childView, dataKey, data) {
    if (data) {
      this.renderVideoAjax(data);
    }
  },
  onUpdateImageOverlaySwitch: function onUpdateImageOverlaySwitch(childView, dataKey, data) {
    this.renderOverlay();
  },
  onUpdateSwitchPlayIcon: function onUpdateSwitchPlayIcon(childView, dataKey, data) {
    this.renderPlayIcon();
  },
  onUpdateVideoLightbox: function onUpdateVideoLightbox(childView, dataKey, data) {
    this.render();
    this.renderLightbox();
  },
  showVideoLightbox: function showVideoLightbox() {
    var self = this;
    var $btnPlay = this.$el.find('.show-lightbox');
    var eData = this.model.get('elmn_data');
    var sourceType = eData['source_type'];
    var linkVideo = eData[sourceType + '_link'];
    $btnPlay.magnificPopup({
      items: {
        src: linkVideo
      },
      type: 'iframe',
      iframe: {
        markup: '<div class="mfp-iframe-scaler">' + '<div class="mfp-close"></div>' + '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>' + '</div>',
        patterns: {
          youtube: {
            index: 'youtube.com/',
            // String that detects type of video (in this case YouTube). Simply via url.indexOf(index).
            id: 'v=',
            // String that splits URL in a two parts, second part should be %id%
            // Or null - full URL will be returned
            // Or a function that should return %id%, for example:
            // id: function(url) { return 'parsed id'; }
            src: '//www.youtube.com/embed/%id%?autoplay=1' // URL that will be set as a source for iframe.

          },
          vimeo: {
            index: 'vimeo.com/',
            id: '/',
            src: '//player.vimeo.com/video/%id%?autoplay=1'
          },
          dailymotion: {
            index: 'dailymotion.com',
            id: function id(url) {
              var m = url.match(/^.+dailymotion.com\/(video|hub)\/([^_]+)[^#]*(#video=([^_&]+))?/);

              if (m !== null) {
                if (m[4] !== undefined) {
                  return m[4];
                }

                return m[2];
              }

              return null;
            },
            src: 'https://www.dailymotion.com/embed/video/%id%'
          }
        },
        srcAction: 'iframe_src'
      },
      midClick: true,
      callbacks: {
        close: function close() {
          self.renderOverlay();
          self.renderPlayIcon();
        }
      }
    });
  },
  renderVideoAjax: function renderVideoAjax(linkVideo) {
    var self = this;
    $.ajax({
      type: "post",
      url: _lwwbData.config.ajaxUrl,
      data: {
        action: 'get_video_via_ajax',
        link: linkVideo
      },
      success: function success(res) {
        if (res.success) {
          self.$el.find('.lwwb-video-wrapper').html(res.html);
        }
      }
    });
  }
});

},{}],22:[function(require,module,exports){
"use strict";

lwwb.Builder.Mn.Views['wp_menu'] = lwwb.Builder.Mn.Views['elmn'].extend({
  onRender: function onRender() {
    var eData = this.model.get('elmn_data');

    if (eData['menu_id']) {
      this.getMenuAjax(eData['menu_id']);
    }
  },
  getMenuAjax: function getMenuAjax(data) {
    var self = this;
    $.ajax({
      type: "post",
      url: _lwwbData.config.ajaxUrl,
      data: {
        action: 'get_wp_menu_html_via_ajax',
        id: data
      },
      success: function success(data) {
        if (data.success) {
          self.$el.find('.lwwb-wp-navigation').html(data.html);
        } else {
          self.$el.find('.lwwb-wp-navigation').html('<div class="lwwb-empty-image"></div>');
        }
      }
    });
  },
  onUpdateMenuId: function onUpdateMenuId(childView, dataKey, data) {
    this.getMenuAjax(data);
  },
  onUpdateTitle: function onUpdateTitle(childView, dataKey, data) {
    this.render();
  }
});

},{}],23:[function(require,module,exports){
"use strict";

require("./elmns/elmn");

require("./elmns/parent-elmn");

require("./elmns/section");

require("./elmns/column");

require("./elmns/elmn-collection");

require("./elmns/block");

require("./elmns/wp_menu");

require("./elmns/menu");

require("./elmns/image");

require("./elmns/text");

require("./elmns/heading");

require("./elmns/video");

require("./elmns/accordion");

require("./elmns/icon");

require("./elmns/google_map");

require("./elmns/button");

var WebsiteBuilderView = Marionette.View.extend({
  getTemplate: function getTemplate() {
    return _.template('');
  },
  initialize: function initialize(options) {
    this.hooks = options.hooks;
  },
  onRender: function onRender() {
    var self = this;

    _.each(this.collection.models, function (blockModel) {
      var hook = blockModel.get('elmn_type');

      if (_.contains(self.hooks, hook)) {
        self.showRegion(blockModel, hook);
      }
    });
  },
  showRegion: function showRegion(blockModel, hook) {
    if (this.getRegion(hook)) {
      this.showChildView(hook, new lwwb.Builder.Mn.Views['block']({
        model: blockModel
      }));
    }
  },
  childViewTriggers: {
    'update:elmn': 'child:update:elmn'
  },
  onChildUpdateElmn: function onChildUpdateElmn() {
    this.trigger('update:region:data', this);
  }
});
module.exports = {
  LWWB: WebsiteBuilderView
};

},{"./elmns/accordion":2,"./elmns/block":7,"./elmns/button":8,"./elmns/column":9,"./elmns/elmn":11,"./elmns/elmn-collection":10,"./elmns/google_map":12,"./elmns/heading":13,"./elmns/icon":15,"./elmns/image":16,"./elmns/menu":17,"./elmns/parent-elmn":18,"./elmns/section":19,"./elmns/text":20,"./elmns/video":21,"./elmns/wp_menu":22}]},{},[1]);
