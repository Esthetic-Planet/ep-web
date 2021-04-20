<div class="separator-section  separator-style1"></div>
<!-- opening HOUR  -->
<section class="opening-hour-style2" id="opening-hour-section">
    <div class="container">
 <!-- HEADER FORM -->
<h2 class="text-center" style="font-size: 38px;padding-bottom:30px;margin-bottom:30px;color:white;text-transform: uppercase;">Esthetic Planet accompagne votre projet</h2>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12 text-left"> 
                <div class="banner-form animated fadeInUp" style="height:auto;visibility: visible !important;background-color: #ffffff80;padding-bottom:20px;" >
                    <span class="titre-form" style="font-size:35px;">Des questions ?</span>
    
   
   

                                <!-- DEBUT LEAD CATCHER -->
<script type="text/javascript" src="https://medcom.sugaropencloud.eu/cache/include/javascript/sugar_grp1.js?v=pwbHIS0LGQylZxf0QjwJJQ"></script>
<script type="text/javascript" src="https://medcom.sugaropencloud.eu/cache/include/javascript/calendar.js?v=3hJ2rwYfp2dZuKaVqEddTQ"></script>

<form id="WebToLeadForm" action="https://medcom.sugaropencloud.eu/index.php?entryPoint=WebToLeadCapture" method="POST" name="WebToLeadForm">


    <table style="font-size:12px;width: 100%;padding:20px;">
        <tbody>

        <tr>
            <td>
                <span><input id="last_name" type="text" name="last_name" placeholder="Entrez votre nom..." /></span>
            </td>
        </tr>
        
        <tr>
            <td>
                <span><input id="first_name" type="text" name="first_name" placeholder="Entrez votre prénom..." /></span>
            </td>
        </tr>

        <tr>
            <td>
                <span><input id="email1" type="text" name="email1" onChange="validateEmailAdd();" placeholder="Votre adresse e-mail ici..." /></span>
            </td>
        </tr>

        <tr>
            <td>
                <span><input id="phone_work" type="text" name="phone_work" placeholder="Votre numéro de téléphone..."  /></span>
            </td>
        </tr>
        
         <tr>
               <td>
               <span><input id="age_c" type="text" name="age_c" placeholder="Votre âge..." /></span>
               </td>

        </tr>
    
        <tr>
            <td>
                <span id="ta_replace">
                    <textarea id="description" type="text" name="description" style="margin-bottom:20px;margin-top:10px;" class="textarea-form" placeholder="Expliquez en quelques mots vos souhaits..." cols="50" rows="10" /></textarea>
                </span>
            </td>
        </tr>

        <tr align="center">
            <td colspan="10"><input class="btn" onClick="submit_form();" type="button" name="Submit" value="Envoyer" /></td>
        </tr>

        <!-- Début des Variables fixes à remplir CRM  dans value=""-->
            <tr>
                <td style="display:none;">
                    <select id="lead_source" name="lead_source" tabindex="1"> 
                        <option selected="selected" value="Estheticplanet"></option> 
                    </select>
                </td>
            </tr>

            <tr>
                <td style="display:none;">
                    <select id="action_de_contact_c" name="action_de_contact_c" tabindex="1"> 
                        <option selected="selected" value="Formulaire_Landing_Page"></option> 
                    </select>
                </td>
            </tr>

            <tr>
                <td style="display:none;">
                    <select id="how_find_us_c" name="how_find_us_c" tabindex="1"> 
                        <option selected="selected" value="website"></option> 
                    </select>
                </td>
            </tr>

            <tr>
                <td style="display: none;"><input id="campaign_id" type="hidden" name="campaign_id" value="9ed079e4-38c9-11e8-919c-02b1f490ee9f" /></td>
            </tr>

            <tr>
                <td style="display: none;"><input id="redirect_url" type="hidden" name="redirect_url" value="https://www.esthetic-planet.com/../offres/pages/merci.html" /></td>
            </tr>

            <tr>
                <td style="display: none;"><input id="assigned_user_id" type="hidden" name="assigned_user_id" value="1" /></td>
            </tr>

            <tr>
                <td style="display: none;"><input id="team_id" type="hidden" name="team_id" value="1" /></td>
            </tr>

            <tr>
                <td style="display: none;"><input id="team_set_id" type="hidden" name="team_set_id" value="Global" /></td>
            </tr>

            <tr>
                <td style="display: none;"><input id="req_id" type="hidden" name="req_id" value="last_name;" /></td>
            </tr>
         <!-- FIN Variable fixe à remplir CRM -->



        </tbody>
    </table>
</form>

<script type="text/javascript">// <![CDATA[
 function submit_form(){
    if(typeof(validateCaptchaAndSubmit)!='undefined'){
        validateCaptchaAndSubmit();
    }else{
        check_webtolead_fields();
    }
 }
 function check_webtolead_fields(){
     if(document.getElementById('bool_id') != null){
        var reqs=document.getElementById('bool_id').value;
        bools = reqs.substring(0,reqs.lastIndexOf(';'));
        var bool_fields = new Array();
        var bool_fields = bools.split(';');
        nbr_fields = bool_fields.length;
        for(var i=0;i<nbr_fields;i++){
          if(document.getElementById(bool_fields[i]).value == 'on'){
             document.getElementById(bool_fields[i]).value = 1;
          }
          else{
             document.getElementById(bool_fields[i]).value = 0;
          }
        }
      }
    if(document.getElementById('req_id') != null){
        var reqs=document.getElementById('req_id').value;
        reqs = reqs.substring(0,reqs.lastIndexOf(';'));
        var req_fields = new Array();
        var req_fields = reqs.split(';');
        nbr_fields = req_fields.length;
        var req = true;
        for(var i=0;i<nbr_fields;i++){
          if(document.getElementById(req_fields[i]).value.length <=0 || document.getElementById(req_fields[i]).value==0){
           req = false;
           break;
          }
        }
        if(req){
            document.WebToLeadForm.submit();
            return true;
        }
        else{
          alert('Merci de renseigner tous les champs requis');
          return false;
         }
        return false
   }
   else{
    document.WebToLeadForm.submit();
   }
}
function validateEmailAdd(){
    if(document.getElementById('email1') && document.getElementById('email1').value.length >0) {
        if(document.getElementById('email1').value.match(/^\w+(['\.\-\+]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/) == null){
          alert('Adresse email invalide');
        }
    }
    if(document.getElementById('email2') && document.getElementById('email2').value.length >0) {
        if(document.getElementById('email2').value.match(/^\w+(['\.\-\+]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/) == null){
          alert('Adresse email invalide');
        }
    }
}
// ]]>
    
</script>
<!-- FIN LEAD CATCHER -->
</div>
<!-- END OF HEADER FORM-->
 </div>
<!--END OF DEVIS PERSO -->