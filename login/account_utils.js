function checkNonEmpty(inputElement, errorClass){
    if (!errorClass){
        errorClass='error';
    }
    var val = inputElement.value;
    if (val.length==0){        
        inputElement.className=errorClass;
        return false;
    }else{
        inputElement.className='normal';
        return true;
    }
}

function checkAllAccountFields(){
    // Check username
    var ele = document.getElementById("un");    
    if (!checkNonEmpty(ele,"checkAgain")){
        alert("You have to provide a username");
        return false;
    }
    // Check first name
    ele = document.getElementById("fn");    
    if (!checkNonEmpty(ele,"checkAgain")){
        alert("You have to provide your first name");
        return false;
    }
    // Check last name
    ele = document.getElementById("ln");
    if (!checkNonEmpty(ele,"checkAgain")){
        alert("You have to provide your last name");
        return false;
    }
    // Check email
    ele = document.getElementById("email");
    val = ele.value;    
    if (val == null || val=="" || !check_email(val)){        
        alert("You have to provide a valid email address");
        ele.className="checkAgain";
        return false;
    }    
    //Check password
    var ele_pwd = document.getElementById("pwd");    
    var pwd = ele_pwd.value;
    if (!checkNonEmpty(ele_pwd,"checkAgain")){
        alert("You have to provide a password.\n Please choose a good one!");
        return false;
    }
    //check second password
    ele = document.getElementById("pwd2");
    if (!checkNonEmpty(ele,"checkAgain")){
        alert("You have to provide your password twice.");
        return false;
    }    
    //check password equality
    if (pwd!=ele.value){
        alert("You have to provide the same password twice.\n\
Please, check again and provide the same password!");
        ele.className="checkAgain";
        ele_pwd.className="checkAgain";
        return false;
    }
    //check CAPTCHA!
    ele = document.getElementById("captcha_code");
    if (!checkNonEmpty(ele,"checkAgain")){        
        return false;
    }
    return true;
}

function check_email(e) {
    var matcher=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
    if (!matcher.test(e))
        return false;       
    return true;
}