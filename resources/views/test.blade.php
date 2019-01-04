<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<div class="register">
    <div class="band_1">
        <div class="box">
            <form action="/test" method="GET">
                <div class="input_table">
                    <table>
                        <thead>
                        <tr>
                            <th><h1>Register to LIMS</h1></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input type="text" name="user_first_name" placeholder="Enter First Name"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="user_last_name" placeholder="Enter Last Name"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="user_phone" placeholder="Enter Contact Number"></td>
                        </tr>
                        <tr>
                            <td><input type="email" name="user_email" placeholder="Enter Email"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="user_login_name" placeholder="Select a Username"><p id="test"></p></td>
                        </tr>
                        <tr>
                            <td><input type="password" name="user_password" placeholder="Select a Password"></td>
                        </tr>
                        <tr>
                            <td><input type="password" name="user_password_2" placeholder="Repeat Password"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <button type="submit" name="user_register" class="button_1">Register</button>
                <button type="button" class="button_3">Cancel</button>
            </form>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function() {

        jQuery("input[name=user_login_name]").keyup(function(){
            var user_login_name = jQuery("input[name=user_login_name]").val();
            console.log(user_login_name);
            jQuery.get("/test?debug=1", {user_login_name: user_login_name}, function(data, status) {
                jQuery("#test").html(data);
            });

        });

    });
</script>
