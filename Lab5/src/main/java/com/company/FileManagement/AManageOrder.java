package com.company.FileManagement;

import java.util.*;
import java.io.*;
import com.company.*;
import com.company.Devices.*;

abstract public class AManageOrder implements IOrder {

    public String path;

    public AManageOrder(String m_path){
        path = m_path;
    }

    public void readById(UUID m_id){

        StringBuilder data = new StringBuilder();
        try {
            FileReader reader = new FileReader(new File(path));
            int ch;
            while ((ch = reader.read()) != -1) {
                data.append((char)ch);
            }
            reader.close();

            StringBuilder CurrentData = new StringBuilder();
            CurrentData.append("Id устройства,Тип устройства,Количество,Название,Цена,Изготовитель,Модель,ОС,корпус/карта/процессор,число карт/разрешение,Id покупателя,Имя,Фамилия,Отчество,Почта,Статус заказа\r\n");
            CurrentData.append(",,,,,,,,,,");
            int firstindex = data.lastIndexOf(m_id.toString());
            int lastindex = data.indexOf("Id устройства",firstindex);
            if (firstindex != -1 && data.lastIndexOf(m_id.toString()+",Phone,") == -1 && data.lastIndexOf(m_id.toString()+",SmartPhone,") == -1  && data.lastIndexOf(m_id.toString()+",Book,") == -1) {
                for (int i = firstindex; i < lastindex; i++) {
                    char m_ch = data.charAt(i);
                    CurrentData.append(m_ch);
                }
                System.out.print(CurrentData);
            }
            else System.out.print("ID не найден");
        }
        catch(IOException e) {
            e.printStackTrace();
        }

    }

    public void saveById(Orders m_orders, UUID m_id){

        File m_file = new File(path);
        try {
            BufferedWriter writer = new BufferedWriter(new FileWriter(m_file,true));

            Order m_order = this.getOrderById(m_orders, m_id);
            List<Device> m_PurchasingItemsList = m_order.PurchasingItemsList;

            if (m_order.Status.equalsIgnoreCase("Empty Order")) {

            }

            else {

                writer.write("Id устройства,Тип устройства,Количество,Название,Цена,Изготовитель,Модель,ОС,корпус/карта/процессор,число карт/разрешение,Id покупателя,Имя,Фамилия,Отчество,Почта,Статус заказа\r\n");
                User user = m_order.OurUser;
                writer.write(",,,,,,,,,," + user.id.toString() + "," + user.Name + "," + user.Sname + "," + user.FatherName + "," + user.Mail + "," + m_order.Status + "\r\n");
                //
                for (int j = 0; j < m_PurchasingItemsList.size(); j++) {
                    if (m_PurchasingItemsList.get(j).getClass().getSimpleName().equalsIgnoreCase("Phone")) {
                        Phone phone = (Phone) m_PurchasingItemsList.get(j);
                        writer.write(phone.GetId().toString() + ",Phone," + phone.GetCount() + "," + phone.GetName() + "," + phone.GetPrice() + "," + phone.GetCompany() + "," + phone.GetModel() + "," + phone.GetOs() + "," + phone.GetParam1() + "\r\n");
                    } else if (m_PurchasingItemsList.get(j).getClass().getSimpleName().equalsIgnoreCase("SmartPhone")) {
                        SmartPhone smphone = (SmartPhone) m_PurchasingItemsList.get(j);
                        writer.write(smphone.GetId().toString() + ",Smartphone," + smphone.GetCount() + "," + smphone.GetName() + "," + smphone.GetPrice() + "," + smphone.GetCompany() + "," + smphone.GetModel() + "," + smphone.GetOs() + "," + smphone.GetParam1() + "," + smphone.GetParam2() + "\r\n");
                    } else if (m_PurchasingItemsList.get(j).getClass().getSimpleName().equalsIgnoreCase("Book")) {
                        Book book = (Book) m_PurchasingItemsList.get(j);
                        writer.write(book.GetId().toString() + ",Book," + book.GetCount() + "," + book.GetName() + "," + book.GetPrice() + "," + book.GetCompany() + "," + book.GetModel() + "," + book.GetOs() + "," + book.GetParam1() + "," + book.GetParam2() + "\r\n");
                    }
                }
                //
            }
            writer.flush();
            writer.close();
        }
        catch(IOException e) {
            e.printStackTrace();
        }
    }

    public void readAll(){

        try {
            FileReader reader = new FileReader(new File(path));
            int ch;
            while ((ch = reader.read()) != -1) {
                System.out.print((char)ch);
            }
            reader.close();
        }
        catch(IOException e) {
            e.printStackTrace();
        }

    }

