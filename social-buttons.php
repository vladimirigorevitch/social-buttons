<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>social icons demo</title>
    <link rel="stylesheet" href="social-buttons.css">
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
</head>
<body>
    <div id="social-container">
        <?php

        echo '<script src="assets/js/social-buttons.js"></script>';

        function get_fblikes($url) {
            $json_string = file_get_contents('http://graph.facebook.com/?ids=' . $url);
            $json = json_decode($json_string, true);
            return intval( $json[$url]['shares'] );
        }   //end of get_fblikes

//        $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//        $fb_likes = get_fblikes($url);

//        echo 'fb_likes = '.$fb_likes;
//        echo 'url = '.$url;

        function print_like_button ($_soc_nw, $_likes) {
            echo '<script language="JavaScript" type="text/javascript">socialButtonCreate('.$_soc_nw.', '.$_likes.')</script>';
        }

        print_like_button('facebook', 100);

        ?>
    </div>
</body>
</html>