<div style="text-align: justify;">
    <p>
    Create your account. All fields marked with an asterisk are mandatory. Please, provide a valid email address.
    </p>
</div>
<div class="cl"></div>
<div id="account-creation-form" onsubmit="return checkAllAccountFields();">
    <form action="account.php?create=true" method="POST">
        <div id="login-forms" style="font-style: italic" >
            <table cellpadding="3">
                <colgroup>
                    <col>
                    <col>
                    <col>
                </colgroup>
                <tr>
                    <td>Username</td>
                    <td><input type="text" name="un" id="un" class="normal" onkeyup="checkNonEmpty(this);"> <sup><small><span style="color: deeppink">*</span></small></sup></td>
                    <td></td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td><input name="fn" type="text" id="fn"  class="normal"  onkeyup="checkNonEmpty(this);"> <sup><small><span style="color: deeppink">*</span></small></sup></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input name="ln" id="ln" type="text" class="normal" onkeyup="checkNonEmpty(this);"> <sup><small><span style="color: deeppink">*</span></small></sup></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input name="email" id="email" type="text" class="normal" onkeyup="checkNonEmpty(this);"> <sup><small><span style="color: deeppink">*</span></small></sup></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" class="normal" id="pwd" name="pwd" onkeyup="checkNonEmpty(this);"> <sup><small><span style="color: deeppink">*</span></small></sup></td>
                    <td><input type="password" class="normal" id="pwd2" name="pwd2" onkeyup="checkNonEmpty(this);"> <sup><small><span style="color: deeppink">*</span></small></sup></td>
                </tr>                                
            </table>                                                                            
        </div>
        <div class="cl"></div>
        <div id="captcha-block" style="margin-top: 20px">
            <p><img id="captcha" src="/securimage/securimage_show.php" alt="CAPTCHA Image" style="border: solid 2px"/></p>
            <p>Please, type the text that you see in the above box in the following text box.</p>
            <input type="text" id="captcha_code" name="captcha_code" class="normal" maxlength="6"  onkeyup="checkNonEmpty(this);"/> <sup><small><span style="color: deeppink">*</span></small></sup>
            <p>In case you can't make it out, try 
                <a href="#" onclick="document.getElementById('captcha').src = 
                        '/securimage/securimage_show.php?' + 
                        Math.random(); return false">a different image</a>.</p>
        </div>
        <input type="submit" value="Submit">
    </form>
</div>