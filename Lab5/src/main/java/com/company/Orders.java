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
                if (m_PurchasingItemsList.get(j).getClass().getSimpleName().equalsIgnoreCase("Phone")) {
                    Phone phone = (Phone)m_PurchasingItemsList.get(j);
                    System.out.println("Идентификатор: "+phone.GetId().toString());
                    System.out.println("Тип устройства: Phone");
                    System.out.println("Количество: "+phone.GetCount());
                    System.out.println("Название: "+phone.GetName());
                    System.out.println("Цена: "+phone.GetPrice());
                    System.out.println("Изготовитель: "+phone.GetCompany());
                    System.out.println("Модель: "+phone.GetModel());
                    System.out.println("ОС: "+phone.GetOs());
                    System.out.println("Тип корпуса: "+phone.GetParam1());
                    System.out.println("________________________");
                }
                else if (m_PurchasingItemsList.get(j).getClass().getSimpleName().equalsIgnoreCase("Smartphone")) {
                    SmartPhone smphone = (SmartPhone)m_PurchasingItemsList.get(j);
                    System.out.println("Идентификатор: "+smphone.GetId().toString());
                    System.out.println("Тип устройства: Smartphone");
                    System.out.println("Количество: "+smphone.GetCount());
                    System.out.println("Название: "+smphone.GetName());
                    System.out.println("Цена: "+smphone.GetPrice());
                    System.out.println("Изготовитель: "+smphone.GetCompany());
                    System.out.println("Модель: "+smphone.GetModel());
                    System.out.println("ОС: "+smphone.GetOs());
                    System.out.println("Тип SIM-карты: "+smphone.GetParam1());
                    System.out.println("Число SIM-карт: "+smphone.GetParam2());
                    System.out.println("________________________");
                }
                else if  (m_PurchasingItemsList.get(j).getClass().getSimpleName().equalsIgnoreCase("Book")) {
                    Book book = (Book)m_PurchasingItemsList.get(j);
                    System.out.println("Идентификатор: "+book.GetId().toString());
                    System.out.println("Тип устройства: Book");
                    System.out.println("Количество: "+book.GetCount());
                    System.out.println("Название: "+book.GetName());
                    System.out.println("Цена: "+book.GetPrice());
                    System.out.println("Изготовитель: "+book.GetCompany());
                    System.out.println("Модель: "+book.GetModel());
                    System.out.println("ОС: "+book.GetOs());
                    System.out.println("Процессор: "+book.GetParam1());
                    System.out.println("Разрешение экрана: "+book.GetParam2());
                    System.out.println("________________________");
                }
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
