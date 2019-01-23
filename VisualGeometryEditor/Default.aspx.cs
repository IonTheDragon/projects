using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Drawing;
using System.Drawing.Drawing2D;
using System.Drawing.Imaging;
using System.Text.RegularExpressions;
using System.Web.Services;

public partial class _Default : System.Web.UI.Page
{
    Label c = new Label();

    protected void Page_Load(object sender, EventArgs e)
    {
        LeftPanel.Controls.Add(c);
        c.ID = "ActionsLabel";
        c.Style["Color"] = "#99CCFF";
        Axes.Style["position"] = "absolute";

        if (Session["Dim"] == null) Session["Dim"] = 3; //Default dim after load       
        if (Session["newcap"] == null) Session["newcap"] = "";
        if (Session["AddClicked"] == null) Session["AddClicked"] = "0";
    }

    protected void Page_PreRender(object sender, EventArgs e)
    {
        Regex regex = new Regex(@"[0-9]+");
        string s = "";
        if (Session["Points"] != null) s = (string)Session["Points"];

        if (regex.IsMatch(s)) //Create point buttons if Points is not null
        {
            updPanel(Session["Points"].ToString(), Convert.ToInt32(Session["Dim"]));           
            if (Session["AddClicked"].ToString() == "1")
            {
                Session["Action"] += "Added point ";
                Session["Action"] += Session["newcap"].ToString();
                Session["Action"] += "<br>";
                Session["AddClicked"] = "0";
            }
        }
        else
        {
            Session["Action"] += "No data to visualise<br>";
        }
        c.Text = (string)Session["Action"];

        //ImageLoad.Src = "loaded.gif";
    }

    protected void AddPoint_Click(object sender, EventArgs e)
    {        
        Regex regex = new Regex(@"[0-9]+");

        try //Checking format of entered coordinates
        {
            string[] pointcoordrow = pointcoord.Text.Split(new char[] { ' ' }, StringSplitOptions.RemoveEmptyEntries); //For format checking and showing entered coordinates in history
            double[] numbersrow = pointcoordrow.Select(x => Convert.ToDouble(x)).ToArray(); //For format checking
            if (regex.IsMatch(pointcoord.Text))
            {
                Session["Points"] += pointcoord.Text;
                Session["Points"] += ";";
                Session["AddClicked"] = "1";
            }
            else Session["Action"] += "No data typed<br>";         
        }
        catch (FormatException ex)
        {
            Session["Action"] += "Format error. No data typed";
            Session["Action"] += "<br>";
        }
    }

    protected void accept_Click(object sender, EventArgs e) //Accept dimension
    {
        if (Convert.ToInt32(dimnum.Text) <= 0)
        {            
            Session["Action"] += "Dimension must be > 0";
            Session["Action"] += "<br>";
            Session["Action"] += "Dimension now is ";
            Session["Action"] += Session["Dim"].ToString();
            Session["Action"] += "<br>";
        }
        else
        {
            Session["Dim"] = Convert.ToInt32(dimnum.Text);
            Session["Action"] += "Dimension set to ";
            Session["Action"] += Session["Dim"].ToString();
            Session["Action"] += "<br>";            
        }
        if (Convert.ToInt32(Session["Dim"]) == 1) //1D
        {
            Axes.ImageUrl = "x.png";
            deltax.Text = "0";
            Session["dx"] = 0;
            deltay.Text = "100";
            Session["dy"] = 100;
        }
        else if (Convert.ToInt32(Session["Dim"]) == 2) //2D
        {
            Axes.ImageUrl = "xy.png";
            deltax.Text = "0";
            Session["dx"] = 0;
            deltay.Text = "0";
            Session["dy"] = 0;
        }
        else
        {
            Axes.ImageUrl = "xyz.png";
            deltax.Text = "50";
            Session["dx"] = 50;
            deltay.Text = "50";
            Session["dy"] = 50;
        }

        int dim = Convert.ToInt32(Session["Dim"]);

        if (dim < 3)
        {
            Axes.Style["left"] = Convert.ToInt32(Session["dx"]) + "px";
            Axes.Style["top"] = Convert.ToInt32(Session["dy"]) + "px";
        }
        else
        {
            Axes.Style["left"] = Convert.ToInt32(Session["dx"]) - 50 + "px";
            Axes.Style["top"] = Convert.ToInt32(Session["dy"]) - 50 + "px";
        }

    }