    public void saveAll(Orders m_orders){

        File m_file = new File(path);
        try {
            BufferedWriter writer = new BufferedWriter(new FileWriter(m_file,true));
            writer.write("Id устройства,Тип устройства,Количество,Название,Цена,Изготовитель,Модель,ОС,корпус/карта/процессор,число карт/разрешение,Id покупателя,Имя,Фамилия,Отчество,Почта,Статус заказа\r\n");
            for (int i = 0; i < m_orders.OrdersList.size(); i++) {

                Order m_order = (Order)m_orders.OrdersList.get(i);
                List<Device> m_PurchasingItemsList = m_order.PurchasingItemsList;

                User user = m_order.OurUser;
                writer.write(",,,,,,,,,,"+user.id.toString()+","+user.Name+","+user.Sname+","+user.FatherName+","+user.Mail+","+m_order.Status+"\r\n");
                //
                for (int j = 0; j < m_PurchasingItemsList.size(); j++) {
                    if (m_PurchasingItemsList.get(j).getClass().getSimpleName().equalsIgnoreCase("Phone")) {
                        Phone phone = (Phone)m_PurchasingItemsList.get(j);
                        writer.write(phone.GetId().toString()+",Phone,"+phone.GetCount()+","+phone.GetName()+","+phone.GetPrice()+","+phone.GetCompany()+","+phone.GetModel()+","+phone.GetOs()+","+phone.GetParam1()+"\r\n");
                    }
                    else if (m_PurchasingItemsList.get(j).getClass().getSimpleName().equalsIgnoreCase("SmartPhone")) {
                        SmartPhone smphone = (SmartPhone)m_PurchasingItemsList.get(j);
                        writer.write(smphone.GetId().toString()+",Smartphone,"+smphone.GetCount()+","+smphone.GetName()+","+smphone.GetPrice()+","+smphone.GetCompany()+","+smphone.GetModel()+","+smphone.GetOs()+","+smphone.GetParam1()+","+smphone.GetParam2()+"\r\n");
                    }
                    else if  (m_PurchasingItemsList.get(j).getClass().getSimpleName().equalsIgnoreCase("Book")) {
                        Book book = (Book)m_PurchasingItemsList.get(j);
                        writer.write(book.GetId().toString()+",Book,"+book.GetCount()+","+book.GetName()+","+book.GetPrice()+","+book.GetCompany()+","+book.GetModel()+","+book.GetOs()+","+book.GetParam1()+","+book.GetParam2()+"\r\n");
                    }
                }
                //
            }
            writer.flush();
            writer.close();
        }
        catch(IOException e) {
            e.printStackTrace();
        }

    }

    public Order getOrderById(Orders m_orders, UUID m_id) {

        List<Order> m_OrdersList = m_orders.OrdersList;
        Order m_order = new Order();

        for (int i = 0; i < m_OrdersList.size(); i++) {
            Order c_order = m_OrdersList.get(i);
            List<Device> m_PurchasingItemsList = c_order.PurchasingItemsList;
            if (m_id==m_PurchasingItemsList.get(i).GetId()) {
                m_order = m_OrdersList.get(i);
            }
            else System.out.println("ID не найден");
        }
        return m_order;
    }

    public void ShowDevices(List<Device> m_PurchasingItemsList){
        for (int j = 0; j < m_PurchasingItemsList.size(); j++) {
            System.out.println("__________\n");
            if (m_PurchasingItemsList.get(j).getClass().getSimpleName().equalsIgnoreCase("Phone")) {
                Phone phone = (Phone)m_PurchasingItemsList.get(j);
                System.out.println("Тип устройства - телефон\n");
                System.out.println("ID устройства: "+phone.GetId().toString()+"\n");
                System.out.println("Количество: "+phone.GetCount()+"\n");
                System.out.println("Название: "+phone.GetName()+"\n");
                System.out.println("Цена: "+phone.GetPrice()+"\n");
                System.out.println("Производитель: "+phone.GetCompany()+"\n");
                System.out.println("Модель: "+phone.GetModel()+"\n");
                System.out.println("Система: "+phone.GetOs()+"\n");
                System.out.println("Корпус: "+phone.GetParam1()+"\n");
            }
            else if (m_PurchasingItemsList.get(j).getClass().getSimpleName().equals("SmartPhone")) {
                SmartPhone smphone = (SmartPhone)m_PurchasingItemsList.get(j);
                System.out.println("Тип устройства - смартфон\n");
                System.out.println("ID устройства: "+smphone.GetId().toString()+"\n");
                System.out.println("Количество: "+smphone.GetCount()+"\n");
                System.out.println("Название: "+smphone.GetName()+"\n");
                System.out.println("Цена: "+smphone.GetPrice()+"\n");
                System.out.println("Производитель: "+smphone.GetCompany()+"\n");
                System.out.println("Модель: "+smphone.GetModel()+"\n");
                System.out.println("Система: "+smphone.GetOs()+"\n");
                System.out.println("Тип SIM-карты: "+smphone.GetParam1()+"\n");
                System.out.println("Число SIM-карт: "+smphone.GetParam2()+"\n");
            }
            else if  (m_PurchasingItemsList.get(j).getClass().getSimpleName().equalsIgnoreCase("Book")) {
                Book book = (Book)m_PurchasingItemsList.get(j);
                System.out.println("Тип устройства - планшет\n");
                System.out.println("ID устройства: "+book.GetId().toString()+"\n");
                System.out.println("Количество: "+book.GetCount()+"\n");
                System.out.println("Название: "+book.GetName()+"\n");
                System.out.println("Цена: "+book.GetPrice()+"\n");
                System.out.println("Производитель: "+book.GetCompany()+"\n");
                System.out.println("Модель: "+book.GetModel()+"\n");
                System.out.println("Система: "+book.GetOs()+"\n");
                System.out.println("Процессор: "+book.GetParam1()+"\n");
                System.out.println("Разрешение экрана: "+book.GetParam2()+"\n");
            }
        }
        System.out.println("__________\n");
    }
}
