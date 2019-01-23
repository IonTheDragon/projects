<%@ Page Language="C#" AutoEventWireup="true" CodeFile="PageProcessor.aspx.cs" Inherits="Bin_PageProcessor" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
    <script>
        var iLoopCounter = 1;
        var iMaxLoop = 6;
        var iIntervalId;

        function BeginPageLoad() {
            // Перенаправить браузер на другую страницу с сохранением фокуса
            location.href = "<%=PageToLoad %>";

            // Обновлять индикатор выполнения каждые 0.5 секунды
            iIntervalId = window.setInterval(
            "iLoopCounter=UpdateProgressMeter(iLoopCounter,iMaxLoop);", 500);
        }

        function UpdateProgressMeter(iCurrentLoopCounter, iMaximumLoops) {
         // Найти объект для элемента span с текстом о состоянии выполнения
            var progressMeter = document.getElementById("ProgressMeter")

            iCurrentLoopCounter += 1;
            if (iCurrentLoopCounter <= iMaximumLoops) {
                progressMeter.innerHTML += ".";
                return iCurrentLoopCounter;
            }
            else {
                progressMeter.innerHTML = "";
            return 1;
            }
        }

        function EndPageLoad() {
            window.clearInterval(iIntervalId);

            var progressMeter = document.getElementById("ProgressMeter")
            progressMeter.innerHTML = "Страница загружена - переадресация";
        }
    </script>
</head>
<body onload="BeginPageLoad();" onunload="EndPageLoad();">
    <form id="form1" runat="server">
        <div style="position:absolute; left:50%; top:50%; margin-left:-110px; margin-top:-25px">
            <span id="MessageText" style="font-size: x-large; font-weight: bold">Загрузка страницы</span>
            <span id="ProgressMeter"></span>
            <br />
            <img src="ajax-loader.gif" />
        </div>
    </form>
</body>
</html>
