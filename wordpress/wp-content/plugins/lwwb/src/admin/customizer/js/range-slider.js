wp.customize.controlConstructor['lwwb-range-slider'] = wp.customize.Control.extend({
	get_number: function (selector, name) {
		return parseInt($(selector).attr(name));
	},
	ready: function () {
		'use strict';

		var control = this;

		var slider = $(this.container).find('.slider-range');
		var min = this.get_number(slider, 'min');
		var max = this.get_number(slider, 'max');
		var from = this.get_number(slider, 'from');
		var to = this.get_number(slider, 'to');
		var step = this.get_number(slider, 'step');



		$(slider).ionRangeSlider({
			type: "double",
			min: min,
			max: max,
			from: from,
			to:to,
			step: step,
			postfix: "col",

		});

		$(slider).on("change keyup", function (e) {
			e.preventDefault();
			var $this = $(this),
				value = [],
				from = $this.data("from"),
				to = $this.data("to");
			value.push(from);
			value.push(to);
			control.setting.set(value);
		});
		$(slider).on('click',function () {
			return false;
		});

	}

});