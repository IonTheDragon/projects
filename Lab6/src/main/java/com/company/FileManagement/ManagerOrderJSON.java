package com.company.FileManagement;

import java.util.*;
import java.io.*;

import com.company.*;
import com.company.Devices.*;
import org.json.simple.*;
import org.json.simple.parser.*;

public class ManagerOrderJSON extends AManageOrder {
    public ManagerOrderJSON(String m_path) {
        super(m_path);
    }

    public void readById(UUID m_id) {

        File m_file = new File(path);
        JSONParser parser = new JSONParser();
        try {
            JSONArray a = (JSONArray) parser.parse(new FileReader(m_file));

            for (Object o : a) {

                JSONObject jsonorder = (JSONObject) o;
                String id = (String) jsonorder.get("user_id");

                if (id.equalsIgnoreCase(m_id.toString())) {

                    System.out.println("__________");
                    System.out.println("Заказчик");

                    System.out.println("ID: " + id);

                    String name = (String) jsonorder.get("user_name");
                    System.out.println("Имя: " + name);

                    String sname = (String) jsonorder.get("user_secondname");
                    System.out.println("Фамилия: " + sname);

                    String fname = (String) jsonorder.get("user_fathername");
                    System.out.println("Отчество: " + fname);

                    String mail = (String) jsonorder.get("user_mail");
                    System.out.println("Email: " + mail);

                    System.out.println("__________");
                    JSONArray items = (JSONArray) jsonorder.get("items");

                    for (Object i : items) {
                        JSONObject jsonitem = (JSONObject) i;

                        String type = (String) jsonitem.get("type");
                        System.out.println("Тип устройства: " + type);

                        String item_id = (String) jsonitem.get("device_id");
                        System.out.println("ID устройства: " + item_id);

                        String count = (String) jsonitem.get("count");
                        System.out.println("Количество: " + count);

                        String iname = (String) jsonitem.get("name");
                        System.out.println("Название: " + iname);

                        String price = (String) jsonitem.get("price");
                        System.out.println("Цена: " + price);

                        String company = (String) jsonitem.get("company");
                        System.out.println("Кампания: " + company);

                        String model = (String) jsonitem.get("model");
                        System.out.println("Модель: " + model);

                        String os = (String) jsonitem.get("os");
                        System.out.println("Операционная система: " + os);

                        if ("Phone".equalsIgnoreCase(type)) {
                            String param1 = (String) jsonitem.get("param1");
                            System.out.println("Тип корпуса: " + param1);
                        } else if ("Smartphone".equalsIgnoreCase(type)) {
                            String param1 = (String) jsonitem.get("param1");
                            String param2 = (String) jsonitem.get("param2");
                            System.out.println("Тип SIM-карты: " + param1);
                            System.out.println("Число SIM-карт: " + param2);
                        } else if ("Book".equalsIgnoreCase(type)) {
                            String param1 = (String) jsonitem.get("param1");
                            String param2 = (String) jsonitem.get("param2");
                            System.out.println("Процессор: " + param1);
                            System.out.println("Разрешение экрана: " + param2);
                        }

                        System.out.println("__________");

                    }
                    break;
                }
            }
        } catch (FileNotFoundException fe) {
            fe.printStackTrace();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public void saveById(Orders m_orders, UUID m_id) {

        try {
            File m_file = new File(path);
            JSONArray OrdersArray = new JSONArray();

            Order m_order = this.getOrderById(m_orders, m_id);
            JSONObject UserData = new JSONObject();
            UserData.put("user_id", m_order.OurUser.GetId().toString());
            UserData.put("user_name", m_order.OurUser.GetName());
            UserData.put("user_secondname", m_order.OurUser.GetSname());
            UserData.put("user_fathername", m_order.OurUser.GetFatherName());
            UserData.put("user_mail", m_order.OurUser.GetFatherName());
            JSONArray ItemsArray = new JSONArray();

            if (m_order.Status.equalsIgnoreCase("Empty Order")) {

            } else {
                for (int j = 0; j < m_order.PurchasingItemsList.size(); j++) {
                    JSONObject ItemParams = new JSONObject();
                    ItemParams.put("type", m_order.PurchasingItemsList.get(j).GetDeviceType());
                    ItemParams.put("device_id", m_order.PurchasingItemsList.get(j).GetId().toString());
                    ItemParams.put("count", m_order.PurchasingItemsList.get(j).GetCount());
                    ItemParams.put("name", m_order.PurchasingItemsList.get(j).GetName());
                    ItemParams.put("price", m_order.PurchasingItemsList.get(j).GetPrice());
                    ItemParams.put("company", m_order.PurchasingItemsList.get(j).GetCompany());
                    ItemParams.put("model", m_order.PurchasingItemsList.get(j).GetModel());
                    ItemParams.put("os", m_order.PurchasingItemsList.get(j).GetOs());
                    ItemParams.put("param1", m_order.PurchasingItemsList.get(j).GetParam1());
                    ItemParams.put("param2", m_order.PurchasingItemsList.get(j).GetParam2());
                    ItemsArray.add(ItemParams);
                }
                UserData.put("items",ItemsArray);
                OrdersArray.add(UserData);
            }


            BufferedWriter writer = new BufferedWriter(new FileWriter(m_file, false));
            writer.write(OrdersArray.toString());
            writer.close();

        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    public void readAll() {
        File m_file = new File(path);
        JSONParser parser = new JSONParser();
        try {
            JSONArray a = (JSONArray) parser.parse(new FileReader(m_file));

            for (Object o : a) {
                JSONObject jsonorder = (JSONObject) o;
                System.out.println("__________");
                System.out.println("Заказчик");

                String id = (String) jsonorder.get("user_id");
                System.out.println("ID: "+id);

                String name = (String) jsonorder.get("user_name");
                System.out.println("Имя: "+name);

                String sname = (String) jsonorder.get("user_secondname");
                System.out.println("Фамилия: "+sname);

                String fname = (String) jsonorder.get("user_fathername");
                System.out.println("Отчество: "+fname);

                String mail = (String) jsonorder.get("user_mail");
                System.out.println("Email: "+mail);

                System.out.println("__________");
                JSONArray items = (JSONArray) jsonorder.get("items");

                for (Object i : items) {
                    JSONObject jsonitem = (JSONObject) i;

                    String type = (String) jsonitem.get("type");
                    System.out.println("Тип устройства: "+type);

                    String item_id = (String) jsonitem.get("device_id");
                    System.out.println("ID устройства: "+item_id);

                    String count = (String) jsonitem.get("count");
                    System.out.println("Количество: "+count);

                    String iname = (String) jsonitem.get("name");
                    System.out.println("Название: "+iname);

                    String price = (String) jsonitem.get("price");
                    System.out.println("Цена: "+price);

                    String company = (String) jsonitem.get("company");
                    System.out.println("Кампания: "+company);

                    String model = (String) jsonitem.get("model");
                    System.out.println("Модель: "+model);

                    String os = (String) jsonitem.get("os");
                    System.out.println("Операционная система: "+os);

                    if ("Phone".equalsIgnoreCase(type)) {
                        String param1 = (String) jsonitem.get("param1");
                        System.out.println("Тип корпуса: "+param1);
                    }
                    else if ("Smartphone".equalsIgnoreCase(type)) {
                        String param1 = (String) jsonitem.get("param1");
                        String param2 = (String) jsonitem.get("param2");
                        System.out.println("Тип SIM-карты: "+param1);
                        System.out.println("Число SIM-карт: "+param2);
                    }
                    else if ("Book".equalsIgnoreCase(type)) {
                        String param1 = (String) jsonitem.get("param1");
                        String param2 = (String) jsonitem.get("param2");
                        System.out.println("Процессор: "+param1);
                        System.out.println("Разрешение экрана: "+param2);
                    }

                    System.out.println("__________");

                }
            }
        } catch (FileNotFoundException fe) {
            fe.printStackTrace();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public void saveAll(Orders m_orders) {

        try {
            File m_file = new File(path);
            JSONArray OrdersArray = new JSONArray();

            for (int i = 0; i < m_orders.OrdersList.size(); i++) {
                JSONObject UserData = new JSONObject();
                Order m_order = m_orders.OrdersList.get(i);
                UserData.put("user_id", m_order.OurUser.GetId().toString());
                UserData.put("user_name", m_order.OurUser.GetName());
                UserData.put("user_secondname", m_order.OurUser.GetSname());
                UserData.put("user_fathername", m_order.OurUser.GetFatherName());
                UserData.put("user_mail", m_order.OurUser.GetFatherName());
                JSONArray ItemsArray = new JSONArray();

                for (int j = 0; j < m_order.PurchasingItemsList.size(); j++) {
                    JSONObject ItemParams = new JSONObject();
                    ItemParams.put("type", m_order.PurchasingItemsList.get(j).GetDeviceType());
                    ItemParams.put("device_id", m_order.PurchasingItemsList.get(j).GetId().toString());
                    ItemParams.put("count", m_order.PurchasingItemsList.get(j).GetCount());
                    ItemParams.put("name", m_order.PurchasingItemsList.get(j).GetName());
                    ItemParams.put("price", m_order.PurchasingItemsList.get(j).GetPrice());
                    ItemParams.put("company", m_order.PurchasingItemsList.get(j).GetCompany());
                    ItemParams.put("model", m_order.PurchasingItemsList.get(j).GetModel());
                    ItemParams.put("os", m_order.PurchasingItemsList.get(j).GetOs());
                    ItemParams.put("param1", m_order.PurchasingItemsList.get(j).GetParam1());
                    ItemParams.put("param2", m_order.PurchasingItemsList.get(j).GetParam2());
                    ItemsArray.add(ItemParams);
                }
                UserData.put("items",ItemsArray);
                OrdersArray.add(UserData);
            }

            BufferedWriter writer = new BufferedWriter(new FileWriter(m_file, false));
            writer.write(OrdersArray.toString());
            writer.close();

        } catch (IOException e) {
            e.printStackTrace();
        }
    }

}
