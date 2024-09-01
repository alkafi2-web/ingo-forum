<!-- resources/views/cookies/cookie-consent.blade.php -->
<style>
    #cookieConsent {
        display: none;
        position: fixed;
        bottom: -100px;
        left: 0;
        width: 100%;
        background-color: #f1f1f1;
        padding: 10px;
        box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.2);
        z-index: 9999;
        transition: bottom 1s ease-in-out;
    }

    #cookieConsent.show {
        bottom: 0;
    }

    #cookieConsent.hide {
        bottom: -100px;
    }

    #cookieConsent div {
        text-align: center;
        font-size: 14px;
    }

    #acceptCookies {
        background-color: green;
        color: white;
        padding: 5px 10px;
        margin-left: 10px;
        border: none;
        cursor: pointer;
    }
</style>

<div id="cookieConsent">
    <div>
        We use cookies to ensure you get the best experience on our website. By continuing, you agree to our <a href="{{ url('privacy-policy') }}" style="color: blue;">Privacy Policy</a>.
        <button id="acceptCookies">Accept</button>
    </div>
</div>

@push('custom-js')
<script>
    $(document).ready(function() {
        if (!getCookie('cookies_accepted')) {
            $('#cookieConsent').show().animate({ bottom: "0" }, 500);  // Slides up into view
        }

        $('#acceptCookies').click(function() {
            setCookie('cookies_accepted', 'true', 365);
            $('#cookieConsent').animate({ bottom: "-100px" }, 500, function() {
                $(this).fadeOut(500);
            });  // Slides down out of view
        });

        function setCookie(cname, cvalue, exdays) {
            const d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            const expires = "expires="+ d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        function getCookie(cname) {
            const name = cname + "=";
            const decodedCookie = decodeURIComponent(document.cookie);
            const ca = decodedCookie.split(';');
            for(let i = 0; i <ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
    });
</script>
@endpush