package com.company.Check;

import com.company.*;

import java.io.IOException;
import java.net.DatagramPacket;
import java.net.DatagramSocket;
import java.net.InetAddress;
import java.util.*;

public class Validate extends ACheck {

    int udp_port;
    int tcp_port;
    DatagramSocket sock;
    String Address;

    public Validate(int m_time, int m_count, Orders m_orders, int mudp_port, int mtcp_port, String m_Address) {
        super(m_time, m_count, m_orders);
        this.udp_port = mudp_port;
        this.tcp_port = mtcp_port;
        this.Address = m_Address;
    }

    public void CreateSocket() {
        // Создаем сокет

        try {
            sock = new DatagramSocket(udp_port);

            //Отправляем данные клиенту
            String s = "ready port "+tcp_port;
            DatagramPacket dp = new DatagramPacket(s.getBytes(), s.getBytes().length, InetAddress.getByName(Address), udp_port);
            sock.send(dp);
            System.out.println("Отправлен запрос клиенту на UDP соединение, адрес "+Address+", порт "+udp_port);

        } catch (IOException e) {
            System.err.println("IOException " + e);
        }

        //
    }

    @Override
    public void run() {
        //synchronized(orders){
        try {
            System.out.println("Начало проверки заказов");

            for (int i = 0; i < count; i++) {
                List<Order> UpdatedOrdersList = new LinkedList<>();
                List<Order> m_ordersList = orders.OrdersList;
                Thread.sleep(Time);

                for (int j = 0; j < m_ordersList.size(); j++) {
                    Order order = m_ordersList.get(j);
                    if ("Ожидание".equalsIgnoreCase(order.Status)) {
                        order.Status = "Обработан";

                        //Отправляем оповещение клиенту

                        StringBuilder data = new StringBuilder();
                        data.append("Заказ обработан\r\n");
                        data.append("Время"+new Date()+"\r\n");
                        data.append("Заказчик\r\n");
                        data.append("ID: "+order.OurUser.GetId()+"\r\n");
                        data.append("Имя: "+order.OurUser.GetName()+"\r\n");
                        data.append("Фамилия: "+order.OurUser.GetSname()+"\r\n");
                        data.append("Отчество: "+order.OurUser.GetFatherName()+"\r\n");
                        data.append("Email: "+order.OurUser.GetMail()+"\r\n");
                        data.append("__________"+"\r\n");

                        for (int k = 0; k < order.PurchasingItemsList.size(); k++) {
                            data.append("__________");
                            data.append("Идентификатор: "+order.PurchasingItemsList.get(k).GetId().toString());
                            data.append("Тип устройства: "+order.PurchasingItemsList.get(k).GetDeviceType());
                            data.append("Количество: "+order.PurchasingItemsList.get(k).GetCount());
                            data.append("Название: "+order.PurchasingItemsList.get(k).GetName());
                            data.append("Цена: "+order.PurchasingItemsList.get(k).GetPrice());
                            data.append("Изготовитель: "+order.PurchasingItemsList.get(k).GetCompany());
                            data.append("Модель: "+order.PurchasingItemsList.get(k).GetModel());
                            data.append("ОС: "+order.PurchasingItemsList.get(k).GetOs());
                            if ("Phone".equalsIgnoreCase(order.PurchasingItemsList.get(k).GetDeviceType())) {
                                data.append("Тип корпуса: "+order.PurchasingItemsList.get(k).GetParam1());
                            }
                            else if ("Smartphone".equalsIgnoreCase(order.PurchasingItemsList.get(k).GetDeviceType())) {
                                data.append("Тип SIM-карты: "+order.PurchasingItemsList.get(k).GetParam1());
                                data.append("Число SIM-карт: "+order.PurchasingItemsList.get(k).GetParam2());
                            }
                            else if ("Book".equalsIgnoreCase(order.PurchasingItemsList.get(k).GetDeviceType())) {
                                data.append("Процессор: "+order.PurchasingItemsList.get(k).GetParam1());
                                data.append("Разрешение экрана: "+order.PurchasingItemsList.get(k).GetParam2());
                            }
                        }
                        String s = data.toString();

                        DatagramPacket dp = new DatagramPacket(s.getBytes(), s.getBytes().length, InetAddress.getByName(Address), udp_port);
                        sock.send(dp);
                        System.out.println("Заказ обработан, оповещение отправлено");

                        //
                    }
                    UpdatedOrdersList.add(order);
                }
                orders.OrdersList = UpdatedOrdersList;
            }

        }
        catch(Exception ex){
            System.out.println(ex.getMessage());
        }
        System.out.println("Конец проверки");
        //}
    }
}
