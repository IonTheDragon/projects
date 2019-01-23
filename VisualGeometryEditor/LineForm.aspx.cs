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

public partial class Bin_LineForm : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        if ((String.IsNullOrEmpty(Request.QueryString["X1"])) ||
            (String.IsNullOrEmpty(Request.QueryString["Y1"])) ||
            (String.IsNullOrEmpty(Request.QueryString["X2"])) ||
            (String.IsNullOrEmpty(Request.QueryString["Y2"])))
        {
            // Часть данных отсутствует, поэтому ничего не выводить на экран. 
            // Другие возможные варианты действий - выбор подходящих значений по умолчанию 
            // или возврат изображения со статическим текстом сообщения об ошибке
        }
        else
        {
            double x1 = double.Parse(Request.QueryString["X1"]);
            double y1 = double.Parse(Request.QueryString["Y1"]);
            double x2 = double.Parse(Request.QueryString["X2"]);
            double y2 = double.Parse(Request.QueryString["Y2"]);

            double l = Math.Sqrt(Math.Pow((x2 - x1), 2) + Math.Pow((y2 - y1), 2)); //length = sqrt(dx^2+dy^2)
            int x = Convert.ToInt32(Math.Ceiling(Math.Abs(x2 - x1)));
            int y = Convert.ToInt32(Math.Ceiling(Math.Abs(y2 - y1)));
            if ((x == 0) && (y != 0))
            {
                x = 2;
            }
            if ((y == 0) && (x != 0))
            {
                y = 2;
            }

            // Создать хранящееся в памяти растровое изображение,
            // где будет выполняться рисование
            if ((x2 - x1) != 0 || (y2 - y1) != 0)
            {
                using (Bitmap image = new Bitmap(x, y, PixelFormat.Format32bppArgb))
                {
                    using (Graphics graphic = Graphics.FromImage(image))
                    {
                        // Нарисовать эскиз
                        //float angle = (float)Math.Acos((x2 - x1) / l);
                        //graphic.RotateTransform(angle);
                        float x0 = 0;
                        float y0 = 0;
                        float xend = (float)Math.Abs(x2 - x1);
                        float yend = (float)Math.Abs(y2 - y1);
                        if ((x2 - x1)<0)
                        {
                            float c = y0;
                            y0 = yend;
                            yend = c;
                        }
                        if ((y2 - y1) < 0)
                        {
                            float c = x0;
                            x0 = xend;
                            xend = c;
                        }
                        Pen pen = new Pen(Color.White, 2);
                        graphic.DrawLine(pen, x0, y0, xend + 1, yend + 1);

                        // Сохранить изображение
                        image.Save(Response.OutputStream, ImageFormat.Png);
                    }
                }
            }
        }
    }
}