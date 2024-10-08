<?php
$html = "<!DOCTYPE html><head><title>test-shell</title>";
$css = "<style type='text/css'>
body{
    font-family: 'Inter', sans-serif;
    display: flex;
    min-height:100vh;
    margin:0;
    background:#0f0f0f;
    color:#fff;
    font-size:12px;
}
.container{
    display: flex;
    flex-direction: column;
    border: 2px solid #D77189;
    padding: 1.5rem;
    border-radius: 0.5rem;
    position: relative;
    width:100%;
}
.header{

}
hr{
margin: 1.5rem 0rem 1.5rem 0rem;
border: 1px solid #D77189;
display:flex;
width:100%;
}
</style></head><body>
";
echo $html;
echo $css;
echo "<div class='container'>";
echo "<div class='header'>" . php_uname() . "<br/>Directory: " . getcwd() . "<br/>User: " . get_current_user() . "<br/>User IP: " . $_SERVER['REMOTE_ADDR'] . "<br/>Server IP : " . gethostbyname($_SERVER['HTTP_HOST']) . "</div>";
echo "<hr></div>";
