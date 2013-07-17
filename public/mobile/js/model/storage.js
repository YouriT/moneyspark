/*global Class*/
/*global console*/
/*global localStorage*/
var WebStorage = Class.extend({
	keyExists: function () {
		if (! this.storageAvailable()) {
			return false;
		}

		var val = localStorage.getItem(this.storageName);
		if (val != undefined && val != null) {
			return true;
		}
		return false;
	},
	storageAvailable: function () {
		if (localStorage) {
			return true;
		}
		return false;
	},
    updateValue: function(key, value){
    	this.insert(key, value);
    }
});
var TableConfiguration = WebStorage.extend({
	storageName: 'cfg',
	findAll: function(){     
		if(this.keyExists()){
			return JSON.parse(localStorage.getItem(this.storageName));
		}
		return false;
	},
    findValueByKey: function(key){
    	if(this.keyExists()) {
			var all = this.findAll();
			if(all[key] != undefined && all[key] != null){
				return all[key];
			}
		}
		return false;
    },
    insert: function(key, value){
    	if(this.storageAvailable()) {
    		var all = this.findAll();
    		if (all == false) {
	    		all = {};
	    	}
    		all[key] = value;
    		localStorage.setItem(this.storageName, JSON.stringify(all));
    		return true;
    	}
		return false;
    },
    remove: function(key){
    	if(this.keyExists()){
    		all = this.findAll();
    		delete all[key];
    		localStorage.setItem(this.storageName, JSON.stringify(all));
    		return true;
    	}
    	return false;
    }
});


var TableProducts = WebStorage.extend({
	storageName: 'productsList',
	findAll: function(){     
		if(this.keyExists()){
			return JSON.parse(localStorage.getItem(this.storageName));
		}
		return false;
	},
	insertAll: function(listObject){
		if(this.storageAvailable()){
			localStorage.setItem(this.storageName, JSON.stringify(listObject));
			return true;
		}
		return false;
	},
	truncate: function(){
		all = {};
		localStorage.setItem(this.storageName, JSON.stringify(all));
		return true;
	}
});


var TableInvestments = WebStorage.extend({
	storageName: 'investmentsList',
	findAll: function(){     
		if(this.keyExists()){
			return JSON.parse(localStorage.getItem(this.storageName));
		}
		return false;
	},
	insertAll: function(listObject){
		if(this.storageAvailable()){
			localStorage.setItem(this.storageName, JSON.stringify(listObject));
			return true;
		}
		return false;
	},
	truncate: function(){
		all = {};
		localStorage.setItem(this.storageName, JSON.stringify(all));
		return true;
	}
});