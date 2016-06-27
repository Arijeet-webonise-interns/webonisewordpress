
var createFormObj='{}';
var saveObj;

var getelemetsListBox=[];
var logicJson,elemetsList=elemetsListBox="";
var elemntArr = '{"rule1":[],"formrule1":[{"subruleid":"001","allany":"all","eleType":"","elemCondi":"","eleValue":"","onsuccess":"show_msg","onsuccessValue":""}]}';
 var elemntObj;
 var ruleCount=1;

function EFBP_logicForm(){

       // create Forms json
        var Formjson='{"forms":[{"field_options":{"form_title":"'+$("#setformTitle label").html()+'","form_description":"'+$("#setformDesc label").html()+'","submitconfirm":"'+$("#submitconfirm").val()+'","includejs":"'+$("#includejs").val()+'","formaligen":"'+$("#formaligen").val()+'"}}]}';

        // if payLoadData is empty
        if($.isEmptyObject(payLoadData))
        payLoadData='{"fields":[]}';

         //alert(payLoadData);
        var text = payLoadData;
        
        obj = JSON.parse(text); 
        

        var flist = [], options="<option></option>";

        console.log("main Obj"+JSON.stringify(obj));

       elemntObj=JSON.parse(elemntArr);
      // alert(elemntArr);
        saveObj=JSON.parse(createFormObj); // if saveObj is not empty

         document.getElementById("elementName").innerHTML='';
          
          elemetsList=elemetsListBox="<option></option>";

        for(var i = 0; i < obj.fields.length; i++){
          
          var selectedCid=false;
          for(var j = 0; j < elemntObj.rule1.length; j++){
            if(obj.fields[i].cid==elemntObj.rule1[j].cid)
            {
              //alert(obj.fields[i].cid);
              selectedCid=true;
              break;
            }
          }

        if(selectedCid==false){
          options +="<option value='"+obj.fields[i].cid+"'>"+obj.fields[i].label+"</option>";
        }
          // display elemet list in field type div
          elemetsList +="<option value='"+obj.fields[i].field_type+"'>"+obj.fields[i].label+"</option>";
          
          if(obj.fields[i].field_type=="Name") 
          { //Name
            console.log('my Name '+obj.fields[i].field_options['name']);
            if(obj.fields[i].field_options['name']=="Normal"){
              elemetsListBox +="<option value='"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_firstname'>firstname</option>";
              elemetsListBox +="<option value='"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_lastname'>lastname</option>";
              getelemetsListBox.push("'"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_firstname'");
              getelemetsListBox.push("'"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_lastname'");
            }else if(obj.fields[i].field_options['name']=="Nor_title" || obj.fields[i].field_options['name']=="F_title"){
              elemetsListBox +="<option value='"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_title'>title</option>";
              elemetsListBox +="<option value='"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_firstname'>firstname</option>";
              elemetsListBox +="<option value='"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_middlename'>middlename</option>";
              elemetsListBox +="<option value='"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_lastname'>lastname</option>";
              getelemetsListBox.push("'"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_title'");
              getelemetsListBox.push("'"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_firstname'");
              getelemetsListBox.push("'"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_middlename'");
              getelemetsListBox.push("'"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_lastname'");
            }else if(obj.fields[i].field_options['name']=="Full"){
              elemetsListBox +="<option value='"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_firstname'>firstname</option>";
              elemetsListBox +="<option value='"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_middlename'>middlename</option>";
              elemetsListBox +="<option value='"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_lastname'>lastname</option>";
              getelemetsListBox.push("'"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_firstname'");
              getelemetsListBox.push("'"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_middlename'");
              getelemetsListBox.push("'"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_lastname'");
            }
            
          }
          else if(obj.fields[i].field_type=="time") 
          { //time
            console.log('my Time '+obj.fields[i].field_options['time']);
            if(obj.fields[i].field_options['time']=="SecondField"){
              elemetsListBox +="<option value='"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_SecondField'>time</option>";
              getelemetsListBox.push("'"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_SecondField'");
            }else if(obj.fields[i].field_options['time']=="HourFormat"){
              elemetsListBox +="<option value='"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_HourFormat'>time</option>";
              getelemetsListBox.push("'"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_HourFormat'");
            }else if(obj.fields[i].field_options['time']=="both"){
              elemetsListBox +="<option value='"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_both'>time</option>";
              getelemetsListBox.push("'"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_both'");
            }
            
          }
          else if(obj.fields[i].field_type=="address") 
          { //address
            console.log('my address '+obj.fields[i].field_options['address']);
            
            elemetsListBox +="<option value='"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_address'>Address - Street Address</option>";
            elemetsListBox +="<option value='"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_address2'>Address Line 2</option>";
            elemetsListBox +="<option value='"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_city'>City</option>";
            elemetsListBox +="<option value='"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_state'>State/Province/Region</option>";
            elemetsListBox +="<option value='"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_zip'>Zip/Postal Code</option>";
            elemetsListBox +="<option value='"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_country'>Country</option>";
 
            getelemetsListBox.push("'"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_address'");
            getelemetsListBox.push("'"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_address2'");
            getelemetsListBox.push("'"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_city'");
            getelemetsListBox.push("'"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_state'");
            getelemetsListBox.push("'"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_zip'");
            getelemetsListBox.push("'"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"_country'");
            
          }
          else
          {
            elemetsListBox +="<option value='"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"'>"+obj.fields[i].label+"</option>"; 
             getelemetsListBox.push("'"+obj.fields[i].field_type+"_"+obj.fields[i].cid+"'");  
          }
          
        }

        document.getElementById("elementName").innerHTML=options;
        
        //Set form Logic html

       
       // explode saveObj 
       if($.isEmptyObject(saveObj)){
          $("#001").html(elemetsListBox);
       }
       else
      {  

        document.getElementById("ulsuccess").innerHTML=""; 
        for(var i=0;i<saveObj.formrule1.length;i++)
         {
            var randomFormid=saveObj.formrule1[i]['subruleid'];
            var eleType=saveObj.formrule1[i]['eleType'];
            //set all/ any
            if(saveObj.formrule1[i]['allany']=="all")
            var allanyOption="<option selected='' value='all'>all</option><option value='any'>any</option>";
            else if(saveObj.formrule1[i]['allany']=="any")
             var allanyOption="<option selected='' value='any'>any</option><option value='all'>all</option>";
             else
             var allanyOption="<option selected='' value='any'>any</option><option value='all'>all</option>"; 

             var elemCondi= saveObj.formrule1[i]['elemCondi'];

            //extract elemet type
            var inlineElemetsList="<option value=''></option>";
            

            $.each(getelemetsListBox, function( key, value ) {
                var splitelemt=value.split('_');
               //alert("eleType:"+eleType+" Type:"+splitelemt[0]+" Cid:"+splitelemt[1]);
                if(eleType==splitelemt[0])
                inlineElemetsList +="<option value='"+value+"' selected=''>"+splitelemt[0]+"</option>";
                else
                inlineElemetsList +="<option value='"+value+"' >"+splitelemt[0]+"</option>";  
              });
            
            var elemCondiList=getconditionList(eleType,elemCondi);

            
            var eleValue=saveObj.formrule1[i]['eleValue'];
            var selectedshowmsg=MSGvalue="";  
            var selectedshowurl=URLvalue="";  

            if(saveObj.formrule1[i]['onsuccess']=="show_msg"){
             selectedshowmsg="checked";
             MSGvalue=saveObj.formrule1[i]['onsuccessValue'];
            }
            else
            {
                selectedshowurl="checked";  
                URLvalue=saveObj.formrule1[i]['onsuccessValue'];
            } 

            var show_msg='<input type="radio" id="show_msgaddFormclone" name="success'+randomFormid+'" value="show_msg" '+selectedshowmsg+' onclick="showmydiv(this);" style="width:auto !important;">Show Message';
            var redirect_msg='<input type="radio" id="redirct_to'+randomFormid+'" '+selectedshowurl+' name="success'+randomFormid+'" value="redirct_to" onclick="showmydiv(this);" style="width:auto !important;">Redirect to Page'; 

            saveObj.formrule1[i]['onsuccessValue'];
            saveObj.formrule1[i]['cid'];

            var closehide="closeme('"+randomFormid+"');";
            var addFormclone="addFormclone('"+randomFormid+"');";
            var selectElementcond="setelementcondi('"+randomFormid+"');";
            var setcondition="setcondition('"+randomFormid+"');";

            document.getElementById("ulsuccess").innerHTML =
            document.getElementById("ulsuccess").innerHTML +'<li id="logicid'+randomFormid+'"><table width="100%" cellspacing="0"><thead><tr><td><strong> Rule'+i+'</strong></td><td><td><button type="button" class="close" onclick="'+closeRule+'">&times;</button></td></td></tr></thead><tbody><tr><td><h6>If <select name="fieldruleallany_15" id="successallany'+randomFormid+'" class="element select rule_all_any form-control" onchange="successallany(this);">'+allanyOption+'</select> of the following conditions match:</h6><ul class="ls_field_rules_conditions"><li id="lifieldrule_'+randomFormid+'"> <select id="'+randomFormid+'" name="conditionfield_'+randomFormid+'" autocomplete="off" class=" element select condition_fieldname form-control" style="width:20%; display: inline-block;" onchange="setelementtype(this);">'+inlineElemetsList+'</select><select name="conditiontext'+randomFormid+'" id="conditiontext'+randomFormid+'" onchange="setformcondition(this);" class="element select condition_text form-control" style="width: 36%;"><option value="">'+elemCondiList+'</select> <span id="conditionkeywordspan'+randomFormid+'" ><input id="conditionkeyword'+randomFormid+'" type="text" class="element text condition_keyword" value="'+eleValue+'" name="conditionkeyword'+randomFormid+'" onkeyup="setformcondkeyword(this);"></span></li></ul></td></tr><tr><td></td><td></td><td><button onclick="'+addFormclone+'" class="close" type="button">+</button></td></tr> <tr><td>On Success Page:</td><td>'+show_msg+'</td><td>'+redirect_msg+'</td></tr> <tr><td><div class="show_msg"><label>Success Message</label><textarea class="form-control" id="msgvalue'+randomFormid+'" onchange="setsuccessValue(this);">'+MSGvalue+'</textarea></div></td><td> <div class="redirct_to" style="display:none"> <label>Redirect URL</label> <input type="text" class="form-control"  value="'+URLvalue+'" id="urlvalue'+randomFormid+'" onchange="setsuccessValue(this);"/></div> </td></tr> </tbody></table></li>';
      } 
   } //end else IF 
}//End RenderForm

/* Start FOrm Logic */

// change condition dropdown by element type In form logic update json
function setelementtype(resource){

 var splitres=resource.value.split("_");
 // set element
 var nameArr=["title","firstname","lastname","middlename"];
 var addArr=["address","address2","city","zip","state","country"];
 var timeArr=["SecondField","HourFormat","both"];

 for(var i=0; i<elemntObj.formrule1.length; i++){
       if(elemntObj.formrule1[i]['subruleid']==resource.id){
         console.log("eleType"+elemntObj.formrule1[i]);
        
        //name 
         if(nameArr.includes(splitres[2]))
         {
          elemntObj.formrule1[i]['eleType']=splitres[2];
          elemntObj.formrule1[i]['cid']=splitres[1];
         } //address
         else if(addArr.includes(splitres[2]))
         {
          elemntObj.formrule1[i]['eleType']=splitres[2];
          elemntObj.formrule1[i]['cid']=splitres[1];
         }//time
         else if(timeArr.includes(splitres[2]))
         {
          elemntObj.formrule1[i]['eleType']=splitres[2];
          elemntObj.formrule1[i]['cid']=splitres[1];
         }
         else
         {
          elemntObj.formrule1[i]['eleType']=splitres[0];
          elemntObj.formrule1[i]['cid']=splitres[1]; 
         }         
//         elemntObj.formrule1[i]['fromid']=splitres[1]; 
      }
       console.log(resource.id+'here'+splitres[0]+JSON.stringify(elemntObj));
    }
     elemntArr=JSON.stringify(elemntObj);

var setcondkeyword="setformcondkeyword(this);";

    var timeTextFormat="";     
      if(splitres[2]=="SecondField"){
      timeTextFormat="HH:MM:SS:AM";
      }
      else if(splitres[2]=="HourFormat"){
      timeTextFormat="HH:MM";
      }
      else if(splitres[2]=="both"){
      timeTextFormat="MM:SS:MM";
      }

 if(splitres[0]=="number" || splitres[0]=="price" ){
   $("#conditiontext"+resource.id).html('<option selected="selected" value=""></option><option value="is">Is</option><option value="less_than">Less than</option><option value="greater_than">Greater than</option>');   
    console.log("setList "+splitres[0]);
    $("#conditionkeywordspan"+resource.id).html('<input type="text" onkeyup="'+setcondkeyword+'" name="conditionkeyword'+resource.id+'" id="conditionkeyword'+resource.id+'" value="" class="element text condition_keyword">');
  }
  else if(splitres[0]=="text" || splitres[0]=="address" || splitres[0]=="paragraph" || splitres[0]=="name" || splitres[0]=="phone" || splitres[0]=="website" || splitres[0]=="fileupload" || splitres[0]=="dropdown" || splitres[0]=="radio"){
    $("#conditiontext"+resource.id).html('<option selected="selected" value=""></option><option value="is">Is</option><option value="is_not">Is Not</option><option value="begins_with">Begins with</option><option value="ends_with">Ends with</option><option value="contains">Contains</option><option value="not_contain">Does not contain</option>');
    $("#conditionkeywordspan"+resource.id).html('<input type="text" onkeyup="'+setcondkeyword+'" name="conditionkeyword'+resource.id+'" id="conditionkeyword'+resource.id+'" value="" class="element text condition_keyword">');
     console.log("setList "+splitres[0]);
  }
  else if(splitres[0]=="checkboxes"){
    $("#conditiontext"+resource.id).html('<option value=""></option><option value="is_checked">IS checked</option><option value="is_empty">IS Empty</option>');   
    $("#conditionkeywordspan"+resource.id).html('');
     console.log("setList "+splitres[0]);
  }
  else if(splitres[0]=="date"){ //set date
    var datefun="logicUidate('"+resource.id+"');";
    $("#conditiontext"+resource.id).html('<option selected="selected" value=""></option><option value="is">Is</option><option value="is_before">Is Before</option><option value="is_after">Is After</option>');   
    $("#conditionkeywordspan"+resource.id).html('<input type="text" name="conditionkeyword'+resource.id+'" onchange="'+setcondkeyword+'" id="conditionkeyword'+resource.id+'" value="" class="element text condition_keyword"><img src="img/calendar.gif" class="dateimg'+resource.id+'" onclick="'+datefun+'">');
     console.log("Date "+splitres[0]);
  }
  else if(splitres[0]=="time"){ //set time
    $("#conditiontext"+resource.id).html('<option selected="selected" value=""></option><option value="is">Is</option><option value="is_before">Is Before</option><option value="is_after">Is After</option>');   
    $("#conditionkeywordspan"+resource.id).html('<input type="text" onkeyup="'+setcondkeyword+'" name="conditionkeyword'+resource.id+'" id="conditionkeyword'+resource.id+'" value="" class="element text condition_keyword" placeholder="'+timeTextFormat+'">');
  }
  

  console.log("setelementcondi conditionkeywordspan"+ resource.id+" "+splitres[0]);
}

//set form condition update json
function setformcondition(resource){
  var conditiontext=resource.id;
  var conditiontext=conditiontext.split("conditiontext");
  for(var i=0; i<elemntObj.formrule1.length; i++){
       if(elemntObj.formrule1[i]['subruleid']==conditiontext[1]){
         console.log("elemCondi"+elemntObj.formrule1[i]);
         elemntObj.formrule1[i]['elemCondi']=resource.value;
      }
       console.log(conditiontext[1]+'here'+JSON.stringify(elemntObj));
    }
     elemntArr=JSON.stringify(elemntObj);
}
//End update json by element conditions

//set form condition box value update json
function setformcondkeyword(resource){
 var setcondkeyword=resource.id;
  var setcondkeyword=setcondkeyword.split("conditionkeyword");

  for(var i=0; i<elemntObj.formrule1.length; i++){
       if(elemntObj.formrule1[i]['subruleid']==setcondkeyword[1]){
         console.log("eleValue"+elemntObj.formrule1[i]);
         elemntObj.formrule1[i]['eleValue']=resource.value;
      }
       console.log(setcondkeyword[1]+'here'+JSON.stringify(elemntObj));
    }
     elemntArr=JSON.stringify(elemntObj);
}
//ENd form condtion box

//set success value update json
function setsuccessValue(resource){
    var successmsg=resource.id;
console.log(resource.id+" me");
    if(successmsg.startsWith("msgvalue")){
      successmsg=successmsg.split("msgvalue");
     }
    else if(successmsg.startsWith("urlvalue")){
     successmsg=successmsg.split("urlvalue");
    }

  for(var i=0; i<elemntObj.formrule1.length; i++){
       if(elemntObj.formrule1[i]['subruleid']==successmsg[1]){
         console.log("onsuccessValue"+elemntObj.formrule1[i]);
         elemntObj.formrule1[i]['onsuccessValue']=resource.value;
      }
       console.log(successmsg[1]+'here'+JSON.stringify(elemntObj));
    }
     elemntArr=JSON.stringify(elemntObj);
}
//ENd
function removediv(data){
  if(totalElements>1){
     data.parentNode.parentNode.parentNode.removeChild(data.parentNode.parentNode);
        totalElements--;
            
      }
  else{alert("At least 1 option is required.");}
}

function showmydiv(resource){
  var successmsg=resource.id;
  var setValue="";
    if(resource.value == "show_msg"){
      $('.show_msg').show();
      $('.redirct_to').hide();
      successmsg=successmsg.split("show_msg");
      setValue=$("#msgvalue"+successmsg[1]).val();
     }
    else if(resource.value == "redirct_to"){
      $('.show_msg').hide();
      $('.redirct_to').show();
      successmsg=successmsg.split("redirct_to");
      setValue=$("#urlvalue"+successmsg[1]).val();
    }

      for(var i=0; i<elemntObj.formrule1.length; i++){
           if(elemntObj.formrule1[i]['subruleid']==successmsg[1]){
             console.log("onsuccess"+elemntObj.formrule1[i]);
             elemntObj.formrule1[i]['onsuccess']=resource.value;
             elemntObj.formrule1[i]['onsuccessValue']=setValue;
          }
           console.log(successmsg[1]+'here'+JSON.stringify(elemntObj));
        }
         elemntArr=JSON.stringify(elemntObj);
  }

// copy form clone 
function copyFormclone(id){
  var randomFormid=Math.ceil(Math.random()*100000);
 if(lastRandom==randomFormid){
 randomnumber++;
 lastRandom=  randomFormid;
   }
   else{
  lastRandom=  randomFormid;
   }
   ruleCount++;
    elemntObj['formrule1'].push({"subruleid":randomFormid,"allany":"all","eleType":"","elemCondi":"","eleValue":"","onsuccess":"show_msg","onsuccessValue":""});
    console.log("update copy form clone "+JSON.stringify(elemntObj));
    elemntArr=JSON.stringify(elemntObj);
    var closeRule="closeRule('"+randomFormid+"');";
    var addFormclone="addFormclone('"+randomFormid+"');";
   /* var selectElementcond="setelementcondi('"+randomFormid+"');";
    var setcondition="setcondition('"+randomFormid+"');";*/
    //var setcondkeyword="setcondkeyword('"+id+"','"+name+"',this);";

    $("#logicid"+id).parent().append('<li id="logicid'+randomFormid+'"><table width="100%" cellspacing="0"><thead><tr><td><strong> Rule'+ruleCount+'</strong></td><td><td><button type="button" class="close" onclick="'+closeRule+'">&times;</button></td></td></tr></thead><tbody><tr><td><h6>If <select name="fieldruleallany_15" id="successallany'+randomFormid+'" class="element select rule_all_any form-control" onchange="successallany(this);"><option value="all">all</option><option value="any">any</option></select> of the following conditions match:</h6><ul class="ls_field_rules_conditions"><li id="lifieldrule_'+randomFormid+'"> <select id="'+randomFormid+'" name="conditionfield_'+randomFormid+'" autocomplete="off" class=" element select condition_fieldname form-control" style="width:20%; display: inline-block;" onchange="setelementtype(this);">'+elemetsListBox+'</select><select name="conditiontext'+randomFormid+'" id="conditiontext'+randomFormid+'" onchange="setformcondition(this);" class="element select condition_text form-control" style="width: 36%;"><option value=""></option><option value="is">Is</option><option value="is_not">Is Not</option><option value="begins_with">Begins with</option><option value="ends_with">Ends with</option><option value="contains">Contains</option><option value="not_contain">Does not contain</option></select> <span id="conditionkeywordspan'+randomFormid+'" ><input id="conditionkeyword'+randomFormid+'" type="text" class="element text condition_keyword" value="" name="conditionkeyword'+randomFormid+'" onkeyup="setformcondkeyword(this);"></span></li></ul></td></tr><tr><td></td><td></td><td><button onclick="'+addFormclone+'" class="close" type="button">+</button></td></tr> <tr><td>On Success Page:</td><td><input type="radio" id="show_msgaddFormclone" name="success'+randomFormid+'" value="show_msg" checked onclick="showmydiv(this);" style="width:auto !important;">Show Message</td><td><input type="radio" id="redirct_to'+randomFormid+'" style="width:auto !important;"  name="success'+randomFormid+'" value="redirct_to" onclick="showmydiv(this);">Redirect to Page</td></tr> <tr><td><div class="show_msg"><label>Success Message</label><textarea class="form-control" id="msgvalue'+randomFormid+'" onchange="setsuccessValue(this);"></textarea></div></td><td> <div class="redirct_to" style="display:none"> <label>Redirect URL</label> <input type="text" class="form-control" id="urlvalue'+randomFormid+'" onchange="setsuccessValue(this);"/></div> </td></tr> </tbody></table></li>');
 
}

// Add form clone 
function addFormclone(id){
  var randomFormid=Math.ceil(Math.random()*100000)
   if(lastRandom==randomFormid){
randomnumber++;
 lastRandom=  randomFormid;
   }
   else{
  lastRandom=  randomFormid;
   }
    //elemntObj['formrule1'].push({"subruleid":randomnumber,"cid":id,"name":name,"status":"show","allany":"all","selectelm":"","selectcond":"","condikeywrd":"","fromid":""});
    ///console.log("update"+id+" "+name+  JSON.stringify(elemntObj));
    //elemntArr=JSON.stringify(elemntObj);
    var closehide="closeme('"+randomFormid+"');";
    var addFormclone="addFormclone('"+randomFormid+"');";
    var selectElementcond="setelementcondi('"+randomFormid+"');";
    var setcondition="setcondition('"+randomFormid+"');";
    //var setcondkeyword="setcondkeyword('"+id+"','"+name+"',this);";
    $("#lifieldrule_"+id).parent().append('<ul class="ls_field_rules_conditions"><li id="lifieldrule_'+randomFormid+'"> <select id="'+randomFormid+'" name="conditionfield_15_1" autocomplete="off" class=" element select condition_fieldname form-control" style="width:20%; display: inline-block;" onchange="'+selectElementcond+'">'+elemetsListBox+'</select> <select name="conditiontext'+randomFormid+'" id="conditiontext'+randomFormid+'" onchange="'+setcondition+'" class="element select condition_text form-control" style="width: 36%;"><option value=""></option><option value="is">Is</option><option value="is_not">Is Not</option><option value="begins_with">Begins with</option><option value="ends_with">Ends with</option><option value="contains">Contains</option><option value="not_contain">Does not contain</option></select> <span id="conditionkeywordspan'+randomFormid+'"><input type="text" id="conditionkeyword'+randomFormid+'" class="element text condition_keyword" value="" name="conditionkeyword'+id+'" onkeyup="'+setcondkeyword+'"></span><button onclick="removeFormclone(this)" id="'+randomFormid+'" class="close" type="button">-</button></li></ul>');
  
}

//Close div
function closeRule(id){
  $("#logicid"+id).remove();

  for(var i=0; i<elemntObj.formrule1.length; i++){
   if(elemntObj.formrule1[i]['subruleid']==id){
     console.log("delete rule"+elemntObj.formrule1[i]);
     elemntObj.formrule1.splice(i,1);
  }
   console.log('delete here'+JSON.stringify(elemntObj));
}
 elemntArr=JSON.stringify(elemntObj);
  EFBP_logicForm();

}

//Remove removeFormclone
function removeFormclone(thisElement){
    $(thisElement).parent().remove();
    /*for(var i=0; i<elemntObj.rule1.length; i++){
        if(elemntObj.rule1[i]['subruleid']==thisElement.id){
            console.log("delete me"+elemntObj.rule1[i]);
            elemntObj.rule1.splice(i,1);
        }
        console.log('delete here'+JSON.stringify(elemntObj));
        
    }
    elemntArr=JSON.stringify(elemntObj);*/
}


function successallany(resource){

  var eleId=resource.id;
  var eleId=eleId.split("successallany");

  for(var i=0; i<elemntObj.formrule1.length; i++){
       if(elemntObj.formrule1[i]['subruleid']==eleId[1]){
         console.log("allany"+elemntObj.formrule1[i]);
         elemntObj.formrule1[i]['allany']=resource.value;
      }
       console.log(resource.id+'here'+JSON.stringify(elemntObj));
    }
     elemntArr=JSON.stringify(elemntObj);
     console.log("please set all any in json "+resource.value);
}

//Save form
function saveForm(){

saveObj=JSON.parse(createFormObj); 
saveObj=elemntObj;

console.log('saved json:'+JSON.stringify(saveObj));
}
/* END FOrm Logic */


var lastRandom=0;
// set json
  function setJsonObj(id,name){
     // var elemntObj=JSON.parse(elemntArr);
      var randomnumber=Math.ceil(Math.random()*100000)
   if(lastRandom==randomnumber){
randomnumber++;
 lastRandom=  randomnumber;
   }
   else{
  lastRandom=  randomnumber;
   }
    elemntObj['rule1'].push({"subruleid":randomnumber,"cid":id,"name":name,"status":"show","allany":"all","selectelm":"","selectcond":"","condikeywrd":"","fromid":""});
    console.log("update"+id+" "+name+  JSON.stringify(elemntObj));
    elemntArr=JSON.stringify(elemntObj);
    var showandhide="showandhide('"+id+"','"+name+"',this.value);";
    var allany="setallany('"+id+"','"+name+"',this.value);";
    var closehide="closeme('"+id+"','"+name+"',this.value);";
    var addme="addclone('"+id+"','"+name+"',this.value);";
    var selectElementcond="setelementcondi('"+id+"','"+name+"',this);";
    var setcondition="setcondition('"+id+"','"+name+"',this);";
    var setcondkeyword="setcondkeyword('"+id+"','"+name+"',this);";
    $("#addElement").append('<li id="logicid'+id+'"><table width="100%" cellspacing="0"><thead><tr><td><strong>'+name+'</strong></td><td><td><button type="button" class="close" onclick="'+closehide+'">&times;</button></td></td></tr></thead><tbody><tr><td><h6><select style="margin-left: 5px;margin-right: 5px; width:25%;" name="fieldruleshowhide_15" id="'+id+'" class="element select rule_show_hide form-control" onchange="'+showandhide+'"><option value="show">Show</option><option value="hide">Hide</option></select> this field if <select style="margin-left: 5px;margin-right: 5px; width:25%;" name="fieldruleallany_15" id="'+id+'" class="element select rule_all_any form-control" onchange="'+allany+'"><option value="all">all</option><option value="any">any</option></select> of the following conditions match:</h6><ul class="ls_field_rules_conditions"><li id="lifieldrule_'+id+'"> <select id="'+randomnumber+'" name="conditionfield_15_1" autocomplete="off" class=" element select condition_fieldname form-control" style="width:20%; display: inline-block;" onchange="'+selectElementcond+'">'+elemetsListBox+'</select> <select name="'+id+'" id="conditiontext'+randomnumber+'" onchange="'+setcondition+'" class="element select condition_text form-control" style="width: 36%;"><option value=""></option><option value="is">Is</option><option value="is_not">Is Not</option><option value="begins_with">Begins with</option><option value="ends_with">Ends with</option><option value="contains">Contains</option><option value="not_contain">Does not contain</option></select> <span id="conditionkeywordspan'+randomnumber+'"><input id="conditionkeyword'+randomnumber+'" type="text" class="element text condition_keyword" value="" name="conditionkeyword'+id+'" onkeyup="'+setcondkeyword+'"></span></li></ul></td></tr><tr><td></td><td></td><td><button onclick="'+addme+'" class="close" type="button">+</button></td></tr></tbody></table></li>');
    EFBP_logicForm();
}

//show and hide dropdown 
function showandhide(id,name,resource){

   for(var i=0; i<elemntObj.rule1.length; i++){
       if(elemntObj.rule1[i]['cid']==id){
         console.log("show/hide me"+elemntObj.rule1[i]);
         elemntObj.rule1[i]['status']=resource;
      }
       console.log(resource+'here'+JSON.stringify(elemntObj));
    }
     elemntArr=JSON.stringify(elemntObj);
 }

function addclone(id,name,resource){
  var randomnumber=Math.ceil(Math.random()*100000)
   if(lastRandom==randomnumber){
randomnumber++;
 lastRandom=  randomnumber;
   }
   else{
  lastRandom=  randomnumber;
   }
    elemntObj['rule1'].push({"subruleid":randomnumber,"cid":id,"name":name,"status":"show","allany":"all","selectelm":"","selectcond":"","condikeywrd":"","fromid":""});
    console.log("update"+id+" "+name+  JSON.stringify(elemntObj));
    elemntArr=JSON.stringify(elemntObj);
    var showandhide="showandhide('"+id+"','"+name+"',this.value);";
    var allany="setallany('"+id+"','"+name+"',this.value);";
    var closehide="closeme('"+id+"','"+name+"',this.value);";
    var addme="addclone('"+id+"','"+name+"',this.value);";
    var selectElementcond="setelementcondi('"+id+"','"+name+"',this);";
    var setcondition="setcondition('"+id+"','"+name+"',this);";
    var setcondkeyword="setcondkeyword('"+id+"','"+name+"',this);";
    //alert("addme");
    $("#lifieldrule_"+id).parent().append('<ul class="ls_field_rules_conditions"><li id="lifieldrule_'+id+'"> <select id="'+randomnumber+'" name="conditionfield_15_1" autocomplete="off" class=" element select condition_fieldname form-control" style="width:20%; display: inline-block;" onchange="'+selectElementcond+'">'+elemetsListBox+'</select> <select name="conditiontext'+id+'" id="conditiontext'+randomnumber+'" onchange="'+setcondition+'" class="element select condition_text form-control" style="width: 36%;"><option value=""></option><option value="is">Is</option><option value="is_not">Is Not</option><option value="begins_with">Begins with</option><option value="ends_with">Ends with</option><option value="contains">Contains</option><option value="not_contain">Does not contain</option></select> <span id="conditionkeywordspan'+randomnumber+'"><input type="text" id="conditionkeyword'+randomnumber+'" class="element text condition_keyword" value="" name="conditionkeyword'+id+'" onkeyup="'+setcondkeyword+'"></span><button onclick="closeRule1(this)" id="'+randomnumber+'" class="close" type="button">-</button></li></ul>');
    EFBP_logicForm();
}

function closeRule1(thisElement){
    $(thisElement).parent().remove();
    for(var i=0; i<elemntObj.rule1.length; i++){
        if(elemntObj.rule1[i]['subruleid']==thisElement.id){
            console.log("delete me"+elemntObj.rule1[i]);
            elemntObj.rule1.splice(i,1);
        }
        console.log('delete here'+JSON.stringify(elemntObj));
        
    }
    elemntArr=JSON.stringify(elemntObj);
}

//Close div
function closeme(id,name,resource){
  $("#logicid"+id).remove();
 
  for(var i=0; i<elemntObj.rule1.length; i++){
   if(elemntObj.rule1[i]['cid']==id){
     console.log("delete me"+elemntObj.rule1[i]);
     elemntObj.rule1.splice(i,1);
  }
   console.log('delete here'+JSON.stringify(elemntObj));
}
 elemntArr=JSON.stringify(elemntObj);
  EFBP_logicForm();
}

//set field all/ any
function setallany(id,name,resource){
  for(var i=0; i<elemntObj.rule1.length; i++){
       if(elemntObj.rule1[i]['subruleid']==resource.id){
         console.log("allany"+elemntObj.rule1[i]);
         elemntObj.rule1[i]['allany']=$(resource).val();
      }
       console.log(resource+'here'+JSON.stringify(elemntObj));
    }
     elemntArr=JSON.stringify(elemntObj);
}

//set keyword
function setcondkeyword(id,name,resource){
  var setcondkeyword=resource.id;
  var setcondkeyword=setcondkeyword.split("conditionkeyword");

  for(var i=0; i<elemntObj.rule1.length; i++){
       if(elemntObj.rule1[i]['subruleid']==setcondkeyword[1]){
         console.log("condikeywrd"+elemntObj.rule1[i]);
         elemntObj.rule1[i]['condikeywrd']=$(resource).val();
      }
       console.log(setcondkeyword[1]+'here'+JSON.stringify(elemntObj));
    }
     elemntArr=JSON.stringify(elemntObj);
}

// set select condition
function setcondition(id,name,resource){
  var conditiontext=resource.id;
  var conditiontext=conditiontext.split("conditiontext");
  for(var i=0; i<elemntObj.rule1.length; i++){
       if(elemntObj.rule1[i]['subruleid']==conditiontext[1]){
         console.log("selectcond"+elemntObj.rule1[i]);
         elemntObj.rule1[i]['selectcond']=$(resource).val();
      }
       console.log(conditiontext[1]+'here'+JSON.stringify(elemntObj));
    }
     elemntArr=JSON.stringify(elemntObj);
}

//set selectElement condition  parmeter element,cid
function setelementcondi(id,name,resource){
 
 var splitres=$(resource).val().split("_");
 console.log(splitres);
 // set element
 for(var i=0; i<elemntObj.rule1.length; i++){
       if(elemntObj.rule1[i]['subruleid']==resource.id){
         console.log("selectelm"+elemntObj.rule1[i]);
         if(splitres[0]=="Name"){
          elemntObj.rule1[i]['selectelm']=splitres[2];
          elemntObj.rule1[i]['fromid']=splitres[1]; 
         }
         else if(splitres[0]=="address"){
          elemntObj.rule1[i]['selectelm']=splitres[2];
          elemntObj.rule1[i]['fromid']=splitres[1]; 
         }
         else if(splitres[0]=="time"){
          elemntObj.rule1[i]['selectelm']=splitres[2];
          elemntObj.rule1[i]['fromid']=splitres[1]; 
         }
         else{
          elemntObj.rule1[i]['selectelm']=splitres[0];
         elemntObj.rule1[i]['fromid']=splitres[1]; 
         }
         
      }
       console.log(splitres[0]+'here'+splitres[1]+JSON.stringify(elemntObj));
    }
     elemntArr=JSON.stringify(elemntObj);
      var timeTextFormat="";     
      if(splitres[2]=="SecondField"){
      timeTextFormat="HH:MM:SS:AM";
      }
      else if(splitres[2]=="HourFormat"){
      timeTextFormat="HH:MM";
      }
      else if(splitres[2]=="both"){
      timeTextFormat="MM:SS:MM";
      }

var setcondkeyword="setcondkeyword('"+id+"','"+name+"',this);";

 if(splitres[0]=="number" || splitres[0]=="price"){
   $("#conditiontext"+resource.id).html('<option value="" selected="selected"></option><option value="is">Is</option><option value="less_than">Less than</option><option value="greater_than">Greater than</option>');   
    console.log("setList "+splitres[0]);
    $("#conditionkeywordspan"+resource.id).html('<input type="text" onkeyup="'+setcondkeyword+'" name="conditionkeyword'+id+'" id="conditionkeyword'+resource.id+'" value="" class="element text condition_keyword">');
  }
  else if(splitres[0]=="text" || splitres[0]=="address" || splitres[0]=="paragraph" || splitres[0]=="name" || splitres[0]=="phone" || splitres[0]=="website"  || splitres[0]=="fileupload" || splitres[0]=="dropdown" || splitres[0]=="radio"){
    $("#conditiontext"+resource.id).html('<option value="" selected="selected"></option><option value="is">Is</option><option value="is_not">Is Not</option><option value="begins_with">Begins with</option><option value="ends_with">Ends with</option><option value="contains">Contains</option><option value="not_contain">Does not contain</option>');
    $("#conditionkeywordspan"+resource.id).html('<input type="text" name="conditionkeyword'+id+'" id="conditionkeyword'+resource.id+'" value="" class="element text condition_keyword" oninput="'+setcondkeyword+'">');
     console.log("setList "+splitres[0]);
  }
  else if(splitres[0]=="date"){ //set date
    var datefun="logicUidate('"+resource.id+"');";
    $("#conditiontext"+resource.id).html('<option value="" selected="selected"></option><option value="is">Is</option><option value="is_before">Is Before</option><option value="is_after">Is After</option>');   
    $("#conditionkeywordspan"+resource.id).html('<input type="text" onchange="'+setcondkeyword+'" name="conditionkeyword'+id+'" id="conditionkeyword'+resource.id+'" value="" class="element text condition_keyword"><img src="img/calendar.gif" class="dateimg'+resource.id+'" onclick="'+datefun+'"><input onchange="alert(\""dateme"\");" type="hidden" name="dateme'+id+'" id="dateme'+resource.id+'" value="">');
     console.log("Date "+splitres[0]);
  }
  else if(splitres[0]=="time"){ //set time
    $("#conditiontext"+resource.id).html('<option value="" selected="selected"></option><option value="is">Is</option><option value="is_before">Is Before</option><option value="is_after">Is After</option>');   
    $("#conditionkeywordspan"+resource.id).html('<input type="text" onkeyup="'+setcondkeyword+'" name="conditionkeyword'+id+'" id="conditionkeyword'+resource.id+'" value="" class="element text condition_keyword" placeholder="'+timeTextFormat+'">');
  }
  else if(splitres[0]=="checkboxes"){ //set checkboxes, dropdown, radio
    $("#conditiontext"+resource.id).html('<option value="" selected="selected"></option><option value="is_checked">IS checked</option><option value="is_empty">IS Empty</option>');   
    $("#conditionkeywordspan"+resource.id).html('');
  }

  console.log("setelementcondi conditionkeyword"+ resource.id+" "+name+" "+splitres[0]);
}

function logicUidate(id) {
  //alert(id);
   $(".dateimg"+id).hide();
        $("#dateme"+id).datepicker({
        showOn: "button",
        buttonImage: "img/calendar.gif",
        buttonImageOnly: true,
        buttonText: "Select date",
//        dateFormat: 'mm/dd/yy',
        onSelect: function(dateText, inst) {
              $('#conditionkeyword'+id).val(dateText);
   
        }
       });
}


function applylogicbuilder(id,elem_type,status,allany,selectelm,selectcond,condikeywrd){
  console.log('yo have called me');
  console.log(id+' ,'+elem_type+' , '+status+' ,'+allany+' ,'+selectelm+' ,'+selectcond+' ,'+condikeywrd);

  // elemt 
  if(status=="hide")
  {
    $("#logic"+id).show();  
  }
  else
  {
    $("#logic"+id).hide();
  }
}

function setlogicBuilderFun(id,name){

//alert(id+" "+name);
var IDval="";
  for(var j=0; j<elemntObj.rule1.length;j++){
  //      console.log(elemntObj.rule1[i]['cid']+' , '+elemntObj.rule1[i]['name']+' ,'+elemntObj.rule1[i]['status']+' ,'+elemntObj.rule1[i]['allany']+' ,'+elemntObj.rule1[i]['selectelm']);
      if(elemntObj.rule1[j]['fromid']==id){

          var status=elemntObj.rule1[j]['status'];

            var condikeywrdVal=elemntObj.rule1[j]['condikeywrd'];
              condikeywrdVal=condikeywrdVal.toLowerCase();

            if (typeof name != 'undefined')
            {
               if(name=="SecondField"){
                 IDval=$("#hour"+id).val()+":"+$("#minute"+id).val()+":"+$("#second"+id).val()+":"+$("#ampm"+id).val().toLowerCase();
                }
                else if(name=="HourFormat"){
                  IDval=$("#hour"+id).val()+":"+$("#minute"+id).val();
                }
                else if(name=="both"){
                  IDval=$("#hour"+id).val()+":"+$("#minute"+id).val()+":"+$("#second"+id).val()+":"+$("#minute1"+id).val(); 
                }
                else if(name!=null){
                  IDval=$("#"+name+id).val();
                }
            }
            else if($(".rend"+id).attr('type')=="radio"){
              $(".rend"+id).each(function(){
               if($(this).is(':checked')){
                IDval=this.value;
               }
              });
            }
            else
            { 
               IDval=$("#rend"+id).val();  
            }

                IDval=IDval.toLowerCase();


            console.log(IDval+" condikeywrdVal:"+condikeywrdVal+" status:"+status);
            
            // is            
            if(elemntObj.rule1[j]['selectcond']=="is"){
              console.log(IDval+" getIS "+condikeywrdVal);
                if(IDval==condikeywrdVal)
                {
                  console.log(IDval+"get SHOW"+condikeywrdVal);
                  if(status=="show")
                  $("#logic"+elemntObj.rule1[j]['cid']).show();  
                  else
                  $("#logic"+elemntObj.rule1[j]['cid']).hide();    
                }
                else
                {
                  if(status=="show")
                  $("#logic"+elemntObj.rule1[j]['cid']).hide();  
                  else
                  $("#logic"+elemntObj.rule1[j]['cid']).show();  
                }  
                
            }

            // is_not           
            if(elemntObj.rule1[j]['selectcond']=="is_not"){
              console.log("getIS");
                if(IDval!=condikeywrdVal)
                {
                  console.log("get SHOW");
                  if(status=="show")
                  $("#logic"+elemntObj.rule1[j]['cid']).show();  
                  else
                  $("#logic"+elemntObj.rule1[j]['cid']).hide();    
                }
                else
                 {
                   if(status=="show")
                   $("#logic"+elemntObj.rule1[j]['cid']).hide();  
                   else
                   $("#logic"+elemntObj.rule1[j]['cid']).show();    
                }
            }

            //less_than 
            if(elemntObj.rule1[j]['selectcond']=="less_than"){
              console.log("getIS");
                if(parseInt(IDval)<parseInt(condikeywrdVal))
                {
                  console.log("get SHOW");
                  if(status=="show")
                  $("#logic"+elemntObj.rule1[j]['cid']).show();  
                  else
                  $("#logic"+elemntObj.rule1[j]['cid']).hide();    
                }
                else
                 {
                   if(status=="show")
                   $("#logic"+elemntObj.rule1[j]['cid']).hide();  
                   else
                   $("#logic"+elemntObj.rule1[j]['cid']).show();    
                }
            }

            //greater_than   
            if(elemntObj.rule1[j]['selectcond']=="greater_than"){
              console.log("getIS");
                if(parseInt(IDval)>parseInt(condikeywrdVal))
                {
                  console.log("get SHOW");
                  if(status=="show")
                  $("#logic"+elemntObj.rule1[j]['cid']).show();  
                  else
                  $("#logic"+elemntObj.rule1[j]['cid']).hide();    
                }
                else
                 {
                   if(status=="show")
                   $("#logic"+elemntObj.rule1[j]['cid']).hide();  
                   else
                   $("#logic"+elemntObj.rule1[j]['cid']).show();    
                }
            }

            //begins_with  
            if(elemntObj.rule1[j]['selectcond']=="begins_with"){
              console.log("getIS");
                if(IDval.startsWith(condikeywrdVal))
                {
                  console.log("get SHOW");
                  if(status=="show")
                  $("#logic"+elemntObj.rule1[j]['cid']).show();  
                  else
                  $("#logic"+elemntObj.rule1[j]['cid']).hide();    
                }
                else
                 {
                   if(status=="show")
                   $("#logic"+elemntObj.rule1[j]['cid']).hide();  
                   else
                   $("#logic"+elemntObj.rule1[j]['cid']).show();    
                } 
            }

            //ends_with
            if(elemntObj.rule1[j]['selectcond']=="ends_with"){
              console.log("getIS");
                if(IDval.endsWith(condikeywrdVal))
                {
                  console.log("get SHOW");
                  if(status=="show")
                  $("#logic"+elemntObj.rule1[j]['cid']).show();  
                  else
                  $("#logic"+elemntObj.rule1[j]['cid']).hide();    
                }
                else
                 {
                   if(status=="show")
                   $("#logic"+elemntObj.rule1[j]['cid']).hide();  
                   else
                   $("#logic"+elemntObj.rule1[j]['cid']).show();    
                }
            }

            //contains
            if(elemntObj.rule1[j]['selectcond']=="contains"){
              console.log("getIS");
                if(IDval.includes(condikeywrdVal))
                {
                  console.log("get SHOW");
                  if(status=="show")
                  $("#logic"+elemntObj.rule1[j]['cid']).show();  
                  else
                  $("#logic"+elemntObj.rule1[j]['cid']).hide();    
                }
                else
                 {
                   if(status=="show")
                   $("#logic"+elemntObj.rule1[j]['cid']).hide();  
                   else
                   $("#logic"+elemntObj.rule1[j]['cid']).show();    
                }
            }

            //not_contain 
            if(elemntObj.rule1[j]['selectcond']=="not_contain"){
              console.log("getIS");
                if(!IDval.includes(condikeywrdVal))
                {
                  console.log("get SHOW");
                  if(status=="show")
                  $("#logic"+elemntObj.rule1[j]['cid']).show();  
                  else
                  $("#logic"+elemntObj.rule1[j]['cid']).hide();    
                }
                else
                 {
                   if(status=="show")
                   $("#logic"+elemntObj.rule1[j]['cid']).hide();  
                   else
                   $("#logic"+elemntObj.rule1[j]['cid']).show();    
                }
            }

            console.log(elemntObj.rule1[j]['selectcond']);
            // checked
            if(elemntObj.rule1[j]['selectcond']=="is_checked"){
              console.log("getIS");
                if($("#rend"+id).is(':checked'))
                {
                  console.log("get SHOW");
                  if(status=="show")
                  $("#logic"+elemntObj.rule1[j]['cid']).show();  
                  else
                  $("#logic"+elemntObj.rule1[j]['cid']).hide();    
                }
                else
                 {
                   if(status=="show")
                   $("#logic"+elemntObj.rule1[j]['cid']).hide();  
                   else
                   $("#logic"+elemntObj.rule1[j]['cid']).show();    
                }
            }

            // is_empty
            if(elemntObj.rule1[j]['selectcond']=="is_empty"){
              console.log("getIS");
                if($("#rend"+id).is(':checked')=="false")
                {
                  console.log("get SHOW");
                  if(status=="show")
                  $("#logic"+elemntObj.rule1[j]['cid']).show();  
                  else
                  $("#logic"+elemntObj.rule1[j]['cid']).hide();    
                }
                else
                 {
                   if(status=="show")
                   $("#logic"+elemntObj.rule1[j]['cid']).hide();  
                   else
                   $("#logic"+elemntObj.rule1[j]['cid']).show();    
                }
            }

        }//end 

     // console.log('loop:'+id+','+condi+','+condival+','+getvalue); 
  }
}
    
//return element type list
function getconditionList(type,condiVal){

 if(type=="number" || type=="price"){
    var options=[['is','IS'],['less_than','LESS than'],['greater_than','Grether than']];
    var returnOptions="<option value=''></option>";
    $.each(options,function(key,value){
      if(key==condiVal)
      returnOptions +="<option value='"+key+"' selected=''>"+value+"</option>";
      else
      returnOptions +="<option value='"+key+"'>"+value+"</option>";  
    });
    return returnOptions;
   } 
  else if(type=="text" || type=="paragraph" || type=="name" || type=="phone" || type=="website" || type=="fileupload" || type=="dropdown" || type=="radio" || type=="address")
  {
    var options=[['is','IS'],['is_not','IS Not'],['begins_with','Begins with'],['ends_with','Ends with'],['contains','Contains'],['not_contain','Does Not contain']];
    var returnOptions="<option value=''></option>";
    $.each(options,function(key,value){
      if(key==condiVal)
      returnOptions +="<option value='"+key+"' selected=''>"+value+"</option>";
      else
      returnOptions +="<option value='"+key+"'>"+value+"</option>";  
    });
   return returnOptions;   
  }
  else if(type=="date" || type=="time"){ //set date
    var options=[['is','IS'],['is_before','Is Before'],['is_after','Is After']];
    var returnOptions="<option value=''></option>";
    $.each(options,function(key,value){
      if(key==condiVal)
      returnOptions +="<option value='"+key+"' selected=''>"+value+"</option>";
      else
      returnOptions +="<option value='"+key+"'>"+value+"</option>";  
    });

   return returnOptions;   
   }
   else if(type=="checkboxes"){ //set checkboxes, dropdown, radio

    var options=[['is_checked','IS checked'],['is_empty','IS Empty']];
    var returnOptions="<option value=''></option>";
    $.each(options,function(key,value){
      if(key==condiVal)
      returnOptions +="<option value='"+key+"' selected=''>"+value+"</option>";
      else
      returnOptions +="<option value='"+key+"'>"+value+"</option>";  
    });

   return returnOptions;   
  }
   else{ //by default

    var options=[['is','IS'],['is_not','IS Not'],['begins_with','Begins with'],['ends_with','Ends with'],['contains','Contains'],['not_contain','Does Not contain']];
    var returnOptions="<option value=''></option>";
    $.each(options,function(key,value){
      returnOptions +="<option value='"+key+"'>"+value+"</option>";  
    });
   return returnOptions;   
  }
}