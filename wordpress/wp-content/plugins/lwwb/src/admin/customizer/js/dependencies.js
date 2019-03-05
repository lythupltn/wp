(function (api) {
	api.bind('ready', function () {
		api.previewer.bind('ready', function () {
			var operators = {
			    '==': function(a, b) { return a == b },
			    '===': function(a, b) { return a === b },
				'!==': function(a, b) { return a !== b },
				'<': function(a, b) { return a < b },
			    '>': function(a, b) { return a > b },
			    '<=': function(a, b) { return a <= b },
			    '<=': function(a, b) { return a <= b },
			    '>=': function(a, b) { return a >= b },
			    '+': function(a, b) { return a + b },
			    '-': function(a, b) { return a - b },
			    '*': function(a, b) { return a * b },
			    '/': function(a, b) { return a / b },
			    '%': function(a, b) { return a % b },
			};
			api.control.each( function ( control ) { 
				if (control.params.dependencies) {

					var is_active = check_active(control.params.dependencies, control);
					control.active.set(is_active);

					_.each(control.params.dependencies, function(dependency, index) {
						api.control(dependency.control).container.on('change', 'input, select, textarea', function(event) {
							event.preventDefault();
							var depend_value = $(this).val();
							var is_active = operators[dependency.operator](depend_value, dependency.value) ? true : false ; 
							var other_control_dependencies = _.filter(control.params.dependencies, function(d) {
								return d.control !== dependency.control
							})							
								is_active = is_active && check_active(other_control_dependencies, control);
								control.active(is_active);
						});
		
					});

				}

				function check_active (dependencies, dependency) {
					var is_active = true;
					var check_active = true;
					_.each(dependencies, function(dependency, index) {
						check_active = operators[dependency.operator](api.control(dependency.control).setting.get(), dependency.value)? true : false; 
						is_active = is_active && check_active;
					});
					return is_active;
				}

			});
		});
	});

})(wp.customize);