    protected void ClearBut_Click(object sender, EventArgs e)
    {
        Session["Points"] = "";
        Session["Lines"] = "";
        Session["Action"] = "";
        Session["Action"] += "Panel is cleared";
        Session["Action"] += "<br>";
    }

    void updPanel(string points, int dim)
    {
        if (Session["dx"] == null) Session["dx"] = 50; //Default dx after load
        if (Session["dy"] == null) Session["dy"] = 50; //Default dy after load
        if (dim < 3)
        {
            Axes.Style["left"] = Convert.ToInt32(Session["dx"]) + "px";
            Axes.Style["top"] = Convert.ToInt32(Session["dy"]) + "px";
        }
        else
        {
            Axes.Style["left"] = Convert.ToInt32(Session["dx"]) - 50 + "px";
            Axes.Style["top"] = Convert.ToInt32(Session["dy"]) - 50 + "px";
        }

        //Add points
        string[] A = points.Split(new char[] { ';' }, StringSplitOptions.RemoveEmptyEntries);//Creating array of coordinate values for points
        for (int i = 0; i < A.Length; i++)
        {
            string cap = "";
            string[] row = A[i].Split(new char[] { ' ' }, StringSplitOptions.RemoveEmptyEntries); //Creating row of coordinates for every point (x y z...)
            double[] numbers = row.Select(x => Convert.ToDouble(x)).ToArray();          
            int numlength = dim;
            if (numbers.Length > dim) numlength = numbers.Length;
            double[] coord = new double[numlength];
            for (int j = 0; j < numlength; j++)
            {
                if (j >= numbers.Length)
                {
                    coord[j] = 0;
                }
                else coord[j] = numbers[j];
                cap += coord[j];
                cap += ";";
                Session["newcap"] = cap;
            }

            ImageButton b = new ImageButton();
            b.ToolTip = "Point " + cap;
            b.ID = "Point"+i;
            b.ImageUrl = "point6x6.png";
            b.CssClass = "Point";
            //b.CommandName = "PointClick";
            //b.Enabled = false;
            b.OnClientClick = "return false;";
            //b.Click += Point_Click;
            double leftc;
            double topc;

            if (dim == 1) //1D
            {
                leftc = coord[0] - 3 + Convert.ToDouble(Session["dx"]); //x
                topc = Convert.ToDouble(Session["dy"]); //y is static                   
            }
            else if (dim == 2) //2D
            {
                leftc = coord[0] - 3 + Convert.ToDouble(Session["dx"]); //x
                topc = coord[1] - 3 + Convert.ToDouble(Session["dy"]); //y
            }
            else
            {
                double d4 = 0;
                if (coord.Length==4) d4 = coord[3];
                leftc = -coord[0] * Math.Cos(Math.PI/6) + coord[1] * Math.Cos(Math.PI / 6) + d4 - 3 + Convert.ToDouble(Session["dx"]); //x
                topc = coord[0] * Math.Sin(Math.PI / 6) + coord[1] * Math.Sin(Math.PI / 6) + coord[2] - 3 + Convert.ToDouble(Session["dy"]); //y                    
            }

            string pattern = @",";
            string replacement = "."; //Replace "," with "." for css style

            b.Style["left"] = Regex.Replace(leftc.ToString(), pattern, replacement) + "px";
            b.Style["top"] = Regex.Replace(topc.ToString(), pattern, replacement) + "px";
            b.Style["position"] = "absolute";
            b.Style["z-index"] = "2";
            b.Width = 6;
            b.Height = 6;
            MainPanel.Controls.Add(b);
        }

        //add lines
        string lines = "";
        if (Session["Lines"] != null) lines = (string)Session["Lines"];
        string[] rows = lines.Split(new char[] { ';' }, StringSplitOptions.RemoveEmptyEntries);//Creating array of rows {x1 x2 y1 y2}
        for (int i = 0; i < rows.Length; i++)
        {
            string[] row = rows[i].Split(new char[] { ' ' }, StringSplitOptions.RemoveEmptyEntries); //Select i-th row {x1 x2 y1 y2}
            double[] coord = row.Select(x => Convert.ToDouble(x)).ToArray();
            System.Web.UI.WebControls.Image img = new System.Web.UI.WebControls.Image();
            double x1 = coord[0] + Convert.ToDouble(Session["dx"]) + 2;
            double x2 = coord[1] + Convert.ToDouble(Session["dx"]) + 2;
            double y1 = coord[2] + Convert.ToDouble(Session["dy"]) + 2;
            double y2 = coord[3] + Convert.ToDouble(Session["dy"]) + 2;
            string pattern = @",";
            string replacement = "."; //Replace "," with "." for css style
            double leftc = x1;
            double topc = y1;
            if ((x2 - x1) < 0)
            {
                leftc = x2;
            }
            if ((y2 - y1) < 0)
            {
                topc = y2;
            }
            img.Style["left"] = Regex.Replace(leftc.ToString(), pattern, replacement) + "px";
            img.Style["top"] = Regex.Replace(topc.ToString(), pattern, replacement) + "px";
            img.Style["position"] = "absolute";
            img.Style["z-index"] = "1";
            //img.BackColor = Color.Transparent;
            img.ImageUrl = "LineForm.aspx?X1=" + x1 + "&X2=" + x2 + "&Y1=" + y1 + "&Y2=" + y2;
            MainPanel.Controls.Add(img);
        }
    }

