function checkSignupForm(form) {
	if (form.email.value == "") {
    	alert( "Please enter your email address." );
    	form.email.focus();
    	return false;
  	}
  	if (form.passwd.value == "") {
    	alert( "You must enter a password." );
    	form.passwd.focus();
    	return false;
  	}
  	
  	if (form.passwd.value != form.cpasswd.value) {
    	alert( "Passwords do no match." );
    	form.passwd.focus();
    	return false;
  	}
  	
  	if (form.display_name.value == "") {
    	alert( "You must enter a display name" );
    	form.display_name.focus();
    	return false;
  	}
  	
  	return true;
}