package com.company.FileManagement;

import java.util.*;
import java.io.*;
import com.company.*;

import org.json.JSONArray;
import org.json.JSONObject;

public class ManagerOrderJSON extends AManageOrder  {
    public ManagerOrderJSON (String m_path){
        super(m_path);
    }

    public void readById(UUID m_id){

        StringBuilder data = new StringBuilder();
        Order ord = new Order();

        try
        {
            FileReader reader = new FileReader(new File(path));
            int ch;
            while ((ch = reader.read()) != -1) {
                data.append((char) ch);
            }
            reader.close();
        }
        catch(IOException e){
            e.printStackTrace();
        }

        JSONObject DataJsonObject = new JSONObject(data);
        JSONArray weatherArray = (JSONArray) DataJsonObject.get("order");

        for(Object obj : weatherArray)
        {
            ord = (Order)obj;
            if (ord.OurUser.GetId()==m_id) {
                System.out.println("__________\n");
                System.out.println("Заказчик\n");
                System.out.println("ID: "+ord.OurUser.GetId()+"\n");
                System.out.println("Имя: "+ord.OurUser.GetName()+"\n");
                System.out.println("Фамилия: "+ord.OurUser.GetSname()+"\n");
                System.out.println("Отчество: "+ord.OurUser.GetFatherName()+"\n");
                System.out.println("Email: "+ord.OurUser.GetMail()+"\n");
                System.out.println("__________\n");

                this.ShowDevices(ord.PurchasingItemsList);
                break;
            }
        }

    }

    public void saveById(Orders m_orders, UUID m_id){

        File m_file = new File(path);
        try {
            BufferedWriter writer = new BufferedWriter(new FileWriter(m_file, true));

            Order m_order = this.getOrderById(m_orders, m_id);

            if (m_order.Status.equalsIgnoreCase("Empty Order")) {

            }
            else {
                JSONObject jsonObject = new JSONObject();
                jsonObject.put("order", m_order);

                writer.write(jsonObject.toString());
            }
            writer.flush();
            writer.close();
        }
        catch(IOException e) {
            e.printStackTrace();
        }
    }

    public void readAll(){

        StringBuilder data = new StringBuilder();
        Orders OrdersIn = new Orders();

        try
        {
            FileReader reader = new FileReader(new File(path));
            int ch;
            while ((ch = reader.read()) != -1) {
                data.append((char) ch);
            }
            reader.close();
        }
        catch(IOException e){
            e.printStackTrace();
        }

        JSONObject DataJsonObject = new JSONObject(data.toString());
        OrdersIn = (Orders)DataJsonObject.get("order");

        for(Order ord : OrdersIn.OrdersList)
        {
            System.out.println("__________\n");
            System.out.println("Заказчик\n");
            System.out.println("ID: "+ord.OurUser.GetId()+"\n");
            System.out.println("Имя: "+ord.OurUser.GetName()+"\n");
            System.out.println("Фамилия: "+ord.OurUser.GetSname()+"\n");
            System.out.println("Отчество: "+ord.OurUser.GetFatherName()+"\n");
            System.out.println("Email: "+ord.OurUser.GetMail()+"\n");
            System.out.println("__________\n");
            this.ShowDevices(ord.PurchasingItemsList);
        }
    }

    public void saveAll(Orders m_orders){

        File m_file = new File(path);
        JSONObject jsonObject = new JSONObject();

        try {
            BufferedWriter writer = new BufferedWriter(new FileWriter(m_file, true));
            int i = 0;
            for (Object m_order : m_orders.OrdersList) {
                if (i==0) jsonObject.put("order", (Order)m_order);
                else if (i==1) jsonObject.accumulate("order", (Order)m_order);
                else jsonObject.append("order", (Order)m_order);
                i++;
            }
            writer.write(jsonObject.toString());
            writer.flush();
            writer.close();
        }
        catch(IOException e) {
            e.printStackTrace();
        }
    }
}
