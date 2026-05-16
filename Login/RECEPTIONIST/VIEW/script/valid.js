function valid(){
	let f = true;
	const msg = document.getElementById("msg");
	msg.innerHTML = "";

	const username = (document.getElementById("username") || {}).value || "";
	const email = (document.getElementById("email") || {}).value || "";
	const password = (document.getElementById("password") || {}).value || "";
	const confirm = (document.getElementById("confirm_password") || {}).value || "";

	if(!username || !email || !password || !confirm) {
		f = false;
		msgEl.innerHTML = "All fields are required.";
		return f;
	}

	// basic email check
	const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
	if(!emailRe.test(email)){
		f = false;
		msg.innerHTML = "Enter a valid email address.";
		return f;
	}

	if(password.length < 6){
		f = false;
		msg.innerHTML = "Password must be at least 6 characters.";
		return f;
	}

	if(password !== confirm){
		f = false;
		msg.innerHTML = "Passwords do not match.";
		return f;
	}

	return f;
}