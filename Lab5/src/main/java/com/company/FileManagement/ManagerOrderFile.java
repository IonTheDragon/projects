package com.company.FileManagement;

import java.util.*;
import java.io.*;
import com.company.*;

public class ManagerOrderFile extends AManageOrder{
    public ManagerOrderFile(String m_path){
        super(m_path);
    }

    public void readById(UUID m_id){

        Orders OrdersIn = new Orders();

        try(ObjectInputStream ois = new ObjectInputStream(new FileInputStream(path)))
        {
            OrdersIn = (Orders)ois.readObject();
        }
        catch(Exception ex){

            System.out.println(ex.getMessage());
        }


        for(Order ord : OrdersIn.OrdersList)
        {
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

        Order m_order = this.getOrderById(m_orders, m_id);

        try(ObjectOutputStream oos = new ObjectOutputStream(new FileOutputStream(path))) {
            if (m_order.Status.equalsIgnoreCase("Empty Order")) {

            }
            else {
                oos.writeObject(m_order);
            }
        }
        catch(IOException e) {
            e.printStackTrace();
        }
    }

    public void readAll(){

        Orders OrdersIn = new Orders();

        try(ObjectInputStream ois = new ObjectInputStream(new FileInputStream(path)))
        {
            OrdersIn = (Orders)ois.readObject();
        }
        catch(Exception ex){

            System.out.println(ex.getMessage());
        }


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

        try(ObjectOutputStream oos = new ObjectOutputStream(new FileOutputStream(path))) {
            oos.writeObject(m_orders);
        }
        catch(Exception ex) {
            System.out.println(ex.getMessage());
        }
    }


}
