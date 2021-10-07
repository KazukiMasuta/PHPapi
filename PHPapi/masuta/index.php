<!-- チャットプラスのチャットを表示する画面 -->

<!DOCTYPE html>

<head>
    <title>チャット画面</title>
</head>

<body>
    <!-- ここにscriptタグを貼る -->
    <?php
    $today = date('Y/m/d');
    $search_url = "http://api.jugemkey.jp/api/horoscope/free/".$today;
    $json = file_get_contents($search_url);
    $data = json_decode($json, false);


    print("<pre>");
    var_dump($data->horoscope->$today[2]->content);
    print("</pre>")
    ?>

    <script>(function(){
        var w=window,d=document;
        var s="https://app.chatplus.jp/cp.js";
        d["__cp_d"]="https://app.chatplus.jp";
        d["__cp_c"]="3cf0878c_1";
        var a=d.createElement("script"), m=d.getElementsByTagName("script")[0];
        a.async=true,a.src=s,m.parentNode.insertBefore(a,m);})();
    </script>
</body>