var generateGUID = function generateGUID() {
    function s4() {
        return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
    }
    return s4() + s4() + s4() + s4();
}

var getDefaultElmnData = function getDefaultElmnData(elmn_type = 'section'){
	let data = {};
	switch(elmn_type){
		case 'section':
		break;
		case 'column':
		break;
		case 'image':
			_.extend(data, {
				image:{
					image_url: 'https://www.google.com.vn/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png',
					image_repeat: '',
					image_position: '',
					image_size: '',
					image_attachment: '',
				}
			})
		break;
		case 'video':
			_.extend(data, {

			})
		break;
		case 'text':
			_.extend(data, {

			})

		break;
		default: 
		break;

	}

	return data;
}

var getDefaultElmn = function getDefaultElmn(elmn_type = 'section') {
	if (! window.parent._lwwbConfig.elmns[elmn_type]) {
		return false;
	}
	let data = {};
	let defaultData = window.parent._lwwbConfig.elmns[elmn_type].default;
	data = _.extend(data,JSON.parse(JSON.stringify(defaultData)) );
	if (Array.isArray(data) && data.length === 0) {
		data = {};
	}
	let elmn =  {
		elmn_id: generateGUID(),
		elmn_type: elmn_type,
		elmn_child: [],
		elmn_data: data,
	}

	return elmn;
}

var getDefaultColumnElmn = function getDefaultColumnElmn(width = 3) {
	let columnElmn = getDefaultElmn('column');
	let columClass = '';
		columClass = 'is-' + width;
		if ('' ===width) {
			columClass = '';
		}
	columnElmn.elmn_data = {
		classes: columClass,
		// width:{},
	}

	return columnElmn;
}

var getDefaultSectionElmn = function getDefaultSectionElmn(columnPreset = [1]) {
	let sectionElmn = getDefaultElmn();
	_.each(columnPreset, function(col) {
		sectionElmn.elmn_child.push(getDefaultColumnElmn(col));
	})
	return sectionElmn;
}

var sectionPresets = {
	_12:[12],
	_2_cols:[6,6],
	_3_cols: [4,4,4],
	_4_cols: [3,3,3,3],
	_5_cols: ['','','','','',],
	_6_cols: [2,2,2,2,2,2],
	_2_4_6: [2,4,6],
	_2_8_2: [2,8,2],
	_2_4_4_2: [2,4,4,2],
	_2_6_2_2: [2,6,2,2],
	_3_2_7: [3,2,7],
	_3_4_5: [3,4,5],
	_3_5_4: [3,5,4],
	_3_6_3: [3,6,3],
	_6_3_3: [6,3,3],
	_3_7_2: [3,7,2],
	_3_9: [3,9],
	_3_3_6: [3,3,6],
	_4_8: [4,8],
	_4_6_2: [4,6,2],
	_4_5_3: [4,5,3],
	_4_3_5: [4,3,5],
	_4_2_6: [4,2,6],
	_5_7: [5,7],
	_8_4: [8,4],
	
};
	

var getSectionPresets = function getSectionPresets(preset) {
	return getDefaultSectionElmn(preset)
}

var cloneRecursiveElmn = function cloneRecursiveElmn(elmnData) {
	let cloneData = JSON.parse(JSON.stringify(elmnData));
	cloneData.elmn_id = generateGUID();
	cloneData.elmn_child = _.map(elmnData.elmn_child, function(childData) {
		return cloneRecursiveElmn(JSON.parse(JSON.stringify(childData)))
	});
	return cloneData;
}

module.exports = {
	generateElmnID: generateGUID,
	getDefaultElmn: getDefaultElmn,
	sectionPresets: sectionPresets,
	getSectionPresets: getSectionPresets,
	cloneRecursiveElmn: cloneRecursiveElmn,
}

