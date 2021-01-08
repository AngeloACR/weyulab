<?php
/* Template Name:instagramAuth */


if (isset($_REQUEST["code"])) {
    $code = $_REQUEST["code"];
}

$home = get_home_url();
$redirectURL = $home . '/instagramAuth/';
?>

<style>
</style>

<script>
    var url = 'https://api.instagram.com/oauth/access_token';
    let igAppId = "623198801923091";
    let secret = "a04e818de60a0696a077f589ab442ca7";
    let redirectURI = "<?php echo $redirectURL; ?>";
    let code = "<?php echo $code; ?>";

    let fd = new FormData();
    fd.append("client_id", igAppId);
    fd.append("client_secret", secret);
    fd.append("grant_type", 'authorization_code');
    fd.append("redirect_uri", redirectURI);
    fd.append("code", code);
    console.log(code);
    var auth = new XMLHttpRequest();
    auth.open('POST', url, true);


    auth.onreadystatechange = function() { //Call a function when the state changes.
        if (auth.readyState == 4 && auth.status == 200) {
            let response = JSON.parse(auth.responseText);
            let accessToken = response.access_token;
            let userId = response.user_id;
            console.log(response);
            window.opener.openPhotoWindow(accessToken);
            var event = new CustomEvent('auth', {
                'detail': accessToken
            });
            document.dispatchEvent(event)
        }
    }
    auth.send(fd);

    document.addEventListener("auth", function(e) {
        let accesToken = e.detail;
        console.log(accessToken)
    })
</script>