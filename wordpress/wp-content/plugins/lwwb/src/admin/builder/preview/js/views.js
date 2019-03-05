import './elmns/elmn';
import './elmns/parent-elmn';
import './elmns/section';
import './elmns/column';
import './elmns/elmn-collection';
import './elmns/block';
import './elmns/wp_menu';
import './elmns/menu';
import './elmns/image';
import './elmns/text';
import './elmns/heading';
import './elmns/video';
import './elmns/accordion';
import './elmns/icon';
import './elmns/google_map';
import './elmns/button';

var WebsiteBuilderView = Marionette.View.extend({
    getTemplate() {
        return _.template('');
    },
    initialize(options) {
        this.hooks = options.hooks;
    },
    onRender() {
        const self = this;
        _.each(this.collection.models, function(blockModel) {
            let hook = blockModel.get('elmn_type');
            if (_.contains(self.hooks, hook)) {
                self.showRegion(blockModel, hook);
            }
        })
    },
    showRegion(blockModel, hook) {
        if (this.getRegion(hook)) {
            this.showChildView(hook, new lwwb.Builder.Mn.Views['block']({
                model: blockModel,
            }));
        }
    },
    childViewTriggers: {
        'update:elmn': 'child:update:elmn',
    },
    onChildUpdateElmn() {
        this.trigger('update:region:data', this);
    }
});
module.exports = {
    LWWB: WebsiteBuilderView,
}