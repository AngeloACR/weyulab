<?php
/* Template Name:facebookAuth */


if (isset($_REQUEST["code"])) {
    $code = $_REQUEST["code"];
}

$home = get_home_url();
$redirectURL = $home . '/facebookAuth/';
?>

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v9.0&appId=353848015765495" nonce="BI6HQ2fd"></script>

<div class="fb-login-button" data-scope="user_photos" data-size="large" data-button-type="continue_with" data-layout="rounded" data-auto-logout-link="false" data-use-continue-as="false" data-width="" onlogin="checkLoginState();"></div>

<style>
</style>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId: 'WeyulabApp',
            cookie: true,
            xfbml: true,
            version: 'v9.0'
        });

        FB.AppEvents.logPageView();

    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<script>
    function checkLoginState() {
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                let token = response.authResponse.accessToken;
                let userId = response.authResponse.userID;
                window.opener.openFBWindow(token, userId)
            }
        });
    }
</script>