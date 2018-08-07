package com.company.Check;
import com.company.*;

import java.util.*;

public class DeleteValidatedOrders extends ACheck{
    public DeleteValidatedOrders(int m_time, int m_count, Orders m_orders, String m_mode) {
        super(m_time, m_count, m_orders, m_mode);
    }
    @Override
    public void run() {
        //synchronized(orders){
        try{
            if ("Auto".equalsIgnoreCase(mode)) {
                System.out.println("Начало очистки списка заказов");

                for (int i = 0; i < count; i++) {
                    List<Order> m_ordersList = orders.OrdersList;
                    Thread.sleep(Time);

                    for(int j = 0; j < m_ordersList.size(); j++){
                        Order order = m_ordersList.get(j);
                        if ("Обработан".equalsIgnoreCase(order.Status)) {
                            orders.OrdersList.remove(order);
                        }
                    }
                }
            }
            else if ("Manual".equalsIgnoreCase(mode)) {
                List<Order> m_ordersList = orders.OrdersList;
                Thread.sleep(750);

                for(int j = 0; j < m_ordersList.size(); j++){
                    Order order = m_ordersList.get(j);
                    if ("Обработан".equalsIgnoreCase(order.Status)) {
                        orders.OrdersList.remove(order);
                    }
                }
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
