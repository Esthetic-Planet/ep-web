function submit_form() {
  "undefined" != typeof validateCaptchaAndSubmit ? validateCaptchaAndSubmit() : check_webtolead_fields()
}

function validateHuman() {
  document.getElementById("human").value = "55"
}

function check_webtolead_fields() {
  if (null != document.getElementById("bool_id")) {
    var e = document.getElementById("bool_id").value;
    bools = e.substring(0, e.lastIndexOf(";"));
    var t = new Array;
    t = bools.split(";");
    nbr_fields = t.length;
    for (var n = 0; n < nbr_fields; n++) "on" == document.getElementById(t[n]).value ? document.getElementById(t[n]).value = 1 : document.getElementById(t[n]).value = 0
  }
  if (null != document.getElementById("req_id")) {
    e = (e = document.getElementById("req_id").value).substring(0, e.lastIndexOf(";"));
    var l = new Array;
    l = e.split(";");
    nbr_fields = l.length;
    var d = !0;
    for (n = 0; n < nbr_fields; n++)
      if (document.getElementById(l[n]).value.length <= 0 || 0 == document.getElementById(l[n]).value) {
        d = !1;
        break
      } return d && "55" == document.getElementById("human").value ? (document.WebToLeadForm.action = "https://medcom.sugaropencloud.eu/index.php?entryPoint=WebToLeadCapture", document.WebToLeadForm.submit(), !0) : (alert("Merci de renseigner tous les champs requis"), !1)
  }
  document.WebToLeadForm.submit()
}

function validateEmailAdd() {
  document.getElementById("email1") && document.getElementById("email1").value.length > 0 && null == document.getElementById("email1").value.match(/^\w+(['\.\-\+]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/) && alert("Adresse email invalide"), document.getElementById("email2") && document.getElementById("email2").value.length > 0 && null == document.getElementById("email2").value.match(/^\w+(['\.\-\+]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/) && alert("Adresse email invalide")
}
