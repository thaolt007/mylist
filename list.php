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
                <div class="left"><input id="link" type="text" placeholder="Hyperlink or Text" autofocus/></div>
                <div class="right"><input id="submit-but" type="submit" value="OK" /> </div>
            </div>
        </div>
        <!--End id top--></!--End>
        <div class="break-line"></div>
        <div id="mid">
            <?php printdata($data);?>
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
            $('.link-row:last').css("border-bottom", "none");
        });
        $('#submit-but').click(function (e) {
            e.preventDefault(); //loai bo cac hanh dong mac dinh

            var text = $('#link').val();
            $.ajax({
                type: 'POST', // method
                url: './process.php', // action
                dataType: 'JSON', // kieu du lieu nhan ve
                data: {// data gui cung request
                    text: text
                },
                success: function (data) {// thanh cong status http = 200
                    // in ket qua sang tab console
//                    console.log(data);
                    // xu ly du lieu tra ve
                    if (data.code === 1) {
                        console.log(data);
                        var link;
                        if (data.type) {
                            link = '<a href="';
                        }
                        else {
                            link = '<a href="http://google.com/?q=';
                        }
                        $('#mid').prepend(
                                '<div class="link-row" style="display: none;"><div class="left">'+ link + data.text + '" target="_blank">' + data.text + '</a></div>' +
                                '<div class="right"><p>' + data.day + '</p></div></div>' +
                                '<div class="break-line"></div>'
                                );
                        $('.link-row:first').slideDown();
                        $('.link-row:last').css("border-bottom", "none");
                        $('#link').val('');

                    }
                    else {
                        console.log(data.error);
                        $('#link').val('');
                    }

                }
            });
        });
    </script>
</body>

</html>