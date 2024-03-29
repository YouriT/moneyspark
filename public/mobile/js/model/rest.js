//Global variables
var TableConfiguration = c = new TableConfiguration();
var TableInvestments = i = new TableInvestments();
var p = new TableProducts();
function SERVER_HTTP_HOST(replace){
	if(replace == undefined)
		replace = false;  
    var serverName = document.location.hostname; 
    serverName = 'http://'+serverName+"/";
    if(replace)  
    	serverName = serverName.replace("m.", "api.");
    return serverName;  
}  
var Ajax = Class.extend({
  currentRetry:0,
  init: function(urlRequest, successCallBack, params, typeRequest, apiKey){
    aj = this;
    if(params == undefined || params == "")
        params = {};
    if(typeRequest == undefined || typeRequest == "GET"){
        typeRequest = "GET";
        contentType = "application/json; charset=utf-8"
    }
    else if(typeRequest == "POST"){
        contentType = "application/x-www-form-urlencoded; charset=UTF-8";
    }
    function ajaxMe() {
        if (apiKey !== undefined) {
            $.ajaxSetup({
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('api-key',apiKey);
                }
            });
        }
        $.ajax({
            type: typeRequest,
            data: params,
            url: SERVER_HTTP_HOST(true)+urlRequest,
            dataType: 'json',
            contentType: contentType,
            crossDomain: true,
            success: function(r){ 
                if(r.error != undefined  && r.error.code == 1200){ 
                    TableConfiguration.remove("token"); 
                } else{ successCallBack(r); }
            },
            error: function(){
                aj.currentRetry++;
                if(aj.currentRetry == 5){
                    console.log("Request "+urlRequest+" stopped");
                }
                else
                {
                    aj.init(urlRequest, successCallBack, params, typeRequest, apiKey);
                    console.log("Request "+urlRequest+" retried");
                }
                
            }
        });
    }

    if(apiKey === undefined){
        if(TableConfiguration.findValueByKey('token') != false){
        	apiKey = TableConfiguration.findValueByKey('token');
        }
        else{
        	apiKey = "";
        }
        ajaxMe();
    }
    else
        ajaxMe();
    
  }
});

var Auth = Class.extend({
    login:function(emailRequest, passwordRequest, successCallBack, errorCallBack){
        params = {email: emailRequest, password: passwordRequest};
        new Ajax("Auth", function(r){ 
            if(r != undefined && r.token != undefined){
            	TableConfiguration.remove("token");
            	TableConfiguration.insert("token", r.token);
            	$("#page").trigger('askRetrieve', [true]); 
            	successCallBack();
            }
            else
            {
                errorCallBack();
            }
        }, params, 'POST');
    }
});

var Input = Class.extend({
    i:null,
    pwd:null,
    set:function(input){
        this.i = input;
    },
    validate:function(){
        var dateDDMMYYYRegex = /^(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d$/;
        var emailRegex = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
        var phoneNumberRegex = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})([0-9]{3})/;
        if(this.i.is("input[type=text]") && this.i.val()==""){
            return "Please fill in this field";
        }
        if(this.i.is("input[name=terms]") && this.i.val()==0){
            return "notAccepted";
        }
        else if( this.i.attr("name") == "birthDate" && !this.i.val().match(dateDDMMYYYRegex)){
            return "Your birthdate seems to be incorrect";
        }
        else if( this.i.attr("name") == "email" && !this.i.val().match(emailRegex) ){
            return "You email seems to be incorrect";
        }
        else if( this.i.attr("name") == "phone" && !this.i.val().match(phoneNumberRegex) ){
            return "Your phonenumber seems to be incorrect";
        }
        else if( this.i.attr("name") == "password" && this.i.val().length < 6 ){
            return "Your password is too short";
        }
        else if(this.i.attr("name") == "password" && this.i.val().length >= 6){
            this.pwd = this.i.val();
            return "good";
        }
        else if( this.i.attr("name") == "passwordconf" && this.pwd != this.i.val() ){
            return "Please confirm the same password";
        }
        else
            return "good";
    }
});
var Subscribe = Input.extend({
    data:null,
    setData:function(inputs){
        data = inputs;
    },
    send:function(successCallBack, errorCallBack){
        new Ajax("Register", successCallBack, inputs, 'POST');
    }
});
var updateProfile = function (r){
    if(r.firstName != undefined && r.lastName != undefined && r.lockboxAmount != undefined && r.averageRentability != undefined){
	   	c.insert("firstName", r.firstName);
		c.insert("lastName", r.lastName);
		c.insert("lockboxAmount", r.lockboxAmount);
		c.insert("averageRentability", r.averageRentability);	
	    updateLastRetrieving("meGranted");
    }
};
var updateInvestments = function (r){
	if (r.current != undefined || r.notStarted != null || r.ended != null) {
		i.insertAll(r);
		updateLastRetrieving("investmentsGranted");
	}
};
var updateLastRetrieving = function (granted){
    var d = new Date();
    var n = d.getTime();
    c.updateValue("lastRetrieving", n);
    $("#page").trigger(granted);
};
var retrieve = function (event, force) {
    if(force == undefined)
        force = false;
    var d = new Date();
    var n = d.getTime();
    var nw = n-600000;
    v = c.findValueByKey("lastRetrieving");
    tok = c.findValueByKey("token");
    if(v != false){
    	if( (v < nw) || force==true ){
            //Update products
            new Ajax("Product", function(r){
            		p.insertAll(r);
            		updateLastRetrieving("productsGranted")}, function(e){});
           	if(tok != false){ //if token exists, UPDATE investments, profile
           		
           		new Ajax("Profile/me", function(r){ updateProfile(r);});
           		new Ajax("Investment", function(r){ updateInvestments(r);});
           	}
           	//Update Config
           	new Ajax("Config", function(r){
        		if(r.maxFeeRate != undefined){
	            c.insert("maxFeeRate", r.maxFeeRate);
	            c.insert("minFeeRate", r.minFeeRate);
	            updateLastRetrieving("configGranted");
	            }});
        }
        else
        {
        	if(tok != false){
        		updateLastRetrieving("meGranted"); 
        		updateLastRetrieving("investmentsGranted");
        	}
            updateLastRetrieving("productsGranted");
            updateLastRetrieving("configGranted");
        }
    	
    }
    else //if lastRetrieving does not exists
    {
    	//Update only table products, insert lastRetrieving products
        new Ajax("Product", function(r){
            p.insertAll(r);
            updateLastRetrieving("productsGranted");
        });
        
        new Ajax("Config", function(r){
        	if(r.maxFeeRate != undefined){
	            c.insert("maxFeeRate", r.maxFeeRate);
	            c.insert("minFeeRate", r.minFeeRate);
	            updateLastRetrieving("configGranted");
           }
        });
    }    
};