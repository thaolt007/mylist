<!DOCTYPE html5>
<head>
    <title>My list</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
    <style type="text/css">
    </style>
</head>
<?php
require 'process.php';
?>
<body>
    <div id="wrap">
        <div id="top">
            <div id="input-link">
                <div class="left"><input id="link" type="text" /></div>
                <div class="right"><input id="submit-but" type="submit" value="OK" /> </div>
            </div>
        </div>
        <!--End id top--></!--End>
        <div class="break-line"></div>
        <div id="mid">
            <?php
            foreach ($data as $row) {
                echo "<div class='link-row'>";
                echo "<div class='left'>";

                if (strpos($row, "http") !== FALSE) {
                    // hyperlink
                    $arr = explode(" ", $row);
                    echo '<a href="' . $arr[0] . '" target="_blank">' . $arr[0] . '</a>';
                    echo "</div>";
                    echo "<div class='right'>";
                    echo "<p>" . $arr[1] . "</p>";
                    echo "</div>";
                } else {
                    // string text

                    $arr = array();
                    $t = strrpos($row, " ");
                    $arr[] = substr($row, 0, $t);
                    $arr[] = substr($row, $t);
                    echo '<a href="http://google.com/?q=' . $arr[0] . '" target="_blank">' . $arr[0] . '</a>';
                    echo "</div>";
                    echo "<div class='right'>";
                    echo "<p>" . $arr[1] . "</p>";
                    echo "</div>";
                }
                echo "</div>";
                echo "<div class='break-line'></div>";
            }
            ?>
        </div>
        <!--End id mid--></!--End>
        <div id="bot">
            <div id="navi">
                <div class="left">
                    <button>Previous</button>
                    <button>Next</button>
                </div>
                <div class="right">
                    <a href="#top"><button>TOP</button></a>
                </div>
            </div>
        </div>
        <!--End id bot--></!--End>
    </div>
    <!--End id wrap--></!--End>
    <script>
        $(document).ready(function () {
            $('.link-row:first').css("border-top", "1px dashed black");
            $('.link-row:last').remove();
        });
        $('#submit-but').click(function (e) {
            e.preventDefault(); //loai bo cac hanh dong mac dinh

            var link = $('#link').val();
            $.ajax({
                type: 'POST', // method
                url: './process.php', // action
                dataType: 'JSON', // kieu du lieu nhan ve
                data: {// data gui cung request
                    link: link,
                },
                success: function (data) {// thanh cong status http = 200
                    // in ket qua sang tab console

                    // xu ly du lieu tra ve
                    if (data.code === 1) {
                        //console.log(data);
                        $('#mid').append(
                                '<div class="link-row" style="display: none;"><div class="left"><a href="' + data.link + '" target="_blank">' + data.link + '</a></div>' +
                                '<div class="right"><p>' + data.day + '</p></div></div>' +
                                '<div class="break-line"></div>'
                                );
                        $('.link-row:last').slideDown();
                        $('#link').val('');

                    } else {

                    }

                }
            });
        });
    </script>
</body>

</html>