    protected void MoveBut_Click(object sender, EventArgs e)
    {
        Session["dx"] = deltax.Text;
        Session["dy"] = deltay.Text;
        if (Session["Dim"] == null) Session["Dim"] = 3; //Default dim after load
        int dim = Convert.ToInt32(Session["Dim"]);

        if (dim < 3)
        {
            Axes.Style["left"] = Convert.ToInt32(Session["dx"]) + "px";
            Axes.Style["top"] = Convert.ToInt32(Session["dy"]) + "px";
        }
        else
        {
            Axes.Style["left"] = Convert.ToInt32(Session["dx"])-50 + "px";
            Axes.Style["top"] = Convert.ToInt32(Session["dy"])-50 + "px";
        }

        Session["Action"] += "New coordinates offset is: dx = ";
        Session["Action"] += Session["dx"].ToString();
        Session["Action"] += "; dy = ";
        Session["Action"] += Session["dy"].ToString();
        Session["Action"] += ";<br>";       
    }


    protected void AddLine_Click(object sender, EventArgs e)
    {
        double dx = 0;
        double dy = 0;
        if (Session["dx"] != null) dx = Convert.ToDouble(Session["dx"]);
        if (Session["dy"] != null) dy = Convert.ToDouble(Session["dy"]);

        if (x1Box.Text != "" && x2Box.Text != "" && y1Box.Text != "" && y2Box.Text != "")
        {
            if (x1Box.Text == x2Box.Text && y1Box.Text == y2Box.Text)
            {
                Session["Action"] += "Cannot add line<br>";                
            }
            else
            {
                //string pattern = @".";
                //string replacement = ","; //Replace "." with "," for double
                string x1 = (Convert.ToDouble(x1Box.Text)- dx).ToString(); // coord without delta
                string x2 = (Convert.ToDouble(x2Box.Text) - dx).ToString();
                string y1 = (Convert.ToDouble(y1Box.Text) - dy).ToString();
                string y2 = (Convert.ToDouble(y2Box.Text) - dy).ToString();

                Session["Lines"] += x1 + " " + x2 + " " + y1 + " " + y2 + ";";

                Session["Action"] += "Added line<br>";

                x1Box.Text = "";
                x2Box.Text = "";
                y1Box.Text = "";
                y2Box.Text = "";
            }
            c.Text = (string)Session["Action"];
        }
    }
}