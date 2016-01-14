<?php
require_once("system.php");

if(isset($_GET["Action"])){
    if($_GET["Action"] == "Saldo"){
        Update("Saldos");?>
        BRL: <span id="brl"><?php echo $_SESSION["Temp"]["Saldos"]["brl"];?></span><br>
        BTC: <span id="btc"><?php echo $_SESSION["Temp"]["Saldos"]["btc"];?></span><br>
        LTC: <span id="ltc"><?php echo $_SESSION["Temp"]["Saldos"]["ltc"];?></span><?php
    }
}else{
    require_once("head.php");?>
    <table class="Center" style="width:100%">
        <tr>
            <td style="text-align:center;width:20%;" id="AjaxSaldo"></td>
            <td style="text-align:center;">
                Versão <?php echo file_get_contents("versao.txt");?> de <?php echo file_get_contents("https://raw.githubusercontent.com/FabioCarpi/FastMB/master/www/versao.txt");?><br>
                Negociações: <a href="#" onclick="Ajax('mercadobtc.php','AjaxPagina');">Bitcoins</a> -
                <a href="#" onclick="Ajax('mercadoltc.php','AjaxPagina');">Litecoin</a><br> 
                Ordens: <a href="#" onclick="Ajax('ordens.php?Action=Form','AjaxJanelaNovaConteudo');
                    document.getElementById('AjaxJanelaNova').style.visibility = 'visible';"
                >Nova</a> -
                <a href="#" onclick="Ajax('concluidas.php','AjaxJanelaConcluidasConteudo');
                    document.getElementById('AjaxJanelaConcluidas').style.visibility = 'visible';
                    document.getElementById('AjaxJanelaConcluidas').style.height = (window.innerHeight / 1.1) + 'px';"
                >Concluídas</a> - 
                <a href="#" onclick="Ajax('simulador.php','AjaxJanelaSimuladorConteudo');
                    document.getElementById('AjaxJanelaSimulador').style.visibility = 'visible';"
                >Simulador</a>
            </td>
            <td rowspan="3" style="vertical-align:top;width:50%;">
                <iframe src="https://www.tradingview.com/chart/8rG7IftD/" width="100%" id="chart"></iframe>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" colspan="2" id="AjaxOrdens"></td>
        </tr>
        <tr>
            <td style="text-align:center;vertical-align:top;" colspan="2" id="AjaxPagina"></td>
        </tr>
    </table>
    <div id="AjaxJanelaNova">
        <div style="text-align:right;background-color:#3366ff;">
            <img src="del.gif" onclick="document.getElementById('AjaxJanelaNova').style.visibility = 'hidden';">
        </div>
        <div id="AjaxJanelaNovaConteudo" style="overflow:auto;text-align:center;"></div>
    </div>
    <div id="AjaxJanelaConcluidas">
        <div id="AjaxJanelaConcluidasTitulo" style="text-align:right;background-color:#3366ff;">
            <img src="del.gif" onclick="document.getElementById('AjaxJanelaConcluidas').style.visibility = 'hidden';">
        </div>
        <div id="AjaxJanelaConcluidasConteudo" style="overflow:auto;text-align:center;"></div>
    </div>
    <div id="AjaxJanelaSimulador">
        <div id="AjaxJanelaSimuladorTitulo" style="text-align:right;background-color:#3366ff;">
            <img src="del.gif" onclick="document.getElementById('AjaxJanelaSimulador').style.visibility = 'hidden';">
        </div>
        <div id="AjaxJanelaSimuladorConteudo" style="overflow:auto;text-align:center;"></div>
    </div>
    <script>
        Ajax("index.php?Action=Saldo", "AjaxSaldo", null, true);
        Ajax("ordens.php?pair=btc", "AjaxOrdens", null, true);
        Ajax("mercadobtc.php", "AjaxPagina");
        document.getElementById("chart").height = (window.innerHeight - 10) + "px";
        document.getElementById('AjaxJanelaConcluidasConteudo').style.height = (window.innerHeight / 1.1) - 25 + "px";
        setInterval(function(){
           document.getElementById("TimerOrdens").innerHTML--;
        }, 1000);
        
        var selected = null, x_pos = 0, y_pos = 0, x_elem = 0, y_elem = 0;
        function _drag_init(elem) {
            selected = elem;
            x_elem = x_pos - selected.offsetLeft;
            y_elem = y_pos - selected.offsetTop;
        }
        function _move_elem(e) {
            x_pos = document.all ? window.event.clientX : e.pageX;
            y_pos = document.all ? window.event.clientY : e.pageY;
            if (selected !== null) {
                selected.style.left = (x_pos - x_elem) + 'px';
                selected.style.top = (y_pos - y_elem) + 'px';
            }
        }
        function _destroy() {
            selected = null;
        }
        document.getElementById("AjaxJanelaNova").onmousedown = function (){
            _drag_init(this);
            return false;
        };
        document.getElementById("AjaxJanelaSimulador").onmousedown = function (){
            _drag_init(this);
            return false;
        };
        document.getElementById("AjaxJanelaConcluidas").onmousedown = function (){
            _drag_init(this);
            return false;
        };
        document.onmousemove = _move_elem;
        document.onmouseup = _destroy;
    </script><?php
}
require_once("foot.php");