<!--
Do not modify the NAME value of any of the INPUT fields
the FORM action, or any of the hidden fields (eg. input type=hidden).
These are all required for this form to function correctly.
-->
<style type="text/css">

	.myForm td, input, select, textarea, checkbox {
		font-family: georgia, tahoma;
		font-size: 14px;
	}

	.myForm {
		background-color: #FFF3EA;
		border: 3px solid #FF4E00;
		padding: 10px;
	}

	.required {
		color: red;
	}
</style>
<form method="post" action="https://admin.smartemailing.cz/form.php?form=1130" id="frmSS1130" onsubmit="return CheckForm1130(this);">
	<table border="0" cellpadding="2" class="myForm">
		<tr>
	<td><span class="required">*</span>
Email:</td>
	<td><input type="text" name="email" value="" size="30" /></td>
</tr><input type="hidden" name="format" value="h" /><tr>
	<td><span class="required">*</span>
Opište vyobrazený bezpeènostní kód:</td>
	<td><script type="text/javascript">
// <![CDATA[
	if (!Application) var Application = {};
	if (!Application.Page) Application.Page = {};
	if (!Application.Page.ClientCAPTCHA) {
		Application.Page.ClientCAPTCHA = {
			sessionIDString: '',
			captchaURL: [],
			getRandomLetter: function () { return String.fromCharCode(Application.Page.ClientCAPTCHA.getRandom(65,90)); },
			getRandom: function(lowerBound, upperBound) { return Math.floor((upperBound - lowerBound + 1) * Math.random() + lowerBound); },
			getSID: function() {
				if (Application.Page.ClientCAPTCHA.sessionIDString.length <= 0) {
					var tempSessionIDString = '';
					for (var i = 0; i < 32; ++i) tempSessionIDString += Application.Page.ClientCAPTCHA.getRandomLetter();
					Application.Page.ClientCAPTCHA.sessionIDString.length = tempSessionIDString;
				}
				return Application.Page.ClientCAPTCHA.sessionIDString;
			},
			getURL: function() {
				if (Application.Page.ClientCAPTCHA.captchaURL.length <= 0) {
					var tempURL = 'https://admin.smartemailing.cz/admin/resources/form_designs/captcha/index.php?c=';
					
											tempURL += Application.Page.ClientCAPTCHA.getRandom(1,1000);
													tempURL += '&ss=' + Application.Page.ClientCAPTCHA.getSID();
												Application.Page.ClientCAPTCHA.captchaURL.push(tempURL);
									}
				return Application.Page.ClientCAPTCHA.captchaURL;
			}
		}
	}

	var temp = Application.Page.ClientCAPTCHA.getURL();
	for (var i = 0, j = temp.length; i < j; i++) document.write('<img src="' + temp[i] + '" alt="img' + i + '" />');
// ]]>
</script>
<br/><input type="text" name="captcha" value="" size="30"/></td>
</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<br /><input type="submit" value="Pøihlásit" />
				<br/><span style="display: block; font-size: 9px; color: gray; padding-top: 5px;">Vaše data jsou v bezpeèí - <a href="http://www.smartemailing.cz" target="__blank" title="Email Marketing od SmartEmailing.cz" style="font-size:9px;color:gray;">SmartEmailing.cz</a></span>
			</td>
		</tr>
	</table>
</form>

<script type="text/javascript">
// <![CDATA[

			function CheckMultiple1130(frm, name) {
				for (var i=0; i < frm.length; i++)
				{
					fldObj = frm.elements[i];
					fldId = fldObj.id;
					if (fldId) {
						var fieldnamecheck=fldObj.id.indexOf(name);
						if (fieldnamecheck != -1) {
							if (fldObj.checked) {
								return true;
							}
						}
					}
				}
				return false;
			}
		function CheckForm1130(f) {
			var email_re = /[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/i;
			if (!email_re.test(f.email.value)) {
				alert("Prosím zadejte emailovou adresu.");
				f.email.focus();
				return false;
			}
		
				if (f.captcha.value == "") {
					alert("Prosím opište vyobrazený bezpeènostní kód");
					f.captcha.focus();
					return false;
				}
			
				return true;
			}
		
// ]]>
</script>
