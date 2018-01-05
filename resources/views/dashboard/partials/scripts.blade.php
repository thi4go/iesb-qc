<script src="https://www.gstatic.com/firebasejs/3.6.3/firebase.js"></script>
<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?php
    if(session('user')) {
        echo '<script>';
        echo 'var globalUserId = '.session('user')->id;
        echo '</script>';
    }
?>
<script>
    var config = {
        apiKey: "AIzaSyAD-EqMPWrs8_iy0rMs8jr-U5YZMD2puvQ",
        authDomain: "controle-iesb.firebaseapp.com",
        databaseURL: "https://controle-iesb.firebaseio.com",
        projectId: "controle-iesb",
        storageBucket: "",
        messagingSenderId: "1000136630664"

    };

    var firebaseStudySchedule = firebase.initializeApp(config, "Secondary");
</script>

<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 873944059;
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    /* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
<noscript>
  <div style="display:inline;">
  <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/873944059/?guid=ON&amp;script=0"/>
  </div>
</noscript>

@stack('scripts')
