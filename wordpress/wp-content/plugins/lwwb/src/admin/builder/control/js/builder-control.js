import BuilderControlView from './view.new';
(function(api) {
    let previewerIframe,
        builderControls;
    api.bind('ready', function() {
        api.previewer.bind('ready', function(previewData) {
            api.previewer.send('lwwb_config', _lwwbConfig);
            previewerIframe = $('#customize-preview iframe').get($('#customize-preview iframe').length - 1).contentWindow;
            api.section('lwwb_section').expand(true);
            var builderView = new BuilderControlView({
                el: '#lwwb-control-container',
                radioChannel: previewerIframe.lwwb.Radio.channel,
            });
            builderView.render();
        });
        builderControls = {
            current_page: [],
            elmn_picker: [],
            elmn: [],
            global_setting: [],
        };
        api.previewer.bind('preview_data', function(previewData) {
            setupBuilder(previewData);
            setupCurrentPageControl(previewData);
            setupElmnPickerControl(previewData);
        });
        setupActiveControl();

        api.previewer.bind('active_group_control', function(groupControl) {
            api.control('setting_switcher').container.find('.lwwb-input[value="'+ groupControl + '"]').trigger('click')
        });


    });
    let setupActiveControl = function() {
        api.control('setting_switcher').container.on('click', '.lwwb-input', function(event) {
            let groupControl = $(event.currentTarget).val();
            activeGroupControls(groupControl);
        });
    }
    let activeGroupControls = function(groupControl) {
        let unActiveControls = _.clone(builderControls);
        delete unActiveControls[groupControl];
        _.each(unActiveControls, function(controls, group) {
            deactiveGroupControls(controls)
        })
        _.each(builderControls[groupControl], function(control, index) {
            if (control.active()) {
                return;
            }
            control.active(true);
        })
    }
    let deactiveGroupControls = function(groupControls) {
        _.each(groupControls, function(control) {
            control.active(false);
        })
    }
    let setupBuilder = function(previewData) {
        const Setting = api.Setting.extend({});
        let settingID = 'lwwb_data[' + previewData.page.id + '][data]';
        let _setting = api(settingID);
        if (!_setting) {
            let data;
            _setting = new Setting(settingID, data, {
                transport: 'postMessage',
                previewer: api.previewer,
                dirty: true
            });
            api.add(settingID, _setting);
        }
        let elmnBuilderControl = api.control('lwwb_build_panel');
        if (elmnBuilderControl && !builderControls.elmn.length) {
            builderControls.elmn.push(elmnBuilderControl);
        }
        api.previewer.bind('collection_data' + previewData.page.id, function(dataBuilder) {
            let _configData = {
                header: previewData.header.id,
                footer: previewData.footer.id,
                content: dataBuilder
            };
            _setting.set(JSON.stringify(_configData));
        });
    }
    let setupCurrentPageControl = function(previewData) {
        const Setting = api.Setting.extend({});
        let headerSettingID = 'lwwb_data[' + previewData.page.id + '][header]';
        let footerSettingID = 'lwwb_data[' + previewData.page.id + '][footer]';
        let hooksID = 'lwwb_data[' + previewData.page.id + '][hooks]';
        let headerSetting = api(headerSettingID);
        let footerSetting = api(footerSettingID);
        let hooksSetting = api(hooksID);

        // Header Settings

        if (!headerSetting) {
            headerSetting = new Setting(headerSettingID, previewData.header.id, {
                transport: 'refresh',
                default: '',
                previewer: wp.customize.previewer,
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
        }
        // Footer Settings

        if (!footerSetting) {
            footerSetting = new Setting(footerSettingID, previewData.footer.id, {
                transport: 'refresh',
                default: '',
                previewer: api.previewer,
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
        }
        // Builder Hooks

        if (!hooksSetting) {
            hooksSetting = new Setting(hooksID, previewData.hooks, {
                transport: 'refresh',
                default: previewData.hooks,
                multi: true,
                previewer: api.previewer,
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
                active: false,
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

    }
    let isActiveCurrentPageControl = function() {
        let currentPageCheck = api.control('setting_switcher').container.find('.lwwb-input[value="current_page"]');
        return currentPageCheck.prop("checked");
    }
    let setupElmnPickerControl = function(previewData) {
        if (isActiveCurrentPageControl()) {
            deactiveGroupControls(builderControls.elmn_picker);
            return;
        }
        if (builderControls.elmn_picker.length) {
            return;
        }
        _.each(previewData.config.elmnGroups, function(val, key) {
            if (api.control(key)) {
                builderControls.elmn_picker.push(api.control(key))
            };
        })
    }
})(wp.customize);