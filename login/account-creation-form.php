<div style="text-align: justify;">
    Create your account
</div>
<form action="account.php?create=true" method="POST">
    <div id="login-forms">
        <table cellpadding="3">
            <colgroup>
                <col>
                <col>
                <col>
            </colgroup>
            <tr>
                <td>Username</td>
                <td><input name="un"></td>
                <td></td>
            </tr>
            <tr>
                <td>First Name</td>
                <td><input name="fn"></td>
                <td></td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td><input name="ln"></td>
                <td></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input name="email"></td>
                <td></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="pwd"></td>
                <td><input type="password" name="pwd2"></td>
            </tr>                                
        </table>                                                                            
    </div>
    <div id="captcha-block" style="margin-top: 20px">
        <p><img id="captcha" src="/securimage/securimage_show.php" alt="CAPTCHA Image" style="border: solid 2px"/></p>
        <p>Please, type the text that you see in the above box in the following text box.</p>
        <input type="text" name="captcha_code" size="10" maxlength="6" />
        <p>In case you can't make it out, try 
           <a href="#" onclick="document.getElementById('captcha').src = 
                    '/securimage/securimage_show.php?' + 
                    Math.random(); return false">a different image</a>.</p>
    </div>
    <input type="submit" value="Submit">
</form>