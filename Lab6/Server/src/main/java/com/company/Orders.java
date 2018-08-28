package com.company;

import java.io.Serializable;
import java.util.Date;
import java.util.*;
import com.company.Devices.*;

public class Orders implements Serializable {

    public List<Order> OrdersList = new LinkedList<>();

    public void Buy(Order m_order) {
        this.OrdersList.add(m_order);
    }

    public void show() {

        for (int i = 0; i < OrdersList.size(); i++) {
            System.out.println("________________________");
            Order m_order = OrdersList.get(i);
            List<Device> m_PurchasingItemsList = m_order.PurchasingItemsList;
            for (int j = 0; j < m_PurchasingItemsList.size(); j++) {

                System.out.println("Идентификатор: "+m_PurchasingItemsList.get(j).GetId().toString());
                System.out.println("Тип устройства: "+m_PurchasingItemsList.get(j).GetDeviceType());
                System.out.println("Количество: "+m_PurchasingItemsList.get(j).GetCount());
                System.out.println("Название: "+m_PurchasingItemsList.get(j).GetName());
                System.out.println("Цена: "+m_PurchasingItemsList.get(j).GetPrice());
                System.out.println("Изготовитель: "+m_PurchasingItemsList.get(j).GetCompany());
                System.out.println("Модель: "+m_PurchasingItemsList.get(j).GetModel());
                System.out.println("ОС: "+m_PurchasingItemsList.get(j).GetOs());
                if ("Phone".equalsIgnoreCase(m_PurchasingItemsList.get(j).GetDeviceType())) {
                    System.out.println("Тип корпуса: "+m_PurchasingItemsList.get(j).GetParam1());
                }
                else if ("Smartphone".equalsIgnoreCase(m_PurchasingItemsList.get(j).GetDeviceType())) {
                    System.out.println("Тип SIM-карты: "+m_PurchasingItemsList.get(j).GetParam1());
                    System.out.println("Число SIM-карт: "+m_PurchasingItemsList.get(j).GetParam2());
                }
                else if ("Book".equalsIgnoreCase(m_PurchasingItemsList.get(j).GetDeviceType())) {
                    System.out.println("Процессор: "+m_PurchasingItemsList.get(j).GetParam1());
                    System.out.println("Разрешение экрана: "+m_PurchasingItemsList.get(j).GetParam2());
                }

                System.out.println("________________________");

            }
            System.out.println("Заказчик");
            User user = m_order.OurUser;
            user.ReadUser();
            System.out.println("________________________");
            System.out.println("Статус");
            System.out.println(m_order.Status);
            System.out.println("________________________");
            System.out.println("Время заказа");
            System.out.println(m_order.CreationTime);
            System.out.println("________________________");
        }
    }

}
