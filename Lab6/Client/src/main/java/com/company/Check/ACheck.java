package com.company.Check;
import com.company.*;

import java.util.*;

abstract public class ACheck implements Runnable {
    int Time;
    int count;
    Orders orders;
    String mode;

    ACheck(int m_time, int m_count, Orders m_orders, String m_mode) {
        this.Time = m_time;
        this.count = m_count;
        this.orders = m_orders;
        this.mode = m_mode;
    }

    @Override
    public void run()
    {
        //synchronized(orders){
        try{
            if ("Auto".equalsIgnoreCase(mode)) {
                System.out.println("Начало проверки заказов");

                for (int i = 0; i < count; i++) {
                    List<Order> UpdatedOrdersList = new LinkedList<>();
                    List<Order> m_ordersList = orders.OrdersList;
                    Thread.sleep(Time);

                    for(int j = 0; j < m_ordersList.size(); j++){
                        Order order = m_ordersList.get(j);
                        if ("Ожидание".equalsIgnoreCase(order.Status)) {
                            order.Status = "Обработан";
                        }
                        UpdatedOrdersList.add(order);
                    }
                    orders.OrdersList = UpdatedOrdersList;
                }
            }
            else if ("Manual".equalsIgnoreCase(mode)) {
                List<Order> UpdatedOrdersList = new LinkedList<>();
                List<Order> m_ordersList = orders.OrdersList;
                Thread.sleep(100);

                for(int j = 0; j < m_ordersList.size(); j++){
                    Order order = m_ordersList.get(j);
                    if ("Ожидание".equalsIgnoreCase(order.Status)) {
                        order.Status = "Обработан";
                    }
                    UpdatedOrdersList.add(order);
                }
                orders.OrdersList = UpdatedOrdersList;
            }
            else {
                System.out.println("Неверно выбран режим проверки");
            }
        }
        catch(InterruptedException e){
            System.out.println("Thread has been interrupted");
        }
        System.out.println("Конец проверки");
        //}
    }

}
