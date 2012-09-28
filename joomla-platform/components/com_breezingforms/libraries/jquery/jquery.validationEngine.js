/*
 * Inline Form Validation Engine 1.7.3, jQuery plugin
 * 
 * Copyright(c) 2010, Cedric Dugas
 * http://www.position-absolute.com
 *	
 * Form validation engine allowing custom regex rules to be added.
 * Thanks to Francois Duquette and Teddy Limousin 
 * and everyone helping me find bugs on the forum
 * Licenced under the MIT Licence
 */
(function($) {
	
	$.fn.bfvalidationEngine = function(settings) {
		
	if($.bfvalidationEngineLanguage){				// IS THERE A LANGUAGE LOCALISATION ?
		allRules = $.bfvalidationEngineLanguage.allRules;
	}else{
		$.bfvalidationEngine.debug("Validation engine rules are not loaded check your external file");
	}
 	settings = jQuery.extend({
		allrules:allRules,
		validationEventTriggers:"focusout",					
		inlineValidation: true,	
		returnIsValid:false,
		liveEvent:false,
		openDebug: true,
		unbindEngine:true,
		containerOverflow:false,
		containerOverflowDOM:"",
		ajaxSubmit: false,
		scroll:true,
		promptPosition: "topRight",	// OPENNING BOX POSITION, IMPLEMENTED: topLeft, topRight, bottomLeft, centerRight, bottomRight
		success : false,
		beforeSuccess :  function() {},
		failure : function() {}
	}, settings);	
	$.bfvalidationEngine.settings = settings;
	$.bfvalidationEngine.ajaxValidArray = [];	// ARRAY FOR AJAX: VALIDATION MEMORY 
	
	if(settings.inlineValidation === true){ 		// Validating Inline ?
		if(!settings.returnIsValid){					// NEEDED FOR THE SETTING returnIsValid
			// what the hell! orefalo
			//allowReturnIsvalid = false;
			if(settings.liveEvent){						// LIVE event, vast performance improvement over BIND
				$(this).find("[class*=validate]").live(settings.validationEventTriggers,
					function(caller){ 
						if($(caller).attr("type") != "checkbox")
							_inlinEvent(this);
					});
				$(this).find("[class*=validate][type=checkbox]").live("click", function(caller){ _inlinEvent(this); });
			}else{
				$(this).find("[class*=validate]").not("[type=checkbox]").bind(settings.validationEventTriggers, function(caller){ _inlinEvent(this); });
				$(this).find("[class*=validate][type=checkbox]").bind("click", function(caller){ _inlinEvent(this); });
			}
			
			// what the hell orefalo
			//firstvalid = false;
		}
		
		function _inlinEvent(caller){
			$.bfvalidationEngine.settings = settings;
			if($.bfvalidationEngine.intercept === false || !$.bfvalidationEngine.intercept){		// STOP INLINE VALIDATION THIS TIME ONLY
				$.bfvalidationEngine.onSubmitValid=false;
				$.bfvalidationEngine.loadValidation(caller); 
			}else{
				$.bfvalidationEngine.intercept = false;
			}
		}
	}
	if (settings.returnIsValid){		// Do validation and return true or false, it bypass everything;
		if ($.bfvalidationEngine.submitValidation(this,settings)){
			return false;
		}else{
			return true;
		}
	}
	$(this).bind("submit", function(caller){   // ON FORM SUBMIT, CONTROL AJAX FUNCTION IF SPECIFIED ON DOCUMENT READY
		$.bfvalidationEngine.onSubmitValid = true;
		$.bfvalidationEngine.settings = settings;
		if($.bfvalidationEngine.submitValidation(this,settings) === false){
			if($.bfvalidationEngine.submitForm(this,settings) === true)
				return false;
		}else{
			// orefalo: what the hell is that ?
			settings.failure && settings.failure(); 
			return false;
		}		
	});
	$(".formError").live("click",function(){	 // REMOVE BOX ON CLICK
		$(this).fadeOut(150,function(){ $(this).remove(); });
	});
};	
$.bfvalidationEngine = {
	defaultSetting : function(caller) {		// NOT GENERALLY USED, NEEDED FOR THE API, DO NOT TOUCH
		if($.bfvalidationEngineLanguage){				
			allRules = $.bfvalidationEngineLanguage.allRules;
		}else{
			$.bfvalidationEngine.debug("Validation engine rules are not loaded check your external file");
		}	
		settings = {
			allrules:allRules,
			validationEventTriggers:"blur",					
			inlineValidation: true,	
			containerOverflow:false,
			containerOverflowDOM:"",
			returnIsValid:false,
			scroll:true,
			unbindEngine:true,
			ajaxSubmit: false,
			promptPosition: "topRight",	// OPENNING BOX POSITION, IMPLEMENTED: topLeft, topRight, bottomLeft, centerRight, bottomRight
			success : false,
			failure : function() {}
		};	
		$.bfvalidationEngine.settings = settings;
	},
	loadValidation : function(caller) {		// GET VALIDATIONS TO BE EXECUTED
		if(!$.bfvalidationEngine.settings)
			$.bfvalidationEngine.defaultSetting();
		var rulesParsing = $(caller).attr('class');
		var rulesRegExp = /\[(.*)\]/;
		var getRules = rulesRegExp.exec(rulesParsing);
		if(getRules === null)
			return false;
		var str = getRules[1];
		var pattern = /\[|,|\]/;
		var result= str.split(pattern);	
		var validateCalll = $.bfvalidationEngine.validateCall(caller,result);
		return validateCalll;
	},
	validateCall : function(caller,rules) {	// EXECUTE VALIDATION REQUIRED BY THE USER FOR THIS FIELD
		var promptText ="";	
		
		if(!$(caller).attr("id"))
			$.bfvalidationEngine.debug("This field have no ID attribut( name & class displayed): "+$(caller).attr("name")+" "+$(caller).attr("class"));

		// what the hell!
		//caller = caller;
		ajaxValidate = false;
		var callerName = $(caller).attr("name");
		$.bfvalidationEngine.isError = false;
		$.bfvalidationEngine.showTriangle = true;
		var callerType = $(caller).attr("type");

		for (var i=0; i<rules.length;i++){
			switch (rules[i]){
			case "optional": 
				if(!$(caller).val()){
					$.bfvalidationEngine.closePrompt(caller);
					return $.bfvalidationEngine.isError;
				}
			break;
			case "required": 
				_required(caller,rules);
			break;
			case "custom": 
				 _customRegex(caller,rules,i);
			break;
			case "exemptString": 
				 _exemptString(caller,rules,i);
			break;
			case "ajax": 
				if(!$.bfvalidationEngine.onSubmitValid)
					_ajax(caller,rules,i);	
			break;
			case "length": 
				 _length(caller,rules,i);
			break;
			case "maxCheckbox": 
				_maxCheckbox(caller,rules,i);
			 	groupname = $(caller).attr("name");
			 	caller = $("input[name='"+groupname+"']");
			break;
			case "minCheckbox": 
				_minCheckbox(caller,rules,i);
				groupname = $(caller).attr("name");
			 	caller = $("input[name='"+groupname+"']");
			break;
			case "equals": 
				 _equals(caller,rules,i);
			break;
			case "funcCall": 
		     	_funcCall(caller,rules,i);
			break;
			default :
			}
		}
		radioHack();
		if ($.bfvalidationEngine.isError === true){
			var linkTofieldText = "." +$.bfvalidationEngine.linkTofield(caller);
			if(linkTofieldText != "."){
				if(!$(linkTofieldText)[0]){
					$.bfvalidationEngine.buildPrompt(caller,promptText,"error");
				}else{	
					$.bfvalidationEngine.updatePromptText(caller,promptText);
				}	
			}else{
				$.bfvalidationEngine.updatePromptText(caller,promptText);
			}
		}else{
			$.bfvalidationEngine.closePrompt(caller);
		}			
		/* UNFORTUNATE RADIO AND CHECKBOX GROUP HACKS */
		/* As my validation is looping input with id's we need a hack for my validation to understand to group these inputs */
		function radioHack(){
	      if($("input[name='"+callerName+"']").size()> 1 && (callerType == "radio" || callerType == "checkbox")) {        // Hack for radio/checkbox group button, the validation go the first radio/checkbox of the group
	          caller = $("input[name='"+callerName+"'][type!=hidden]:first");     
	          $.bfvalidationEngine.showTriangle = false;
	      }      
	    }
		/* VALIDATION FUNCTIONS */
		function _required(caller,rules){   // VALIDATE BLANK FIELD
			var callerType = $(caller).attr("type");
			if (callerType == "text" || callerType == "password" || callerType == "textarea"){
								
				if(!$(caller).val()){
					$.bfvalidationEngine.isError = true;
					promptText += $.bfvalidationEngine.settings.allrules[rules[i]].alertText+"<br />";
				}	
			}	
			if (callerType == "radio" || callerType == "checkbox" ){
				callerName = $(caller).attr("name");
		
				if($("input[name='"+callerName+"']:checked").size() === 0) {
					$.bfvalidationEngine.isError = true;
					if($("input[name='"+callerName+"']").size() == 1) {
						promptText += $.bfvalidationEngine.settings.allrules[rules[i]].alertTextCheckboxe+"<br />"; 
					}else{
						 promptText += $.bfvalidationEngine.settings.allrules[rules[i]].alertTextCheckboxMultiple+"<br />";
					}	
				}
			}	
			if (callerType == "select-one") { // added by paul@kinetek.net for select boxes, Thank you		
				if(!$(caller).val()) {
					$.bfvalidationEngine.isError = true;
					promptText += $.bfvalidationEngine.settings.allrules[rules[i]].alertText+"<br />";
				}
			}
			if (callerType == "select-multiple") { // added by paul@kinetek.net for select boxes, Thank you	
				if(!$(caller).find("option:selected").val()) {
					$.bfvalidationEngine.isError = true;
					promptText += $.bfvalidationEngine.settings.allrules[rules[i]].alertText+"<br />";
				}
			}
		}
		function _customRegex(caller,rules,position){		 // VALIDATE REGEX RULES
			var customRule = rules[position+1];
			var pattern = eval($.bfvalidationEngine.settings.allrules[customRule].regex);
			
			if(!pattern.test($(caller).attr('value'))){
				$.bfvalidationEngine.isError = true;
				promptText += $.bfvalidationEngine.settings.allrules[customRule].alertText+"<br />";
			}
		}
		function _exemptString(caller,rules,position){		 // VALIDATE REGEX RULES
			var customString = rules[position+1];
			if(customString == $(caller).attr('value')){
				$.bfvalidationEngine.isError = true;
				promptText += $.bfvalidationEngine.settings.allrules['required'].alertText+"<br />";
			}
		}
		
		function _funcCall(caller,rules,position){  		// VALIDATE CUSTOM FUNCTIONS OUTSIDE OF THE ENGINE SCOPE
			var customRule = rules[position+1];
			var funce = $.bfvalidationEngine.settings.allrules[customRule].nname;
			
			var fn = window[funce];
			if (typeof(fn) === 'function'){
				var fn_result = fn();
				if(!fn_result){
					$.bfvalidationEngine.isError = true;
				}
				
				promptText += $.bfvalidationEngine.settings.allrules[customRule].alertText+"<br />";
			}
		}
		function _ajax(caller,rules,position){				 // VALIDATE AJAX RULES
			
			customAjaxRule = rules[position+1];
			postfile = $.bfvalidationEngine.settings.allrules[customAjaxRule].file;
			fieldValue = $(caller).val();
			ajaxCaller = caller;
			fieldId = $(caller).attr("id");
			ajaxValidate = true;
			ajaxisError = $.bfvalidationEngine.isError;
			
			if($.bfvalidationEngine.settings.allrules[customAjaxRule].extraData){
				extraData = $.bfvalidationEngine.settings.allrules[customAjaxRule].extraData;
			}else{
				extraData = "";
			}
			/* AJAX VALIDATION HAS ITS OWN UPDATE AND BUILD UNLIKE OTHER RULES */	
			if(!ajaxisError){
				$.ajax({
				   	type: "POST",
				   	url: postfile,
				   	async: true,
				   	data: "validateValue="+fieldValue+"&validateId="+fieldId+"&validateError="+customAjaxRule+"&extraData="+extraData,
				   	beforeSend: function(){		// BUILD A LOADING PROMPT IF LOAD TEXT EXIST		   			
				   		if($.bfvalidationEngine.settings.allrules[customAjaxRule].alertTextLoad){
				   		
				   			if(!$("div."+fieldId+"formError")[0]){				   				
	 			 				return $.bfvalidationEngine.buildPrompt(ajaxCaller,$.bfvalidationEngine.settings.allrules[customAjaxRule].alertTextLoad,"load");
	 			 			}else{
	 			 				$.bfvalidationEngine.updatePromptText(ajaxCaller,$.bfvalidationEngine.settings.allrules[customAjaxRule].alertTextLoad,"load");
	 			 			}
			   			}
			  	 	},
			  	 	error: function(data,transport){ $.bfvalidationEngine.debug("error in the ajax: "+data.status+" "+transport); },
					success: function(data){					// GET SUCCESS DATA RETURN JSON
						data = eval( "("+data+")");				// GET JSON DATA FROM PHP AND PARSE IT
						ajaxisError = data.jsonValidateReturn[2];
						customAjaxRule = data.jsonValidateReturn[1];
						ajaxCaller = $("#"+data.jsonValidateReturn[0])[0];
						fieldId = ajaxCaller;
						ajaxErrorLength = $.bfvalidationEngine.ajaxValidArray.length;
						existInarray = false;
						
			 			 if(ajaxisError == "false"){			// DATA FALSE UPDATE PROMPT WITH ERROR;
			 			 	
			 			 	_checkInArray(false);				// Check if ajax validation alreay used on this field
			 			 	
			 			 	if(!existInarray){		 			// Add ajax error to stop submit		 		
				 			 	$.bfvalidationEngine.ajaxValidArray[ajaxErrorLength] =  new Array(2);
				 			 	$.bfvalidationEngine.ajaxValidArray[ajaxErrorLength][0] = fieldId;
				 			 	$.bfvalidationEngine.ajaxValidArray[ajaxErrorLength][1] = false;
				 			 	existInarray = false;
			 			 	}
				
			 			 	$.bfvalidationEngine.ajaxValid = false;
							promptText += $.bfvalidationEngine.settings.allrules[customAjaxRule].alertText+"<br />";
							$.bfvalidationEngine.updatePromptText(ajaxCaller,promptText,"",true);				
						 }else{	 
						 	_checkInArray(true);
						 	$.bfvalidationEngine.ajaxValid = true; 			
						 	if(!customAjaxRule)	{
						 		$.bfvalidationEngine.debug("wrong ajax response, are you on a server or in xampp? if not delete de ajax[ajaxUser] validating rule from your form ");}		   
						 	if($.bfvalidationEngine.settings.allrules[customAjaxRule].alertTextOk){	// NO OK TEXT MEAN CLOSE PROMPT	 			
	 			 				$.bfvalidationEngine.updatePromptText(ajaxCaller,$.bfvalidationEngine.settings.allrules[customAjaxRule].alertTextOk,"pass",true);
 			 				}else{
				 			 	ajaxValidate = false;		 	
				 			 	$.bfvalidationEngine.closePrompt(ajaxCaller);
 			 				}		
			 			 }
			 			function  _checkInArray(validate){
			 				for(var x=0 ;x<ajaxErrorLength;x++){
			 			 		if($.bfvalidationEngine.ajaxValidArray[x][0] == fieldId){
			 			 			$.bfvalidationEngine.ajaxValidArray[x][1] = validate;
			 			 			existInarray = true;
			 			 		}
			 			 	}
			 			}
			 		}				
				});
			}
		}
		function _equals(caller,rules,position){		 // VALIDATE FIELD MATCH
			var equalsField = rules[position+1];
			
			if($(caller).attr('value') != $("#"+equalsField).attr('value')){
				$.bfvalidationEngine.isError = true;
				promptText += $.bfvalidationEngine.settings.allrules["equals"].alertText+"<br />";
			}
		}
		function _length(caller,rules,position){    	  // VALIDATE LENGTH
			var startLength = eval(rules[position+1]);
			var endLength = eval(rules[position+2]);
			var feildLength = $(caller).attr('value').length;

			if(feildLength<startLength || feildLength>endLength){
				$.bfvalidationEngine.isError = true;
				promptText += $.bfvalidationEngine.settings.allrules["length"].alertText+startLength+$.bfvalidationEngine.settings.allrules["length"].alertText2+endLength+$.bfvalidationEngine.settings.allrules["length"].alertText3+"<br />";
			}
		}
		function _maxCheckbox(caller,rules,position){  	  // VALIDATE CHECKBOX NUMBER
		
			var nbCheck = eval(rules[position+1]);
			var groupname = $(caller).attr("name");
			var groupSize = $("input[name='"+groupname+"']:checked").size();
			if(groupSize > nbCheck){	
				$.bfvalidationEngine.showTriangle = false;
				$.bfvalidationEngine.isError = true;
				promptText += $.bfvalidationEngine.settings.allrules["maxCheckbox"].alertText+"<br />";
			}
		}
		function _minCheckbox(caller,rules,position){  	  // VALIDATE CHECKBOX NUMBER
		
			var nbCheck = eval(rules[position+1]);
			var groupname = $(caller).attr("name");
			var groupSize = $("input[name='"+groupname+"']:checked").size();
			if(groupSize < nbCheck){	
			
				$.bfvalidationEngine.isError = true;
				$.bfvalidationEngine.showTriangle = false;
				promptText += $.bfvalidationEngine.settings.allrules["minCheckbox"].alertText+" "+nbCheck+" "+$.bfvalidationEngine.settings.allrules["minCheckbox"].alertText2+"<br />";
			}
		}
		return ($.bfvalidationEngine.isError) ? $.bfvalidationEngine.isError : false;
	},
	submitForm : function(caller){

		if ($.bfvalidationEngine.settings.success) {	// AJAX SUCCESS, STOP THE LOCATION UPDATE
			if($.bfvalidationEngine.settings.unbindEngine) $(caller).unbind("submit");
			var serializedForm = $(caller).serialize();
			$.bfvalidationEngine.settings.success && $.bfvalidationEngine.settings.success(serializedForm);
			return true;
		}
		return false;
	},
	buildPrompt : function(caller,promptText,type,ajaxed) {			// ERROR PROMPT CREATION AND DISPLAY WHEN AN ERROR OCCUR
		if(!$.bfvalidationEngine.settings) {
			$.bfvalidationEngine.defaultSetting();
		}
		var deleteItself = "." + $(caller).attr("id") + "formError";
	
		if($(deleteItself)[0]) {
			$(deleteItself).stop();
			$(deleteItself).remove();
		}
		var divFormError = document.createElement('div');
		var formErrorContent = document.createElement('div');
		var linkTofield = $.bfvalidationEngine.linkTofield(caller);
		$(divFormError).addClass("formError");
		
		if(type == "pass")
			$(divFormError).addClass("greenPopup");
		if(type == "load")
			$(divFormError).addClass("blackPopup");
		if(ajaxed)
			$(divFormError).addClass("ajaxed");
		
		$(divFormError).addClass(linkTofield);
		$(formErrorContent).addClass("formErrorContent");
		
		if($.bfvalidationEngine.settings.containerOverflow)		// Is the form contained in an overflown container?
			$(caller).before(divFormError);
		else
			$("body").append(divFormError);
				
		$(divFormError).append(formErrorContent);
			
		if($.bfvalidationEngine.showTriangle != false){		// NO TRIANGLE ON MAX CHECKBOX AND RADIO
			var arrow = document.createElement('div');
			$(arrow).addClass("formErrorArrow");
			$(divFormError).append(arrow);
			if($.bfvalidationEngine.settings.promptPosition == "bottomLeft" || $.bfvalidationEngine.settings.promptPosition == "bottomRight") {
				$(arrow).addClass("formErrorArrowBottom");
				$(arrow).html('<div class="line1"><!-- --></div><div class="line2"><!-- --></div><div class="line3"><!-- --></div><div class="line4"><!-- --></div><div class="line5"><!-- --></div><div class="line6"><!-- --></div><div class="line7"><!-- --></div><div class="line8"><!-- --></div><div class="line9"><!-- --></div><div class="line10"><!-- --></div>');
			}
			else if($.bfvalidationEngine.settings.promptPosition == "topLeft" || $.bfvalidationEngine.settings.promptPosition == "topRight"){
				$(divFormError).append(arrow);
				$(arrow).html('<div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div>');
			}
		}
		$(formErrorContent).html(promptText);
		
		var calculatedPosition = $.bfvalidationEngine.calculatePosition(caller,promptText,type,ajaxed,divFormError);
		calculatedPosition.callerTopPosition +="px";
		calculatedPosition.callerleftPosition +="px";
		calculatedPosition.marginTopSize +="px";
		$(divFormError).css({
			"top":calculatedPosition.callerTopPosition,
			"left":calculatedPosition.callerleftPosition,
			"marginTop":calculatedPosition.marginTopSize,
			"opacity":0
		});
		//orefalo - what the hell
		//return $(divFormError).animate({"opacity":0.87},function(){return true;});
		return $(divFormError).animate({"opacity":0.87});	
	},
	updatePromptText : function(caller,promptText,type,ajaxed) {	// UPDATE TEXT ERROR IF AN ERROR IS ALREADY DISPLAYED
		
		var linkTofield = $.bfvalidationEngine.linkTofield(caller);
		var updateThisPrompt =  "."+linkTofield;
		
		if(type == "pass")
			$(updateThisPrompt).addClass("greenPopup");
		else
			$(updateThisPrompt).removeClass("greenPopup");
		
		if(type == "load")
			$(updateThisPrompt).addClass("blackPopup");
		else
			$(updateThisPrompt).removeClass("blackPopup");
		
		if(ajaxed)
			$(updateThisPrompt).addClass("ajaxed");
		else
			$(updateThisPrompt).removeClass("ajaxed");
	
		$(updateThisPrompt).find(".formErrorContent").html(promptText);
		
		var calculatedPosition = $.bfvalidationEngine.calculatePosition(caller,promptText,type,ajaxed,updateThisPrompt);
		calculatedPosition.callerTopPosition +="px";
		calculatedPosition.callerleftPosition +="px";
		calculatedPosition.marginTopSize +="px";
		$(updateThisPrompt).animate({ "top":calculatedPosition.callerTopPosition,"marginTop":calculatedPosition.marginTopSize });
	},
	calculatePosition : function(caller,promptText,type,ajaxed,divFormError){
		
		var callerTopPosition,callerleftPosition,inputHeight,marginTopSize;
		var callerWidth =  $(caller).width();
		
		if($.bfvalidationEngine.settings.containerOverflow){		// Is the form contained in an overflown container?
			callerTopPosition = 0;
			callerleftPosition = 0;
			inputHeight = $(divFormError).height();					// compasation for the triangle
			marginTopSize = "-"+inputHeight;
		}else{
			callerTopPosition = $(caller).offset().top;
			callerleftPosition = $(caller).offset().left;
			inputHeight = $(divFormError).height();
			marginTopSize = 0;
		}
		
		/* POSITIONNING */
		if($.bfvalidationEngine.settings.promptPosition == "topRight"){ 
			if($.bfvalidationEngine.settings.containerOverflow){		// Is the form contained in an overflown container?
				callerleftPosition += callerWidth -30;
			}else{
				callerleftPosition +=  callerWidth -30; 
				callerTopPosition += -inputHeight; 
			}
		}
		if($.bfvalidationEngine.settings.promptPosition == "topLeft"){ callerTopPosition += -inputHeight -10; }
		
		if($.bfvalidationEngine.settings.promptPosition == "centerRight"){ callerleftPosition +=  callerWidth +13; }
		
		if($.bfvalidationEngine.settings.promptPosition == "bottomLeft"){
			callerTopPosition = callerTopPosition + $(caller).height() + 15;
		}
		if($.bfvalidationEngine.settings.promptPosition == "bottomRight"){
			callerleftPosition +=  callerWidth -30;
			callerTopPosition +=  $(caller).height() +5;
		}
		return {
			"callerTopPosition":callerTopPosition,
			"callerleftPosition":callerleftPosition,
			"marginTopSize":marginTopSize
		};
	},
	linkTofield : function(caller){
		var linkTofield = $(caller).attr("id") + "formError";
		linkTofield = linkTofield.replace(/\[/g,""); 
		linkTofield = linkTofield.replace(/\]/g,"");
		return linkTofield;
	},
	closePrompt : function(caller,outside) {						// CLOSE PROMPT WHEN ERROR CORRECTED
		if(!$.bfvalidationEngine.settings){
			$.bfvalidationEngine.defaultSetting();
		}
		if(outside){
			$(caller).fadeTo("fast",0,function(){
				$(caller).remove();
			});
			return false;
		}
		
		// orefalo -- review conditions non sense
		if(typeof(ajaxValidate)=='undefined')
		{ ajaxValidate = false; }
		if(!ajaxValidate){
			var linkTofield = $.bfvalidationEngine.linkTofield(caller);
			var closingPrompt = "."+linkTofield;
			$(closingPrompt).fadeTo("fast",0,function(){
				$(closingPrompt).remove();
			});
		}
	},
	debug : function(error) {
		if(!$.bfvalidationEngine.settings.openDebug) return false;
		if(!$("#debugMode")[0]){
			$("body").append("<div id='debugMode'><div class='debugError'><strong>This is a debug mode, you got a problem with your form, it will try to help you, refresh when you think you nailed down the problem</strong></div></div>");
		}
		$(".debugError").append("<div class='debugerror'>"+error+"</div>");
	},			
	submitValidation : function(caller) {					// FORM SUBMIT VALIDATION LOOPING INLINE VALIDATION
		var stopForm = false;
		$.bfvalidationEngine.ajaxValid = true;
		var toValidateSize = $(caller).find("[class*=validate]").size();
		
		$(caller).find("[class*=validate]").each(function(){
			var linkTofield = $.bfvalidationEngine.linkTofield(this);
			
			if(!$("."+linkTofield).hasClass("ajaxed")){	// DO NOT UPDATE ALREADY AJAXED FIELDS (only happen if no normal errors, don't worry)
				var validationPass = $.bfvalidationEngine.loadValidation(this);
				return(validationPass) ? stopForm = true : "";					
			};
		});
		var ajaxErrorLength = $.bfvalidationEngine.ajaxValidArray.length;		// LOOK IF SOME AJAX IS NOT VALIDATE
		for(var x=0;x<ajaxErrorLength;x++){
	 		if($.bfvalidationEngine.ajaxValidArray[x][1] == false)
	 			$.bfvalidationEngine.ajaxValid = false;
 		}
		if(stopForm || !$.bfvalidationEngine.ajaxValid){		// GET IF THERE IS AN ERROR OR NOT FROM THIS VALIDATION FUNCTIONS
			if($.bfvalidationEngine.settings.scroll){
				if(!$.bfvalidationEngine.settings.containerOverflow){
					var destination = $(".formError:not('.greenPopup'):first").offset().top;
					$(".formError:not('.greenPopup')").each(function(){
						var testDestination = $(this).offset().top;
						if(destination>testDestination)
							destination = $(this).offset().top;
					});
					$("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination}, 1100);
				}else{
					var destination = $(".formError:not('.greenPopup'):first").offset().top;
					var scrollContainerScroll = $($.bfvalidationEngine.settings.containerOverflowDOM).scrollTop();
					var scrollContainerPos = - parseInt($($.bfvalidationEngine.settings.containerOverflowDOM).offset().top);
					destination = scrollContainerScroll + destination + scrollContainerPos -5;
					var scrollContainer = $.bfvalidationEngine.settings.containerOverflowDOM+":not(:animated)";
					
					$(scrollContainer).animate({ scrollTop: destination}, 1100);
				}
			}
			return true;
		}else{
			return false;
		}
	}
};
})(jQuery);