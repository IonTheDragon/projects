<%@ Page Language="C#" AutoEventWireup="true" CodeFile="Default.aspx.cs" Inherits="_Default" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="StyleSheet.css"/>
    <title>Visual Geometry Editor</title>
   
    <script>
        function PageLoading() {
            var ImgLoad = document.getElementById("ImageLoad");
            ImgLoad.src = "ajax-loader2.gif";            
        }
        function PageLoaded() {
            var ImgLoad = document.getElementById("ImageLoad");
            ImgLoad.src = "loaded.gif";            
        }
    </script>

</head>
<body onload="PageLoaded()" onwaiting="PageLoading()">
    <form id="form1" runat="server">
        <h1>Visual geometry editor</h1>
        <div id="main">
			<asp:Panel ID="LeftPanel" runat="server" CssClass="lpanel" ScrollBars="Auto">
                <p style="padding-top: 5px; padding-left: 5px; color: #99CCFF">Actions</p>
			</asp:Panel>
        	<br />
			<img id="ImageLoad" src="ajax-loader2.gif" style="position:absolute; top: 65px; left: 130px;" runat="server" />
            <p id="choosedpoint1" style="width:auto; position:absolute; top: 50px; left: 260px; color: #99CCFF" runat="server">Select point 1</p>
            <p id="choosedpoint2" style="width:auto; position:absolute; top: 50px; left: 600px; color: #99CCFF" runat="server">Select point 2</p>
			<br />
            <asp:Panel ID="RightPanel" runat="server" CssClass="rpanel">
                <p style="padding-top: 5px; padding-left: 5px; color: #99CCFF">Enter object parameters</p>
                <p style="padding-left: 5px; margin-bottom: 3px; color: #99CCFF">Dimension count</p>
                <asp:TextBox id="dimnum" runat="server" TextMode="Number" Width="94px">3</asp:TextBox>
                <asp:Button ID="accept" CssClass="baccept" runat="server" Text="Accept" OnClick="accept_Click" EnableViewState="False" />  
                <br/>
                <br/>
                <p style="padding-left: 5px; margin-bottom: 3px; color: #99CCFF">Add point (use format &quot;x y z")</p>             
                <asp:TextBox id="pointcoord" runat="server" Width="94px" EnableViewState="False"/>
                <asp:Button ID="AddPoint" CssClass="baddpoint" runat="server" Text="Add" OnClick="AddPoint_Click" EnableViewState="False" />
                <br/>
                <br/>               
                <p style="padding-left: 5px; margin-bottom: 10px; color: #99CCFF">Coordinates centre</p>
                <p style="padding-left: 5px; margin-bottom: 3px; margin-top: 3px; color: #99CCFF">Delta x of window</p>
                <asp:TextBox ID="deltax" runat="server" TextMode="Number" Width="94px">50</asp:TextBox>
                <p style="padding-left: 5px; margin-bottom: 3px; margin-top: 3px; color: #99CCFF">Delta y of window</p>
                <asp:TextBox ID="deltay" runat="server" TextMode="Number" Width="94px" style="margin-bottom:10px;">50</asp:TextBox>
                <br/> 
                <asp:Button ID="MoveBut" runat="server" Text="Move" OnClick="MoveBut_Click" EnableViewState="False" />
                <br/>                
                <br/>
                <asp:Button ID="ClearBut" runat="server" Text="Clear" CssClass="bclearpoint" OnClick="ClearBut_Click" EnableViewState="False" />                
                <p style="padding-left: 5px; margin-bottom: 3px; color: #99CCFF">Add line</p> 
                <p style="padding-left: 5px; margin-bottom: 3px; margin-top: 3px; color: #99CCFF">Using x1, y1, x2, y2 of window</p>
                <asp:TextBox ID="x1Box" runat="server" ToolTip="x1 of window" Width="94px" EnableViewState="False"></asp:TextBox>
                <asp:TextBox ID="y1Box" runat="server" ToolTip="y1 of window" Width="94px" EnableViewState="False"></asp:TextBox>
                <asp:TextBox ID="x2Box" runat="server" ToolTip="x2 of window" Width="94px" EnableViewState="False"></asp:TextBox>
                <asp:TextBox ID="y2Box" runat="server" ToolTip="y2 of window" Width="94px" EnableViewState="False"></asp:TextBox>
                <asp:Button ID="AddLine" CssClass="baddpoint" runat="server" Text="Add" style="margin-bottom: 20px;" OnClick="AddLine_Click" EnableViewState="False"/>
                <br/>
                <asp:Button ID="UpdateBut" runat="server" Text="Update" CssClass="bclearpoint" style="margin-bottom: 5px;" EnableViewState="False"/>
            </asp:Panel>
            <asp:Panel ID="MainPanel" runat="server" CssClass="mpanel" BorderColor="#0066FF" BorderStyle="Solid" Height="3000px" ScrollBars="Auto" BackColor="Black">
                <asp:Image ID="Axes" Width = "100" Height ="100" runat="server" ImageUrl="~/xyz.png" />
            </asp:Panel>
			<br />
			<br />
        </div>
        <script type="text/javascript">            
            document.getElementById('MainPanel').onmousedown = function () {
                var target=event.target;
                var points = document.getElementsByClassName('Point');
                for (var i = 0; i < points.length; i++) {
                    if (target == points[i]) {
                        if (document.getElementById('x1Box').value == "" && document.getElementById('y1Box').value == "") {
                            document.getElementById('x1Box').value = points[i].style.left.replace(/px/g, "");
                            document.getElementById('x1Box').value = document.getElementById('x1Box').value.replace(/\./g, ",");
                            document.getElementById('y1Box').value = points[i].style.top.replace(/px/g, "");
                            document.getElementById('y1Box').value = document.getElementById('y1Box').value.replace(/\./g, ",");
                            document.getElementById('choosedpoint1').innerHTML = "Selected " + points[i].title;
                        }
                        else if (document.getElementById('x2Box').value == "" && document.getElementById('y2Box').value == "") {
                            document.getElementById('x2Box').value = points[i].style.left.replace(/px/g, "");
                            document.getElementById('x2Box').value = document.getElementById('x2Box').value.replace(/\./g, ",");
                            document.getElementById('y2Box').value = points[i].style.top.replace(/px/g, "");
                            document.getElementById('y2Box').value = document.getElementById('y2Box').value.replace(/\./g, ",");
                            //document.getElementById('choosedpoint2').innerHTML = "Created line to " + points[i].title;
                            document.getElementById('AddLine').click();
                            //create line
                        }
                    }
                }
            }
        </script>
    </form>

</body>
</html>
