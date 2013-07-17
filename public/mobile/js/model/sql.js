/*global Class*/
/*global console*/
/*global localStorage*/
var checkKey = function(key){
	if(localStorage && (localStorage.getItem(key) != undefined && localStorage.getItem(key) != null) ){
      	return true;
     }
     else
     {
     	return false;
     }
};
var TableConfiguration = Class.extend({
  check: function(){
  	if(checkKey("cfg")){
      	return true;
      }
      else
      {
      	return false;
      }      
  },
  findAll: function(){     
      if(this.check()){
      	return JSON.parse(localStorage.getItem("cfg"));
      }
      else
      {
      	return false;
      }         
    },
    findValueByKey: function(key){
    	if(this.check()){
	      	if(localStorage.getItem("cfg")[key] != null && localStorage.getItem("cfg")[key] != undefined){
	      		all = this.findAll();
	      		if(all[key] != undefined && all[key] != null){
	      			return all[key];
	      		}
	      		else
	      		{
	      			return false;
	      		}
	      	}
	      	else
	      	{
	      		return false;
	      	}
      	}
      	else
      	{
      		return false;
      	}  
    },
    insert: function(key, value){
    	if(this.check()){
    		all = this.findAll();
    		all[key] = value;
    		localStorage.setItem("cfg", JSON.stringify(all));
    	}
    	else
    	{
    		return false;
    	}
    },
    remove: function(key){
    	if(this.check()){
    		all = this.findAll();
    		delete all[key];
    		localStorage.setItem("cfg", JSON.stringify(all));
    	}
    	else
    	{
    		return false;
    	}
    },
    updateValue: function(key, value){
    	if(this.check()){
    		all = this.findAll();
    		all[key] = value;
    		localStorage.setItem("cfg", JSON.stringify(all));
    	}
    	else
    	{
    		return false;
    	}
    }


});


var TableProducts = Class.extend({
  check: function(){
  	if(checkKey("productsList")){
      	return true;
      }
      else
      {
      	return false;
      }      
  },
  findAll: function(){     
      if(this.check()){
      	return JSON.parse(localStorage.getItem("productsList"));
      }
      else
      {
      	return false;
      }         
   },
   insertAll: function(listObject){
    	if(this.check()){
    		all = listObject;
    		localStorage.setItem("productsList", JSON.stringify(all));
    	}
    	else
    	{
    		return false;
    	}
    },
    deleteAll: function(){
    	all = {};
    	localStorage.setItem("productsList", JSON.stringify(all));
    }
});