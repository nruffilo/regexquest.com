<?php

require('includes.php');
echo $header;

?>

<div class="module login container">
    <form method="post" id="login_form">
        <fieldset>
            <legend>Hero Login</legend>
            <dl>
                <dt>E-Mail:</dt>
                <dd><input type="text" name="email"/></dd>
                <dt>Password:</dt>
                <dd><input type="password" name="passwd"/></dd>
            </dl>
            <input type="submit" class="btn btn-small btn-primary" value="Begin Questing"/>
        </fieldset>
      
    </form>
</div><!-- .module.login -->

<?

echo $footer;

?>